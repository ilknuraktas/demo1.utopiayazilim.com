<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="left">
                    <h3 class="card-title"><?php echo $title; ?> - <?php echo $language->name; ?></h3>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>

                <?php $this->load->view('admin/language/_filter_translations'); ?>
                <?php echo form_open('language_controller/update_translations_post'); ?>
                <input type="hidden" name="lang_id" value="<?php echo $language->id; ?>">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo trans('id'); ?></th>
                            <th><?php echo trans('phrase'); ?></th>
                            <th><?php echo trans('label'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($translations as $item): ?>
                            <tr>
                                <td>
                                    <?php echo $item->id; ?>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?php echo $item->label; ?>" <?php echo ($language->text_direction == "rtl") ? 'dir="rtl"' : ''; ?> readonly>
                                </td>
                                <td>
                                    <input type="text" name="<?php echo $item->id; ?>" data-label="<?php echo $item->id; ?>" data-lang="<?php echo $item->lang_id; ?>" class="form-control input_translation" value="<?php echo $item->translation; ?>" <?php echo ($language->text_direction == "rtl") ? 'dir="rtl"' : ''; ?>>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex flex-wrap align-items-center mb-3">
                <button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
                    <i class="bx bx-check label-icon"></i>
                    <?php echo trans("save_changes"); ?>
                </button>
                <?php echo form_close(); ?>
                <?php if (empty($translations)): ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>

                <div class=" ms-auto">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>