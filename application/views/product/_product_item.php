<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
        <a class="item-wishlist-button item-wishlist-enable <?php echo (is_product_in_wishlist($product) == 1) ? 'item-wishlist' : ''; ?>" data-product-id="<?php echo $product->id; ?>"></a>
						<div class="flip-box text-center" data-brk-library="component__flip_box,component__elements,fancybox">
							<div class="flip flip_horizontal flip-box__split">
								<div class="flip__front">
									<div class="img-product-container">
										<img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_item_image($product); ?>" alt="<?php echo html_escape($product->title); ?>" class="lazyload img-fluid img-product" style="display: block;height: 100%;width: 100%;margin: 0 auto;max-width: 400px;object-fit: cover;/*! margin-left: 50%; *//*! transform: translateX(-50%); */border-radius: 20px 20px 0 0;">
									</div>
									<div class="pt-30 pb-30 pr-20 pl-20 flip-box__split-info">
										<div class="font__family-montserrat font__weight-bold pl-20 pr-20 font__size-18" style="white-space: nowrap;display: block;overflow: hidden;display: block;overflow: hidden;text-overflow: ellipsis;">
											<?php echo html_escape($product->title); ?>
										</div>
										<div class="brk-base-font-color font__family-montserrat font__size-17 font__weight-medium">
        <div class="item-meta" style="height: 50px;">
            <?php $this->load->view('product/_price_product_item', ['product' => $product]); ?>
        </div>
										</div>
									</div>
								</div>
								<div class="flip__back lazyload" data-bg="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_item_image($product); ?>" alt="<?php echo html_escape($product->title); ?>">
									<div class="flip-box__split-overlay brk-base-bg-gradient-10deg"></div>
									<div class="flip-box__split-content">
										<a href="<?php echo generate_product_url($product); ?>">
										<div class="pt-lg-100 pb-lg-30 pt-sm-20 pb-sm-20 pt-xs-40 pb-xs-40 pt-20 pb-20 position-relative z-index-5">
												<h4 class="font__family-montserrat font__weight-bold font__size-18 line__height-24">
													<?php echo html_escape($product->title); ?>
												</h4>
											<div class="flip-box__split-price font__family-montserrat font__size-15">
        <div class="item-meta" style="height: 50px;">
            <?php $this->load->view('product/_price_product_item', ['product' => $product]); ?>
        </div>
											</div>
										</div>
										</a>
										<div class="flip-box__split-actions">
											<a href="#" class="add-cart d-flex align-items-center justify-content-center">
												<i class="fas fa-shopping-cart"></i>
											</a>
											<a href="<?php echo generate_product_url($product); ?>" class="add-search d-flex align-items-center justify-content-center fancybox">
												<i class="fas fa-search"></i>
											</a>
											<a href="javascript:void(0)" class="item-option btn-add-remove-wishlist add-wishlist d-flex align-items-center justify-content-center" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
                    <?php if (is_product_in_wishlist($product) == 1): ?>
                        <i class="icon-heart"></i>
                    <?php else: ?>
                        <i class="icon-heart-o"></i>
                    <?php endif; ?>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>