<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ücretsiz Kargo Ayarları</h4>
                        <p class="card-title-desc">Belirli Tutar Üzerindeki Ücretsiz Kargo Ayarları</p>
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




                                        <?php if ($active_tab == "paypal") :
                                            $this->load->view('partials/_messages');
                                        endif; ?>

                                        <?php echo form_open('ucretsiz-kargo-post');

                                        ?>


                                    </div>
                        <div class="form-group">
                            <label>Ücretsiz Kargo İçin Alt Limit</label>
                            <input type="text" name="ucretsiz_kargo" class="form-control form-input" value="<?= $user->ucretsiz_kargo_siniri ?>" required>
                        </div>
                        <div class="form-group d-grid">
                            <button type="submit" class="btn btn-primary mt-2"><?php echo trans("save_changes"); ?></button>
                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->