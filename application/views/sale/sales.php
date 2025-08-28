<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="wrapper">
	<div class="container-fluid">

		<div class="row">
			<!--div class="col-sm-12 col-md-3">
				<div class="row-custom">
					<?php $this->load->view("sale/_sale_tabs"); ?>
				</div>
			</div-->

			<div class="card">
				<div id="table-gridjs">
					<div class="card-header">
						<h4 class="card-title mb-0">Satışlar</h4>
					</div>
					<div role="complementary" class="gridjs gridjs-container" style="width: 100%;">
						<div class="gridjs-head"><div class="gridjs-search">
							<input type="search" placeholder="Satışlarda arayın" aria-label="Type a keyword..." class="gridjs-input gridjs-search-input"></div>
						</div>
						<div class="gridjs-wrapper" style="height: auto;">
							<table role="grid" class="gridjs-table" style="height: auto;">
								<thead class="gridjs-thead">
									<tr class="gridjs-tr">
										<th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("sale"); ?></th>
										<th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("date"); ?></th>
										<th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("total"); ?></th>
										<th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("payment"); ?></th>
										<th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("status"); ?></th>
										<th class="gridjs-th gridjs-th-sort" tabindex="0" ><?php echo trans("options"); ?></th>
									</tr>
								</thead>
								<tbody class="gridjs-tbody">

									<?php if (!empty($orders)) : ?>
										<?php foreach ($orders as $order) :
											$sale = get_order($order->id);
											$total = $this->order_model->get_seller_total_price($order->id);
											if (!empty($sale)) : ?>
												<tr class="gridjs-tr">
													<td class="gridjs-td">#<?php echo $sale->order_number; ?></td>
													<td class="gridjs-td"><?php echo date("d/m/Y / h:i", strtotime($sale->created_at)); ?></td>
													<td class="gridjs-td"><?php echo price_formatted($total, $sale->price_currency); ?> TL</td>
													<td class="gridjs-td">
														<?php if ($sale->payment_status == 'payment_received') :
															echo trans("payment_received");
														else :
															echo trans("awaiting_payment");
														endif; ?>
													</td>
													<td class="gridjs-td">
														<strong class="font-600">
															<?php if ($sale->payment_status == 'awaiting_payment') :
																if ($sale->payment_method == 'Cash On Delivery') {
																	echo trans("order_processing");
																} else {
																	echo trans("awaiting_payment");
																}
															else :
																if ($active_tab == "active_sales") :
																	echo trans("order_processing");
																else :
																	echo trans("completed");
																endif;
															endif; ?>
														</strong>
													</td>
													<td class="gridjs-td">
														<a href="<?php echo generate_url("sale"); ?>/<?php echo $sale->order_number; ?>">
															<button class="btn btn-warning waves-effect btn-label waves-light"><i class="bx bx-error label-icon"></i> <?php echo trans("details"); ?></button>
														</a>

													</td>
												</tr>
											<?php endif;
										endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
						</div>


						<?php if (empty($orders)) : ?>
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