<?php defined('BASEPATH') or exit('No direct script access allowed');

?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Gerekli Evraklar</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open_multipart('admin_controller/evrak_post'); ?>

                    <div class="card-body">
                        <!-- include message block -->
                        <?php
                        $magaza1 = $this->db->query("SELECT * FROM evrak WHERE id=4");
                        $magaza = $magaza1->row();
                        $satici1 = $this->db->query("SELECT * FROM evrak WHERE id=5");
                        $satici = $satici1->row();
                        $gizlilik1 = $this->db->query("SELECT * FROM evrak WHERE id=6");
                        $gizlilik = $gizlilik1->row();
                        $excell = $this->db->query("SELECT * FROM evrak WHERE id=7");
                        $excel = $excell->row();
                        ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <label class="label-sitemap">Mağaza Sözleşmesi  </label>
                                    <br>
                                    <label style="color: red" class="label-sitemap"> <a href="/evrak/<?=  $magaza->file   ?>" download> Yüklü Dosyayı İndir </a></label>
                                    <input type="file" class="form-control" name="magaza_sozlesmesi" >
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label class="label-sitemap">Satıcı Sözleşmesi  </label>
                                    <br>
                                    <label style="color: red" class="label-sitemap"> <a href="/evrak/<?=  $satici->file   ?>" download> Yüklü Dosyayı İndir </a></label>
                                    <input type="file" class="form-control" name="satici_sozlesmesi" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <label class="label-sitemap">Gizlilik Sözleşmesi    </label>
                                    <br>
                                    <label style="color: red" class="label-sitemap"> <a href="/evrak/<?=  $gizlilik->file   ?>" download> Yüklü Dosyayı İndir   </a></label>
                                    <input type="file" class="form-control" name="gizlilik_sozlesmesi" >
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label class="label-sitemap">Excel</label>
                                    <br>
                                    <label style="color: red" class="label-sitemap"> <a href="/evrak/<?=  $excel->file   ?>" download> Yüklü Dosyayı İndir  </a></label>
                                    <input type="file" class="form-control" name="excel" >
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