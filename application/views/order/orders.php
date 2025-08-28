<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="breadcrumbs__section breadcrumbs__section-thin brk-bg-center-cover lazyload" data-bg="<?php echo base_url(); ?>assets/skin/img/1920x258_1.jpg" data-brk-library="component__breadcrumbs_css">
		<span class="brk-abs-bg-overlay brk-bg-grad opacity-80"></span>
		<div class="breadcrumbs__wrapper">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-lg-6">
						<div class="d-flex justify-content-lg-end justify-content-start pr-40 pr-xs-0 breadcrumbs__title">
							<h2 class="brk-white-font-color font__weight-semibold font__size-48 line__height-68 font__family-montserrat pt-xs-40">
								<?php echo $title; ?>
							</h2>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="pt-50 pb-50 position-static position-lg-relative breadcrumbs__subtitle">
							<h3 class="brk-white-font-color font__family-montserrat font__weight-regular font__size-18 line__height-21 text-uppercase mb-15">
								<?php echo $title; ?>
							</h3>
							<ol class="breadcrumb font__family-montserrat font__size-15 line__height-16 brk-white-font-color" style="background:transparent;padding-left: 0;">
								<li>
									<a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a>
									<i class="fal fa-chevron-right icon" style="padding-right: 5px;padding-left: 5px;"></i>
								</li>
								<li class="active"><?php echo $title; ?></li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-3">
				<div class="row-custom">
					<!-- load profile nav -->
					<?php $this->load->view("order/_order_tabs"); ?>
				</div>
			</div>

			<div class="col-sm-12 col-md-9">
				<div class="row-custom">
					<div class="profile-tab-content">
						<!-- include message block -->
						<?php $this->load->view('partials/_messages'); ?>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
								<tr>
									<th scope="col"><?php echo trans("order"); ?></th>
									<th scope="col"><?php echo trans("total"); ?></th>
									<th scope="col"><?php echo trans("payment"); ?></th>
									<th scope="col"><?php echo trans("status"); ?></th>
									<th scope="col"><?php echo trans("date"); ?></th>
									<th scope="col"><?php echo trans("options"); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php if (!empty($orders)): ?>
									<?php foreach ($orders as $order): ?>
										<tr>
											<td>#<?php echo $order->order_number; ?></td>
											<td><?php echo price_formatted($order->price_total, $order->price_currency); ?></td>
											<td>
												<?php if ($order->payment_status == 'payment_received'):
													echo trans("payment_received");
												else:
													echo trans("awaiting_payment");
												endif; ?>
											</td>
											<td>
												<strong class="font-600">
													<?php if ($order->payment_status == 'awaiting_payment'):
														if ($order->payment_method == 'Cash On Delivery') {
															echo trans("order_processing");
														} else {
															echo trans("awaiting_payment");
														}
													else:
														if ($order->status == 1):
															echo trans("completed");
														else:
															echo trans("order_processing");
														endif;
													endif; ?>
												</strong>
											</td>
											<td><?php echo formatted_date($order->created_at); ?></td>
											<td>
												<a href="<?php echo generate_url("order_details") . "/" . $order->order_number; ?>" class="btn btn-sm btn-table-info"><?php echo trans("details"); ?></a>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>


						<?php if (empty($orders)): ?>
							<p class="text-center">
								<?php echo trans("no_records_found"); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
				<div class="row-custom m-t-15">
					<div class="float-right">
						<?php echo $this->pagination->create_links(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Wrapper End-->

