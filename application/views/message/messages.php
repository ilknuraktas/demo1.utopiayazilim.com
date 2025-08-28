<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="breadcrumbs__section breadcrumbs__section-thin brk-bg-center-cover lazyload" data-bg="<?php echo base_url(); ?>assets/skin/img/1920x258_1.jpg" data-brk-library="component__breadcrumbs_css">
		<span class="brk-abs-bg-overlay brk-bg-grad opacity-80"></span>
		<div class="breadcrumbs__wrapper">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-lg-6">
						<div class="d-flex justify-content-lg-end justify-content-start pr-40 pr-xs-0 breadcrumbs__title">
							<h2 class="brk-white-font-color font__weight-semibold font__size-48 line__height-68 font__family-montserrat pt-xs-40">
								<?php echo trans("messages"); ?>
							</h2>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="pt-50 pb-50 position-static position-lg-relative breadcrumbs__subtitle">
							<h3 class="brk-white-font-color font__family-montserrat font__weight-regular font__size-18 line__height-21 text-uppercase mb-15">
								<?php echo trans("messages"); ?>
							</h3>
							<ol class="breadcrumb font__family-montserrat font__size-15 line__height-16 brk-white-font-color" style="background:transparent;padding-left: 0;">
								<li>
									<a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a>
									<i class="fal fa-chevron-right icon" style="padding-right: 5px;padding-left: 5px;"></i>
								</li>
								<li class="active"><?php echo trans("messages"); ?></li>
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
		<div class="row row-col-messages">
			<?php if (empty($unread_conversations) && empty($read_conversations)): ?>
				<div class="col-12">
					<p class="text-center"><?php echo trans("no_messages_found"); ?></p>
				</div>
			<?php else: ?>

				<div class="col-sm-12 col-md-12 col-lg-3 col-message-sidebar">
					<div class="message-sidebar-custom-scrollbar">
						<div class="row-custom messages-sidebar">
							<?php foreach ($unread_conversations as $item):
								$user_id = 0;
								if ($item->receiver_id != $this->auth_user->id) {
									$user_id = $item->receiver_id;
								} else {
									$user_id = $item->sender_id;
								}
								$user = get_user($user_id);
								if (!empty($user)):?>
									<div class="conversation-item <?php echo ($item->id == $conversation->id) ? 'active-conversation-item' : ''; ?>">
										<a href="<?php echo generate_url("messages", "conversation"); ?>/<?php echo $item->id; ?>" class="conversation-item-link">
											<div class="middle">
												<img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo html_escape($user->username); ?>">
											</div>
											<div class="right">
												<div class="row-custom">
													<strong class="username"><?php echo html_escape($user->username); ?></strong>
													<label class="badge badge-success badge-new"><?php echo trans("new_message"); ?></label>
												</div>
												<div class="row-custom m-b-0">
													<p class="subject"><?php echo html_escape(character_limiter($item->subject, 28, '...')); ?></p>
												</div>
											</div>
										</a>
										<a href="javascript:void(0)" class="delete-conversation-link" onclick='delete_conversation(<?php echo $item->id; ?>,"<?php echo trans("confirm_message"); ?>");'><i class="icon-trash"></i></a>
									</div>
								<?php endif;
							endforeach; ?>
							<?php foreach ($read_conversations as $item):
								$user_id = 0;
								if ($item->receiver_id != $this->auth_user->id) {
									$user_id = $item->receiver_id;
								} else {
									$user_id = $item->sender_id;
								}
								$user = get_user($user_id);
								if (!empty($user)):?>
									<div class="conversation-item <?php echo ($item->id == $conversation->id) ? 'active-conversation-item' : ''; ?>">
										<a href="<?php echo generate_url("messages", "conversation"); ?>/<?php echo $item->id; ?>" class="conversation-item-link">
											<div class="middle">
												<img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo html_escape($user->username); ?>">
											</div>
											<div class="right">
												<div class="row-custom">
													<strong class="username"><?php echo html_escape($user->username); ?></strong>
												</div>
												<div class="row-custom m-b-0">
													<p class="subject"><?php echo html_escape(character_limiter($item->subject, 28, '...')); ?></p>
												</div>
											</div>
										</a>
										<a href="javascript:void(0)" class="delete-conversation-link" onclick='delete_conversation(<?php echo $item->id; ?>,"<?php echo trans("confirm_message"); ?>");'><i class="icon-trash"></i></a>
									</div>
								<?php endif;
							endforeach; ?>
						</div>
					</div>
				</div>

				<div class="col-sm-12 col-md-12 col-lg-9 col-message-content">
					<?php
					$profile_id = $conversation->sender_id;
					if ($this->auth_user->id == $conversation->sender_id) {
						$profile_id = $conversation->receiver_id;
					}

					$profile = get_user($profile_id);
					if (!empty($profile)):?>
						<div class="row-custom messages-head">
							<div class="sender-head">
								<div class="left">
									<img src="<?php echo get_user_avatar($profile); ?>" alt="<?php echo html_escape($profile->username); ?>" class="img-profile">
								</div>
								<div class="right">
									<strong class="username"><?php echo html_escape($profile->username); ?></strong>
									<p class="p-last-seen">
										<span class="last-seen <?php echo (is_user_online($profile->last_seen)) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <?php echo trans("last_seen"); ?>&nbsp;<?php echo time_ago($profile->last_seen); ?></span>
									</p>
									<p class="subject m-0"><?php echo html_escape($conversation->subject); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="row-custom messages-content">
						<div id="message-custom-scrollbar" class="messages-list">
							<?php foreach ($messages as $item):
								if ($item->deleted_user_id != $this->auth_user->id): ?>
									<?php if ($this->auth_user->id == $item->receiver_id): ?>
										<div class="message-list-item">
											<div class="message-list-item-row-received">
												<div class="user-avatar">
													<div class="message-user">
														<img src="<?php echo get_user_avatar_by_id($item->sender_id); ?>" alt="" class="img-profile">
													</div>
												</div>
												<div class="user-message">
													<div class="message-text">
														<?php echo html_escape($item->message); ?>
													</div>
													<span class="time"><?php echo time_ago($item->created_at); ?></span>
												</div>
											</div>
										</div>
									<?php else: ?>
										<div class="message-list-item">
											<div class="message-list-item-row-sent">
												<div class="user-message">
													<div class="message-text">
														<?php echo html_escape($item->message); ?>
													</div>
													<span class="time"><?php echo time_ago($item->created_at); ?></span>
												</div>
												<div class="user-avatar">
													<div class="message-user">
														<img src="<?php echo get_user_avatar_by_id($item->sender_id); ?>" alt="" class="img-profile">
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>

						<div class="message-reply">
							<!-- form start -->
							<?php echo form_open('send-message-post', ['id' => 'form_validate']); ?>
							<input type="hidden" name="conversation_id" value="<?php echo $conversation->id; ?>">
							<?php if ($this->auth_user->id == $conversation->sender_id): ?>
								<input type="hidden" name="receiver_id" value="<?php echo $conversation->receiver_id; ?>">
							<?php else: ?>
								<input type="hidden" name="receiver_id" value="<?php echo $conversation->sender_id; ?>">
							<?php endif; ?>
							<div class="form-group m-b-10">
								<textarea class="form-control form-textarea" name="message" placeholder="<?php echo trans('write_a_message'); ?>" required></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-md btn-custom float-right"><i class="icon-send"></i> <?php echo trans("send"); ?></button>
							</div>
							<?php echo form_close(); ?>
							<!-- form end -->
						</div>
					</div>

				</div>

			<?php endif; ?>
		</div>
	</div>
</div>
<!-- Wrapper End-->
