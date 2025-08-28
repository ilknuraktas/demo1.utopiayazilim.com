<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("add_administrator"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open_multipart('admin_controller/add_administrator_post'); ?>

                    <div class="card-body">
                        <!-- include message block -->
                        <?php $this->load->view('admin/includes/_messages'); ?>

                        <div class="form-group">
                            <input type="text" name="username" class="form-control auth-form-input" placeholder="<?php echo trans("username"); ?>" value="<?php echo old("username"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="first_name" class="form-control auth-form-input" placeholder="<?php echo trans("first_name"); ?>" value="<?php echo old("first_name"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" class="form-control auth-form-input" placeholder="<?php echo trans("last_name"); ?>" value="<?php echo old("last_name"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" value="<?php echo old("email"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" value="<?php echo old("password"); ?>" required>
                        </div>

                    </div>

                    <!-- /.box-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-plus label-icon"></i>
                            <?php echo trans('add_administrator'); ?>
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