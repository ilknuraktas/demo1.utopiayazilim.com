<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <div class="d-flex flex-wrap align-items-center mb-3">
                    <div class="left">
                        <h3 class="card-title"><?php echo trans('categories'); ?></h3>
                    </div>
                    <div class="ms-auto">
                        <a href="<?php echo admin_url(); ?>add-category" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-plus label-icon"></i> <?php echo trans('add_category'); ?>
                        </a>
                    </div>
                </div>
            </div><!-- /.box-header -->

            <div class="card-body">
                <div class="row">
                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" role="grid">
                                <?php $this->load->view('admin/category/_filter_categories'); ?>
                                <thead>
                                    <tr role="row">
                                        <th class="text-center" width="20"><?php echo trans('id'); ?></th>
                                        <th class="text-center"><?php echo trans('category_name'); ?></th>
                                        <th class="text-center"><?php echo trans('parent_category'); ?></th>
                                        <th class="text-center"><?php echo trans('order'); ?></th>
                                        <th class="text-center"><?php echo trans('visibility'); ?></th>
                                        <th class="text-center"><?php echo trans('show_on_homepage'); ?></th>
                                        <th class="text-center">Anasayfa Listeleme</th>
                                        <th class="th-options text-center"><?php echo trans('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($categories)):
                                        foreach ($categories as $item): ?>
                                            <tr>
                                                <td class="text-center"><?php echo html_escape($item->id); ?></td>
                                                <td><?php echo category_name($item); ?></td>
                                                <td>
                                                    <?php
                                                    $parent = get_category_by_id($item->parent_id);
                                                    if (!empty($parent)) {
                                                        echo category_name($parent);
                                                    } else {
                                                        echo "-";
                                                    } ?>
                                                </td>
                                                <td class="text-center"><?php echo html_escape($item->category_order); ?></td>
                                                <td class="text-center">
                                                    <?php if ($item->visibility == 1): ?>
                                                        <label class="label label-success label-table"><i class="fa fa-eye"></i></label>
                                                    <?php else: ?>
                                                        <label class="label label-danger label-table"><i class="fa fa-eye"></i></label>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($item->show_on_homepage == 1): ?>
                                                        <label class="label label-success label-table"><?php echo trans('yes'); ?></label>
                                                    <?php else: ?>
                                                        <label class="label label-danger label-table"><?php echo trans('no'); ?></label>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($item->home_show == 1): ?>
                                                        <label class="label label-success label-table"><?php echo trans('yes'); ?></label>
                                                    <?php else: ?>
                                                        <label class="label label-danger label-table"><?php echo trans('no'); ?></label>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                        <i class="bx bx-brightness label-icon"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo admin_url(); ?>update-category/<?php echo html_escape($item->id); ?>"><?php echo trans('edit'); ?></a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('category_controller/delete_category_post','<?php echo $item->id; ?>','<?php echo trans("confirm_category"); ?>');"><?php echo trans('delete'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>

                        <?php if (empty($categories)): ?>
                            <p class="text-center">
                                <?php echo trans("no_records_found"); ?>
                            </p>
                        <?php endif; ?>
                        <div class="col-sm-12 table-ft">
                            <div class="row">

                                <div class="pull-right">
                                    <?php echo $this->pagination->create_links(); ?>
                                </div>
                                <?php if (count($categories) > 0): ?>
                                    <div class="pull-left">
                                        <button class="btn btn-danger waves-effect btn-label waves-light" onclick="delete_selected_products('<?php echo trans("confirm_products"); ?>');">
                                            <i class="bx bx-trash label-icon"></i>
                                            <?php echo trans('delete'); ?>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div>
</div>
</div>