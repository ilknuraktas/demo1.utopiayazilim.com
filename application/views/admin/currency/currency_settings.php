<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("currency_settings"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open('admin_controller/currency_settings_post'); ?>

                    <div class="card-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata('msg_settings'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('default_product_currency'); ?></label>
                            <select name="default_product_currency" class="form-control">
                                <?php if (!empty($currencies)):
                                    foreach ($currencies as $item): ?>
                                        <option value="<?php echo $item->code; ?>" <?php echo ($this->payment_settings->default_product_currency == $item->code) ? 'selected' : ''; ?>><?php echo $item->name . " (" . $item->hex . ")"; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 m-b-5">
                                    <label><?php echo trans('allow_all_currencies_classified_ads'); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="allow_all_currencies_for_classied" value="1" id="allow_1" class="form-check-input" <?php echo ($this->payment_settings->allow_all_currencies_for_classied == 1) ? 'checked' : ''; ?>>
                                    <label for="allow_1" class="form-check-label"><?php echo trans("yes"); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="allow_all_currencies_for_classied" value="0" id="allow_2" class="form-check-input" <?php echo ($this->payment_settings->allow_all_currencies_for_classied != 1) ? 'checked' : ''; ?>>
                                    <label for="allow_2" class="form-check-label"><?php echo trans("no"); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('featured_products_payment_currency'); ?></label>
                            <select name="promoted_products_payment_currency" class="form-control">
                                <?php if (!empty($currencies)):
                                    foreach ($currencies as $item): ?>
                                        <option value="<?php echo $item->code; ?>" <?php echo ($this->payment_settings->promoted_products_payment_currency == $item->code) ? 'selected' : ''; ?>><?php echo $item->name . " (" . $item->hex . ")"; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 m-b-5">
                                    <label><?php echo trans('currency_format'); ?> <?php echo trans('thousands_seperator'); ?> </label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="currency_format" value="us" id="currency_format_1" class="form-check-input" <?php echo ($this->payment_settings->currency_format == 'us') ? 'checked' : ''; ?>>
                                    <label for="currency_format_1" class="form-check-label">1<strong>,</strong>234<strong>,</strong>567<strong>.</strong>89</label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="currency_format" value="european" id="currency_format_2" class="form-check-input" <?php echo ($this->payment_settings->currency_format == 'european') ? 'checked' : ''; ?>>
                                    <label for="currency_format_2" class="form-check-label">1<strong>.</strong>234<strong>.</strong>567<strong>,</strong>89</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 m-b-5">
                                    <label><?php echo trans('currency_symbol_format'); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="currency_symbol_format" value="left" id="currency_symbol_format_1" class="form-check-input" <?php echo ($this->payment_settings->currency_symbol_format == 'left') ? 'checked' : ''; ?>>
                                    <label for="currency_symbol_format_1" class="form-check-label">$100 (<?php echo trans("left"); ?>)</label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="currency_symbol_format" value="right" id="currency_symbol_format_2" class="form-check-input" <?php echo ($this->payment_settings->currency_symbol_format == 'right') ? 'checked' : ''; ?>>
                                    <label for="currency_symbol_format_2" class="form-check-label">100$ (<?php echo trans("right"); ?>)</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 m-b-5">
                                    <label><?php echo trans('add_space_between_money_currency'); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="space_between_money_currency" value="1" id="space_between_money_currency_1" class="form-check-input" <?php echo ($this->payment_settings->space_between_money_currency == 1) ? 'checked' : ''; ?>>
                                    <label for="space_between_money_currency_1" class="form-check-label"><?php echo trans("yes"); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="space_between_money_currency" value="0" id="space_between_money_currency_2" class="form-check-input" <?php echo ($this->payment_settings->space_between_money_currency == 0) ? 'checked' : ''; ?>>
                                    <label for="space_between_money_currency_2" class="form-check-label"><?php echo trans("no"); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- /.box-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
                            <i class="bx bx-check label-icon"></i>
                            <?php echo trans('save_changes'); ?>
                        </button>
                    </div>
                    <!-- /.box-footer -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("add_currency"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open('admin_controller/add_currency_post'); ?>

                    <div class="card-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata('msg_add'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><?php echo trans("currency_name"); ?></label>
                                    <input type="text" class="form-control" name="name" placeholder="Örnek: US Dollar" maxlength="200" required>
                                </div>
                                <div class="col-md-6">
                                    <label><?php echo trans("currency_code"); ?></label>
                                    <input type="text" class="form-control" name="code" placeholder="Örnek: USD" maxlength="99" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><?php echo trans("currency_symbol"); ?></label>
                                    <input type="text" class="form-control" name="symbol" placeholder="Örnek: $" maxlength="99" required>
                                </div>
                                <div class="col-md-6">
                                    <label><?php echo trans("currency_hexcode"); ?></label>
                                    <input type="text" class="form-control" name="hex" placeholder="Örnek: <?php echo htmlentities("&#x24;") ?>" maxlength="99" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- /.box-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-plus label-icon"></i>
                            <?php echo trans('add_currency'); ?>
                        </button>
                    </div>
                    <!-- /.box-footer -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>

            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="pull-left">
                            <h3 class="card-title"><?php echo trans('currencies'); ?></h3>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <!-- include message block -->
                                <div class="col-sm-12">
                                    <?php if (!empty($this->session->flashdata('msg_table'))):
                                        $this->load->view('admin/includes/_messages');
                                    endif; ?>
                                </div>
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
                                        <thead>
                                            <tr role="row">
                                                <th width="20"><?php echo trans('id'); ?></th>
                                                <th><?php echo trans('currency'); ?></th>
                                                <th><?php echo trans('currency_code'); ?></th>
                                                <th><?php echo trans('currency_symbol'); ?></th>
                                                <th class="th-options"><?php echo trans('options'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($currencies as $item): ?>
                                                <tr>
                                                    <td><?php echo html_escape($item->id); ?></td>
                                                    <td><?php echo html_escape($item->name); ?>&nbsp;</td>
                                                    <td><?php echo html_escape($item->code); ?></td>
                                                    <td><?php echo html_escape($item->symbol); ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown">
                                                                <?php echo trans('select_option'); ?>
                                                                <i class="bx bx-brightness label-icon"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li>
                                                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>update-currency/<?php echo html_escape($item->id); ?>">
                                                                        <?php echo trans('edit'); ?>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('admin_controller/delete_currency_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');">
                                                                        <?php echo trans('delete'); ?>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>

                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>