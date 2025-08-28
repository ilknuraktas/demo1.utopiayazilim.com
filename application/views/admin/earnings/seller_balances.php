<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <h3 class="card-title"><?php echo $title; ?></h3>
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
                                <?php $this->load->view('admin/earnings/_filter_seller_balances'); ?>
                                <thead>
                                    <tr role="row">
                                        <th><?php echo trans('user_id'); ?></th>
                                        <th><?php echo trans('user'); ?></th>
                                        <th><?php echo trans('number_of_total_sales'); ?></th>
                                        <th><?php echo trans('balance'); ?></th>
                                        <th class="th-options"><?php echo trans('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($balances as $item): ?>
                                        <tr>
                                            <td><?php echo $item->id; ?></td>
                                            <td>
                                                <?php if (!empty($item)): ?>
                                                    <div class="table-orders-user">
                                                        <a href="<?php echo generate_profile_url($item->slug); ?>" target="_blank">
                                                            <div style="overflow: hidden; float: left; margin-right: 10px;">
                                                                <img src="<?php echo get_user_avatar($item); ?>" alt="" class="rounded-circle avatar-sm">
                                                            </div>
                                                            <?php echo html_escape($item->username); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong class="font-600"><?php echo $item->number_of_sales; ?></strong></td>
                                            <td><strong class="font-600"><?php echo price_formatted($item->balance, $this->payment_settings->default_product_currency); ?></strong></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <i class="bx bx-brightness label-icon"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo admin_url(); ?>update-seller-balance/<?php echo html_escape($item->id); ?>"><?php echo trans('edit'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>

                        <?php if (empty($balances)): ?>
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
        </div><!-- /.box-body -->
    </div>
</div>
</div>
<style>
    .font-600{
        font-weight: 600;
    }
</style>