<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <div class="row table-filter-container">
                                <div class="col-sm-12">
                                    <?php echo form_open($form_action, ['method' => 'GET']); ?>

                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label><?php echo trans("show"); ?></label>
                                                <select name="show" class="form-control">
                                                    <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                                                    <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                                                    <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                                                    <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label><?php echo trans("search"); ?></label>
                                                <input name="order_number" class="form-control" placeholder="<?php echo trans("order_number"); ?>" type="search" value="<?php echo html_escape($this->input->get('order_number', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                            </div>

                                            <div class="col-md-3">
                                                <label style="display: block">&nbsp;</label>
                                                <button type="submit" class="btn btn-warning waves-effect btn-label waves-light"><i class="bx bx-filter-alt label-icon"></i><?php echo trans("filter"); ?></button>
                                            </div>

                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                            <thead>
                                <tr role="row">
                                    <th><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('order_number'); ?></th>
                                    <th><?php echo trans('date'); ?></th>
                                    <th><?php echo trans('buyer'); ?></th>
                                    <th><?php echo trans('first_name'); ?></th>
                                    <th><?php echo trans('last_name'); ?></th>
                                    <th><?php echo trans('address'); ?></th>
                                    <th><?php echo trans('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($invoices as $item): ?>
                                    <tr>
                                        <td><?php echo $item->id; ?></td>
                                        <td><?php echo $item->order_number; ?></td>
                                        <td><?php echo formatted_date($item->created_at); ?></td>
                                        <td><?php echo $item->client_username; ?></td>
                                        <td><?php echo $item->client_first_name; ?></td>
                                        <td><?php echo $item->client_last_name; ?></td>
                                        <td><?php echo $item->client_address; ?></td>
                                        <td>
                                            <a href="<?php echo base_url(); ?>invoice/<?php echo $item->order_number; ?>" class="btn btn-primary waves-effect btn-label waves-light" target="_blank"><i class="bx bx-link label-icon"></i> <?php echo trans("view_invoice"); ?></a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        <?php if (empty($invoices)): ?>
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