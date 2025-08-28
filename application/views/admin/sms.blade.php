<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('add_story_item'); ?></h3>
            </div>
            <?php echo form_open_multipart('admin_controller/add_story_item_post'); ?>
            <div class="box-body">
                
                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control">
                        <?php foreach ($this->languages as $language) : ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($this->selected_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class=" form-group">
                    <label class="control-label"><?php echo trans('url'); ?></label>
                    <input required type="text" class="form-control" name="link" placeholder="<?php echo trans('url'); ?>" value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class=" form-group">
                    <label class="control-label"><?php echo trans('text'); ?></label>
                    <input required type="text" class="form-control" name="text" placeholder="<?php echo trans('text'); ?>" value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('image'); ?></label>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('select_image'); ?>
                            <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" required onchange="show_preview_image(this);">
                        </a>
                    </div>
                    <img src="<?php echo IMG_BASE64_1x1; ?>" id="img_preview_file" class="img-file-upload-preview">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-block"><?php echo trans('add_story_item'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('stories'); ?></h3>
            </div>
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th width="20"><?php echo trans('id'); ?></th>
                                        <th><?php echo trans('image'); ?></th>
                                        <th><?php echo trans('language'); ?></th>
                                        <th><?php echo trans('url'); ?></th>
                                        <th><?php echo trans('text'); ?></th>
                                        <th class="th-options"><?php echo trans('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($stories as $item) : ?>
                                        <tr>
                                            <td><?php echo html_escape($item->id); ?></td>
                                            <td>
                                                <img src="<?php echo base_url() . $item->image; ?>" alt="" style="width: 200px;" />
                                            </td>
                                            <td>
                                                <?php
                                                $language = get_language($item->lang_id);
                                                if (!empty($language)) {
                                                    echo $language->name;
                                                } ?>
                                            </td>
                                            <td><a href="<?php echo $item->link; ?>" target="_blank"><?php echo $item->link; ?></a></td>
                                            <td>
                                                <?php echo $item->text; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">

                                                        <li>
                                                            <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_story_item_post','<?php echo $item->id; ?>','<?php echo trans("confirm_story_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('story'); ?></h3>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/update_story_settings_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_settings"))) :
                    $this->load->view('admin/includes/_messages_form');
                endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('status'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="story_status" value="1" id="slider_status_1" class="square-purple" <?php echo ($this->general_settings->story_status == 1) ? 'checked' : ''; ?>>
                            <label for="slider_status_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-6 col-xs-12 col-option">
                            <input type="radio" name="story_status" value="0" id="slider_status_2" class="square-purple" <?php echo ($this->general_settings->story_status != 1) ? 'checked' : ''; ?>>
                            <label for="slider_status_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?>
            <!-- form end -->
        </div>
    </div>
</div>