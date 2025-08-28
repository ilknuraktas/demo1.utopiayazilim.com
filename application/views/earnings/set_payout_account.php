<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ödeme Tanımları</h4>
                        <p class="card-title-desc">Hakedişlerinizi alabilmek için lütfen aşağıdaki bilgilerden bir yada birkaçını doldurun.</p>
                    </div>

                    <div class="card-body">
                        <div class="col-sm-12 col-md-12">
                            <?php
                            $active_tab = $this->session->flashdata('msg_payout');
                            if (empty($active_tab)) {
                                $active_tab = "paypal";
                            }
                            $show_all_tabs = false;
                            ?>
                            <!-- Nav pills -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <?php if ($this->payment_settings->payout_paypal_enabled) : $show_all_tabs = true; ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo ($active_tab == 'paypal') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#tab_paypal" role="tab"><?php echo trans("paypal"); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($this->payment_settings->payout_iban_enabled) : $show_all_tabs = true; ?>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-bank <?php echo ($active_tab == 'iban') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#tab_iban" role="tab"><?php echo trans("iban"); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($this->payment_settings->payout_swift_enabled) : $show_all_tabs = true; ?>
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-swift <?php echo ($active_tab == 'swift') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#tab_swift" role="tab"><?php echo trans("swift"); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <?php $active_tab_content = 'paypal'; ?>
                            <!-- Tab panes -->
                            <?php if ($show_all_tabs) : ?>
                                <div class="tab-content mt-2">
                                    <div class="tab-pane <?php echo ($active_tab == 'paypal') ? 'active' : 'fade'; ?>" role="tabpanel" id="tab_paypal">

                                        <?php if ($active_tab == "paypal") :
                                            $this->load->view('partials/_messages');
                                        endif; ?>

                                        <?php echo form_open('set-paypal-payout-account-post', ['id' => 'form_validate_payout_1']); ?>
                                        <div class="form-group">
                                            <label><?php echo trans("paypal_email_address"); ?>*</label>
                                            <input type="email" name="payout_paypal_email" class="form-control form-input" value="<?php echo html_escape($user_payout->payout_paypal_email); ?>" required>
                                        </div>
                                        <div class="form-group d-grid">
                                            <button type="submit" class="btn btn-primary mt-2"><?php echo trans("save_changes"); ?></button>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="tab-pane <?php echo ($active_tab == 'iban') ? 'active' : 'fade'; ?>" role="tabpanel" id="tab_iban">

                                        <?php if ($active_tab == "iban") :
                                            $this->load->view('partials/_messages');
                                        endif; ?>

                                        <?php echo form_open('set-iban-payout-account-post', ['id' => 'form_validate_payout_2']); ?>
                                        <div class="form-group">
                                            <label><?php echo trans("full_name"); ?>*</label>
                                            <input type="text" name="iban_full_name" class="form-control form-input" value="<?php echo html_escape($user_payout->iban_full_name); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label><?php echo trans("country"); ?>*</label>
                                                    <div class="selectdiv">
                                                        <select name="iban_country_id" class="form-control" required>
                                                            <option value="" selected><?php echo trans("select_country"); ?></option>
                                                            <?php foreach ($this->countries as $item) : ?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($user_payout->iban_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label><?php echo trans("bank_name"); ?>*</label>
                                                    <input type="text" name="iban_bank_name" class="form-control form-input" value="<?php echo html_escape($user_payout->iban_bank_name); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo trans("iban_long"); ?>(<?php echo trans("iban"); ?>)*</label>
                                            <input type="text" name="iban_number" class="form-control form-input" value="<?php echo html_escape($user_payout->iban_number); ?>" required>
                                        </div>
                                        <div class="form-group d-grid">
                                            <button type="submit" class="btn btn-primary mt-2"><?php echo trans("save_changes"); ?></button>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="tab-pane <?php echo ($active_tab == 'swift') ? 'active' : 'fade'; ?>" role="tabpanel" id="tab_swift">

                                        <?php if ($active_tab == "swift") :
                                            $this->load->view('partials/_messages');
                                        endif; ?>

                                        <?php echo form_open('set-swift-payout-account-post', ['id' => 'form_validate_payout_3']); ?>
                                        <div class="form-group">
                                            <label><?php echo trans("full_name"); ?>*</label>
                                            <input type="text" name="swift_full_name" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_full_name); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label><?php echo trans("country"); ?>*</label>
                                                    <div class="selectdiv">
                                                        <select name="swift_country_id" class="form-control" required>
                                                            <option value="" selected><?php echo trans("select_country"); ?></option>
                                                            <?php foreach ($this->countries as $item) : ?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($user_payout->swift_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label><?php echo trans("state"); ?>*</label>
                                                    <input type="text" name="swift_state" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_state); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label><?php echo trans("city"); ?>*</label>
                                                    <input type="text" name="swift_city" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_city); ?>" required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label><?php echo trans("postcode"); ?>*</label>
                                                    <input type="text" name="swift_postcode" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_postcode); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo trans("address"); ?>*</label>
                                            <input type="text" name="swift_address" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_address); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label><?php echo trans("bank_account_holder_name"); ?>*</label>
                                                    <input type="text" name="swift_bank_account_holder_name" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_bank_account_holder_name); ?>" required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label><?php echo trans("bank_name"); ?>*</label>
                                                    <input type="text" name="swift_bank_name" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_bank_name); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label><?php echo trans("bank_branch_country"); ?>*</label>
                                                    <div class="selectdiv">
                                                        <select name="swift_bank_branch_country_id" class="form-control" required>
                                                            <option value="" selected><?php echo trans("select_country"); ?></option>
                                                            <?php foreach ($this->countries as $item) : ?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($user_payout->swift_bank_branch_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label><?php echo trans("bank_branch_city"); ?>*</label>
                                                    <input type="text" name="swift_bank_branch_city" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_bank_branch_city); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo trans("swift_iban"); ?>*</label>
                                            <input type="text" name="swift_iban" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_iban); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo trans("swift_code"); ?>*</label>
                                            <input type="text" name="swift_code" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_code); ?>" required>
                                        </div>
                                        <div class="form-group d-grid">
                                            <button type="submit" class="btn btn-primary mt-2"><?php echo trans("save_changes"); ?></button>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->