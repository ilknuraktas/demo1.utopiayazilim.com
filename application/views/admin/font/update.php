<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("update_font"); ?></h3>
                    </div>

                    <?php echo form_open('settings_controller/update_font_post'); ?>
                    <input type="hidden" name="id" value="<?php echo $font->id; ?>">
                    <div class="card-body">
                        <?php if (!empty($this->session->flashdata('mes_add_font'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label><?php echo trans("name"); ?></label>
                                    <input type="text" class="form-control" name="font_name" value="<?php echo html_escape($font->font_name); ?>" placeholder="<?php echo trans("name"); ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                    <small>(Örnek: Open Sans)</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label"><?php echo trans("font_family"); ?> </label>
                                    <input type="text" class="form-control" name="font_family" value="<?php echo html_escape($font->font_family); ?>" placeholder="<?php echo trans("font_family"); ?>" maxlength="500" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                    <small>(Örnek: font-family: "Open Sans", Helvetica, sans-serif)</small>
                                </div>
                                <div class="col-md-12">
                                    <?php if ($font->is_default != 1): ?>
                                        <label class="control-label"><?php echo trans("url"); ?> </label>
                                        <textarea name="font_url" class="form-control" placeholder="<?php echo trans("url"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                            <?php echo $font->font_url; ?>
                                        </textarea>
                                        <small>(Örnek: <?php echo html_escape('<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">'); ?>)</small>
                                    <?php else: ?>
                                        <input type="hidden" name="font_url" value="">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary pull-right"><?php echo trans("save_changes"); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>