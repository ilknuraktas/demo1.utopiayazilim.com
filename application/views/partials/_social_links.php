<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<ul>
    <?php if (!empty($this->settings->facebook_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->facebook_url); ?>" class="facebook" style="background-color: #4267b2; border-radius: 5px;"><i class="icon-facebook"></i></a></li>
    <?php endif; ?>
    <?php if (!empty($this->settings->twitter_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->twitter_url); ?>" class="twitter" style="background-color: #4393ce; border-radius: 5px;"><i class="icon-twitter"></i></a></li>
    <?php endif; ?>
    <?php if (!empty($this->settings->instagram_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->instagram_url); ?>" class="instagram" style="background-color: #d83377; border-radius: 5px;"><i class="icon-instagram"></i></a></li>
    <?php endif; ?>
    <?php if (!empty($this->settings->youtube_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->youtube_url); ?>" class="youtube" style="background-color: #e52425; border-radius: 5px;"><i class="icon-youtube"></i></a></li>
    <?php endif; ?>
    <?php if (!empty($this->settings->linkedin_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->linkedin_url); ?>" class="linkedin" style="background-color: #0076b4; border-radius: 5px;"><i class="icon-linkedin"></i></a></li>
    <?php endif; ?>
    <?php if (!empty($this->settings->vk_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->vk_url); ?>" class="vk" style="background-color: #4c75a3; border-radius: 5px;"><i class="icon-vk"></i></a></li>
    <?php endif; ?>
    <?php if (!empty($this->settings->pinterest_url)): ?>
        <li><a href="<?php echo html_escape($this->settings->pinterest_url); ?>" class="pinterest" style="background-color: #f0002a; border-radius: 5px;"><i class="icon-pinterest"></i></a></li>
    <?php endif; ?>
    <?php if ($this->general_settings->rss_system == 1 && isset($show_rss)): ?>
        <!--li><a href="<?php echo generate_url("rss_feeds"); ?>" class="rss" style="background-color: #333; border-radius: 5px;"><i class="icon-rss"></i></a></li-->
    <?php endif; ?>
</ul>
