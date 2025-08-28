<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <div class="left">
                                <h3 class="card-title"><?php echo trans('add_page'); ?></h3>
                            </div>
                            <div class="ms-auto">
                                <a href="<?php echo admin_url(); ?>pages" class="btn btn-success waves-effect btn-label waves-light">
                                    <i class="bx bx-plus label-icon"></i>
                                    <?php echo trans('pages'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open('page_controller/add_page_post'); ?>
                    <div class="card-body">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <label><?php echo trans("language"); ?></label>
                                    <select name="lang_id" class="form-control" style="max-width: 600px;">
                                        <?php foreach ($this->languages as $language): ?>
                                            <option value="<?php echo $language->id; ?>" <?php echo ($this->selected_lang->id == $language->id) ? 'selected' : ''; ?>>
                                                <?php echo $language->name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <label class="control-label">
                                        <?php echo trans('title'); ?>
                                    </label>
                                    <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>" value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <label class="control-label"><?php echo trans("slug"); ?> <small>(<?php echo trans("slug_exp"); ?>)</small></label>
                                    <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>" value="<?php echo old('slug'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                                    <input type="text" class="form-control" name="keywords" placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('keywords'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                </div>

                                <div class="col-sm-4 col-xs-12">
                                    <label class="control-label"><?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                                    <input type="text" class="form-control" name="description" placeholder="<?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('description'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <label><?php echo trans('order'); ?></label>
                                    <input type="number" class="form-control" name="page_order" placeholder="<?php echo trans('order'); ?>" value="1" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> style="max-width: 600px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <label>
                                        <?php echo trans('location'); ?>
                                    </label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input class="form-check-input" type="radio" name="location" value="top_menu" id="menu_top_menu" checked>
                                    <label class="form-check-label" for="menu_top_menu">
                                        <?php echo trans('top_menu'); ?>
                                    </label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input class="form-check-input" type="radio" name="location" value="quick_links" id="menu_quick_links">
                                    <label class="form-check-label" for="menu_quick_links">
                                        <?php echo trans('footer_quick_links'); ?>
                                    </label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input class="form-check-input" type="radio" name="location" value="information" id="menu_information">
                                    <label class="form-check-label" for="menu_information">
                                        <?php echo trans('footer_information'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <label>
                                        <?php echo trans('visibility'); ?>
                                    </label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input class="form-check-input" type="radio" name="visibility" value="1" id="page_enabled" class="square-purple" <?php echo (old("visibility") == 1 || old("visibility") == "") ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="page_enabled">
                                        <?php echo trans('show'); ?>
                                    </label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input class="form-check-input" type="radio" name="visibility" value="0" id="page_disabled" class="square-purple" <?php echo (old("visibility") == 0 && old("visibility") != "") ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="page_disabled">
                                        <?php echo trans('hide'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <label>
                                        <?php echo trans('show_title'); ?>
                                    </label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12">
                                    <input class="form-check-input" type="radio" name="title_active" value="1" id="title_enabled" <?php echo (old("title_active") == 1 || old("title_active") == "") ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="title_enabled"><?php echo trans('yes'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12">
                                    <input class="form-check-input" type="radio" name="title_active" value="0" id="title_disabled" <?php echo (old("title_active") == 0 && old("title_active") != "") ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="title_disabled"><?php echo trans('no'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('content'); ?></label>
                            <div class="row">
                              <div class="col-sm-12 mb-3">
                                <button type="button" class="btn btn-primary waves-effect waves-light btn_ck_add_image"><?php echo trans("add_image"); ?></button>
                                <button type="button" class="btn btn-primary waves-effect waves-light btn_ck_add_video"><?php echo trans("add_video"); ?></button>
                                <button type="button" class="btn btn-primary waves-effect waves-light btn_ck_add_iframe"><?php echo trans("add_iframe"); ?></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea id="ckEditor" class="form-control" name="page_content" placeholder="İçerik"><?php echo old('page_content'); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success waves-effect btn-label waves-light">
                        <i class="bx bx-plus label-icon"></i>
                        <?php echo trans('add_page'); ?>
                    </button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
</div>