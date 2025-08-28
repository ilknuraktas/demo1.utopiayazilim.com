<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("update_country"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open('admin_controller/update_country_post'); ?>
                    <input type="hidden" name="id" value="<?php echo $country->id; ?>">
                    <div class="card-body">
                        <!-- include message block -->
                        <?php $this->load->view('admin/includes/_messages'); ?>

                        <div class="form-group">
                            <label><?php echo trans("name"); ?></label>
                            <input type="text" class="form-control" name="name" placeholder="<?php echo trans("name"); ?>"
                            value="<?php echo $country->name; ?>" maxlength="200" required>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <label><?php echo trans('status'); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="status" value="1" id="status_1" class="form-check-input" <?php echo ($country->status == 1) ? 'checked' : ''; ?>>
                                    <label for="status_1" class="form-check-label"><?php echo trans('active'); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="status" value="0" id="status_2" class="form-check-input" <?php echo ($country->status != 1) ? 'checked' : ''; ?>>
                                    <label for="status_2" class="form-check-label"><?php echo trans('inactive'); ?></label>
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- /.box-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
                            <i class="bx bx-check label-icon"></i>
                            <?php echo trans('update_country'); ?>
                        </button>
                    </div>
                    <!-- /.box-footer -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
</div>