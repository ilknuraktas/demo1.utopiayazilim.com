<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo trans("options"); ?>&nbsp;(<?php echo html_escape(get_variation_label($variation->label_names, $this->selected_lang->id)); ?>)</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <hr>
            <div class="variation-options-container">
                <?php if (!empty($variation_options)): ?>
                    <ul>
                        <?php foreach ($variation_options as $option): ?>
                            <li>
                                <div class="float-left">
                                    <strong><?php echo html_escape(get_variation_option_name($option->option_names, $this->selected_lang->id)); ?></strong>
                                    <?php if ($option->is_default == 1): ?>
                                        <span><?php echo trans("stock"); ?>:&nbsp;<strong><?php echo $product->stock; ?></strong></span>
                                    <?php else: ?>
                                        <span><?php echo trans("stock"); ?>:&nbsp;<strong><?php echo $option->stock; ?></strong></span>
                                    <?php endif; ?>
                                    <?php if ($option->is_default == 1): ?>
                                        <label class="badge badge-success"><?php echo trans("default"); ?></label>
                                    <?php endif; ?>
                                </div>
                                <div class="float-right">
                                    <button type="button" class="btn btn-warning btn-sm waves-effect btn-label waves-light" onclick='edit_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>");'>
                                        <i class="bx bx-edit label-icon"></i>
                                        <?php echo trans('edit'); ?></button>
                                        <button type="button" class="btn btn-danger btn-sm waves-effect btn-label waves-light" onclick='delete_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>","<?php echo trans("confirm_delete"); ?>");'>
                                            <i class="bx bx-trash label-icon"></i>
                                            <?php echo trans('delete'); ?></button>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted text-center m-t-15"> <?php echo trans("no_records_found"); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row-custom">
                <button type="submit" class="btn btn-danger waves-effect btn-label waves-light" data-bs-dismiss="modal">
                    <i class="mdi mdi-close label-icon"></i>
                    <?php echo trans("close"); ?>
                </button>
            </div>
        </div>
