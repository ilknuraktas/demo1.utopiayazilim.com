<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                 <div class="card-header with-border">
                    <div class="d-flex flex-wrap align-items-center mb-3">
                        <div class="left">
                           <h3 class="card-title"><?php echo trans('add_post'); ?></h3>
                       </div>
                       <div class="ms-auto">
                           <a href="<?php echo admin_url(); ?>blog-posts" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-link label-icon"></i><?php echo trans('posts'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php echo form_open_multipart('blog_controller/add_post_post'); ?>

            <div class="card-body">
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans("language"); ?></label>
                            <select name="lang_id" class="form-control max-600" onchange="get_blog_categories_by_lang(this.value);">
                                <?php foreach ($this->languages as $language): ?>
                                    <option value="<?php echo $language->id; ?>" <?php echo ($this->selected_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <label class="control-label"><?php echo trans('title'); ?></label>
                            <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                            value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <label class="control-label"><?php echo trans('slug'); ?>
                            <small>(<?php echo trans('slug_exp'); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?php echo trans('slug'); ?>"
                        value="<?php echo old('slug'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <label class="control-label">Kısa Açıklama (<?php echo trans('meta_tag'); ?>)</label>
                        <textarea style="height: 10px" class="form-control text-area" name="summary" placeholder="Kısa Açıklama (<?php echo trans('meta_tag'); ?>)" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo old('summary'); ?></textarea>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="keywords"
                        placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('keywords'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <label class="control-label"><?php echo trans('category'); ?></label>
                        <select id="categories" name="category_id" class="form-control max-600" required>
                            <option value=""><?php echo trans('select_category'); ?></option>
                            <?php foreach ($categories as $item): ?>
                                <option value="<?php echo $item->id; ?>"><?php echo html_escape($item->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <label class="control-label"><?php echo trans('tags'); ?> (<?php echo trans('type_tag'); ?>)</label>
                        <input class="form-control tag" id="tags_1" type="text" name="tag"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label"><?php echo trans('image'); ?></label>
                <div class="display-block">
                    <a class='btn btn-success btn-sm btn-file-upload'>
                        <input type="file" id="Multifileupload" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" required>
                    </a>
                </div>

                <div id="MultidvPreview" class="image-preview"></div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"><?php echo trans('content'); ?></label>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <button type="button" class="btn btn-primary waves-effect waves-light btn_ck_add_image"><?php echo trans("add_image"); ?></button>
                                <button type="button" class="btn btn-primary waves-effect waves-light btn_ck_add_video"><?php echo trans("add_video"); ?></button>
                                <button type="button" class="btn btn-primary waves-effect waves-light btn_ck_add_iframe"><?php echo trans("add_iframe"); ?></button>
                            </div>
                        </div>
                        <textarea id="ckEditor" class="form-control" name="content"><?php echo old('content'); ?></textarea>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success waves-effect btn-label waves-light">
                <i class="bx bx-plus label-icon"></i>
                <?php echo trans('add_post'); ?>
            </button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>
</div>
</div>