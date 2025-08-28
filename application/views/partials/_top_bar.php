<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>



<!--img src="uploads/blocks/tb.jpg" width="100%"-->
<!--div class="container-fluid">

      <div class="row">

        <center>

          <a href="index.php">

            <img alt="kampanya-banner" src="uploads/blocks/tb.jpg" class="img-top-banner" width="100%">

          </a>

        </center>

      </div>

    </div-->


<div class="top-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 col-left  brk-header_color-white">
							<div class="brk-lang brk-header__item brk-lang-rendered brk-location-screen-left">
								<?php if ($this->general_settings->multilingual_system == 1 && count($this->languages) > 1): ?>
								
<span class="brk-lang__selected"><?php echo html_escape($this->selected_lang->name); ?><i class="fa fa-caret-down" aria-hidden="true"></i></span>
<span class="brk-lang__open"><i class="fa fa-language"></i> Language <span class="brk-lang__active-lang text-white brk-bg-primary"><?php echo html_escape($this->selected_lang->name); ?></span></span>
<ul class="brk-lang__option"><?php foreach ($this->languages as $language):
                                                        $lang_url = base_url() . $language->short_form . "/";
                                                        if ($language->id == $this->general_settings->site_lang) {
                                                            $lang_url = base_url();
                                                        } ?>
<li>
                                                        <a href="<?php echo $lang_url; ?>" class="<?php echo ($language->id == $this->selected_lang->id) ? 'selected' : ''; ?> " class="dropdown-item">
                                                            <?php echo $language->name; ?>
                                                        </a>
                                                    <?php endforeach; ?></li>
	
</ul>
								<?php endif; ?>
</div>
							<div class="brk-header__element brk-header__element_skin-2 brk-header__item" style="opacity: 1;">
								<a href="tel:<?php echo html_escape($this->settings->contact_phone); ?>" class="brk-header__element--wrap">
									<i class="fa fa-phone"></i>
									<span class="brk-header__element--label font__weight-semibold"><?php echo html_escape($this->settings->contact_phone); ?></span>
								</a>
							</div>
							<div class="brk-header__element brk-header__element_skin-2 brk-header__item" style="opacity: 1;">
								<a href="mailto:<?php echo html_escape($this->settings->contact_email); ?>" class="brk-header__element--wrap">
									<i class="fa fa-envelope"></i>
									<span class="brk-header__element--label font__weight-medium"><?php echo html_escape($this->settings->contact_email); ?></span>
								</a>
							</div>
            </div>
            <div class="col-8 col-right">
                <ul class="navbar-nav">
                    <?php if ($this->auth_check): ?>
                        <?php if (is_multi_vendor_active()): ?>
                            <li class="nav-item m-r-5 m-b-0 brk-header__element"><a href="<?php echo generate_url("rss_feeds"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("rss_feeds"); ?></a>
                            </li>
                            <li class="nav-item m-r-5 m-b-0 brk-header__element"><a href="<?php echo generate_url("orders"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("orders"); ?></a>
                            </li>
                            <li class="nav-item m-r-5 m-b-0 brk-header__element"><a href="<?php echo generate_url("messages"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("messages"); ?></a>
                            </li>
                            <li class="nav-item m-r-5 m-b-0 brk-header__element"><a href="<?php echo generate_url("settings", "update_profile"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("settings"); ?></a>
                            </li>
                            <?php if ($this->auth_user->role == "admin"): ?>
                                <li class="nav-item m-r-5 m-b-0 brk-header__element">
                                    <a href="<?php echo admin_url(); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80" target="_blank"><?php echo trans("admin_panel"); ?></a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item m-r-0"><a href="<?php echo generate_url("sell_now"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("sell_now"); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if (is_multi_vendor_active()): ?>
                            <li class="nav-item m-r-5 m-b-0 brk-header__element"><a href="<?php echo generate_url("rss_feeds"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("rss_feeds"); ?></a>
                            </li>
                            <li class="nav-item m-r-5 m-b-0 brk-header__element"><a href="<?php echo generate_url("blog"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("blog"); ?></a>
                            </li>
                            <li class="nav-item m-r-5 m-b-0 brk-header__element"><a href="<?php echo generate_url("contact"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("contact"); ?></a>
                            </li>
                            <li class="nav-item m-r-5 m-b-0 brk-header__element"><a href="javascript:void(0)" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a>
                            </li>
                            <li class="nav-item m-r-0"><a href="<?php echo generate_url("register"); ?>" class="btn-sell-now m-r-0 brk-mini-cart__open d-flex brk-header__element--wrap brk-mini-cart__label font__family-montserrat font__weight-medium text-uppercase letter-spacing-60 font__size-10 opacity-80"><?php echo trans("sell_now"); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>