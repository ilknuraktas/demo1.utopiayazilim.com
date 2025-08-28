<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php echo form_open_multipart('/excel/test.php'); ?>
                    <input type="file" name="upload_file" class="form-control">
                    <button type="submit" class="form-control">İçe Aktar</button>
           <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
