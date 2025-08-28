<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <div class="d-flex flex-wrap align-items-center mb-3">
                    <div class="left">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="ms-auto">
                        <a href="<?php echo admin_url(); ?>add-state" class="btn btn-success waves-effect btn-label waves-light">
                            <i class="bx bx-plus label-icon"></i>
                            <?php echo trans('add_state'); ?>
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
                            <div class="row table-filter-container">
                                <div class="col-sm-12">
                                    <?php echo form_open(admin_url() . "states", ['method' => 'GET']); ?>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label><?php echo trans("show"); ?></label>
                                                <select name="show" class="form-control">
                                                    <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                                                    <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                                                    <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                                                    <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label><?php echo trans('country'); ?></label>
                                                <select name="country" class="form-control">
                                                    <option value=""><?php echo trans("all"); ?></option>
                                                    <?php
                                                    foreach ($countries as $item): ?>
                                                        <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('country', true) == $item->id) ? 'selected' : ''; ?>>
                                                            <?php echo html_escape($item->name); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label><?php echo trans("search"); ?></label>
                                                <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="display: block">&nbsp;</label>
                                                <button type="submit" class="btn btn-warning waves-effect btn-label waves-light">
                                                    <i class="bx bx-filter-alt label-icon"></i>
                                                    <?php echo trans("filter"); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                                <thead>
                                    <tr role="row">
                                        <th><?php echo trans('id'); ?></th>
                                        <th><?php echo trans('name'); ?></th>
                                        <th><?php echo trans('country'); ?></th>
                                        <th><?php echo trans('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($states as $item): ?>
                                        <tr>
                                            <td><?php echo html_escape($item->id); ?></td>
                                            <td><?php echo html_escape($item->name); ?></td>
                                            <td>
                                                <?php echo html_escape($item->country_name); ?>
                                                <?php if ($item->country_status == 1): ?>
                                                    <label class="badge bg-success"><?php echo trans("active"); ?></label>
                                                <?php else: ?>
                                                    <label class="badge bg-danger"><?php echo trans("inactive"); ?></label>
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
                                                            <a class="dropdown-item" href="<?php echo admin_url(); ?>update-state/<?php echo html_escape($item->id); ?>">
                                                                <?php echo trans('edit'); ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('admin_controller/delete_state_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');">
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

                            <?php if (empty($states)): ?>
                                <p class="text-center">
                                    <?php echo trans("no_records_found"); ?>
                                </p>
                            <?php endif; ?>
                            <div class="col-sm-12 table-ft">
                                <div class="row">

                                    <div class="pull-right">
                                        <?php echo $this->pagination->create_links(); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>