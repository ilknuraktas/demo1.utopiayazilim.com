<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (!empty($featured_categories)): ?>
    <div class="row">
		<?php foreach ($featured_categories as $category): ?>
		
			<div class="col-6 col-md-3">
				
				<div class="product-item home-category-mobile tk-category">
					<div class="row-custom">
						<a class="item-wishlist-button item-wishlist-enable item-wishlist" data-product-id="1"></a>
						<div class="img-product-container">
							<a href="<?php echo generate_category_url($category); ?>">
								<img src="<?php echo get_category_image_url($category); ?>" data-src="<?php echo get_category_image_url($category); ?>" alt="<?php echo category_name($category); ?>" class="img-fluid img-product ls-is-cached lazyloaded">
							</a>
						</div>
					</div>
					<div class="row-custom item-details">
						<h3 class="product-title">
							<a href="<?php echo generate_category_url($category); ?>" style="text-align:center;color:#fff"><?php echo category_name($category); ?></a>
						</h3>  
					</div>
                    <div class="hover"></div>
                    <a class="bg" href="<?php echo generate_category_url($category); ?>"><i class="icon-arrow-slider-right"></i></a>
				</div>

			</div>
			
		<?php endforeach; ?>
    </div>
<?php endif; ?>
