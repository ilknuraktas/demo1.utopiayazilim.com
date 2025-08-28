<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("update_state"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open('admin_controller/update_state_post'); ?>
                    <input type="hidden" name="id" value="<?php echo $state->id; ?>">
                    <input type="hidden" name="redirect_url" value="<?php echo $this->agent->referrer(); ?>">

                    <div class="card-body">
                        <?php $this->load->view('admin/includes/_messages'); ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><?php echo trans('country'); ?></label>
                                    <select name="country_id" class="form-control" required>
                                        <option value=""><?php echo trans("select"); ?></option>
                                        <?php
                                        foreach ($countries as $item): ?>
                                            <option value="<?php echo $item->id; ?>" <?php echo ($state->country_id == $item->id) ? 'selected' : ''; ?>>
                                                <?php echo html_escape($item->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label><?php echo trans("name"); ?></label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $state->name; ?>" placeholder="<?php echo trans("name"); ?>" maxlength="200" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
                            <i class="bx bx-check label-icon"></i>
                            <?php echo trans('update_state'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>