<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
#wrapper {
	background:#fff !important;
}
</style>
	<div class="breadcrumbs__section breadcrumbs__section-thin brk-bg-center-cover lazyload" data-bg="<?php echo base_url(); ?>assets/skin/img/1920x258_1.jpg" data-brk-library="component__breadcrumbs_css">
		<span class="brk-abs-bg-overlay brk-bg-grad opacity-80"></span>
		<div class="breadcrumbs__wrapper">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-lg-6">
						<div class="d-flex justify-content-lg-end justify-content-start pr-40 pr-xs-0 breadcrumbs__title">
							<h2 class="brk-white-font-color font__weight-semibold font__size-48 line__height-68 font__family-montserrat  pt-xs-40">
								<?php echo trans("products"); ?>
							</h2>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="pt-50 pb-50 position-static position-lg-relative breadcrumbs__subtitle">
							<h3 class="brk-white-font-color font__family-montserrat font__weight-medium font__size-18 line__height-21 text-uppercase mb-15">
								Discover Espripack
							</h3>
							<ol class="breadcrumb font__family-montserrat font__size-15 line__height-16 brk-white-font-color" style="background:transparent;padding-left: 0;">
								<li>
									<a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a>
								</li>
								<?php if (!empty($category)):
                            $breadcrumb = get_parent_categories_array($category->id);
                            if (!empty($breadcrumb)):
                                foreach ($breadcrumb as $item_breadcrumb):
                                    $item_category = get_category_by_id($item_breadcrumb->id);
                                    if (!empty($item_category)):?>
                                        <li><i class="fal fa-chevron-right icon" style="padding-right: 5px;padding-left: 5px;"></i><a href="<?php echo generate_category_url($item_category); ?>"><?php echo category_name($item_category); ?></a></li>
                                    <?php endif;
                                endforeach;
                            endif;
                        else: ?>
								<li class="active"><?php echo trans("products"); ?></li>
								<?php endif; ?>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">
        <!-- form start -->
        <?php echo form_open(current_url(), ['id' => 'form-product-filters', 'method' => 'get']);
        $search = trim($this->input->get('search', TRUE));
        if (!empty($search)):?>
            <input type="hidden" name="search" value="<?php echo html_escape($search); ?>">
        <?php endif; ?>

        <div class="row">
            <?php $this->load->view('product/_product_filters'); ?>

            <div class="col-12 col-md-10">
				
				<div class="row">
				
					<div class="col-md-3">
						
						<?php
						if ($show_location_filter == true):
							if ($this->form_settings->product_location == 1):
								$country_id = $this->input->get('country', true);
								$state_id = $this->input->get('state', true);
								$city_id = $this->input->get('city', true); ?>
								<div class="filter-it em filt er-location">
									<!-- <h6 class="title"><?php echo trans("location"); ?></h6> -->
									<div class="input-group input-group-location">
										<i class="icon-map-marker"></i>
										<input type="text" id="input_location" class="form-control form-input" value="<?php echo get_location_input($country_id, $state_id, $city_id); ?>" placeholder="<?php echo trans("enter_location") ?>" autocomplete="off">
									</div>
									<div class="search-results-ajax">
										<div class="search-results-location">
											<div id="response_search_location"></div>
										</div>
									</div>
								</div>
								<?php if (!empty($country_id)): ?>
								<input type="hidden" name="country" value="<?php echo $country_id; ?>" class="input-location-filter">
							<?php endif; ?>
								<?php if (!empty($state_id)): ?>
								<input type="hidden" name="state" value="<?php echo $state_id; ?>" class="input-location-filter">
							<?php endif; ?>
								<?php if (!empty($city_id)): ?>
								<input type="hidden" name="city" value="<?php echo $city_id; ?>" class="input-location-filter">
							<?php endif; ?>
							<?php endif;
						endif; ?>

					</div>
					
				</div>
				
                <div class="filter-reset-tag-container mt-0 mb-0">
                    <?php $filters = get_filters_query_string_array();
                    if (!empty($filters)):
                        foreach ($filters as $key => $value):
                            if (!empty($value) && $key != 'sort' && $key != 'condition' && $key != 'country' && $key != 'state' && $key != 'city' && $key != 'p_min' && $key != 'p_max' && $key != 'page'):?>
                                <div class="filter-reset-tag">
                                    <div class="left">
                                        <a href="<?php echo remove_filter_from_query_string($key); ?>"><i class="icon-close"></i></a>
                                    </div>
                                    <div class="right">
                                        <span class="reset-tag-title"><?php echo get_filter_name_by_key($key); ?></span>
                                        <span><?php echo html_escape($value); ?></span>
                                    </div>
                                </div>
                            <?php endif;
                        endforeach;
                    endif;

                    $filter_condition = get_filter_query_string_key_value('condition');
                    if (!empty($filter_condition)):
                        $product_condition = get_product_condition_by_key($filter_condition, $this->selected_lang->id);
                        if (!empty($product_condition)):?>
                            <div class="filter-reset-tag">
                                <div class="left">
                                    <a href="<?php echo remove_filter_from_query_string('condition'); ?>"><i class="icon-close"></i></a>
                                </div>
                                <div class="right">
                                    <span class="reset-tag-title"><?php echo trans("condition"); ?></span>
                                    <span><?php echo html_escape($product_condition->option_label); ?></span>
                                </div>
                            </div>
                        <?php endif;
                    endif;

                    $filter_p_max = @(float)get_filter_query_string_key_value('p_max');
                    $filter_p_min = @(float)get_filter_query_string_key_value('p_min');
                    if (!empty($filter_p_max) || !empty($filter_p_min)): ?>
                        <div class="filter-reset-tag">
                            <div class="left">
                                <a href="<?php echo remove_filter_from_query_string('price'); ?>"><i class="icon-close"></i></a>
                            </div>
                            <div class="right">
                                <span class="reset-tag-title"><?php echo trans('price') . '(' . get_currency($this->payment_settings->default_product_currency) . ')'; ?></span>
                                <span>
                                <?php if ($filter_p_min != 0):
                                    echo trans('min') . ': ' . $filter_p_min;
                                endif; ?>&nbsp;&nbsp;
                                <?php if ($filter_p_max != 0):
                                    echo trans('max') . ': ' . $filter_p_max;
                                endif; ?>
                            </span>
                            </div>
                        </div>
                    <?php endif;

                    $country_id = $this->input->get('country', true);
                    $state_id = $this->input->get('state', true);
                    $city_id = $this->input->get('city', true);
                    $filter_location = get_location_input($country_id, $state_id, $city_id);
                    if (!empty($filter_location)): ?>
                        <div class="filter-reset-tag">
                            <div class="left">
                                <a href="<?php echo remove_filter_from_query_string('location'); ?>"><i class="icon-close"></i></a>
                            </div>
                            <div class="right">
                                <span class="reset-tag-title"><?php echo trans("location"); ?></span>
                                <span><?php echo $filter_location; ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="product-list-content">
                    <div class="row mb-3">
                                <h1 class="page-title product-list-title" style="padding: 0 30px;"><?php echo category_name($category); ?></h1>
                        <div class="col-12 product-list-header d-flex align-items-center justify-content-between" style="padding-right: 30px;padding-left:30px">
                            <?php if (!empty($category)): ?>
                                <h1 class="page-title product-list-title"></h1>
                            <?php else: ?>
                                <h1 class="page-title product-list-title"><?php echo trans("products"); ?></h1>
                            <?php endif; ?>
                            <div class="product-sort-by">
                                <span class="span-sort-by" style="vertical-align: -moz-middle-with-baseline;"><?php echo trans("sort_by"); ?></span>
                                <div class="dropdown sort-select">
                                    <button type="button" class="btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <?php $filter_sort = get_filter_query_string_key_value('sort');
                                        if ($filter_sort == 'most_recent' || $filter_sort == 'lowest_price' || $filter_sort == 'highest_price') {
                                            echo trans($filter_sort);
                                        } else {
                                            echo trans('most_recent');
                                        } ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button type="submit" name="sort" value="most_recent" class="dropdown-item"><?php echo trans("most_recent"); ?></button>
                                        <button type="submit" name="sort" value="lowest_price" class="dropdown-item"><?php echo trans("lowest_price"); ?></button>
                                        <button type="submit" name="sort" value="highest_price" class="dropdown-item"><?php echo trans("highest_price"); ?></button>
                                    </div>
                                </div>
                            </div>
                            <button class="btn-primary btn-filter-products-mobile" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" style="border-radius: 10px;padding: 10px;">
                                <i class="icon-filter"></i>&nbsp;<?php echo trans("filter_products"); ?>
                            </button>
                        </div>
                    </div>
                    <div class="row row-product" style="margin:0px;">
                        <!--print products-->
                        <?php foreach ($products as $product): ?>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-product">
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($products)): ?>
                            <div class="col-12">
                                <p class="no-records-found"><?php echo trans("no_products_found"); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="product-list-pagination">
                    <div class="float-right">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>

                <div class="col-12">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "products", "class" => "m-t-15"]); ?>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>
        <!-- form end -->
    </div>
</div>
<!-- Wrapper End-->
