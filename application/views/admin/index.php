<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Yönetici Paneli</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Utopia Store Maker</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row hstack">
        <div class="col-xl-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="text-center py-3">
                        <ul class="bg-bubbles ps-0">
                            <li><i class="bx bx-grid-alt font-size-24"></i></li>
                            <li><i class="bx bx-tachometer font-size-24"></i></li>
                            <li><i class="bx bx-store font-size-24"></i></li>
                            <li><i class="bx bx-cube font-size-24"></i></li>
                            <li><i class="bx bx-cylinder font-size-24"></i></li>
                            <li><i class="bx bx-command font-size-24"></i></li>
                            <li><i class="bx bx-hourglass font-size-24"></i></li>
                            <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                            <li><i class="bx bx-coffee font-size-24"></i></li>
                            <li><i class="bx bx-polygon font-size-24"></i></li>
                        </ul>
                        <div class="main-wid position-relative">
                            <h3 class="text-white">Hoşgeldin Yönetici</h3>
                            <p class="text-white-50 px-4 mt-4">Özgürce kullanabileceğin bir yönetim paneli!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="mdi mdi-shopping-outline text-primary font-size-24"></i>
                                </span>
                            </div>
                            <p class="text-muted mt-4 mb-0"><a href="<?php echo admin_url(); ?>orders"><?php echo trans("orders"); ?></a></p>
                            <h4 class="mt-1 mb-0"><?php echo $order_count; ?></h4>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                <span class="avatar-title bg-soft-success rounded">
                                    <i class="mdi mdi-eye-outline text-success font-size-24"></i>
                                </span>
                            </div>
                            <p class="text-muted mt-4 mb-0"><a href="<?php echo admin_url(); ?>products"><?php echo trans("products"); ?></a></p>
                            <h4 class="mt-1 mb-0"><?php echo $product_count; ?></h4>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                <span class="avatar-title bg-soft-primary rounded">
                                    <i class="mdi mdi-rocket-outline text-primary font-size-24"></i>
                                </span>
                            </div>
                            <p class="text-muted mt-4 mb-0"><a href="<?php echo admin_url(); ?>pending-products"><?php echo trans("pending_products"); ?></a></p>
                            <h4 class="mt-1 mb-0"><?php echo $pending_product_count; ?></h4>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="avatar">
                                <span class="avatar-title bg-soft-success rounded">
                                    <i class="mdi mdi-account-multiple-outline text-success font-size-24"></i>
                                </span>
                            </div>
                            <p class="text-muted mt-4 mb-0"><a href="<?php echo admin_url(); ?>members"><?php echo trans("members"); ?></a></p>
                            <h4 class="mt-1 mb-0"><?php echo $members_count; ?></h4>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center">
                        <h3 class="card-title"><?php echo trans("latest_orders"); ?></h3>
                    </div>
                </div>
                <div class="card-body pt-xl-1">
                    <div class="table-responsive px-3" data-simplebar style="height: 400px;">
                        <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th><?php echo trans("order"); ?></th>
                                    <th><?php echo trans("date"); ?></th>
                                    <th class="text-center"><?php echo trans("total"); ?></th>
                                    <th class="text-center"><?php echo trans("status"); ?></th>
                                    <th class="text-center"><?php echo trans("details"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latest_orders as $item): ?>
                                    <tr>
                                        <td>#<?php echo $item->order_number; ?></td>
                                        <td><?php echo date("d/m/Y h:i", strtotime($item->created_at)); ?></td>
                                        <td class="text-center"><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                        <td class="text-center">
                                            <?php if ($item->status == 1):
                                                echo trans("completed");
                                            else:
                                                echo trans("order_processing");
                                            endif; ?>
                                        </td>
                                        <td style="width: 10%">
                                            <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-warning waves-effect waves-light btn-sm"><?php echo trans('details'); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-grid gap-2">
                    <a href="<?php echo admin_url(); ?>orders" class="btn btn-warning waves-effect waves-light">
                        <?php echo trans("view_all"); ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center">
                        <h3 class="card-title"><?php echo trans("latest_products"); ?></h3>
                    </div>
                </div>
                <div class="card-body pt-xl-1">
                    <div class="table-responsive px-3" data-simplebar style="height: 400px;">
                        <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th><?php echo trans("id"); ?></th>
                                    <th><?php echo trans("name"); ?></th>
                                    <th><?php echo trans("details"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latest_products as $item): ?>
                                    <tr>
                                        <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                        <td class="index-td-product">
                                            <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="avatar-sm rounded-circle"/>
                                            <?php echo html_escape($item->title); ?>
                                        </td>
                                        <td style="width: 10%">
                                            <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>" class="btn btn-warning waves-effect waves-light btn-sm"><?php echo trans('details'); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="card-footer d-grid cap-2">
                    <a href="<?php echo admin_url(); ?>products" class="btn btn-warning waves-effect waves-light">
                        <?php echo trans("view_all"); ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center">
                        <h3 class="card-title"><?php echo trans("latest_pending_products"); ?></h3>
                    </div>
                </div>
                <div class="card-body pt-xl-1">
                    <div class="table-responsive" data-simplebar style="height: 400px;">
                        <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th><?php echo trans("id"); ?></th>
                                    <th><?php echo trans("name"); ?></th>
                                    <th><?php echo trans("details"); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latest_pending_products as $item): ?>
                                    <tr>
                                        <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                        <td class="index-td-product">
                                            <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="avatar-sm rounded-circle"/>
                                            <?php echo html_escape($item->title); ?>
                                        </td>
                                        <td style="width: 10%;vertical-align: center !important;">
                                            <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>" class="btn btn-warning waves-effect waves-light btn-sm"><?php echo trans('details'); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="card-footer d-grid gap-3">
                    <a href="<?php echo admin_url(); ?>pending-products" class="btn btn-warning waves-effect waves-light">
                        <?php echo trans("view_all"); ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center">
                        <h3 class="card-title"><?php echo trans("latest_transactions"); ?></h3>
                    </div>
                </div>
                <div class="card-body pt-xl-1">
                    <div class="table-responsive" data-simplebar style="height: 400px;">
                        <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th><?php echo trans("id"); ?></th>
                                    <th><?php echo trans("order"); ?></th>
                                    <th><?php echo trans("date"); ?></th>
                                    <th><?php echo trans("payment_amount"); ?></th>
                                    <th><?php echo trans('payment_method'); ?></th>
                                    <th><?php echo trans('status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latest_transactions as $item): ?>
                                    <tr>
                                        <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                        <td style="white-space: nowrap">#<?php
                                        $order = $this->order_admin_model->get_order($item->order_id);
                                        if (!empty($order)):
                                            echo $order->order_number;
                                        endif; ?>
                                    </td>
                                    <td><?php echo date("d-m-Y / h:i", formatted_date($item->created_at)); ?></td>
                                    <td><?php echo price_currency_format($item->payment_amount, $item->currency); ?></td>
                                    <td>
                                        <?php
                                        if ($item->payment_method == "Bank Transfer") {
                                            echo trans("bank_transfer");
                                        } else {
                                            echo $item->payment_method;
                                        } ?>
                                    </td>
                                    <td><?php echo trans($item->payment_status); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <div class="card-footer d-grid gap-3">
                <a href="<?php echo admin_url(); ?>transactions" class="btn btn-warning waves-effect waves-light">
                    <?php echo trans("view_all"); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center">
                    <h3 class="card-title"><?php echo trans("latest_reviews"); ?></h3>
                </div>
            </div>
            <div class="card-body pt-xl-1">
                <div class="table-responsive" data-simplebar style="height: 400px;">
                    <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th><?php echo trans("id"); ?></th>
                                <th><?php echo trans("username"); ?></th>
                                <th style="width: 60%"><?php echo trans("review"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest_reviews as $item): ?>
                                <tr>
                                    <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                    <td style="width: 25%" class="break-word">
                                        <?php echo html_escape($item->user_username); ?>
                                    </td>
                                    <td style="width: 65%" class="break-word">
                                        <div>
                                            <?php $this->load->view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                                        </div>
                                        <?php echo character_limiter($item->review, 100); ?>
                                        <div class="table-sm-meta">
                                            <?php echo time_ago($item->created_at); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-grid gap-3">
                <a href="<?php echo admin_url(); ?>product-reviews" class="btn btn-warning waves-effect waves-light">
                    <?php echo trans("view_all"); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center">
                    <h3 class="card-title"><?php echo trans("latest_transactions"); ?>&nbsp;(<?php echo trans("featured_products"); ?>)
                    </h3>
                </div>
            </div>
            <div class="card-body pt-xl-1">
                <div class="table-responsive" data-simplebar style="height: 400px;">
                    <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th><?php echo trans("id"); ?></th>
                                <th><?php echo trans('payment_method'); ?></th>
                                <th><?php echo trans("payment_amount"); ?></th>
                                <th><?php echo trans('status'); ?></th>
                                <th><?php echo trans("date"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest_promoted_transactions as $item): ?>
                                <tr>
                                    <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                    <td>
                                        <?php
                                        if ($item->payment_method == "Bank Transfer") {
                                            echo trans("bank_transfer");
                                        } else {
                                            echo $item->payment_method;
                                        } ?>
                                    </td>
                                    <td><?php echo price_currency_format($item->payment_amount, $item->currency); ?></td>
                                    <td><?php echo trans($item->payment_status); ?></td>
                                    <td><?php echo formatted_date($item->created_at); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-grid gap-3">
                <a href="<?php echo admin_url(); ?>featured-products-transactions" class="btn btn-warning waves-effect waves-light">
                    <?php echo trans("view_all"); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center">
                    <h3 class="card-title"><?php echo trans("latest_comments"); ?></h3>
                </div>
            </div>
            <div class="card-body pt-xl-1">
                <div class="table-responsive" data-simplebar style="height: 400px;">
                    <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th><?php echo trans("id"); ?></th>
                                <th><?php echo trans("user"); ?></th>
                                <th style="width: 60%"><?php echo trans("comment"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest_comments as $item): ?>
                                <tr>
                                    <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                    <td style="width: 25%" class="break-word">
                                        <?php echo html_escape($item->name); ?>
                                    </td>
                                    <td style="width: 65%" class="break-word">
                                        <?php echo character_limiter($item->comment, 100); ?>
                                        <div class="table-sm-meta">
                                            <?php echo time_ago($item->created_at); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-grid gap-3">
                <a href="<?php echo admin_url(); ?>product-comments" class="btn btn-warning waves-effect waves-light">
                    <?php echo trans("view_all"); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center">
                    <h3 class="card-title"><?php echo trans("latest_members"); ?></h3>
                </div>
            </div>
            <div class="card-body" data-simplebar style="height: 400px;">
                <ul class="users-list clearfix" style="display: flex;">
                    <?php if (!empty($latest_members)):
                        foreach ($latest_members as $item) : ?>
                            <li style="display: flex; flex-direction: column; align-items: center;margin: 0 10px;">
                                <a href="<?php echo generate_profile_url($item->slug); ?>">
                                    <img src="<?php echo get_user_avatar($item); ?>" alt="user" class="rounded-circle avatar-md">
                                </a>
                                <a href="<?php echo generate_profile_url($item->slug); ?>" class="users-list-name">
                                    <?php echo html_escape($item->username); ?>
                                </a>
                                <span class="users-list-date"><?php echo time_ago($item->created_at); ?></span>
                            </li>
                        <?php endforeach;
                    endif; ?>
                </ul>
            </div>
            <div class="card-footer d-grid gap-3">
                <a href="<?php echo admin_url(); ?>members" class="btn btn-warning waves-effect waves-light">
                    <?php echo trans("view_all"); ?>
                </a>
            </div>
        </div>
    </div>
</div>

</div>
