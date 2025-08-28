<div class="row table-filter-container">
	<div class="col-sm-12">
		<?php echo form_open($form_action, ['method' => 'GET']); ?>

		<div class="mb-3">
			<div class="row">
				<div class="col-md-1">
					<label><?php echo trans("show"); ?></label>
					<select name="show" class="form-control">
						<option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
						<option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
						<option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
						<option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
					</select>
				</div>
				<div class="col-md-3">
					<label><?php echo trans('category'); ?></label>
					<select id="categories" name="category" class="form-control" onchange="get_filter_subcategories(this.value);">
						<option value=""><?php echo trans("all"); ?></option>
						<?php
						$categories = $this->category_model->get_all_parent_categories();
						foreach ($categories as $item): ?>
							<option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('category', true) == $item->id) ? 'selected' : ''; ?>>
								<?php echo category_name($item); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3">
					<label class="control-label"><?php echo trans('subcategory'); ?></label>
					<select id="subcategories" name="subcategory" class="form-control" onchange="get_third_categories(this.value);">
						<option value=""><?php echo trans("all"); ?></option>
						<?php
						if (!empty($this->input->get('category', true))):
							$subcategories = $this->category_model->get_subcategories_by_parent_id($this->input->get('category', true));
							if (!empty($subcategories)) {
								foreach ($subcategories as $item):?>
									<option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('subcategory', true) == $item->id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
								<?php endforeach;
							}
						endif;
						?>
					</select>
				</div>
				<div class="col-md-3">
					<label><?php echo trans("search"); ?></label>
					<input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
				</div>
				<div class="col-md-2">
					<label style="display: block">&nbsp;</label>
					<button type="submit" class="btn btn-warning waves-effect btn-label waves-light"><i class="bx bx-filter-alt label-icon"></i> <?php echo trans("filter"); ?></button>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
