<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="breadcrumbs__section breadcrumbs__section-thin brk-bg-center-cover lazyload" data-bg="<?php echo base_url(); ?>assets/skin/img/1920x258_1.jpg" data-brk-library="component__breadcrumbs_css">
		<span class="brk-abs-bg-overlay brk-bg-grad opacity-80"></span>
		<div class="breadcrumbs__wrapper">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-lg-6">
						<div class="d-flex justify-content-lg-end justify-content-start pr-40 pr-xs-0 breadcrumbs__title">
							<h2 class="brk-white-font-color font__weight-semibold font__size-48 line__height-68 font__family-montserrat pt-xs-40">
								<?php echo trans("blog"); ?>
							</h2>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="pt-50 pb-50 position-static position-lg-relative breadcrumbs__subtitle">
							<h3 class="brk-white-font-color font__family-montserrat font__weight-regular font__size-18 line__height-21 text-uppercase mb-15">
								<?php echo trans("blog"); ?>
							</h3>
							<ol class="breadcrumb font__family-montserrat font__size-15 line__height-16 brk-white-font-color" style="background:transparent;padding-left: 0;">
								<li>
									<a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a>
									<i class="fal fa-chevron-right icon" style="padding-right: 5px;padding-left: 5px;"></i>
								</li>
								<li class="active"><?php echo trans("blog"); ?></li>
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
                    <div class="row">
                        <div class="col-12">
                            <ul class="blog-categories">
                                <li class="<?php echo ($active_category == "all") ? 'active' : ''; ?>">
                                    <a href="<?php echo generate_url("blog"); ?>"><?php echo trans('all'); ?></a>
                                </li>
                                <?php
                                $blog_categories = get_blog_categories();
                                foreach ($blog_categories as $category): ?>
                                    <li class="<?php echo ($active_category == $category->slug) ? 'active' : ''; ?>">
                                        <a href="<?php echo generate_url("blog") . "/" . html_escape($category->slug); ?>"><?php echo html_escape($category->name); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <!--print blog posts-->
                        <?php foreach ($posts as $item): ?>
                            <div class="col-xs-12 col-sm-6 col-lg-4">
                                <?php $this->load->view('blog/_blog_item', ['item' => $item, 'blog_slider' => false]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row">
                        <!-- Pagination -->
                        <div class="col-sm-12">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- Wrapper End-->
