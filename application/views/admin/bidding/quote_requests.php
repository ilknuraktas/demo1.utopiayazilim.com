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
							<?php $this->load->view('admin/bidding/_filter_quote_requests'); ?>
							<thead>
								<tr role="row">
									<th><?php echo trans('quote'); ?></th>
									<th><?php echo trans('product'); ?></th>
									<th><?php echo trans('seller'); ?></th>
									<th><?php echo trans('buyer'); ?></th>
									<th><?php echo trans('status'); ?></th>
									<th><?php echo trans('sellers_bid'); ?></th>
									<th><?php echo trans('updated'); ?></th>
									<th><?php echo trans('date'); ?></th>
									<th><?php echo trans('options'); ?></th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($quote_requests as $item): ?>
									<tr>
										<td>#<?php echo $item->id; ?></td>
										<td>
											<?php $product = get_product($item->product_id);
											if (!empty($product)):?>
												<div class="img-table" style="height: 100px;">
													<a href="<?php echo generate_product_url($product); ?>" target="_blank">
														<img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="rounded-circle avatar-lg"/>
													</a>
												</div>
												<a href="<?php echo generate_product_url($product); ?>" target="_blank" class="table-product-title">
													<?php echo html_escape($item->product_title); ?>
												</a>
												<?php echo trans("quantity") . ": " . $item->product_quantity; ?>
											<?php endif; ?>
										</td>
										<td>
											<?php $user = get_user($item->seller_id);
											if (!empty($user)):?>
												<div class="table-orders-user">
													<a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
														<img src="<?php echo get_user_avatar($user); ?>" alt="buyer" class="rounded-circle avatar-sm">
														<?php echo html_escape($user->username); ?>
													</a>
												</div>
											<?php endif; ?>
										</td>
										<td>
											<?php $user = get_user($item->buyer_id);
											if (!empty($user)):?>
												<div class="table-orders-user">
													<a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
														<img src="<?php echo get_user_avatar($user); ?>" alt="buyer" class="rounded-circle avatar-sm">
														<?php echo html_escape($user->username); ?>
													</a>
												</div>
											<?php endif; ?>
										</td>
										<td><?php echo trans($item->status); ?></td>
										<td>
											<?php if ($item->status != 'new_quote_request' && $item->price_offered != 0): ?>
												<div class="table-seller-bid">
													<p><b><?php echo trans("price"); ?>:&nbsp;</b><strong><?php echo price_formatted($item->price_offered, $item->price_currency); ?></strong></p>
													<?php if (!empty($product) && $product->product_type == 'digital'): ?>
														<p><b><?php echo trans("shipping"); ?>:&nbsp;</b><strong><?php echo trans("no_shipping"); ?></strong></p>
													<?php else: ?>
														<p><b><?php echo trans("shipping"); ?>:&nbsp;</b><strong><?php echo price_formatted($item->shipping_cost, $item->price_currency); ?></strong></p>
													<?php endif; ?>
													<p><b><?php echo trans("total"); ?>:&nbsp;</b><strong><?php echo price_formatted($item->price_offered + $item->shipping_cost, $item->price_currency); ?></strong></p>
												</div>
											<?php endif; ?>
										</td>
										<td><?php echo time_ago($item->updated_at); ?></td>
										<td><?php echo formatted_date($item->created_at); ?></td>
										<td>
											<div class="btn-group">
												<button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown"><?php echo trans('select_option'); ?>
												<i class="bx bx-brightness label-icon"></i>
											</button>
											<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
												<li>
													<a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('admin_controller/delete_quote_request_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><?php echo trans('delete'); ?></a>
												</li>
											</ul>
										</div>
									</td>
								</tr>

							<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($quote_requests)): ?>
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
</div>
</div>