<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <div class="left">
                    <h3 class="card-title"><?php echo trans('reviews'); ?></h3>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th width="20" class="table-no-sort" style="text-align: center !important;">
                                        <input type="checkbox" class="checkbox-table" id="checkAll">
                                    </th>
                                    <th><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('user'); ?></th>
                                    <th><?php echo trans('review'); ?></th>
                                    <th><?php echo trans('product'); ?></th>
                                    <th><?php echo trans('ip_address'); ?></th>
                                    <th><?php echo trans('date'); ?></th>
                                    <th><?php echo trans('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($reviews as $item): ?>
                                    <tr>
                                        <td style="text-align: center !important;">
                                            <input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                            <td><?php echo html_escape($item->id); ?></td>
                                            <td><?php echo html_escape($item->user_username); ?></td>
                                            <td class="break-word">
                                                <div>
                                                    <?php $this->load->view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                                                </div>
                                                <?php echo html_escape($item->review); ?>
                                            </td>
                                            <td>
                                                <?php $product = get_product($item->product_id);
                                                if (!empty($product)): ?>
                                                    <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                        <?php echo html_escape($product->title); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $item->ip_address; ?></td>
                                            <td><?php echo formatted_date($item->created_at); ?></td>

                                            <td>
                                                <div class="btn-group">
                                                    <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown">
                                                        <?php echo trans('select_option'); ?>
                                                        <i class="bx bx-brightness label-icon"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('product_admin_controller/delete_review','<?php echo $item->id; ?>','<?php echo trans("confirm_review"); ?>');">
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

                        <div class="col-sm-12">
                            <div class="row">
                                <div class="pull-left">
                                    <button class="btn btn-danger waves-effect btn-label waves-light btn-table-delete" onclick="delete_selected_reviews('<?php echo trans("confirm_reviews"); ?>');">
                                        <i class="bx bx-trash label-icon"></i>
                                        <?php echo trans('delete'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>