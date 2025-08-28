<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header with-border">
						<h3 class="card-title"><?php echo trans('blog_comments'); ?></h3>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header with-border">
				<div class="d-flex flex-wrap align-items-center mb-3">
					<div class="left">
						<h3 class="card-title"><?php echo $title; ?></h3>
					</div>
					<div class="ms-auto">
						<a href="<?php echo $top_button_url; ?>" class="btn btn-warning waves-effect btn-label waves-light btn-add-new">
							<i class="bx bx-comment-dots label-icon"></i>
							<?php echo $top_button_text; ?>
						</a>
					</div>
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
							<table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
								<thead>
									<tr role="row">
										<th width="20" class="table-no-sort" style="text-align: center !important;"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
										<th width="20"><?php echo trans('id'); ?></th>
										<th><?php echo trans('name'); ?></th>
										<th><?php echo trans('email'); ?></th>
										<th><?php echo trans('comment'); ?></th>
										<th style="min-width: 20%"><?php echo trans('url'); ?></th>
										<th><?php echo trans('ip_address'); ?></th>
										<th style="min-width: 10%"><?php echo trans('date'); ?></th>
										<th class="max-width-120"><?php echo trans('options'); ?></th>
									</tr>
								</thead>
								<tbody>

									<?php foreach ($comments as $item): ?>
										<tr>
											<td style="text-align: center !important;"><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
											<td><?php echo html_escape($item->id); ?></td>
											<td><?php echo html_escape($item->name); ?></td>
											<td><?php echo html_escape($item->email); ?></td>
											<td class="break-word"><?php echo html_escape($item->comment); ?></td>
											<td>
												<?php $post = get_post($item->post_id);
												if (!empty($post)): ?>
													<a href="<?php echo generate_post_url($post); ?>" target="_blank">
														<?php echo html_escape($post->title); ?>
													</a>
												<?php endif; ?>
											</td>
											<td><?php echo html_escape($item->ip_address); ?></td>
											<td><?php echo formatted_date($item->created_at); ?></td>

											<td>
												<?php echo form_open('blog_controller/approve_comment_post'); ?>
												<input type="hidden" name="id" value="<?php echo $item->id; ?>">
												<div class="btn-group">
													<button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light" type="button" data-bs-toggle="dropdown">
														<?php echo trans('select_option'); ?>
														<i class="bx bx-brightness label-icon"></i>
													</button>
													<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
														<?php if ($item->status != 1): ?>
															<li>
																<button class="dropdown-item" type="submit">
																	<?php echo trans("approve"); ?>
																</button>
															</li>
														<?php endif; ?>
														<li>
															<a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('blog_controller/delete_comment','<?php echo $item->id; ?>','<?php echo trans("confirm_comment"); ?>');">
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
						</div>

						<div class="col-sm-12">
							<div class="row">
								<div class="pull-left">
									<button class="btn btn-danger waves-effect btn-label waves-light btn-table-delete" onclick="delete_selected_blog_comments('<?php echo trans("confirm_comments"); ?>');">
										<i class="bx bx-trash label-icon"></i>
										<?php echo trans('delete'); ?>
									</button>
									<?php if ($show_approve_button == true): ?>
										<button class="btn btn-primary waves-effect btn-label waves-light btn-table-delete" onclick="approve_selected_blog_comments();">
											<i class="bx bx-check label-icon"></i>
											<?php echo trans('approve'); ?>
										</button>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>