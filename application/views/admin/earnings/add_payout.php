<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
	<div class="container-fluid">
		<div class="card box-primary">
			<div class="card-header with-border">
				<div class="d-flex flex-wrap align-items-center mb-3">
					<div class="left">
						<h3 class="card-title"><?php echo trans('add_payout'); ?></h3>
					</div>
					<div class="ms-auto">
						<a href="<?php echo admin_url(); ?>payout-requests" class="btn btn-success waves-effect btn-label waves-light">
							<i class="bx bx-plus label-icon"></i>
							<?php echo trans('payout_requests'); ?>
						</a>
					</div>
				</div>
			</div><!-- /.box-header -->

			<!-- form start -->
			<?php echo form_open('earnings_admin_controller/add_payout_post', ['class' => 'validate_price']); ?>

			<div class="card-body">
				<!-- include message block -->
				<?php $this->load->view('admin/includes/_messages'); ?>
				<div class="mb-3">
					<div class="row">
						<div class="col-md-6 mb-3">
							<label><?php echo trans("user"); ?></label>
							<select name="user_id" class="form-control" required>
								<option value="" selected><?php echo trans("select"); ?></option>
								<?php foreach ($users as $user): ?>
									<option value="<?php echo $user->id; ?>"><?php echo $user->id; ?>&nbsp;&nbsp;--&nbsp;<?php echo $user->username; ?>&nbsp;&nbsp;--&nbsp;&nbsp;<?php echo price_formatted($user->balance, $this->payment_settings->default_product_currency); ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="col-md-6 mb-3">
							<label><?php echo trans("withdraw_amount"); ?>&nbsp;(<?php echo $this->payment_settings->default_product_currency; ?>)</label>
							<input type="text" name="amount" class="form-control form-input price-input" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
						</div>

						<div class="col-md-6 mb-3">
							<label><?php echo trans("withdraw_method"); ?></label>
							<div class="selectdiv">
								<select name="payout_method" class="form-control" required>
									<option value="" selected><?php echo trans("select"); ?></option>
									<option value="paypal"><?php echo trans("paypal"); ?></option>
									<option value="iban"><?php echo trans("iban"); ?></option>
									<option value="swift"><?php echo trans("swift"); ?></option>
								</select>
							</div>
						</div>

						<div class="col-md-6 mb-3">
							<label><?php echo trans("status"); ?></label>
							<div class="selectdiv">
								<select name="status" class="form-control" required>
									<option value="" selected><?php echo trans("select"); ?></option>
									<option value="0"><?php echo trans("pending"); ?></option>
									<option value="1"><?php echo trans("completed"); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>

			</div>

			<!-- /.box-body -->
			<div class="card-footer">
				<button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
					<i class="bx bx-check label-icon"></i>
					<?php echo trans('add_payout'); ?>
				</button>
			</div>
			<!-- /.box-footer -->
			<?php echo form_close(); ?><!-- form end -->
		</div>
		<!-- /.box -->
	</div>
</div>
</div>
</div>