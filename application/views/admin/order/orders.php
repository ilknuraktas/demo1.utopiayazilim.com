<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h3 class="box-title"><?php echo $title; ?></h3>
			</div><!-- /.box-header -->

			<div class="card-body">
				<div class="row">
					<!-- include message block -->
					<div class="col-sm-12">
						<?php $this->load->view('admin/includes/_messages'); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<table class="table table-bordered table-striped" role="grid">
							<?php $this->load->view('admin/order/_filter_orders'); ?>
							<thead>
								<tr role="row">
									<th style="text-align: center;"><?php echo trans('order'); ?></th>
									<th style="text-align: center;"><?php echo trans('date'); ?></th>
									<th style="text-align: center;"><?php echo trans('buyer'); ?></th>
									<th style="text-align: center;"><?php echo trans('total'); ?></th>
									<th style="text-align: center;"><?php echo trans('currency'); ?></th>
									<th style="text-align: center;"><?php echo trans('status'); ?></th>
									<th style="text-align: center;"><?php echo trans('payment_status'); ?></th>
									<th style="text-align: center;"><?php echo trans('updated'); ?></th>
									<th style="text-align: center;" class="max-width-120"><?php echo trans('options'); ?></th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($orders as $item): ?>
									<tr>
										<td class="order-number-table" style="text-align: center;">
											<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="table-link">
												#<?php echo html_escape($item->order_number); ?>
											</a>
										</td>

										<td style="text-align: center;"> <?php echo formatted_date($item->created_at); ?></td>

										<td>
											<?php if ($item->buyer_id == 0): ?>
												<div class="table-orders-user">
													<img src="<?php echo get_user_avatar(null); ?>" alt="satıcı" class="img-responsive" style="height: 20px; border-radius: 50%;">
													<?php $shipping = get_order_shipping($item->id);
													if (!empty($shipping)): ?>
														<span style="text-decoration: none;"><?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?></span>
													<?php endif; ?>
													<label class="label bg-olive" style="position: absolute;top: 0; left: 0;"><?php echo trans("guest"); ?></label>
												</div>
											<?php else:
												$buyer = get_user($item->buyer_id);
												if (!empty($buyer)):?>
													<div class="table-orders-user">
														<a style="text-decoration: none;" href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
															<img src="<?php echo get_user_avatar($buyer); ?>" alt="satıcı" class="img-responsive" style="height: 20px; border-radius: 50%;">
															<?php echo html_escape($buyer->username); ?>
														</a>
													</div>
												<?php endif;
											endif;
											?>
										</td>

										<td style="text-align: center;">
											<strong><?php echo price_formatted($item->price_total, $item->price_currency); ?></strong>
										</td>

										<td style="text-align: center;"><?php echo $item->price_currency; ?></td>

										<td style="text-align: center;">
											<?php if ($item->status == 1): ?>
												<label class="label label-success"><?php echo trans("completed"); ?></label>
											<?php else: ?>
												<label class="label label-default"><?php echo trans("order_processing"); ?></label>
											<?php endif; ?>
										</td>

										<td style="text-align: center;">
											<?php echo trans($item->payment_status); ?>
										</td>

										<td style="text-align: center;"><?php echo time_ago($item->updated_at); ?></td>

										<td>
											<?php echo form_open_multipart('order_admin_controller/order_options_post'); ?>
											<input type="hidden" name="id" value="<?php echo $item->id; ?>">
											<div class="btn-group">
												<button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown"><?php echo trans('select_option'); ?>
												<i class="bx bx-brightness label-icon"></i>
											</button>
											<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
												<li>
													<a class="dropdown-item" href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>"><?php echo trans('view_details'); ?></a>
												</li>
												<li>
													<?php if ($item->payment_status != 'payment_received'): ?>
														<button class="dropdown-item" type="submit" name="option" value="payment_received">
															<?php echo trans('payment_received'); ?>
														</button>
													<?php endif; ?>
												</li>
												<li>
													<a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_order_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');" ><?php echo trans('delete'); ?></a>
												</li>
											</ul>
										</div>
										<?php echo form_close(); ?><!-- form end -->
									</td>
								</tr>

							<?php endforeach; ?>
						</tbody>
					</table>
					<?php if (empty($orders)): ?>
						<p class="text-center">
							<?php echo trans("no_records_found"); ?>
						</p>
					<?php endif; ?>
					<div class="col-sm-6">
						<div class="float-sm-end">
							<ul class="pagination mb-sm-0">
								<li class="page-item">
									<?php echo $this->pagination->create_links(); ?>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>