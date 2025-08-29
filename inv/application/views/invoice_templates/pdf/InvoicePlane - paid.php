<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('invoice'); ?></title>
    <style>
        .clearfix:after {
  content: "";
  display: table;
  clear: both;
}
a {
  color: #375bc8;
  text-decoration: underline;
}
body {
  position: relative;
  width: 21cm;
  height: 29.7cm;
  margin: 0 auto;
  color: #3a3a3a;
  background: #ffffff;
  font-family: sans-serif;
  font-size: 14px;
}
header {
  padding: 10px 0;
  margin-bottom: 30px;
}
#header > div {
  color: black;
}
#devider {
  background-color: black;
  height: 4px;
  margin: 0.5rem 0;
}
#info-title {
  font-size: 25px;
  color: black;
  text-align: center;
}
#info-title-2 {
  font-size: 15px;
  color: black;
  text-align: center;
}
#logo {
  text-align: left;
  margin-bottom: 30px;
}
#invoice-logo {
  max-height: 125px;
  text-align: right;
}
.invoice-title {
  color: #375bc8;
  font-size: 2em;
  line-height: 1.4em;
  font-weight: normal;
  margin: 20px 0;
}
#details-right {
  float: right;
  text-align: left;
  width: 40%;
}
#details-left {
  float: left;
  width: 55%;
  margin-right: 5%;
}
.invoice-details {
  color: black;
  padding-bottom: 10px;
  text-align: left;
}
.invoice-details table {
  border-collapse: collapse;
  border-spacing: 0;
  text-align: right;
  width: 40%;
  margin: 0 0 0 auto;
  font-size: 12px;
}
.invoice-details table td {
  width: auto;
  margin: 0;
  padding: 0 0 0.5em 0;
}
table.item-table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  font-size: 12px;
}
table.item-table tr:nth-child(2n-1) td {
  background: #f5f5f5;
}
table.item-table th {
  padding: 10px 15px;
  border: 2px solid black;
  white-space: nowrap;
  text-align: left;
}
table.item-table th.text-right {
  text-align: right;
}
table.item-table td {
  padding: 10px 15px;
}
table.item-table .invoice-sums {
  text-align: right;
}
.invoice-items td {
  border-left: 2px solid black;
  border-right: 2px solid black;
}
.last-items {
  border: 2px solid black;
  border-top-width: 0px;
}
.invoice-items {
  border: 2px solid black;
}
.bordered {
  border: 2px solid black;
}
footer {
  color: black;
  width: 100%;
  padding: 8px 0;
}
.notes {
    font-size: 10px;
}
.text-right {
  text-align: right;
}
.text-red {
  color: #ea5340;
}
.text-green {
  color: #77b632;
}
#tf {
  padding: 0px;
  border: 4px solid black;
  text-align: center;
  background-color: rgb(220, 229, 255);
}
.signature {
    float: right;
    width: 20%;
    text-align: center;
}
    </style>
</head>
<body>
<header class="clearfix">
    <!-- <pre><?php var_dump($invoice) ?></pre> -->
    <div id="logo">
        <?php echo invoice_logo_pdf(); ?>
    </div>
    <div id='header'>
        <div>HP &ensp;&ensp;&ensp;: <?= htmlsc($invoice->user_mobile) == ""? "-" : htmlsc($invoice->user_mobile); ?></div>
        <div>Email : <?= htmlsc($invoice->user_email) == ""? "-" : htmlsc($invoice->user_email); ?></div>
    </div>
    <div id="devider"></div>
    <div id="info">
        <div id='info-title'><u>Invoice</u></div>
        <div id="info-title-2">No. <?= htmlsc($invoice->invoice_id); ?></div>
    </div>

</header>

<main>
    <div class="invoice-details clearfix">
        <div id="details-left">
            <div>Kepada &ensp;: <?= htmlsc($invoice->client_name) == ""?"-" : htmlsc($invoice->client_name); ?></div>
            <div>Alamat &ensp;&nbsp;: <?= htmlsc($invoice->client_address_1) ==""?"-":htmlsc($invoice->client_address_1); ?></div>
        </div>
        <div id="details-right">
            <div>Tanggal &ensp;&ensp;&ensp;&ensp;&ensp;: <?= date_from_mysql($invoice->invoice_date_due, true); ?></div>
            <div>Pembayaran &nbsp;: <?=$payment_method ? _htmlsc($payment_method->payment_method_name) : "-"; ?></div>
        </div>
    </div>

    <table class="item-table">
        <thead>
        <tr>
            <th class="item-name">No</th>
            <th class="item-name">Produk</th>
            <th class="item-desc">Deskripsi</th>
            <th class="item-amount text-right">Qty</th>
            <th class="item-price text-right">Harga</th>
            <?php if ($show_item_discounts) : ?>
                <th class="item-discount text-right">Diskon</th>
            <?php endif; ?>
            <th class="item-total text-right">Total</th>
        </tr>
        </thead>
        <tbody class="invoice-items">

        <?php
        foreach ($items as $key=>$item) { ?>
            <tr>
                <td class="text-left"><?php echo $key+1; ?></td>
                <td><?php _htmlsc($item->item_name); ?></td>
                <td><?php echo nl2br(htmlsc($item->item_description)); ?></td>
                <td class="text-right">
                    <?php echo format_amount($item->item_quantity); ?>
                    <?php if ($item->item_product_unit) : ?>
                        <br>
                        <small><?php _htmlsc($item->item_product_unit); ?></small>
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <?php echo format_currency($item->item_price); ?>
                </td>
                <?php if ($show_item_discounts) : ?>
                    <td class="text-right">
                        <?php echo format_currency($item->item_discount); ?>
                    </td>
                <?php endif; ?>
                <td class="text-right">
                    <?php echo format_currency($item->item_total); ?>
                </td>
            </tr>
        <?php } ?>

        <tr class="last-items">
        <?php echo($show_item_discounts ? '<td></td>' : ''); ?>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
        </tbody>
        <tbody class="invoice-sums">

        <?php if ($invoice->invoice_item_tax_total > 0) { ?>
            <tr>
            <td></td><td></td><td></td><td></td>
            <?php echo($show_item_discounts ? '<td></td>' : ''); ?>
            <td class="text-right bordered">
                    <?php _trans('item_tax'); ?>
                </td>
                <td class="text-right bordered">
                    <?php echo format_currency($invoice->invoice_item_tax_total); ?>
                </td>
            </tr>
        <?php } ?>

        <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
            <tr>
            <td></td><td></td><td></td><td></td>
            <?php echo($show_item_discounts ? '<td></td>' : ''); ?>
            <td class="text-right bordered">
                    <?php echo htmlsc($invoice_tax_rate->invoice_tax_rate_name) . ' (' . format_amount($invoice_tax_rate->invoice_tax_rate_percent) . '%)'; ?>
                </td>
                <td class="text-right bordered">
                    <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                </td>
            </tr>
        <?php endforeach ?>

        <?php if ($invoice->invoice_discount_percent != '0.00') : ?>
            <tr>
            <td></td><td></td><td></td><td></td>
            <?php echo($show_item_discounts ? '<td></td>' : ''); ?>
            <td class="text-right bordered">
                    Diskon
                </td>
                <td class="text-right bordered">
                    <?php echo format_amount($invoice->invoice_discount_percent); ?>%
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($invoice->invoice_discount_amount != '0.00') : ?>
            <tr>
            <td></td><td></td><td></td><td></td>
            <?php echo($show_item_discounts ? '<td></td>' : ''); ?>
            <td class="text-right bordered">
                    <?php _trans('discount'); ?>
                </td>
                <td class="text-right bordered">
                    <?php echo format_currency($invoice->invoice_discount_amount); ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td></td><td></td><td></td><td></td>
            <?php echo($show_item_discounts ? '<td></td>' : ''); ?>
            <td class="text-right bordered">
                <b>Total</b>
            </td>
            <td class="text-right bordered">
                <b><?php echo format_currency($invoice->invoice_total); ?></b>
            </td>
        </tr>
        <tr>
        <td></td><td></td><td></td><td></td>
        <?php echo($show_item_discounts ? '<td></td>' : ''); ?>
            <td class="text-right bordered">
                Terbayar
            </td>
            <td class="text-right bordered">
                <?php echo format_currency($invoice->invoice_paid); ?>
            </td>
        </tr>
        <tr>
        <td></td><td></td><td></td><td></td>
        <?php echo($show_item_discounts ? '<td></td>' : ''); ?>
            <td class="text-right bordered">
                <b>Sisa</b>
            </td>
            <td class="text-right bordered">
                <b><?php echo format_currency($invoice->invoice_balance); ?></b>
            </td>
        </tr>
        </tbody>
    </table>

</main>

<footer>
    <!--<div id='tf'><h4>BCA RITA 4880152501</h4></div>-->
    <h4 class='text-green'>Telah sampai kepada kami pembayaran anda, Terima kasih.</h4>
    <div class="signature">
                <div>Hormat kami</div>
                <img class='signature-img' src="<?php echo base_url(); ?>assets/core/img/anton.png" />
                <div><u>Anton</u></div>
            </div>
</footer>

</body>
</html>
