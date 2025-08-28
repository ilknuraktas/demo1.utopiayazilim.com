<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


    <div class="row" style="justify-content: space-between">
        <div class="left" style="margin-left: 15px;">
            <h3 style="color:#2a41e8;font-size:24px;text-transform:inherit"><?=get_category_by_id($category)->name?> </h3>
            <h5 style="font-size:16px;text-transform:inherit"><?=get_category_by_id($category)->name?> Kategorisini İncele </h5>
        </div>

        <a style="margin-right:15px;margin-left:20px;display: flex;-webkit-box-pack: justify;justify-content: space-between;-webkit-box-align: center;align-items: center;font-weight: 500;font-size:14px;" href="<?php echo generate_url("products"); ?>" class="link-see-more">
            <span><?php echo trans("see_more"); ?>&nbsp;</span><i style="font-size:20px;margin-bottom: 4px;" class="icon-arrow-right"></i>
        </a>
      
    </div>
    <div id="row_promoted_products" class="row row-product">
     
        <?php foreach (get_home_categories($category) as $product): ?>
            <div class="col-6 col-sm-6 col-md-4 col-lg-2 col-product">
                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false]); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div id="load_promoted_spinner" class="col-12 load-more-spinner">
        <div class="row">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>