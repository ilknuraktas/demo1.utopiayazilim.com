<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">

        

        <div class="row hstack">
            <div class="col-6 col-md-6">
                <div class="card bg-primary border-primary">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between;">
                            <h4 class="text-white">
                                <?php echo trans("sales"); ?>
                            </h4>
                            <h4 class="text-white"><?php echo $user->number_of_sales; ?></h4>
                        </div>
                        <p class="text-white">
                            <i class="mdi mdi-information-outline"></i> <em>Toplam satış sayınız yukarıdadır.</em>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="card bg-dark border-dark">
                    <div class="card-body">
                        <div style="display: flex; justify-content: space-between;">
                            <h4 class="text-white">
                                <?php echo trans("balance"); ?>
                            </h4>
                            <h4 class="text-white"><?php echo price_formatted($user->balance, $this->payment_settings->default_product_currency); ?> TL</h4>
                        </div>
                        <p class="text-white">
                            <i class="mdi mdi-information-outline"></i> <em>Onaylanmış satış kazancınız.</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div id="table-gridjs">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Kazançlar</h4>
                    </div>
                    <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
                        <div class="gridjs-wrapper" style="height: auto;">
                            <table role="grid" class="gridjs-table" style="height: auto;">
                                <thead class="gridjs-thead">
                                    <tr class="gridjs-tr">
                                        <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("order"); ?></th>
                                        <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("date"); ?></th>
                                        <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("price"); ?></th>
                                        <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("commission_rate"); ?></th>
                                        <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("shipping_cost"); ?></th>
                                        <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("earned_amount"); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="gridjs-tbody">
                                    <?php foreach ($satis_kazanclari as $earning) : ?>
                                        <tr class="gridjs-tr">
                                            <td class="gridjs-td">#<?php echo $earning->order_number; ?></td>
                                            <td class="gridjs-td"><?php echo formatted_date($earning->created_at); ?></td>
                                            <td class="gridjs-td"><?php echo price_formatted($earning->price, $earning->currency); ?></td>
                                            <td class="gridjs-td"><?php echo $earning->commission_rate; ?>%</td>
                                            <td class="gridjs-td"><?php echo price_formatted($earning->shipping_cost, $earning->currency); ?></td>
                                            <td class="gridjs-td">
                                                <?php echo price_formatted($earning->earned_amount, $earning->currency);
                                                $order = get_order_by_order_number($earning->order_number);
                                                if (!empty($order) && $order->payment_method == "Cash On Delivery") : ?>
                                                    <span class="text-danger">(-<?php echo price_formatted($earning->earned_amount, $earning->currency); ?>)</span><br><small class="text-danger"><?php echo trans("cash_on_delivery"); ?></small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if (empty($earnings)) : ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="row-custom m-t-15">
                    <div class="float-right">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Wrapper End-->

<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    $(document).ready(function() {
        $('#para-birimleri').DataTable();
    });
    $(document).ready(function() {
        $('#teslimat-suresi').DataTable();
    });
    $(document).ready(function() {
        $('#kargo').DataTable();
    });
</script>