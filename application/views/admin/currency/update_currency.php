<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="box-title"><?php echo $title; ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open('admin_controller/update_currency_post'); ?>

                    <div class="card-body">
                        <!-- include message block -->
                        <?php $this->load->view('admin/includes/_messages'); ?>

                        <input type="hidden" name="id" value="<?php echo $currency->id; ?>">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><?php echo trans("currency_name"); ?></label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $currency->name; ?>" placeholder="Ex: US Dollar" maxlength="200" required>
                                </div>
                                <div class="col-md-6">
                                    <label><?php echo trans("currency_code"); ?></label>
                                    <input type="text" class="form-control" name="code" value="<?php echo $currency->code; ?>" placeholder="Ex: USD" maxlength="99" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><?php echo trans("currency_symbol"); ?></label>
                                    <input type="text" class="form-control" name="symbol" value="<?php echo $currency->symbol; ?>" placeholder="Ex: $" maxlength="99" required>
                                </div>
                                <div class="col-md-6">
                                    <label><?php echo trans("currency_hexcode"); ?></label>
                                    <input type="text" class="form-control" name="hex" value="<?php echo htmlentities($currency->hex); ?>" placeholder="Ex: <?php echo htmlentities("&#x24;") ?>" maxlength="99" required>
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
            </div>
        </div>
    </div>
</div>