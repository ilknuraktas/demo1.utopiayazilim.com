<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--print error messages-->
<?php if ($this->session->flashdata('errors_form')): ?>
    <div class="form-group">
        <div class="error-message">
            <?php echo $this->session->flashdata('errors_form'); ?>
        </div>
    </div>
<?php endif; ?>

<!--print custom error message-->
<?php if ($this->session->flashdata('error_form')): ?>
    <div class="form-group">
        <div class="margin-bottom-10">
            <div class="alert alert-danger alert-border-left alert-dismissible">
                <i class="mdi mdi-check-all me-3 align-middle"></i>
                <strong>Hey!</strong> <?php echo $this->session->flashdata('error_form'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
<?php endif; ?>

<!--print custom success message-->
<?php if ($this->session->flashdata('success_form')): ?>
    <div class="form-group">
        <div class="margin-bottom-10">
            <div class="alert alert-success alert-border-left alert-dismissible">
                <i class="mdi mdi-check-all me-3 align-middle"></i>
                <strong>Hey!</strong> <?php echo $this->session->flashdata('success_form'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>