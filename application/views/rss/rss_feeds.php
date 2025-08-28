<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="breadcrumbs__section breadcrumbs__section-thin brk-bg-center-cover lazyload" data-bg="<?php echo base_url(); ?>assets/skin/img/1920x258_1.jpg" data-brk-library="component__breadcrumbs_css">
		<span class="brk-abs-bg-overlay brk-bg-grad opacity-80"></span>
		<div class="breadcrumbs__wrapper">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-lg-6">
						<div class="d-flex justify-content-lg-end justify-content-start pr-40 pr-xs-0 breadcrumbs__title">
							<h2 class="brk-white-font-color font__weight-semibold font__size-48 line__height-68 font__family-montserrat pt-xs-40">
								<?php echo $title; ?>
							</h2>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="pt-50 pb-50 position-static position-lg-relative breadcrumbs__subtitle">
							<h3 class="brk-white-font-color font__family-montserrat font__weight-regular font__size-18 line__height-21 text-uppercase mb-15">
								<?php echo $title; ?>
							</h3>
							<ol class="breadcrumb font__family-montserrat font__size-15 line__height-16 brk-white-font-color" style="background:transparent;padding-left: 0;">
								<li>
									<a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a>
									<i class="fal fa-chevron-right icon" style="padding-right: 5px;padding-left: 5px;"></i>
								</li>
								<li class="active"><?php echo $title; ?></li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="blog-content">
					<h1 class="page-title"><?php echo html_escape($title); ?></h1>
					<div class="row">
						<div class="col-sm-12">
							<div class="page-text-content">
								<div class="rss-item">
									<div class="left">
										<a href="<?php echo lang_base_url(); ?>rss/<?php echo get_route("latest_products"); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo trans("latest_products"); ?></a>
									</div>
									<div class="right">
										<p><?php echo lang_base_url() . "rss/" . get_route("latest_products"); ?></p>
									</div>
								</div>
								<div class="rss-item">
									<div class="left">
										<a href="<?php echo lang_base_url(); ?>rss/<?php echo get_route("featured_products"); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo trans("featured_products"); ?></a>
									</div>
									<div class="right">
										<p><?php echo lang_base_url() . "rss/" . get_route("featured_products"); ?></p>
									</div>
								</div>
								<?php if (!empty($this->parent_categories)):
									foreach ($this->parent_categories as $category): ?>
										<div class="rss-item">
											<div class="left">
												<a href="<?php echo lang_base_url(); ?>rss/<?php echo get_route("category"); ?>/<?php echo html_escape($category->slug); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo category_name($category); ?></a>
											</div>
											<div class="right">
												<p><?php echo lang_base_url(); ?>rss/<?php echo get_route("category"); ?>/<?php echo html_escape($category->slug); ?></p>
											</div>
										</div>
									<?php
									endforeach;
								endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Wrapper End-->
