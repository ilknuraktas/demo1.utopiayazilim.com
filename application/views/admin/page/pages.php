<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <div class="d-flex flex-wrap align-items-center mb-3">
                    <div class="left">
                        <h3 class="card-title"><?php echo trans('pages'); ?></h3>
                    </div>
                    <div class="ms-auto">
                        <a href="<?php echo admin_url(); ?>add-page" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-plus label-icon"></i><?php echo trans('add_page'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" role="grid">
                            <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('title'); ?></th>
                                    <th><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('location'); ?></th>
                                    <th><?php echo trans('visibility'); ?></th>
                                    <th><?php echo trans('page_type'); ?></th>
                                    <th><?php echo trans('date'); ?></th>
                                    <th><?php echo trans('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($pages as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td><?php echo html_escape($item->title); ?></td>
                                        <td>
                                            <?php
                                            $language = get_language($item->lang_id);
                                            if (!empty($language)) {
                                                echo $language->name;
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if ($item->location == 'top_menu') {
                                                echo trans("top_menu");
                                            } else {
                                                echo trans("footer_" . $item->location);
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if ($item->visibility == 1): ?>
                                                <label class="label label-success"><i class="fa fa-eye"></i></label>
                                            <?php else: ?>
                                                <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($item->is_custom == 1): ?>
                                                <label class="label bg-teal"><?php echo trans('custom'); ?></label>
                                            <?php else: ?>
                                                <label class="label label-default"><?php echo trans('default'); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo formatted_date($item->created_at); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown">
                                                    <?php echo trans('select_option'); ?>
                                                    <i class="bx bx-brightness label-icon"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>update-page/<?php echo html_escape($item->id); ?>">
                                                            <?php echo trans('edit'); ?>
                                                        </a>
                                                    </li>
                                                    <?php if ($item->is_custom == 1): ?>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('page_controller/delete_page_post','<?php echo $item->id; ?>','<?php echo trans("confirm_page"); ?>');">
                                                                <?php echo trans('delete'); ?>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
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