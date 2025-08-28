<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <div class="left">
                                <h3 class="card-title">
                                    <?php echo trans('custom_fields'); ?>
                                </h3>
                            </div>
                            <div class="ms-auto">
                                <a href="<?php echo admin_url(); ?>add-custom-field" class="btn btn-success waves-effect btn-label waves-light">
                                    <i class="bx bx-plus label-icon"></i> 
                                    <?php echo trans('add_custom_field'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
                                    <thead>
                                        <tr role="row">
                                            <th><?php echo trans('id'); ?></th>
                                            <th><?php echo trans('name'); ?></th>
                                            <th><?php echo trans('type'); ?></th>
                                            <th>&nbsp;</th>
                                            <th><?php echo trans('required'); ?></th>
                                            <th><?php echo trans('order'); ?></th>
                                            <th><?php echo trans('status'); ?></th>
                                            <th><?php echo trans('options'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($fields as $item): ?>
                                            <tr>
                                                <td><?php echo html_escape($item->id); ?></td>
                                                <td><?php echo html_escape($item->name); ?></td>
                                                <td><?php echo trans($item->field_type); ?></td>
                                                <td>
                                                    <?php echo form_open_multipart('category_controller/add_remove_custom_field_filters_post'); ?>
                                                    <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                                                    <?php if ($item->field_type == 'checkbox' || $item->field_type == 'radio_button' || $item->field_type == 'dropdown'):
                                                        if ($item->is_product_filter == 1):?>
                                                            <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i>&nbsp;<?php echo trans('remove_from_product_filters'); ?></button>
                                                        <?php else: ?>
                                                            <button class="btn btn-sm btn-success"><i class="bx bx-plus"></i>&nbsp;<?php echo trans('add_to_product_filters'); ?></button>
                                                        <?php endif;
                                                    endif; ?>
                                                    <?php echo form_close(); ?>
                                                </td>
                                                <td>
                                                    <?php if ($item->is_required == 1) {
                                                        echo trans("yes");
                                                    } else {
                                                        echo trans("no");
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo html_escape($item->field_order); ?></td>
                                                <td>
                                                    <?php if ($item->status == 1): ?>
                                                        <label class="label bg-olive label-table"><?php echo trans('active'); ?></label>
                                                    <?php else: ?>
                                                        <label class="label bg-danger label-table"><?php echo trans('inactive'); ?></label>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown">
                                                            <?php echo trans('select_option'); ?>
                                                            <i class="bx bx-brightness label-icon"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <li>
                                                                <a class="dropdown-item" href="<?php echo admin_url(); ?>update-custom-field/<?php echo html_escape($item->id); ?>">
                                                                    <?php echo trans('edit'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('category_controller/delete_custom_field_post','<?php echo $item->id; ?>','<?php echo trans("confirm_custom_field"); ?>');">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>