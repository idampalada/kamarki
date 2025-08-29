<?php

namespace Botble\RealEstate\Tables;

use Illuminate\Support\Facades\Auth;
use Botble\Base\Facades\BaseHelper;
use Botble\RealEstate\Enums\ConsultStatusEnum;
use Botble\RealEstate\Models\Consult;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Base\Facades\Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Botble\Table\DataTables;

class ConsultTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, Consult $model)
    {
        parent::__construct($table, $urlGenerator);

        $this->model = $model;

        if (! Auth::user()->hasAnyPermission(['consult.edit', 'consult.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (Consult $item) {
                if (! Auth::user()->hasPermission('consult.edit')) {
                    return BaseHelper::clean($item->name);
                }

                return Html::link(route('consult.edit', $item->id), BaseHelper::clean($item->name));
            })
            ->editColumn('checkbox', function (Consult $item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function (Consult $item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function (Consult $item) {
                return BaseHelper::clean($item->status->toHtml());
            })
            ->addColumn('operations', function (Consult $item) {
                return $this->getOperations('consult.edit', 'consult.destroy', $item);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'name',
                'phone',
                'email',
                'created_at',
                'ip_address',
                'status',
            ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-start',
            ],
            'email' => [
                'title' => trans('plugins/real-estate::consult.email.header'),
                'class' => 'text-start',
            ],
            'phone' => [
                'title' => trans('plugins/real-estate::consult.phone'),
            ],
            'ip_address' => [
                'title' => trans('plugins/real-estate::consult.ip_address'),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('consult.deletes'), 'consult.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'select',
                'choices' => ConsultStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', ConsultStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }
}
