<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="promoted_posts">
    <!--div class="row mb-4" style="justify-content: space-between">
        <div class="left">
            <h3 style="margin-left:-12px;color:#2a41e8;margin-bottom:4px;font-size:24px;text-transform:inherit" class="title">Trend Ürünler </h3>
            <p style="margin-bottom:0;font-size:17px;color:#2a41e8;margin-left:19px">En çok görüntülenen ürünler</p>
        </div>
        <a style="margin-right:15px;margin-left:20px;display: flex;-webkit-box-pack: justify;justify-content: space-between;-webkit-box-align: center;align-items: center;font-weight: 500;font-size:14px;color:#2a41e8" href="<?php echo generate_url("products"); ?>" class="link-see-more">
            <span><?php echo trans("see_more"); ?>&nbsp;</span><i style="font-size:20px;margin-bottom: 4px;" class="icon-arrow-right"></i>
        </a>
    </div-->
    <div id="row_promoted_products" class="row row-product">
        <?php foreach ($trend_products as $product): ?>
            <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-product">
                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false]); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <input type="hidden" id="promoted_products_offset" value="<?php echo count($trend_products); ?>">
    <div id="load_promoted_spinner" class="col-12 load-more-spinner">
        <div class="row">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>
   
</div>