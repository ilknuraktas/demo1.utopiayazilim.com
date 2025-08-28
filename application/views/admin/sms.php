<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Servis Ayarları</h3>
                    </div>


                    <!-- form start -->



                    <?php echo form_open('admin_controller/gsm_tercih'); ?>

                    <div class="card-body">
                        <?php if (!empty($this->session->flashdata("msg_settings"))) :
                            $this->load->view('admin/includes/_messages_form');
                        endif; ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label>Tercih Edilen Sms Firması</label>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-option">
                                    <select class="form-select" name="status" id="">
                                        <?php
                                        $sec = $this->db->query("SELECT * FROM `gsm_api_users`");
                                        $s = $sec->result();
                                        foreach ($s as $ss):
                                        ?>
                                        <option <?php echo $degisken=($ss->status==1)? 'selected' : ''; ?> value="<?= $ss->id   ?>"><?= $ss->api_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
                            <i class="bx bx-check label-icon"></i>
                            <?php echo trans('save_changes'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">SMS Ayarları</h3>
                    </div>
                    <?php echo form_open_multipart('admin_controller/gsm_update'); ?>
                    <div class="card-body">
                        <?php if (empty($this->session->flashdata("msg_settings"))) :
                            $this->load->view('admin/includes/_messages_form');
                        endif; ?>

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified">
                               <?php

                               $cargo = $this->db->query("SELECT * FROM `gsm_api_users`");
                               $vay = $cargo->result();

                               foreach($vay as $len){
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link <?=  $active =($len->status)? 'active': '';  ?>" href="#tab_<?=$len->api_id?>" data-bs-toggle="tab" aria-expanded="true"><?=$len->api_name?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content p-3 text-muted">
                            <?php
                            foreach($vay as $len){ ?>
                                <div class="tab-pane <?=  $active =($len->status)? 'active': '';  ?>" id="tab_<?=$len->api_id?>" role="tabpanel">
                                    <form>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="control-label">Müşteri ID</label>
                                                    <input type="text" class="form-control" name="customer_id<?=$len->id?>" value="<?=$len->customer_id?>">
                                                </div>
                                                <div class="col-md-6">
                                                  <label class="control-label">Kullanıcı Adı</label>
                                                  <input type="text" class="form-control" name="username<?=$len->id?>" value="<?=$len->username?>">
                                              </div>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                              <label class="control-label">Kullanıcı Şifre</label>
                                              <input type="text" class="form-control" name="password<?=$len->id?>" value="<?=$len->password?>">
                                          </div>
                                          <div class="col-md-6">
                                              <label class="control-label">SMS Numarası veya SMS Başlık</label>
                                              <input type="text" class="form-control" name="phone<?=$len->id?>" value="<?=$len->phone?>">
                                              <input type="hidden" class="form-control" name="id<?=$len->id?>" value="<?=$len->id?>">
                                          </div>
                                      </div>
                                  </div>


                              <button type="submit" name="button<?=$len->id?>" value="<?=$len->id?>" class="btn btn-primary waves-effect btn-label waves-light mt-3">
                                <i class="bx bx-check label-icon"></i>
                                Değişiklikleri Kaydet
                            </button>
                        </div><!-- /.tab-pane -->
                    <?php } ?>
                            </form>
                </div><!-- /.tab-content -->

            </div><!-- nav-tabs-custom -->

        </form>
    </div><!-- /.col -->
</div>
</div>
</div>

</div>
</div>