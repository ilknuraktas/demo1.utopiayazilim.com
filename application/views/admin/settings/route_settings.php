<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
				<div class="card">
					<div class="card-header with-border">
						<div class="left">
							<h3 class="card-title"><?php echo trans("route_settings");; ?></h3>
						</div>
					</div><!-- /.box-header -->

					<!-- form start -->
					<?php echo form_open_multipart('settings_controller/route_settings_post'); ?>
					<div class="card-body">
						<div class="row">
							<!-- include message block -->
							<div class="col-sm-12">
								<?php $this->load->view('admin/includes/_messages'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<?php if (!empty($this->routes)):
									foreach ($this->routes as $key => $value):
										if ($key != "id"):?>
											<div class="col-sm-3 col-xs-3">
												<input type="text" class="form-control" name="<?php echo $key; ?>_readonly" value="<?php echo str_replace('_', '-', $key); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
											</div>
											<div class="col-sm-3 col-xs-3">
												<input type="text" class="form-control" name="<?php echo $key; ?>" value="<?php echo $value; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
											</div>
										<?php endif;
									endforeach;
								endif; ?>
							</div>
						</div>
					</div><!-- /.box-body -->

					<!-- /.box-body -->
					<div class="card-footer">
						<button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
							<i class="bx bx-check label-icon"></i>
							<?php echo trans('save_changes'); ?>
						</button>
					</div>
					<!-- /.box-footer -->
					<?php echo form_close(); ?><!-- form end -->
				</div>
				<div class="alert alert-danger">
					<i class="mdi mdi-block-helper me-2"></i>
					<strong><?php echo trans("warning"); ?>!</strong>
					<?php echo trans("route_settings_warning"); ?>
				</div>
			</div>
		</div>
	</div>
</div>