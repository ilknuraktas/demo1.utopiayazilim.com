<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <div class="left">
                                <h3 class="box-title"><?php echo trans("add_state"); ?></h3>
                            </div>
                            <div class="ms-auto">
                                <a href="<?php echo admin_url(); ?>states" class="btn btn-success waves-effect btn-label waves-light">
                                    <i class="bx bx-sticker label-icon"></i>
                                    <?php echo trans('states'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open('admin_controller/add_state_post'); ?>

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
                                            <option value="<?php echo $item->id; ?>">
                                                <?php echo html_escape($item->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label><?php echo trans("name"); ?></label>
                                    <input type="text" class="form-control" name="name" placeholder="<?php echo trans("name"); ?>" maxlength="200" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-plus label-icon"></i>
                            <?php echo trans('add_state'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>