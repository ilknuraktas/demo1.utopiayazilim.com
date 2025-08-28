<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <div class="left">
                    <h3 class="card-title"><?php echo trans('administrators'); ?></h3>
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
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans('id'); ?></th>
                                <th><?php echo trans('image'); ?></th>
                                <th><?php echo trans('username'); ?></th>
                                <th><?php echo trans('email'); ?></th>
                                <th><?php echo str_replace(":", "", trans('last_seen')); ?></th>
                                <th><?php echo trans('date'); ?></th>
                                <th class="max-width-120"><?php echo trans('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo html_escape($user->id); ?></td>
                                    <td>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-link">
                                            <img src="<?php echo get_user_avatar($user); ?>" alt="user" class="img-responsive" style="height: 50px;">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-link"><?php echo html_escape($user->username); ?></a>
                                    </td>
                                    <td><?php echo html_escape($user->email); ?></td>
                                    <td><?php echo time_ago($user->last_seen); ?></td>
                                    <td><?php echo formatted_date($user->created_at); ?></td>

                                    <td>
                                        <div class="btn-group">
                                            <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown">
                                                <?php echo trans('select_option'); ?>
                                                <i class="bx bx-brightness label-icon"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>edit-user/<?php echo $user->id; ?>">
                                                        <?php echo trans('edit_user'); ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('admin_controller/delete_user_post','<?php echo $user->id; ?>','<?php echo trans("confirm_user"); ?>');">
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