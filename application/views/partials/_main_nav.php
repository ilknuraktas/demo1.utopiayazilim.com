<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($this->general_settings->selected_navigation == 1): ?>
<?php if ($_SERVER['REQUEST_URI']!="/kayit"){  ?>
    <div class="container-fluid">
        <div class="background-dark"></div>
        <div class="navbar navbar-light navbar-expand">
            <ul class="nav navbar-nav mega-menu">
                <?php $limit = $this->general_settings->menu_limit;
                $count = 1;
                if (!empty($this->parent_categories)):
                    foreach ($this->parent_categories as $category):
                        if ($count <= $limit):?>
                            <li class="nav-item dropdown " data-category-id="<?php echo $category->id; ?>">
                                <a href="<?php echo generate_category_url($category); ?>" class="nav-link dropdown-toggle">
                                    <?php echo category_name($category); ?>
                                </a>
                                <?php $subcategories = get_subcategories($this->categories, $category->id);
                                if (!empty($subcategories)): ?>
                                    <div id="mega_menu_content_<?php echo $category->id; ?>" class="dropdown-menu">
                                        <div class="row">
                                            <div class="col-8 menu-subcategories col-category-links">
                                                <div class="card-columns">
                                                    <?php foreach ($subcategories as $subcategory): ?>
                                                        <div class="card">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <a href="<?php echo generate_category_url($subcategory); ?>" class="second-category"><?php echo category_name($subcategory); ?></a>
                                                                    <?php
                                                                    $third_categories = get_subcategories($this->categories, $subcategory->id);
                                                                    if (!empty($third_categories)):
                                                                        $display_limit = 1; ?>
                                                                        <ul>
                                                                            <?php foreach ($third_categories as $item):
                                                                                if ($display_limit <= $this->menu_subcategory_display_limit):?>
                                                                                    <li>
                                                                                        <a href="<?php echo generate_category_url($item); ?>"><?php echo html_escape($item->name); ?></a>
                                                                                    </li>
                                                                                <?php endif;
                                                                                $display_limit++;
                                                                            endforeach; ?>
                                                                            <?php if ($display_limit > $this->menu_subcategory_display_limit): ?>
                                                                                <li>
                                                                                    <a href="<?php echo generate_category_url($subcategory); ?>" class="link-view-all"><?php echo trans("show_all"); ?></a>
                                                                                </li>
                                                                            <?php endif; ?>
                                                                        </ul>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <div class="col-4 col-category-images">
                                                <?php if (!empty($category->image) && $category->show_image_on_navigation == 1): ?>
                                                    <div class="nav-category-image">
                                                        <a href="<?php echo generate_category_url($category); ?>">
                                                            <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_category_image_url($category); ?>" alt="category" class="lazyload img-fluid">
                                                            <span><?php echo character_limiter(category_name($category), 20, '..'); ?></span>
                                                        </a>
                                                    </div>
                                                <?php endif;
                                                foreach ($subcategories as $subcategory):
                                                    if (!empty($subcategory->image) && $subcategory->show_image_on_navigation == 1):?>
                                                        <div class="nav-category-image">
                                                            <a href="<?php echo generate_category_url($subcategory); ?>">
                                                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_category_image_url($subcategory); ?>" alt="<?php echo category_name($subcategory); ?>" class="lazyload img-fluid">
                                                                <span><?php echo character_limiter(category_name($subcategory), 20, '..'); ?></span>
                                                            </a>
                                                        </div>
                                                    <?php endif;
                                                endforeach;
                                                foreach ($subcategories as $subcategory):
                                                    $third_categories = get_subcategories($this->categories, $subcategory->id);
                                                    if (!empty($third_categories)):
                                                        foreach ($third_categories as $third_category):
                                                            if (!empty($third_category->image) && $third_category->show_image_on_navigation == 1):?>
                                                                <div class="nav-category-image">
                                                                    <a href="<?php echo generate_category_url($third_category); ?>">
                                                                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_category_image_url($third_category); ?>" alt="<?php echo category_name($third_category); ?>" class="lazyload img-fluid">
                                                                        <span><?php echo category_name($third_category); ?></span>
                                                                    </a>
                                                                </div>
                                                            <?php endif;
                                                        endforeach;
                                                    endif;
                                                endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </li>
                            <?php $count++;
                        endif;
                    endforeach;

                    if (item_count($this->parent_categories) > $limit): ?>
                        <li class="nav-item dropdown menu-li-more">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo trans("more"); ?></a>
                            <div class="dropdown-menu dropdown-menu-more-items">
                                <?php
                                $count = 1;
                                if (!empty($this->parent_categories)):
                                    foreach ($this->parent_categories as $category):
                                        if ($count > $limit):?>
                                            <a href="<?php echo generate_category_url($category); ?>" class="dropdown-item">
                                                <?php echo category_name($category); ?>
                                            </a>
                                            <?php
                                        endif;
                                        $count++;
                                    endforeach;
                                endif; ?>
                            </div>
                        </li>
                    <?php endif;
                endif; ?>
            </ul>
        </div>
    </div>
    <?php } ?>
<?php else: ?>
<?php if ($_SERVER['REQUEST_URI']!="/kayit"){  ?>
    <div class="container">
        <div class="navbar navbar-light navbar-expand">
            <ul class="navbar-nav w-100 nav-justified mega-menu ">
                <?php
                $limit = $this->general_settings->menu_limit;
                $menu_item_count = 1;
                if (!empty($this->parent_categories)):
                    foreach ($this->parent_categories as $category):
                        if ($menu_item_count <= $limit):?>
                            <li class="nav-item dropdown" data-category-id="<?php echo $category->id; ?>">
                                <a href="<?php echo generate_category_url($category); ?>" class="nav-link dropdown-toggle font__family-montserrat font__weight-semibold letter-spacing-20 font__size-18 line__height-16 brk-base-font-color text-uppercase" style="font-size: 17px;">
                                    <strong><?php echo category_name($category); ?></strong>
                                </a>
                                <?php $subcategories = get_subcategories($this->categories, $category->id);
                                if (!empty($subcategories)):?>
                                    <div id="mega_menu_content_<?php echo $category->id; ?>" class="dropdown-menu dropdown-menu-large">
                                        <div class="row">

                                            <div class="col-4 left" style="padding-top: 0px; padding-bottom: 0px;">
                                                <?php
                                                $count = 0;
                                                foreach ($subcategories as $subcategory): ?>
                                                    <div class="large-menu-item <?php echo ($count == 0) ? 'large-menu-item-first active' : ''; ?>" data-subcategory-id="<?php echo $subcategory->id; ?>">
                                                        <a href="<?php echo generate_category_url($subcategory); ?>" class="second-category">
                                                            <?php echo category_name($subcategory); ?>
                                                            <i class="icon-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                    <?php
                                                    $count++;
                                                endforeach; ?>
                                            </div>

                                            <div class="col-8 right">
                                                <?php
                                                $count = 0;
                                                foreach ($subcategories as $subcategory): ?>
                                                    <div id="large_menu_content_<?php echo $subcategory->id; ?>" class="large-menu-content <?php echo ($count == 0) ? 'large-menu-content-first active' : ''; ?>">
                                                        <?php $third_categories = get_subcategories($this->categories, $subcategory->id);
                                                        if (!empty($third_categories)): ?>
                                                            <div class="row">
                                                                <?php foreach ($third_categories as $item): ?>
                                                                    <div class="col-3 item-large-menu-content">
                                                                        <a href="<?php echo generate_category_url($item); ?>"><i class="icon-angle-right"></i> <?php echo html_escape($item->name); ?></a>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php
                                                    $count++;
                                                endforeach; ?>
                                            </div>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            </li>
                            <?php $menu_item_count++;
                        endif;
                    endforeach;

                    if (item_count($this->parent_categories) > $limit): ?>
                        <li class="nav-item dropdown menu-li-more">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?php echo trans("more"); ?></a>
                            <div class="dropdown-menu dropdown-menu-more-items">
                                <?php
                                $menu_item_count = 1;
                                if (!empty($this->parent_categories)):
                                    foreach ($this->parent_categories as $category):
                                        if ($menu_item_count > $limit): ?>
                                            <a href="<?php echo generate_category_url($category); ?>" class="dropdown-item">
                                                <?php echo category_name($category); ?>
                                            </a>
                                        <?php endif;
                                        $menu_item_count++;
                                    endforeach;
                                endif; ?>
                            </div>
                        </li>
                    <?php endif;
                endif; ?>

                <?php if ($this->auth_check): ?>

                    <!--li class="nav-item dropdown">
                       <a class="nav-link" href="<?php echo generate_url("settings", "shipping_address"); ?>">
                          <span><i class="icon-map-marker"></i> <?php echo trans("shipping_address"); ?></span>
                      </a>
                  </li-->


                  <?php if (is_sale_active()): ?>

				<!--li class="nav-item dropdown">
					<a href="<?php echo generate_url("orders"); ?>" class="nav-link dropdown-toggle">
						<i class="icon-shopping-basket"></i>
						<?php echo trans("orders"); ?>
					</a>
				</li-->

            <?php endif; ?>

				<!--li class="nav-item dropdown" >

					<?php if ($this->auth_check): ?>

						<a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>" class="nav-link dropdown-toggle">
							<i class="icon-heart-o"></i> <?php echo trans("wishlist"); ?>
						</a>

					<?php else: ?>

						<a href="<?php echo generate_url("wishlist"); ?>" class="nav-link dropdown-toggle">
							<i class="icon-heart-o"></i> <?php echo trans("wishlist"); ?>
						</a>

					<?php endif; ?>
				</li-->

            <?php endif; ?>

            <?php if (!$this->auth_check): ?>
					<!--li class="nav-item">
						<a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="nav-link"><?php echo trans("login"); ?></a>
					</li>
					<li class="nav-item">
						<a href="<?php echo generate_url("register"); ?>" class="nav-link"><?php echo trans("register"); ?></a>
					</li-->
				<?php endif; ?>

				<?php if (is_sale_active()): ?>
					<!--li class="nav-item dropdown" >
						<a href="<?php echo generate_url("cart"); ?>" class="nav-link dropdown-toggle">
							<i class="icon-cart"></i> <span><?php echo trans("cart"); ?></span>
							<?php $cart_product_count = get_cart_product_count();
							if ($cart_product_count > 0): ?>
								<span class="notification"><strong>( <?php echo $cart_product_count; ?> )</strong></span>
							<?php endif; ?>
						</a>
					</li-->
				<?php endif; ?>
            </ul>
        </div>
    </div>
    <?php } ?>
<?php endif; ?>


