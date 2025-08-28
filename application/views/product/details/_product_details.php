<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    #wrapper {
       background:#fff !important;
   }
</style>

<div class="row">
    <div class="col-12">
        <?php if ($product->product_type == 'digital'):
            if ($product->is_free_product == 1):
                if ($this->auth_check):?>
                    <div class="row-custom m-t-10">
                        <?php echo form_open('download-free-digital-file-post'); ?>
                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                        <button class="btn btn-instant-download"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                        <?php echo form_close(); ?>
                    </div>
                <?php else: ?>
                    <div class="row-custom m-t-10">
                        <button class="btn btn-instant-download" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if (!empty($digital_sale)): ?>
                    <div class="row-custom m-t-10">
                        <?php echo form_open('download-purchased-digital-file-post'); ?>
                        <input type="hidden" name="sale_id" value="<?php echo $digital_sale->id; ?>">
                        <button class="btn btn-instant-download"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                        <?php echo form_close(); ?>
                    </div>
                <?php else: ?>
                    <label class="label-instant-download"><i class="icon-download-solid"></i><?php echo trans("instant_download"); ?></label>
                <?php endif;
            endif;
        endif; ?>
		<h2 class="font__family-montserrat brk-white-font-color font__size-46 font__weight-light line__height-52 mb-20">
			<span class="font__weight-bold letter-spacing--20"><?php echo html_escape($product->title); ?></span>
		</h2>
        <?php if ($product->status == 0): ?>
            <label class="badge badge-warning badge-product-status"><?php echo trans("pending"); ?></label>
        <?php elseif ($product->visibility == 0): ?>
            <label class="badge badge-danger badge-product-status"><?php echo trans("hidden"); ?></label>
        <?php endif; ?>
        <div class="row-custom meta">
            <!--<?php if ($this->general_settings->product_comments == 1): ?>
                <span><i class="icon-comment"></i><?php echo html_escape($comment_count); ?></span>
                <?php endif; ?>-->
                <?php if ($this->general_settings->reviews == 1): ?>
                    <div class="product-details-review">
                        <?php $this->load->view('partials/_review_stars', ['review' => $product->rating]); ?>
                        <span>(<?php echo $review_count; ?>)</span>
                    </div>
                <?php endif; ?>
            <!--<span><i class="icon-heart"></i><?php echo get_product_wishlist_count($product->id); ?></span>
                <span><i class="icon-eye"></i><?php echo html_escape($product->hit); ?></span>-->
            </div>
            <div class="row-custom price">
                <div id="product_details_price_container" class="d-inline-block">
                    <?php $this->load->view("product/details/_price", ['product' => $product, 'price' => $product->price, 'discount_rate' => $product->discount_rate]); ?>
                </div>
            </div>

            <div class="row-custom meta">
                <div class="product-details-user brk-color-filter__title brk-white-font-color font__family-montserrat font__weight-bold font__size-14 line__height-14 text-uppercase text-center">
                    <?php echo trans("by"); ?>:&nbsp;
                    <a class="mr-3" href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo character_limiter(get_shop_name_product($product), 30, '..'); ?></a>
                    <b class="mr-3"><?=get_store_rank($product->user_id)?></b>
                    
                    <?php if ($this->auth_check): ?>
                        <a href="#" data-toggle="modal" data-target="#messageModal"style="color: var(--yellow);font-weight:bold"><i style="color: var(--yellow);font-weight:bold" class="icon-comment"></i> <?php echo trans("ask_question") ?></a>
                    <?php else: ?>
                        <a href="#" data-toggle="modal" data-target="#loginModal" style="color: var(--yellow);font-weight:bold"><i style="color: var(--yellow);font-weight:bold" class="icon-comment"></i> <?php echo trans("ask_question") ?></a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row-custom details text-uppercase">
                <?php if (!empty($product->product_condition)): ?>
                    <div class="item-details">
                        <div class="left font__weight-bold">
                            <label><?php echo trans("condition"); ?></label>
                        </div>
                        <div class="right">
                            <?php $product_condition = get_product_condition_by_key($product->product_condition, $this->selected_lang->id);
                            if (!empty($product_condition)):?>
                                <span><?php echo html_escape($product_condition->option_label); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->brand)): ?>
                    <div class="item-details">
                        <div class="left font__weight-bold">
                            <label>Marka</label>
                        </div>
                        <div class="right">
                            <span>: <?php echo html_escape($product->brand); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->sku)): ?>
                    <div class="item-details">
                        <div class="left font__weight-bold">
                            <label><?php echo trans("sku"); ?></label>
                        </div>
                        <div class="right">
                            <span>: <?php echo html_escape($product->sku); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->sku)): ?>
                    <div class="item-details">
                        <div class="left font__weight-bold">
                            <label>Barkod</label>
                        </div>
                        <div class="right">
                            <span>: <?php echo html_escape($product->barcode); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->sku)): ?>
                    <div class="item-details">
                        <div class="left font__weight-bold">
                            <label>GTIN Kodu</label>
                        </div>
                        <div class="right">
                            <span>: <?php echo html_escape($product->GTIN_code); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($product->product_type == 'digital'): ?>
                    <div class="item-details">
                        <div class="left font__weight-bold">
                            <label><?php echo trans("files_included"); ?></label>
                        </div>
                        <div class="right">
                            <span>: <?php echo html_escape($product->files_included); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($product->listing_type == 'ordinary_listing'): ?>
                    <div class="item-details">
                        <div class="left font__weight-bold">
                            <label><?php echo trans("uploaded"); ?></label>
                        </div>
                        <div class="right">
                            <span>: <?php echo time_ago($product->created_at); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php echo form_open(get_product_form_data($product)->add_to_cart_url, ['id' => 'form_add_cart']); ?>
    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
    <div class="row">
        <div class="col-12">
            <div class="row-custom product-variations">
                <div class="row row-product-variation item-variation">
                    <?php if (!empty($full_width_product_variations)):
                        foreach ($full_width_product_variations as $variation):
                            $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                        endforeach;
                    endif;
                    if (!empty($half_width_product_variations)):
                        foreach ($half_width_product_variations as $variation):
                            $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                        endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12"><?php $this->load->view('product/details/_messages'); ?></div>
    </div>
    <div class="row">
        <div class="col-12 product-add-to-cart-container">
            <div class="tk-add-to-cart">
                <div class="row">

                    <div class="col-12" style="display: flex; flex-direction: row; align-items: center;">
                        <div class="colm">
                            <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital'): ?>
                                <div class="number-spinner">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default btn-spinner-minus" data-dir="dwn">-</button>
                                        </span>
                                        <input type="text" class="form-control text-center" name="product_quantity" value="1">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default btn-spinner-plus" data-dir="up">+</button>
                                        </span>
                                    </div>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="colm">
                            <?php $buttton = get_product_form_data($product)->button;
                            if (!empty($buttton)) : ?>
                                <div class="button-container">

									<a href="<?= $product->external_link ?>" target="_blank"><button class="btn-info btn-md btn-product-cart font__size-21" style="padding-top: 15px;padding-bottom: 15px;border-radius: 40px;"><i class="icon-cart-solid" style="padding-right: 5px;"></i>Sepete Ekle
                                    <?php if ($product->external_link) : ?>
                                        <a href="<?= $product->external_link ?>" target="_blank" class="btn-info btn-md btn-block btn-product-cart" style="padding-top: 15px;padding-bottom: 15px;border-radius: 40px; font-size;font-size: 21px;"><i class="icon-cart-solid" style="padding-right: 5px;"></i>Sepete Ekle</a>
                                    <?php endif; ?>
									</button></a></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12" style="margin-top: 10px;">
                        <span class="brk-color-filter__title brk-white-font-color font__family-montserrat font__weight-bold font__size-14 line__height-14 text-uppercase text-center" style="font-weight: 900; font-size: 14px;">
                            <i class="icon-eye" style="text-align: center; margin-bottom: 10px;"></i> Stokta <?=$product->stock?> adet ürün var!
                        </span>
                    </div>

                <!--<div class="col-6">
                    <div class="button-container button-container-wishlist">
                        <?php
                        $whislist_button_class = "";
                        $whislist_button_class = (empty($product->demo_url) && $product->listing_type == 'ordinary_listing') ? "btn-wishlist-classified" : "";
                        if ($this->product_model->is_product_in_wishlist($product->id) == 1): ?>
                            <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1"><i class="icon-heart"></i><span><?php echo trans("remove_from_wishlist"); ?></span></a>
                        <?php else: ?>
                            <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1"><i class="icon-heart-o"></i><span><?php echo trans("add_to_wishlist"); ?></span></a>
                        <?php endif; ?>
                    </div>
                </div>-->

            </div>
        </div>
    </div>

    <?php if (!empty($product->demo_url)): ?>
        <div class="col-12 product-add-to-cart-container">
            <div class="button-container">
                <a href="<?php echo $product->demo_url; ?>" target="_blank" class="btn-info btn-md btn-live-preview"><i class="icon-preview"></i><?php echo trans("live_preview") ?></a>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php echo form_close(); ?>

<div class="tk-product-buttons">
    <div class="area">
        <?php
        $whislist_button_class = "";
        $whislist_button_class = (empty($product->demo_url) && $product->listing_type == 'ordinary_listing') ? "btn-wishlist-classified" : "";
        if ($this->product_model->is_product_in_wishlist($product->id) == 1): ?>
            <a href="javascript:void(0)" class="link btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1">
                <span class="icon"><i class="icon-heart text-danger"></i></span>
                <span class="text"><?php echo trans("remove_from_wishlist"); ?></span>
            </a>
        <?php else: ?>
            <a href="javascript:void(0)" class="link btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1">
                <span class="icon"><i class="icon-heart-o"></i></span>
                <span class="text"><?php echo trans("add_to_wishlist"); ?></span>
            </a>
        <?php endif; ?>
    </div>
    <?php if ($this->general_settings->product_comments == 1): ?>
        <div class="area">
            <div class="dropdown">
                <a class="link" type="button" href="#" id="dropdownShareProduct" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="icon"><i class="icon-send"></i></span>
                    <span class="text"><?php echo trans("share"); ?></span>
                </a>
                <div class="dropdown-menu lang">
                    <a class="dropdown-item" href="javascript:void(0)" onclick='window.open("https://www.facebook.com/sharer/sharer.php?u=<?php echo generate_product_url($product); ?>", "Share This Post", "width=640,height=450");return false'>
                        <i class="icon-facebook"></i>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick='window.open("https://twitter.com/share?url=<?php echo generate_product_url($product); ?>&amp;text=<?php echo html_escape($product->title); ?>", "Share This Post", "width=640,height=450");return false'>
                        <i class="icon-twitter"></i>
                    </a>
                    <a class="dropdown-item" href="https://api.whatsapp.com/send?text=<?php echo str_replace("&", "", $product->title); ?> - <?php echo generate_product_url($product); ?>" target="_blank">
                        <i class="icon-whatsapp"></i>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick='window.open("http://pinterest.com/pin/create/button/?url=<?php echo generate_product_url($product); ?>&amp;media=<?php echo get_product_image($product->id, 'image_default'); ?>", "Share This Post", "width=640,height=450");return false'>
                        <i class="icon-pinterest"></i>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick='window.open("http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo generate_product_url($product); ?>", "Share This Post", "width=640,height=450");return false'>
                        <i class="icon-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="area">
            <a href="#" class="link">
                <span class="icon"><i class="icon-comment"></i></span>
                <span class="text"><?php echo trans("comments"); ?>: <?php echo html_escape($comment_count); ?></span>
            </a>
        </div>
    <?php endif; ?>
    <div class="area">
        <a href="#" class="link">
            <span class="icon"><i class="icon-heart"></i></span>
            <span class="text">Favoriler: <?php echo get_product_wishlist_count($product->id); ?></span>
        </a>
    </div>
    <div class="area">
        <a href="#" class="link">
            <span class="icon"><i class="icon-eye"></i></span>
            <span class="text">Görüntülenme: <?php echo html_escape($product->hit); ?></span>
        </a>
    </div>
</div>

<!--Include social share
    <?php $this->load->view("product/details/_product_share"); ?>-->