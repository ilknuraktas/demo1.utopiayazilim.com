<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title"><?php echo trans('pricing'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('product_admin_controller/featured_products_pricing_post'); ?>
            <div class="card-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label"><?php echo trans('price_per_day'); ?></label>
                            <input type="text" name="price_per_day" class="form-control form-input price-input" value="<?php echo get_price($this->payment_settings->price_per_day, 'input'); ?>" onpaste="return false;" maxlength="32" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label"><?php echo trans('price_per_month'); ?></label>
                            <input type="text" name="price_per_month" class="form-control form-input price-input" value="<?php echo get_price($this->payment_settings->price_per_month, 'input'); ?>" onpaste="return false;" maxlength="32" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("free_promotion"); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input class="form-check-input" type="radio" name="free_product_promotion" value="1" id="free_promotion_1"
                            class="square-purple" <?php echo ($this->payment_settings->free_product_promotion == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="free_promotion_1"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input class="form-check-input" type="radio" name="free_product_promotion" value="0" id="free_promotion_2"
                            class="square-purple" <?php echo ($this->payment_settings->free_product_promotion != 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="free_promotion_2" ><?php echo trans('disable'); ?></label>
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
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>