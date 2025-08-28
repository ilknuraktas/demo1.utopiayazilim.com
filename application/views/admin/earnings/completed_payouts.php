<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header with-border">
				<div class="d-flex flex-wrap align-items-center mb-3">
					<div class="left">
						<h3 class="card-title"><?php echo trans('completed_payouts'); ?></h3>
					</div>
					<div class="ms-auto">
						<a href="<?php echo admin_url(); ?>add-payout" class="btn btn-success waves-effect btn-label waves-light">
							<i class="bx bx-plus label-icon"></i><?php echo trans('add_payout'); ?>
						</a>
					</div>
				</div><!-- /.box-header -->
			</div>

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
							<?php $this->load->view('admin/earnings/_filter_payouts'); ?>
							<thead>
								<tr role="row">
									<th><?php echo trans('id'); ?></th>
									<th><?php echo trans('user_id'); ?></th>
									<th><?php echo trans('user'); ?></th>
									<th><?php echo trans('withdraw_method'); ?></th>
									<th><?php echo trans('withdraw_amount'); ?></th>
									<th><?php echo trans('status'); ?></th>
									<th><?php echo trans('date'); ?></th>
									<th><?php echo trans('options'); ?></th>
								</tr>
							</thead>
							<tbody>

								<?php foreach ($payouts as $item): ?>
									<tr>
										<td><?php echo $item->id; ?></td>
										<td><?php echo $item->user_id; ?></td>
										<td>
											<?php $user = get_user($item->user_id);
											if (!empty($user)):?>
												<div class="table-orders-user">
													<a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
														<img src="<?php echo get_user_avatar($user); ?>" alt="buyer" class="rounded-circle avatar-sm">
														<?php echo html_escape($user->username); ?>
													</a>
												</div>
											<?php endif; ?>
										</td>
										<td><?php echo trans($item->payout_method); ?></td>
										<td><?php echo price_formatted($item->amount, $item->currency); ?></td>
										<td>
											<?php if ($item->status == 1) {
												echo trans("completed");
											} else {
												echo trans("pending");
											} ?>
										</td>
										<td><?php echo formatted_date($item->created_at); ?></td>
										<td>
											<div class="btn-group">
												<button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown"><?php echo trans('select_option'); ?>
												<i class="bx bx-brightness label-icon"></i>
											</button>
											<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
												<li>
													<a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('earnings_admin_controller/delete_payout_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><?php echo trans('delete'); ?></a>
												</li>
											</ul>
										</div>
									</td>
								</tr>

							<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($payouts)): ?>
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