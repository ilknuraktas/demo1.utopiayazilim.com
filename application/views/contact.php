<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="breadcrumbs__section breadcrumbs__section-thin brk-bg-center-cover lazyload" data-bg="<?php echo base_url(); ?>assets/skin/img/1920x258_1.jpg" data-brk-library="component__breadcrumbs_css">
		<span class="brk-abs-bg-overlay brk-bg-grad opacity-80"></span>
		<div class="breadcrumbs__wrapper">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-lg-6">
						<div class="d-flex justify-content-lg-end justify-content-start pr-40 pr-xs-0 breadcrumbs__title">
							<h2 class="brk-white-font-color font__weight-semibold font__size-48 line__height-68 font__family-montserrat pt-xs-40">
								<?php echo trans("contact"); ?>
							</h2>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="pt-50 pb-50 position-static position-lg-relative breadcrumbs__subtitle">
							<h3 class="brk-white-font-color font__family-montserrat font__weight-regular font__size-18 line__height-21 text-uppercase mb-15">
								Meet Us
							</h3>
							<ol class="breadcrumb font__family-montserrat font__size-15 line__height-16 brk-white-font-color" style="background:transparent;padding-left: 0;">
								<li>
									<a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a>
									<i class="fal fa-chevron-right icon" style="padding-right: 5px;padding-left: 5px;"></i>
								</li>
								<li class="active"><?php echo trans("contact"); ?></li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
			<section class="pt-80 pb-25">
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
                            <!-- include message block -->
                            <?php $this->load->view('partials/_messages'); ?>
							<div class="brk-subscribe-mail brk-subscribe-mail_dark brk-form-strict pt-15 wow fadeInLeft">
							<!-- form start -->
                            <?php echo form_open('contact-post', ['id' => 'form_validate', 'class' => 'validate_terms']); ?>
                            <div class="form-group" style="margin-top:10px">
                                <input style="/*! border-bottom: 3px solid #623cea; */" type="text" class="form-control form-input" name="name" placeholder="<?php echo trans("name"); ?>" maxlength="199" minlength="1" pattern=".*\S+.*" value="<?php echo old('name'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>
                            <div class="form-group">
                                <input style="/*! border-bottom: 3px solid #623cea; */" type="email" class="form-control form-input" name="email" maxlength="199" placeholder="<?php echo trans("email_address"); ?>" value="<?php echo old('email'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>
                            <div class="form-group">
                                <textarea style="/*! border-bottom: 3px solid #623cea; */" class="form-control form-input form-textarea" name="message" placeholder="<?php echo trans("message"); ?>" maxlength="4970" minlength="5" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required><?php echo old('message'); ?></textarea>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox custom-control-validate-input">
                                    <input style="border-bottom: 3px solid #1a71eb;" type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" required>
                                    <?php $page_terms_condition = get_page_by_default_name("terms_conditions", $this->selected_lang->id); ?>
                                    <label for="checkbox_terms" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;<a href="<?php echo lang_base_url() . $page_terms_condition->slug; ?>" class="link-terms" target="_blank"><strong><?php echo html_escape($page_terms_condition->title); ?></strong></a></label>
                                </div>
                            </div>

                            <?php generate_recaptcha(); ?>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-block" style="padding: 10px;">
                                    <?php echo trans("submit"); ?>
                                </button>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
						</div>
						<div class="col-lg-1"></div>
						<div class="col-lg-5">
							<div class="wow fadeInRight">
								<h1 class="font__family-montserrat font__size-56 line__height-60 font__weight-thin">
									<?php echo $this->settings->contact_text; ?><br>
								</h1>
								<p class="font__family-open-sans font__weight-bold font__size-14 mb-15">
                            <?php if ($this->settings->contact_phone): ?>
                                <div class="col-12 contact-item font__family-montserrat font__weight-regular letter-spacing-60" style="margin-top: 10px;font-size: 16px; color: #333;">
                                    <i class="icon-phone" style="color: #623cea;padding: 5px;/*! border-radius: 5px; *//*! border-right: 3px solid; */margin-right: 10px;font-size: 22px;" aria-hidden="true"></i>
                                    <?php echo html_escape($this->settings->contact_phone); ?>
                                </div>
                            <?php endif; ?>
								</p>

								<p class="font__family-open-sans font__weight-bold font__size-14 mb-15">
                            <?php if ($this->settings->contact_whatsapp1): ?>
                                <div class="col-12 contact-item font__family-montserrat font__weight-regular letter-spacing-60" style="margin-top: 10px;font-size: 16px; color: #333;">
                                    <i class="icon-whatsapp" style="color: #623cea;padding: 5px;/*! border-radius: 5px; *//*! border-right: 3px solid; */margin-right: 10px;font-size: 22px;" aria-hidden="true"></i>
                                    <?php echo html_escape($this->settings->contact_whatsapp1); ?>
                                </div>
                            <?php endif; ?>
								</p>

								<p class="font__family-open-sans font__weight-bold font__size-14 mb-15">
                            <?php if ($this->settings->contact_whatsapp2): ?>
                                <div class="col-12 contact-item font__family-montserrat font__weight-regular letter-spacing-60" style="margin-top: 10px;font-size: 16px; color: #333;">
                                    <i class="icon-whatsapp" style="color: #623cea;padding: 5px;/*! border-radius: 5px; *//*! border-right: 3px solid; */margin-right: 10px;font-size: 22px;" aria-hidden="true"></i>
                                    <?php echo html_escape($this->settings->contact_whatsapp2); ?>
                                </div>
                            <?php endif; ?>
								</p>

								<p class="font__family-open-sans font__weight-bold font__size-14 mb-15">
                            <?php if ($this->settings->contact_email): ?>
                                <div class="col-12 contact-item font__family-montserrat font__weight-regular letter-spacing-60" style="font-size: 16px; color: #333;">
                                    <i class="icon-envelope" style="color: #623cea;padding: 5px;/*! border-radius: 5px; *//*! border-right: 3px solid; */margin-right: 10px;font-size: 22px;" aria-hidden="true"></i>
                                    <?php echo html_escape($this->settings->contact_email); ?>
                                </div>
                            <?php endif; ?>
								</p>

								<p class="font__family-open-sans font__weight-bold font__size-14 mb-15">
                            <?php if ($this->settings->contact_address): ?>
                                <div class="col-12 contact-item font__family-montserrat font__weight-regular letter-spacing-60" style="font-size: 16px; color: #333;">
                                    <i class="icon-map-marker" style="color: #623cea;padding: 5px;/*! border-radius: 5px; *//*! border-right: 3px solid; */margin-right: 10px;font-size: 22px;" aria-hidden="true"></i>
                                    <?php echo html_escape($this->settings->contact_address); ?>
                                </div>
                            <?php endif; ?>
								</p>
                            <div class="col-sm-12 contact-social">
                                <!--Include social media links-->
                                <?php $this->load->view('partials/_social_links', ['show_rss' => null]); ?>
                            </div>
							</div>
						</div>
					</div>
				</div>
			</section>
<!-- Wrapper -->
<div id="wrapper" style="min-height: auto;padding-bottom: 0;">

    <?php if (!empty($this->settings->contact_address)): ?>
        <div class="container-fluid">
            <div class="row">
                <div class="contact-map-container">
                    <iframe id="contact_iframe" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo $this->settings->contact_address; ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- Wrapper End-->
<script>
    var iframe = document.getElementById("contact_iframe");
    iframe.src = iframe.src;
</script>
<style>
    .circle__wrap, .corner__wrap, .round__wrap, .triangle__wrap, .wing__wrap {

        display: none;
    }

</style>
