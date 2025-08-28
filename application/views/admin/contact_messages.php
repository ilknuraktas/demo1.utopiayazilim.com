<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <div class="left">
                    <h3 class="card-title"><?php echo trans('contact_messages'); ?></h3>
                </div>
            </div>

            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>

            <div class="card-body">
                <div class="row">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                            <tr role="row">
                                <th><?php echo trans('id'); ?></th>
                                <th><?php echo trans('date'); ?></th>
                                <th><?php echo trans('name'); ?></th>
                                <th><?php echo trans('email'); ?></th>
                                <th><?php echo trans('message'); ?></th>
                                <th><?php echo trans('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($messages as $item): ?>
                                <tr>
                                    <td><?php echo html_escape($item->id); ?></td>
                                    <td><?php echo formatted_date($item->created_at); ?></td>
                                    <td><?php echo html_escape($item->name); ?></td>
                                    <td><?php echo html_escape($item->email); ?></td>
                                    <td class="break-word"><?php echo html_escape($item->message); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown">
                                                <?php echo trans('select_option'); ?>
                                                <i class="bx bx-brightness label-icon"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('admin_controller/delete_contact_message_post','<?php echo $item->id; ?>','<?php echo trans("confirm_message"); ?>');">
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
            </div><!-- /.box-body -->
        </div>
    </div>
</div>