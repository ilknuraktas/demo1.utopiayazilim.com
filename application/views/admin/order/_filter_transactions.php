<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php echo form_open($form_action, ['method' => 'GET']); ?>

        <div class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label><?php echo trans("show"); ?></label>
                    <select name="show" class="form-control">
                        <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                        <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                        <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                        <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label><?php echo trans("search"); ?></label>
                    <input name="q" class="form-control" placeholder="<?php echo trans("order_number"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="col-md-3">
                    <label style="display: block">&nbsp;</label>
                    <button type="submit" class="btn btn-warning waves-effect btn-label waves-light"><i class="bx bx-filter-alt label-icon"></i> <?php echo trans("filter"); ?></button>
                </div>

            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>