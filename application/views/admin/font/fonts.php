<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("site_font"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open('settings_controller/set_site_font_post'); ?>

                    <div class="card-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata('mes_set_font'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <label><?php echo trans("language"); ?></label>
                            <select name="lang_id" class="form-control" onchange="window.location.href = '<?php echo admin_url(); ?>' + 'font-settings?lang='+this.value;">
                                <?php foreach ($this->languages as $language): ?>
                                    <option value="<?php echo $language->id; ?>" <?php echo ($selected_lang == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label-sitemap"><?php echo trans('site_font'); ?></label>
                            <select name="site_font" class="form-control custom-select">
                                <?php foreach ($fonts as $font): ?>
                                    <option value="<?php echo $font->id; ?>" <?php echo ($settings->site_font == $font->id) ? 'selected' : ''; ?>><?php echo $font->font_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
                            <i class="bx bx-check label-icon"></i>
                            <?php echo trans('save_changes'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <div class="card">
                    <div class="card-header with-border">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <h3 class="card-title"><?php echo trans("add_font"); ?></h3>
                            <div class="ms-auto">
                                <a href="https://fonts.google.com/" target="_blank">
                                    <strong>
                                        Google Fonts'a Git 
                                        <i class="bx bx-right-arrow-alt"></i>
                                    </strong>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open('settings_controller/add_font_post'); ?>

                    <div class="card-body">
                        <?php if (!empty($this->session->flashdata('mes_add_font'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <label><?php echo trans("name"); ?></label>
                            <input type="text" class="form-control" name="font_name" placeholder="<?php echo trans("name"); ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            <small>(Örnek: Open Sans)</small>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans("url"); ?> </label>
                            <textarea name="font_url" class="form-control" placeholder="<?php echo trans("url"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required></textarea>
                            <small>(Örnek: <?php echo html_escape('<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">'); ?>)</small>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans("font_family"); ?> </label>
                            <input type="text" class="form-control" name="font_family" placeholder="<?php echo trans("font_family"); ?>" maxlength="500" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            <small>(Örnek: font-family: "Open Sans", Helvetica, sans-serif)</small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-plus label-icon"></i>
                            <?php echo trans('add_font'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="pull-left">
                            <h3 class="card-title"><?php echo trans('fonts'); ?></h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php if (!empty($this->session->flashdata('mes_table'))):
                                    $this->load->view('admin/includes/_messages');
                                endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th><?php echo trans('id'); ?></th>
                                        <th><?php echo trans("name"); ?></th>
                                        <th><?php echo trans("font_family"); ?></th>
                                        <th><?php echo trans("options"); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($fonts as $font): ?>
                                        <tr>
                                            <td><?php echo html_escape($font->id); ?></td>
                                            <td><?php echo html_escape($font->font_name); ?></td>
                                            <td><?php echo html_escape($font->font_family); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown">
                                                        <?php echo trans('select_option'); ?>
                                                        <i class="bx bx-brightness label-icon"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo admin_url(); ?>update-font/<?php echo html_escape($font->id); ?>">
                                                                <?php echo trans('edit'); ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('settings_controller/delete_font_post','<?php echo $font->id; ?>','<?php echo trans("confirm_delete"); ?>');">
                                                                <?php echo trans('delete'); ?>
                                                            </a>
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
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</div>
</div>