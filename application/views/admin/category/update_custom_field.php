<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("update_custom_field"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open_multipart('category_controller/update_custom_field_post', ['onkeypress' => 'return event.keyCode != 13;']); ?>
                    <input type="hidden" name="id" value="<?php echo $field->id; ?>">
                    <div class="card-body">
                        <!-- include message block -->
                        <?php $this->load->view('admin/includes/_messages'); ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php foreach ($this->languages as $language): ?>
                                    <div class="form-group">
                                        <label><?php echo trans("field_name"); ?> (<?php echo $language->name; ?>)</label>
                                        <input type="text" class="form-control" name="name_lang_<?php echo $language->id; ?>" placeholder="<?php echo trans("field_name"); ?>"
                                        value="<?php echo get_custom_field_name_by_lang($field->id, $language->id); ?>" maxlength="255" required>
                                    </div>
                                <?php endforeach; ?>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <label><?php echo trans('row_width'); ?></label>
                                        </div>
                                        <div class="col-sm-3 col-xs-12 col-option">
                                            <input type="radio" name="row_width" value="half" id="row_width_1" class="form-check-input" <?php echo ($field->row_width == "half") ? "checked" : ""; ?>>
                                            <label for="row_width_1" class="form-check-label"><?php echo trans('half_width'); ?></label>
                                        </div>
                                        <div class="col-sm-3 col-xs-12 col-option">
                                            <input type="radio" name="row_width" value="full" id="row_width_2" class="form-check-input" <?php echo ($field->row_width == "full") ? "checked" : ""; ?>>
                                            <label for="row_width_2" class="form-check-label"><?php echo trans('full_width'); ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <label class="control-label"><?php echo trans('required'); ?></label>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <input type="checkbox" name="is_required" value="1" class="form-check-input" <?php echo ($field->is_required == 1) ? "checked" : ""; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <label><?php echo trans('status'); ?></label>
                                        </div>
                                        <div class="col-sm-3 col-xs-12 col-option">
                                            <input type="radio" name="status" value="1" id="status_1" class="form-check-input" <?php echo ($field->status == 1) ? "checked" : ""; ?>>
                                            <label for="status_1" class="form-check-label"><?php echo trans('active'); ?></label>
                                        </div>
                                        <div class="col-sm-3 col-xs-12 col-option">
                                            <input type="radio" name="status" value="0" id="status_2" class="form-check-input" <?php echo ($field->status != 1) ? "checked" : ""; ?>>
                                            <label for="status_2" class="form-check-label"><?php echo trans('inactive'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo trans('order'); ?></label>
                                    <input type="number" class="form-control" name="field_order" placeholder="<?php echo trans('order'); ?>"
                                    value="<?php echo html_escape($field->field_order); ?>" min="1" max="99999" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo admin_url(); ?>custom-fields" class="btn btn-danger waves-effect btn-label waves-light">
                            <i class="bx bx-bx bx-left-arrow-alt label-icon"></i>
                            <?php echo trans('back'); ?>
                        </a>
                        <a href="<?php echo admin_url(); ?>custom-field-options/<?php echo $field->id; ?>" class="btn btn-warning waves-effect btn-label waves-light">
                            <i class="bx bx-sticker label-icon"></i>
                            <?php echo trans('edit_options'); ?>
                        </a>
                        <button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
                            <i class="bx bx-check label-icon"></i>
                            <?php echo trans('save_changes'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>