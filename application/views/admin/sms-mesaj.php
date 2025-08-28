<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Sms Şablon Ayarları</h3>
                    </div>


                    <!-- form start -->



                    <?php echo form_open('admin_controller/sms_sablon');
                    $sms_ayar = $this->db->query("SELECT * FROM `sms_sablon`");
                    $sms = $sms_ayar->row();
                    ?>

                    <div class="card-body">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Yeni Mesaj Satıcı</label>
                                    <input type="text" class="form-control" name="mesaj_satici" value="<?=$sms->mesaj_satici?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Yeni Mesaj Müşteri</label>
                                    <input type="text" class="form-control" name="mesaj_musteri" value="<?=$sms->mesaj_musteri?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Yeni Sipariş Satıcı</label>
                                    <input type="text" class="form-control" name="siparis_satici" value="<?=$sms->siparis_satici?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Yeni Sipariş Müşteri</label>
                                    <input type="text" class="form-control" name="siparis_musteri" value="<?=$sms->siparis_musteri?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Yeni Mağaza Sistem</label>
                                    <input type="text" class="form-control" name="magaza_sistem" value="<?=$sms->magaza_sistem?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Yeni Mağaza Kullanıcı</label>
                                    <input type="text" class="form-control" name="magaza_musteri" value="<?=$sms->magaza_musteri?>">
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

</div>
</div>