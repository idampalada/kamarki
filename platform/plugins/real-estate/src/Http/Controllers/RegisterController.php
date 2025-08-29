<?php

namespace Botble\RealEstate\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\Base\Facades\BaseHelper;
use Botble\ACL\Traits\RegistersUsers;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Captcha\Facades\Captcha;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\Base\Facades\EmailHandler;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Botble\RealEstate\Facades\RealEstateHelper;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\URL;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected string $redirectTo = '/';

    public function __construct(protected AccountInterface $accountRepository)
    {
        $this->redirectTo = route('public.account.register');
    }

    public function showRegistrationForm()
    {
        if (! RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        SeoHelper::setTitle(__('Register'));

        if (view()->exists(Theme::getThemeNamespace() . '::views.real-estate.account.auth.register')) {
            return Theme::scope('real-estate.account.auth.register')->render();
        }

        return view('plugins/real-estate::account.auth.register');
    }

    public function confirm(int|string $id, Request $request, BaseHttpResponse $response, AccountInterface $accountRepository)
    {
        if (! RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        if (! URL::hasValidSignature($request)) {
            abort(404);
        }

        $account = $accountRepository->findOrFail($id);

        $account->confirmed_at = Carbon::now();
        $this->accountRepository->createOrUpdate($account);

        $this->guard()->login($account);

        return $response
            ->setNextUrl(route('public.index'))
            ->setMessage(__('You successfully confirmed your email address.'));
    }

    protected function guard()
    {
        return auth('account');
    }

    public function resendConfirmation(
        Request $request,
        AccountInterface $accountRepository,
        BaseHttpResponse $response
    ) {
        if (! RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        $account = $accountRepository->getFirstBy(['email' => $request->input('email')]);
        if (! $account) {
            return $response
                ->setError()
                ->setMessage(__('Cannot find this account!'));
        }

        $this->sendConfirmationToUser($account);

        return $response
            ->setMessage(__('We sent you another confirmation email. You should receive it shortly.'));
    }

    protected function sendConfirmationToUser(Account $account)
    {
        // Notify the user
        $notificationConfig = config('plugins.real-estate.real-estate.notification');
        if ($notificationConfig) {
            $notification = app($notificationConfig);
            $account->notify($notification);
        }
    }

    public function register(Request $request, BaseHttpResponse $response)
    {
        if (! RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        $this->validator($request->input())->validate();

        event(new Registered($account = $this->create($request->input())));

        EmailHandler::setModule(REAL_ESTATE_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'account_name' => $account->name,
                'account_email' => $account->email,
            ])
            ->sendUsingTemplate('account-registered');

        if (setting('verify_account_email', false)) {
            $this->sendConfirmationToUser($account);

            $this->registered($request, $account);

            return $response
                ->setNextUrl($this->redirectPath())
                ->setMessage(__('Please confirm your email address.'));
        }

        $account->confirmed_at = Carbon::now();
        $this->accountRepository->createOrUpdate($account);
        $this->guard()->login($account);
        // Send SMS with OTP and redirect to OTP verification route
        $this->sendSMS($account->phone, $account->otp);
        $user_id = $account->id;
        $resend = true;
        return view('plugins/real-estate::account.auth.varify',compact('user_id', 'resend'))->with('success', "OTP has been sent on Your Mobile Number.");
        // return $response->setNextUrl($this->redirectPath())->setMessage(__('Registered successfully!'));
    }

    public function otp_login(Request $request, BaseHttpResponse $response)
    {
        $request->validate([
            'user_id' => 'required',
            'otp' => 'required'
        ]);

        // Check if user exist
        $user = $this->accountRepository->findOrFail($request->user_id);
        $user_id = $request->user_id;
        $resend = true;
        if (!$user) {
            return view('plugins/real-estate::account.auth.varify',compact('user_id', 'resend'))->withErrors(['error' => 'User not found']);
        }

        // Check if OTP is valid
        if ($request->otp != $user->otp) {
            return view('plugins/real-estate::account.auth.varify',compact('user_id', 'resend'))->withErrors(['error' =>'Invalid OTP']);
        }

        $user->expire_at = now();
        $user->varified = 'true';
        $user->update();

        return redirect('/');
    }
    public function otpresend(Request $request){
        $user = $this->accountRepository->findOrFail($request->user_id);
        $user_id = $request->user_id;
        $verification_code = rand(100000, 999999);
        $user->otp = $verification_code;
        $user->expire_at = now();
        $user->update();

        $this->sendSMS($user->phone,$verification_code);
        return view('plugins/real-estate::account.auth.varify', compact('user_id'));
    }

    protected function validator(array $data)
    {
        $rules = [
            'first_name' => 'required|max:120',
            'last_name' => 'required|max:120',
            'username' => 'required|max:60|min:2|unique:re_accounts,username',
            'email' => 'required|email|max:255|unique:re_accounts',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|' . BaseHelper::getPhoneValidationRule(),
        ];

        if (is_plugin_active('captcha') && setting('enable_captcha') && setting(
            'real_estate_enable_recaptcha_in_register_page',
            0
        )) {
            $rules += Captcha::rules();
        }

        return Validator::make($data, $rules, [], Captcha::attributes());
    }

    protected function create(array $data)
    {
        $verification_code = rand(100000, 999999);
        $register = $this->accountRepository->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'otp' => $verification_code,
            'expire_at' => now(),
        ]);
        // dd($register);
        return $register;
    }

    protected function registered(Request $request, $user)
    {
        $this->sendSMS($user->mobile_no,$user->otp);

        return redirect()->route('otp.verify',$user->id) ->with('success',  "OTP has been sent on Your Mobile Number.");
    }


    public function sendSMS($receiverNumber,$otp)
    {
        try {
            $gosmsUser = getenv('GOSMS_USERNAME');
            $gosmsPass = getenv('GOSMS_PASSWORD');
            $apiKey = md5($gosmsUser . $gosmsPass . $receiverNumber);

            $message = "Kode Verifikasi Anda: {$otp}\nJangan bagikan kode ini kepada siapa pun, termasuk pihak yang mengaku dari kamarki.com.";

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://secure.gosmsgateway.com/masking/api/sendsms.php?' . http_build_query([
                    'username' => $gosmsUser,
                    'mobile' => $receiverNumber,
                    'message' => $message,
                    'auth' => $apiKey,
                ]),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                info("cURL Error: " . $err);
                return;
            }

            info('SMS Sent Successfully via GoSMS. Response: ' . $response);
        } catch (Exception $e) {
            info("Error: " . $e->getMessage());
        }
    }

    public function getVerify()
    {
        if (! RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        return view('plugins/real-estate::account.auth.verify');
    }
}
