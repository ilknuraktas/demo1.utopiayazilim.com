<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="wrapper">
    <div class="container-fluid">

        <div class="row" style="margin-top:15px">
            <!--div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <?php $this->load->view("earnings/_earnings_tabs"); ?>
                </div>
            </div-->

            <div class="col-sm-12 col-md-12">

                <div class="row">
                    <div class="col-12">
                        <!-- İçerik -->
                        <?php $this->load->view('product/_messages'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 card p-3">
                        <div class="withdraw-money-container">
                            <?php echo form_open('withdraw-money-post', ['id' => 'form_validate_payout_1', 'class' => 'validate_price',]); ?>
                            <div class="form-group">
                                <h5 class="font-size-14"><i class="mdi mdi-arrow-right text-primary me-1"></i> <?php echo trans("withdraw_amount"); ?></h5>
                                <?php
                                $min_value = 0;
                                if ($this->payment_settings->payout_paypal_enabled) {
                                    $min_value = $this->payment_settings->min_payout_paypal;
                                } elseif ($this->payment_settings->payout_iban_enabled) {
                                    $min_value = $this->payment_settings->min_payout_iban;
                                } elseif ($this->payment_settings->payout_swift_enabled) {
                                    $min_value = $this->payment_settings->min_payout_swift;
                                } ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-currency" id="basic-addon2">₺</span>
                                        <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_product_currency; ?>">
                                    </div>
                                    <input type="text" name="amount" id="product_price_input" aria-describedby="basic-addon2" class="form-control form-input price-input validate-price-input " placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <h5 class="font-size-14"><i class="mdi mdi-arrow-right text-primary me-1"></i> <?php echo trans("withdraw_method"); ?></h5>
                                <div class="selectdiv">
                                    <select name="payout_method" class="form-control" onchange="update_payout_input(this.value);" required>
                                        <?php if ($this->payment_settings->payout_paypal_enabled) : ?>
                                            <option value="paypal"><?php echo trans("paypal"); ?></option>
                                        <?php endif; ?>
                                        <?php if ($this->payment_settings->payout_iban_enabled) : ?>
                                            <option value="iban"><?php echo trans("iban"); ?></option>
                                        <?php endif; ?>
                                        <?php if ($this->payment_settings->payout_swift_enabled) : ?>
                                            <option value="swift"><?php echo trans("swift"); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group d-grid">
                                <button type="submit" class="btn btn-primary btn-block"><?php echo trans("submit"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 card p-3">
                        <div class="minimum-payout-container text-center">
                            <div class="card-header">
                                <h2 class="title"><?php echo trans("min_poyout_amounts"); ?></h2>
                            </div>
                            <div class="card-body">
                                <?php if ($this->payment_settings->payout_paypal_enabled) : ?>
                                    <button type="button" class="btn btn-warning waves-effect waves-light">
                                        <i class="bx bx-error font-size-16 align-middle me-2"></i> <?php echo trans("paypal"); ?> : <strong><?php echo price_formatted($this->payment_settings->min_payout_paypal, $this->payment_settings->default_product_currency) ?></strong>
                                    </button>
                                <?php endif; ?>
                                <?php if ($this->payment_settings->payout_iban_enabled) : ?>
                                    <button type="button" class="btn btn-warning waves-effect waves-light">
                                        <i class="bx bx-error font-size-16 align-middle me-2"></i> <?php echo trans("iban"); ?> : <?php echo price_formatted($this->payment_settings->min_payout_iban, $this->payment_settings->default_product_currency) ?></strong>
                                    </button>
                                <?php endif; ?>
                                <?php if ($this->payment_settings->payout_swift_enabled) : ?>
                                    <button type="button" class="btn btn-warning waves-effect waves-light">
                                        <i class="bx bx-error font-size-16 align-middle me-2"></i> <?php echo trans("swift"); ?> : <strong><?php echo price_formatted($this->payment_settings->min_payout_swift, $this->payment_settings->default_product_currency) ?></strong>
                                    </button>
                                <?php endif; ?>

                            </div>
                            <div class="card-footer bg-transparent border-top">
                                <?php if ($this->auth_check) : ?>
                                    <h4><?php echo trans("your_balance"); ?> : <strong><?php echo price_formatted($this->auth_user->balance, $this->payment_settings->default_product_currency) ?></strong></h4>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="card">
                        <div id="table-gridjs">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Para Çekme Talepleri</h4>
                            </div>
                            <div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
                                <div class="gridjs-wrapper" style="height: auto;">
                                    <table role="grid" class="gridjs-table" style="height: auto;">
                                        <thead class="gridjs-thead">
                                            <tr class="gridjs-tr">
                                                <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("date"); ?></th>
                                                <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("withdraw_method"); ?></th>
                                                <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("withdraw_amount"); ?></th>
                                                <th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("status"); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody class="gridjs-tbody">
                                            <?php foreach ($payouts as $payout) : ?>
                                                <tr class="gridjs-tr">
                                                    <td class="gridjs-td"><?php echo formatted_date($payout->created_at);  ?></td>
                                                    <td class="gridjs-td"><?php echo trans($payout->payout_method); ?></td>
                                                    <td class="gridjs-td"><?php echo price_formatted($payout->amount, $payout->currency); ?></td>
                                                    <td class="gridjs-td">
                                                        <?php if ($payout->status == 1) {
                                                            echo trans("completed");
                                                        } else {
                                                            echo trans("pending");
                                                        } ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php if (empty($payouts)) : ?>
                                <p class="text-center">
                                    <?php echo trans("no_records_found"); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
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

<script>
    function update_payout_input(option) {
        if (option == "paypal") {
            $('#payout_price_input').attr('min', '<?php echo get_price($this->payment_settings->min_payout_paypal, 'decimal'); ?>');
        }
        if (option == "iban") {
            $('#payout_price_input').attr('min', '<?php echo get_price($this->payment_settings->min_payout_iban, 'decimal'); ?>');
        }
        if (option == "swift") {
            $('#payout_price_input').attr('min', '<?php echo get_price($this->payment_settings->min_payout_swift, 'decimal'); ?>');
        }
        $('#payout_price_input').val('');
    }
</script>