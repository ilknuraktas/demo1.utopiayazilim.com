<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $this->selected_lang->short_form ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,maximum-scale=1">
	<meta name="format-detection" content="telephone=no">
	<title><?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?></title>
	<meta name="description" content="<?php echo xss_clean($description); ?>"/>
	<meta name="keywords" content="<?php echo xss_clean($keywords); ?>"/>
	<meta name="author" content="Utopia"/>
	<link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->general_settings); ?>"/>
	<meta property="og:locale" content="en-US"/>
	<meta property="og:site_name" content="<?php echo xss_clean($this->general_settings->application_name); ?>"/>
	<?php if (isset($show_og_tags)): ?>
		<meta property="og:type" content="<?php echo $og_type; ?>"/>
		<meta property="og:title" content="<?php echo $og_title; ?>"/>
		<meta property="og:description" content="<?php echo $og_description; ?>"/>
		<meta property="og:url" content="<?php echo $og_url; ?>"/>
		<meta property="og:image" content="<?php echo $og_image; ?>"/>
		<meta property="og:image:width" content="<?php echo $og_width; ?>"/>
		<meta property="og:image:height" content="<?php echo $og_height; ?>"/>
		<meta property="article:author" content="Utopia"/>
		<meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
		<?php if (!empty($og_tags)):foreach ($og_tags as $tag): ?>
			<meta property="article:tag" content="<?php echo $tag->tag; ?>"/>
		<?php endforeach; endif; ?>
		<meta property="article:published_time" content="<?php echo $og_published_time; ?>"/>
		<meta property="article:modified_time" content="<?php echo $og_modified_time; ?>"/>
		<meta name="twitter:card" content="summary_large_image"/>
		<meta name="twitter:site" content="@<?php echo xss_clean($this->general_settings->application_name); ?>"/>
		<meta name="twitter:creator" content="@<?php echo xss_clean($og_creator); ?>"/>
		<meta name="twitter:title" content="<?php echo xss_clean($og_title); ?>"/>
		<meta name="twitter:description" content="<?php echo xss_clean($og_description); ?>"/>
		<meta name="twitter:image" content="<?php echo $og_image; ?>"/>
	<?php else: ?>
		<meta property="og:image" content="<?php echo get_logo($this->general_settings); ?>"/>
		<meta property="og:image:width" content="160"/>
		<meta property="og:image:height" content="60"/>
		<meta property="og:type" content="website"/>
		<meta property="og:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?>"/>
		<meta property="og:description" content="<?php echo xss_clean($description); ?>"/>
		<meta property="og:url" content="<?php echo base_url(); ?>"/>
		<meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
		<meta name="twitter:card" content="summary_large_image"/>
		<meta name="twitter:site" content="@<?php echo xss_clean($this->general_settings->application_name); ?>"/>
		<meta name="twitter:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?>"/>
		<meta name="twitter:description" content="<?php echo xss_clean($description); ?>"/>
	<?php endif; ?>
	<link rel="canonical" href="<?php echo current_url(); ?>"/>
	<?php if ($this->general_settings->multilingual_system == 1):
		foreach ($this->languages as $language):
			if ($language->id == $this->site_lang->id):?>
				<link rel="alternate" href="<?php echo base_url(); ?>" hreflang="<?php echo $language->language_code ?>"/>
			<?php else: ?>
				<link rel="alternate" href="<?php echo base_url() . $language->short_form . "/"; ?>" hreflang="<?php echo $language->language_code ?>"/>
			<?php endif; endforeach; endif; ?>
			<!-- Icons -->
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-icons/css/font-icon.min.css"/>
			<?php echo !empty($this->fonts->font_url) ? $this->fonts->font_url : ''; ?>
			<!-- Bootstrap CSS -->
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css"/>
			<!-- Style CSS -->
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-1.6.min.css"/>
			<!-- Plugins CSS -->
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/plugins-1.6.css"/>
			<?php if (!empty($this->general_settings->site_color)): ?>
				<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/<?php echo $this->general_settings->site_color; ?>.min.css"/>
			<?php else: ?>
				<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/default.min.css"/>
			<?php endif; ?>
			<style>body {<?php echo $this->fonts->font_family; ?>} .m-r-0{margin-right: 0 !important;} .p-r-0{padding-right: 0 !important}</style>
			<?php echo $this->general_settings->custom_css_codes; ?>
			<script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
	
	<link rel="stylesheet" id="brk-direction-bootstrap" href="<?php echo base_url(); ?>assets/skin/css/assets/bootstrap.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
	<link rel="stylesheet" id="brk-skin-color" href="<?php echo base_url(); ?>assets/skin/css/skins/brk-blue.css">
	<link id="brk-base-color" rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/skins/brk-base-color.css">
	<link rel="stylesheet" id="brk-direction-offsets" href="<?php echo base_url(); ?>assets/skin/css/assets/offsets.css">
	<link id="brk-css-min" rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/assets/styles.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/vendor/revslider/css/settings.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/parallax.css">
<link rel="stylesheet"  href="<?php echo base_url(); ?>assets/skin/css/components/info-box.css">
<!-- for parallax with progress bars -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/progress-bars.css">


	<style> #rev_slider_15_1_wrapper .tp-loader.spinner2{ background-color: #0071fc !important; } </style>
	<style>.brk-castom-btn.rev-btn.rev-withicon i{margin-left:0 !important; margin-right:10px !important; vertical-align:0; top:-1px}</style>
	<style>.custom.tparrows{cursor:pointer;background:#000;background:rgba(0,0,0,0.5);width:40px;height:40px;position:absolute;display:block;z-index:100}.custom.tparrows:hover{background:#000}.custom.tparrows:before{font-family:"revicons";font-size:15px;color:#fff;display:block;line-height:40px;text-align:center}.custom.tparrows.tp-leftarrow:before{content:"\e824"}.custom.tparrows.tp-rightarrow:before{content:"\e825"}</style>
	<script>function setREVStartSize(e){
  try{ e.c=jQuery(e.c);var i=jQuery(window).width(),t=9999,r=0,n=0,l=0,f=0,s=0,h=0;
    if(e.responsiveLevels&&(jQuery.each(e.responsiveLevels,function(e,f){f>i&&(t=r=f,l=e),i>f&&f>r&&(r=f,n=e)}),t>r&&(l=n)),f=e.gridheight[l]||e.gridheight[0]||e.gridheight,s=e.gridwidth[l]||e.gridwidth[0]||e.gridwidth,h=i/s,h=h>1?1:h,f=Math.round(h*f),"fullscreen"==e.sliderLayout){var u=(e.c.width(),jQuery(window).height());if(void 0!=e.fullScreenOffsetContainer){var c=e.fullScreenOffsetContainer.split(",");if (c) jQuery.each(c,function(e,i){u=jQuery(i).length>0?u-jQuery(i).outerHeight(!0):u}),e.fullScreenOffset.split("%").length>1&&void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0?u-=jQuery(window).height()*parseInt(e.fullScreenOffset,0)/100:void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0&&(u-=parseInt(e.fullScreenOffset,0))}f=u}else void 0!=e.minHeight&&f<e.minHeight&&(f=e.minHeight);e.c.closest(".rev_slider_wrapper").css({height:f})
  }catch(d){console.log("Failure at Presize of Slider:"+d)}
};</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/steps.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/widgets.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/vendor/slickCarousel/css/slick.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/sliders.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/tabbed-contents.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/svg-pattern.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/image-frames.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/portfolio-isotope.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/vendor/swiper/css/swiper.min.css">
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/shop-components-row.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/shop-components-masonry.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/backgrounds.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/content-sliders.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/sliders.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/team.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/content-sliders.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/shop-components-row.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/timelines.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/team.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/media-embeds.css">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/tabbed-contents.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/image-frames.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/svg-pattern.css">


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/section-titles.css">


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/shop-components-honeycomb.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/skin/css/components/parallax.css">
	<link id="css-google-fonts" href="https://fonts.googleapis.com/css?family=Oxygen:300,400,700|Montserrat:100,200,300,400,500,600,700|Open+Sans:300,400,600,700|Montserrat+Alternates:400,700" rel="stylesheet">
	
			<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
			<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
	<?php echo $this->general_settings->google_adsense_code; ?>

	<script type="text/javascript">
		var title = document.title;
		var alttitle = "Beni Unutma! ❤";
		window.onblur = function () { document.title = alttitle; };
		window.onfocus = function () { document.title = title; };
	</script>
</head>
<body class="brk-bordered-theme" data-border="30">
	<style>.brk-button-shadow{-webkit-box-shadow:0 5px 16px rgba(39,117,255,.5) !important;-moz-box-shadow:0 5px 16px rgba(39,117,255,.5) !important;box-shadow:0 5px 16px rgba(39,117,255,.5) !important;  margin:20px !important}@media (min-width: 992px) {.custom-tabbed-contents-mt {margin-top: -140px;}}</style>
	<div class="main-page">
	<header id="header">

		<?php $this->load->view("partials/_top_bar"); ?>
		<div class="main-menu" style="box-shadow: rgb(85 85 85 / 50%) 0px 1px 2px 0px;">
			<div class="container">
				<div class="row">
					<div class="nav-top">
						<div class="container" style="margin-left: auto; margin-right: auto;">
							<div class="row align-items-center">
								<div class="col-md-9 nav-top-left">
									<div class="row-align-items-center">
										<div class="logo">
											<a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo"></a>
										</div>

										<div class="top-search-bar text-center">
											<div class="background-dark"></div>
											<?php echo form_open(generate_url('search'), ['id' => 'form_validate_search', 'class' => 'form_search_main', 'method' => 'get']); ?>
											<?php if ($this->general_settings->multi_vendor_system == 1): ?>
												<div class="left">
													<div class="dropdown search-select">
														<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
															<?php if (isset($search_type)): ?>
																<?php echo trans("member"); ?>
															<?php else: ?>
																<?php echo trans("product"); ?>
															<?php endif; ?>
														</button>
														<div class="dropdown-menu">
															<a class="dropdown-item" data-value="product" href="javascript:void(0)"><?php echo trans("product"); ?></a>
															<a class="dropdown-item" data-value="member" href="javascript:void(0)"><?php echo trans("member"); ?></a>
														</div>
													</div>
													<?php if (isset($search_type)): ?>
														<input type="hidden" class="search_type_input" name="search_type" value="member">
													<?php else: ?>
														<input type="hidden" class="search_type_input" name="search_type" value="product">
													<?php endif; ?>
												</div>
												<div class="right">
													<input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_exp"); ?>" required autocomplete="off">
													<button class="btn btn-default btn-search">
														<i class="icon-search" style="color: #fff!important;font-weight: bold;"></i>
													</button>
													<div id="response_search_results" class="search-results-ajax"></div>
												</div>
											<?php else: ?>
												<input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_products"); ?>" required autocomplete="off">
												<button class="btn btn-default btn-search"><i class="icon-search"></i></button>
												<div id="response_search_results" class="search-results-ajax"></div>
											<?php endif; ?>
											<?php echo form_close(); ?>
										</div>
									</div>
								</div>
								<div class="col-md-3 nav-top-right">
									<ul class="nav align-items-center">
										<?php if ($this->auth_check): ?>
											<li class="nav-item dropdown profile-dropdown p-r-0">
												<a class="nav-link dropdown-toggle a-profile" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false">
													<img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>">
													<?php if ($unread_message_count > 0): ?>
														<span class="notification"><?php echo $unread_message_count; ?></span>
													<?php endif; ?>
													<?php echo character_limiter(get_shop_name($this->auth_user), 15, '..'); ?>
													<i class="icon-arrow-down"></i>
												</a>
												<ul class="dropdown-menu">
													<?php if ($this->auth_user->role == "admin"): ?>
														<li>
															<a href="<?php echo admin_url(); ?>">
																<i class="icon-dashboard"></i>
																<?php echo trans("admin_panel"); ?>
															</a>
														</li>
													<?php endif; ?>
													<li>
														<a href="<?php echo generate_profile_url($this->auth_user->slug); ?>">
															<i class="icon-user"></i>
															<?php echo trans("view_profile"); ?>
														</a>
													</li>
													<?php if (is_sale_active()): ?>
														<?php if (is_user_vendor()): ?>
															<li>
																<a href="/magazam">
																	<i class="icon-dashboard"></i>
																	<?php echo trans("panel"); ?>
																</a>
															</li>
														<!--li>
															<a href="<?php echo generate_url("sales"); ?>">
																<i class="icon-shopping-bag"></i>
																<?php echo trans("sales"); ?>
															</a>
														</li-->
														<!--li>
															<a href="<?php echo generate_url("earnings"); ?>">
																<i class="icon-wallet"></i>
																<?php echo trans("earnings"); ?>
															</a>
														</li-->
													<?php endif; ?>
													<li>
														<a href="<?php echo generate_url("orders"); ?>">
															<i class="icon-shopping-basket"></i>
															<?php echo trans("orders"); ?>
														</a>
													</li>

													<?php if (is_bidding_system_active()): ?>
														<li>
															<a href="<?php echo generate_url("quote_requests"); ?>">
																<i class="icon-price-tag-o"></i>
																<?php echo trans("quote_requests"); ?>
															</a>
														</li>
													<?php endif; ?>
													<?php if ($this->general_settings->digital_products_system == 1): ?>
														<li>
															<a href="<?php echo generate_url("downloads"); ?>">
																<i class="icon-download"></i>
																<?php echo trans("downloads"); ?>
															</a>
														</li>
													<?php endif; ?>
												<?php endif; ?>
											<li>
												<a href="<?php echo generate_url("wishlist") . "/" . ($this->auth_user->slug); ?>">
													<i class="icon-heart-o"></i>
													<?php echo trans("wishlist"); ?>
												</a>
											</li>

												<li>
													<a href="<?php echo generate_url("messages"); ?>">
														<i class="icon-mail"></i>
														<?php echo trans("messages"); ?>&nbsp;<?php if ($unread_message_count > 0): ?>
														<span class="span-message-count"><?php echo $unread_message_count; ?></span>
													<?php endif; ?>
												</a>
											</li>
											<li>
												<a href="<?php echo generate_url("settings", "update_profile"); ?>">
													<i class="icon-settings"></i>
													<?php echo trans("settings"); ?>
												</a>
											</li>
											<li>
												<a href="<?php echo lang_base_url(); ?>logout" class="logout">
													<i class="icon-logout"></i>
													<?php echo trans("logout"); ?>
												</a>
											</li>
										</ul>
									</li>
								<?php else: ?>
										<!--li class="nav-item">
											<a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="nav-link">
												<strong style="display: flex; -webkit-box-align: center; align-items: center; -webkit-box-pack: center; justify-content: center; border-radius: 50%; background-color: rgb(244, 244, 244); width: 48px; height: 48px;">
													<svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="18" height="18">
														<path d="M22.713,4.077A2.993,2.993,0,0,0,20.41,3H4.242L4.2,2.649A3,3,0,0,0,1.222,0H1A1,1,0,0,0,1,2h.222a1,1,0,0,1,.993.883l1.376,11.7A5,5,0,0,0,8.557,19H19a1,1,0,0,0,0-2H8.557a3,3,0,0,1-2.82-2h11.92a5,5,0,0,0,4.921-4.113l.785-4.354A2.994,2.994,0,0,0,22.713,4.077ZM21.4,6.178l-.786,4.354A3,3,0,0,1,17.657,13H5.419L4.478,5H20.41A1,1,0,0,1,21.4,6.178Z"/><circle cx="7" cy="22" r="2"/><circle cx="17" cy="22" r="2"/>
													</svg>
												</strong>
												Giriş
											</a>
										</li-->
										<li class="nav-item">
											<a href="<?php echo generate_url("register"); ?>" class="nav-link">
												<strong style="display: flex; -webkit-box-align: center; align-items: center; -webkit-box-pack: center; justify-content: center; border-radius: 50%; background-color: rgb(244, 244, 244); width: 48px; height: 48px;">
													<svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="20" height="18">
														<path d="M12,12A6,6,0,1,0,6,6,6.006,6.006,0,0,0,12,12ZM12,2A4,4,0,1,1,8,6,4,4,0,0,1,12,2Z"/><path d="M12,14a9.01,9.01,0,0,0-9,9,1,1,0,0,0,2,0,7,7,0,0,1,14,0,1,1,0,0,0,2,0A9.01,9.01,0,0,0,12,14Z"/>
													</svg>
												</strong>
												<span><?php echo trans("login"); ?> <br> <?php echo trans("register"); ?></span>
											</a>
										</li>
									<?php endif; ?>
									<?php if (is_sale_active()): ?>
										<li class="nav-item nav-item-cart li-main-nav-right">
											<a href="<?php echo generate_url("cart"); ?>">
												<span style="display: flex; -webkit-box-align: center; align-items: center; -webkit-box-pack: center; justify-content: center; border-radius: 50%; background-color: rgb(244, 244, 244); width: 48px; height: 48px;">
													<svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="18" height="18">
														<path d="M22.713,4.077A2.993,2.993,0,0,0,20.41,3H4.242L4.2,2.649A3,3,0,0,0,1.222,0H1A1,1,0,0,0,1,2h.222a1,1,0,0,1,.993.883l1.376,11.7A5,5,0,0,0,8.557,19H19a1,1,0,0,0,0-2H8.557a3,3,0,0,1-2.82-2h11.92a5,5,0,0,0,4.921-4.113l.785-4.354A2.994,2.994,0,0,0,22.713,4.077ZM21.4,6.178l-.786,4.354A3,3,0,0,1,17.657,13H5.419L4.478,5H20.41A1,1,0,0,1,21.4,6.178Z"/><circle cx="7" cy="22" r="2"/><circle cx="17" cy="22" r="2"/>
													</svg>
												</span>
												<span>Sepetim</span>
												<?php $cart_product_count = get_cart_product_count();
												if ($cart_product_count > 0): ?>
													<span class="notification"><?php echo $cart_product_count; ?></span>
												<?php endif; ?>
											</a>
										</li>
									<?php endif; ?>
								</ul>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="nav-main">
			<!--main navigation-->
			<?php $this->load->view("partials/_main_nav"); ?>
		</div>
	</div>
	<div class="mobile-nav-container">
		<div class="nav-mobile-header">
			<div class="container-fluid">
				<div class="row">
					<div class="nav-mobile-header-container">
						<div class="menu-icon">
							<a href="javascript:void(0)" class="btn-open-mobile-nav"><i class="icon-menu"></i></a>
						</div>
						<div class="mobile-logo">
							<a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo" class="logo"></a>
						</div>
						<?php if (is_sale_active()): ?>
							<div class="mobile-cart">
								<a href="<?php echo generate_url("cart"); ?>"><i class="icon-cart"></i>
									<?php $cart_product_count = get_cart_product_count(); ?>
									<span class="notification"><?php echo $cart_product_count; ?></span>
								</a>
							</div>
						<?php endif; ?>
						<div class="mobile-search">
							<a class="search-icon"><i class="icon-search"></i></a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="top-search-bar mobile-search-form">
						<?php echo form_open(generate_url('search'), ['id' => 'form_validate_search_mobile', 'method' => 'get']); ?>
						<?php if ($this->general_settings->multi_vendor_system == 1): ?>
							<div class="left">
								<div class="dropdown search-select">
									<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
										<?php if (isset($search_type)): ?>
											<?php echo trans("member"); ?>
										<?php else: ?>
											<?php echo trans("product"); ?>
										<?php endif; ?>
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" data-value="product" href="javascript:void(0)"><?php echo trans("product"); ?></a>
										<a class="dropdown-item" data-value="member" href="javascript:void(0)"><?php echo trans("member"); ?></a>
									</div>
								</div>
								<?php if (isset($search_type)): ?>
									<input type="hidden" class="search_type_input" name="search_type" value="member">
								<?php else: ?>
									<input type="hidden" class="search_type_input" name="search_type" value="product">
								<?php endif; ?>
							</div>
							<div class="right">
								<input type="text" name="search" maxlength="300" pattern=".*\S+.*" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search"); ?>" required>
								<button class="btn btn-default btn-search"><i class="icon-search"></i></button>
							</div>
						<?php else: ?>
							<input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_products"); ?>" required autocomplete="off">
							<button class="btn btn-default btn-search btn-search-single-vendor-mobile"><i class="icon-search"></i></button>
						<?php endif; ?>

						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

		</header>
	<div id="overlay_bg" class="overlay-bg"></div>
<!--include mobile menu-->
<?php $this->load->view("partials/_mobile_nav"); ?>

<?php if (!$this->auth_check): ?>
	<!-- Login Modal -->
	<div class="modal fade" id="loginModal" role="dialog">
		<div class="modal-dialog modal-dialog-centered login-modal" role="document">
			<div class="modal-content">
				<div class="auth-box">
					<button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
					<h4 class="title"><?php echo trans("login"); ?></h4>
					<!-- form start -->
					<form id="form_login" novalidate="novalidate">
						<div class="social-login-cnt">
							<?php $this->load->view("partials/_social_login", ["or_text" => trans("login_with_email")]); ?>
						</div>
						<!-- include message block -->
						<div id="result-login" class="font-size-13"></div>
						<div class="form-group">
							<input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" required>
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" minlength="4" required>
						</div>
						<div class="form-group text-right">
							<a href="<?php echo generate_url("forgot_password"); ?>" class="link-forgot-password"><?php echo trans("forgot_password"); ?></a>
						</div>
						<div class="form-group">
							<button type="submit" class="btn-custom btn-md btn-custom btn-block"><?php echo trans("login"); ?></button>
						</div>

						<p class="p-social-media m-0 m-t-5"><?php echo trans("dont_have_account"); ?>&nbsp;<a href="<?php echo generate_url("register"); ?>" class="link"><?php echo trans("register"); ?></a></p>
					</form>
					<!-- form end -->
				</div>
			</div>
		</div>
	</div>

	<?php endif; ?>

<div class="modal fade" id="locationModal" role="dialog">
	<div class="modal-dialog modal-dialog-centered login-modal" role="document">
		<div class="modal-content">
			<div class="auth-box">
				<button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
				<h4 class="title"><?php echo trans("select_location"); ?></h4>
				<!-- form start -->
				<?php echo form_open('set-default-location-post'); ?>
				<p class="location-modal-description"><?php echo trans("location_exp"); ?></p>
				<div class="selectdiv select-location">
					<select name="location_id" id="dropdown_location" class="form-control"></select>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("update_location"); ?></button>
				</div>
				<?php echo form_close(); ?>
				<!-- form end -->
			</div>
		</div>
	</div>
</div>

<div class="background-dark"></div>

<script>

	$(window).scroll(function(){
		var scrollTop = $(window).scrollTop();
		if(scrollTop > 0){
			$('.mp-gig-top-nav li.btns').removeClass("d-none");
			$('.dropdown-menu .right').css({ position : 'fixed', zIndex : "100", top : "0px", width: "100%", left: "300px"});
	  // ANA MENÜ FIXED
	  $('.nav-top').css({ position : 'fixed', zIndex : "100", top : "0px", width: "100%"});
	}else{
		$('.mp-gig-top-nav li.btns').addClass("d-none");
		$('.dropdown-menu .right').css({ position : 'sticky', zIndex : "100" });
      // ANA MENÜ FIXED
      $('.nav-top').css({ position : 'sticky', zIndex : "100" });
  }
});



	function menu(e){
		console.log(e.target)
		var _d=$(e.target).closest('.dropdown');
		if (e.type === 'mouseenter')_d.addClass('show');
		setTimeout(function(){
			_d.toggleClass('show', _d.is(':hover'));
			$('[data-toggle="#dropmenu"]', _d).attr('aria-expanded',_d.is(':hover'));
		},0);
	}


	$('body').on('mouseenter mouseleave','.dropdown',menu(e));


</script>


