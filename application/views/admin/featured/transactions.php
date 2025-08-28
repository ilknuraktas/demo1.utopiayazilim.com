<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header with-border">
				<h3 class="card-title"><?php echo $title; ?></h3>
			</div><!-- /.box-header -->

			<div class="card-body">
				<div class="row">
					<!-- include message block -->
					<div class="col-sm-12">
						<?php $this->load->view('admin/includes/_messages'); ?>
					</div>
				</div>
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered table-striped" role="grid">
							<?php $this->load->view('admin/featured/_filter_transactions'); ?>
							<thead>
								<tr role="row">
									<th><?php echo trans('id'); ?></th>
									<th><?php echo trans('payment_method'); ?></th>
									<th><?php echo trans('payment_id'); ?></th>
									<th><?php echo trans('user'); ?></th>
									<th><?php echo trans('product_id'); ?></th>
									<th><?php echo trans('currency'); ?></th>
									<th><?php echo trans('payment_amount'); ?></th>
									<th><?php echo trans('payment_status'); ?></th>
									<th><?php echo trans('purchased_plan'); ?></th>
									<th><?php echo trans('ip_address'); ?></th>
									<th><?php echo trans('date'); ?></th>
									<th><?php echo trans('options'); ?></th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($transactions as $item): ?>
									<tr>
										<td><?php echo $item->id; ?></td>
										<td>
											<?php
											if ($item->payment_method == "Bank Transfer") {
												echo trans("bank_transfer");
											} else {
												echo $item->payment_method;
											} ?>
										</td>
										<td><?php echo $item->payment_id; ?></td>
										<td>
											<?php $user = get_user($item->user_id);
											if (!empty($user)):?>
												<div class="table-orders-user">
													<a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
														<?php echo html_escape($user->username); ?>
													</a>
												</div>
											<?php endif; ?>
										</td>
										<td><?php echo $item->product_id; ?></td>
										<td><?php echo $item->currency; ?></td>
										<td><?php echo $item->payment_amount; ?></td>
										<td><?php echo $item->payment_status; ?></td>
										<td><?php echo $item->purchased_plan; ?></td>
										<td><?php echo $item->ip_address; ?></td>
										<td><?php echo formatted_date($item->created_at); ?></td>
										<td>
											<div class="btn-group">
												<button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown"><?php echo trans('select_option'); ?>
												<i class="bx bx-brightness label-icon"></i>
											</button>
											<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
												<?php $product = get_product($item->product_id);
												if (!empty($product)):
													if ($product->is_promoted != 1): ?>
														<li>
															<a class="dropdown-item" href="javascript:void(0)" onclick="$('#day_count_product_id').val('<?php echo html_escape($item->product_id); ?>');" data-toggle="modal" data-target="#myModal">
																<?php echo trans('add_to_featured'); ?>
															</a>
														</li>
													<?php endif;
												endif;
												?>
												<li>
													<a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('product_admin_controller/delete_featured_transaction_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');">
														<?php echo trans('delete'); ?>
													</a>
												</li>
											</ul>
										</div>
									</td>
								</tr>

							<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($transactions)): ?>
						<p class="text-center">
							<?php echo trans("no_records_found"); ?>
						</p>
					<?php endif; ?>
					<div class="col-sm-12 table-ft">
						<div class="row">
							<div class="pull-right">
								<?php echo $this->pagination->create_links(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.box-body -->
	</div>

	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<?php echo form_open('product_admin_controller/add_remove_featured_products'); ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php echo trans('add_to_featured'); ?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label><?php echo trans('day_count'); ?></label>
						<input type="hidden" class="form-control" name="product_id" id="day_count_product_id" value="">
						<input type="hidden" class="form-control" name="is_ajax" value="0">
						<input type="number" class="form-control" name="day_count" placeholder="<?php echo trans('day_count'); ?>" value="1" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><?php echo trans("submit"); ?></button>
					<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
				</div>
				<?php echo form_close(); ?><!-- form end -->
			</div>

		</div>
	</div>
</div>
</div>