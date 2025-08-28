<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <div class="left">
                                <h3 class="card-title"><?php echo trans('blog_posts'); ?></h3>
                            </div>
                            <div class="ms-auto">
                                <a href="<?php echo admin_url(); ?>blog-add-post" class="btn btn-success waves-effect btn-label waves-light">
                                    <i class="bx bx-plus label-icon"></i><?php echo trans('add_post'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th width="20"><?php echo trans('id'); ?></th>
                                            <th><?php echo trans('title'); ?></th>
                                            <th><?php echo trans('language'); ?></th>
                                            <th><?php echo trans('category'); ?></th>
                                            <th><?php echo trans('date'); ?></th>
                                            <th class="th-options"><?php echo trans('options'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($posts as $item): ?>
                                            <?php $post_category = $this->blog_category_model->get_category($item->category_id); ?>
                                            <tr>
                                                <td><?php echo html_escape($item->id); ?></td>
                                                <td class="td-product">
                                                    <?php if (!empty($post_category)): ?>
                                                        <a href="<?php echo generate_url("blog") . "/" . $post_category->slug; ?>/<?php echo $item->slug; ?>" target="_blank" class="a-table">
                                                            <div class="img-table" style="height: 67px;">
                                                                <img src="<?php echo get_blog_image_url($item, 'image_small'); ?>" height="50px" alt=""/>
                                                            </div>
                                                            <?php echo html_escape($item->title); ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <div class="img-table" style="height: 67px;">
                                                            <img src="<?php echo get_blog_image_url($item, 'image_small'); ?>" height="50px" alt=""/>
                                                        </div>
                                                        <?php echo html_escape($item->title); ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $language = get_language($item->lang_id);
                                                    if (!empty($language)) {
                                                        echo $language->name;
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($post_category)): ?>
                                                        <?php echo html_escape($post_category->name); ?>
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
                                                                <a class="dropdown-item" href="<?php echo admin_url(); ?>update-blog-post/<?php echo html_escape($item->id); ?>">
                                                                    <?php echo trans('edit'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('blog_controller/delete_post_post','<?php echo $item->id; ?>','<?php echo trans("confirm_post"); ?>');">
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