<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">


            <div class="col-sm-12 col-md-12">

                <!-- Nav pills -->
                <?php
                $products = $this->product_model->get_user_pending_products_count(11);
                if ($this->auth_check && $this->auth_user->id == $user->id) :
                    foreach ($products as  $product) :
                        $this->load->view('product/_product_item_profile', ['product' => $product, 'promoted_badge' => true]);
                    endforeach;
                else : ?>
                    <div class="row row-product-items row-product">
                        <!--print products-->
                        <?php foreach ($products->result() as $product) : ?>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-3 col-product">
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<!-- Wrapper End-->

<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    $(document).ready(function() {
        $('#para-birimleri').DataTable();
    });
    $(document).ready(function() {
        $('#teslimat-suresi').DataTable();
    });
    $(document).ready(function() {
        $('#kargo').DataTable();
    });
</script>