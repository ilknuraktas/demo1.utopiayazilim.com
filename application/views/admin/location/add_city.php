<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <div class="left">
                                <h3 class="card-title"><?php echo trans("add_city"); ?></h3>
                            </div>
                            <div class="ms-auto">
                                <a href="<?php echo admin_url(); ?>cities" class="btn btn-success waves-effect btn-label waves-light">
                                    <i class="bx bx-sticker label-icon"></i>
                                    <?php echo trans('cities'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open('admin_controller/add_city_post'); ?>

                    <div class="card-body">
                        <!-- include message block -->
                        <?php $this->load->view('admin/includes/_messages'); ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><?php echo trans('country'); ?></label>
                                    <select name="country_id" class="form-control" onchange="get_states_by_country($(this).val());" required>
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
                                    <label><?php echo trans('state'); ?></label>
                                    <select name="state_id" id="select_states" class="form-control" required>
                                        <option value=""><?php echo trans("select"); ?></option>
                                        <?php foreach ($states as $item): ?>
                                            <option value="<?php echo $item->id; ?>">
                                                <?php echo html_escape($item->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("name"); ?></label>
                            <input type="text" class="form-control" name="name" placeholder="<?php echo trans("name"); ?>" maxlength="200" required>
                        </div>

                    </div>

                    <!-- /.box-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-plus label-icon"></i>
                            <?php echo trans('add_city'); ?></button>
                        </div>
                        <!-- /.box-footer -->
                        <?php echo form_close(); ?><!-- form end -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </div>
    </div>