<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">


            <div class="col-sm-12 col-md-12">
                <?php
                $cargo = $this->db->query("SELECT * FROM `product_options` where lang_id=1 ");

                $active_tab = $this->session->flashdata('msg_payout');
                if (empty($active_tab)) {
                    $active_tab = "kargo";
                }
                $show_all_tabs = true;

                ?>
                <!-- Nav pills -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_tab == 'kargo') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#tab_kargo" role="tab">Kargo Ayarları</a>
                    </li>
                       <!--li class="nav-item">
                        <a class="nav-link" href="sms-ayarlari">SMS Ayarları </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" role="tab" disabled>Pazaryeri Ayarları <small>(YAKINDA)</small> </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" role="tab" disabled>Muhasebe Ayarları <small>(YAKINDA)</small> </a>
                    </li-->
                </ul>
                <?php $active_tab_content = 'paypal'; ?>
                <!-- Tab panes -->
                <?php if ($show_all_tabs) : ?>
                    <div class="tab-content card mt-5">

                        <div class="tab-pane <?php echo ($active_tab == 'kargo') ? 'active' : 'fade'; ?>" id="tab_kargo">

                            <div >
                                <div style="height: auto;" class="table table-responsive">
                                    <table style="    width: 100%;">
                                        <thead class="gridjs-thead">
                                            <tr class="gridjs-tr">
                                                <th class="gridjs-th gridjs-th-sort" tabindex="0" >ID</th>
                                                <th class="gridjs-th gridjs-th-sort" tabindex="0" >Kargo Firmaları</th>
                                                <th class="gridjs-th gridjs-th-sort" tabindex="0" >Durum</th>
                                                <th class="gridjs-th gridjs-th-sort" tabindex="0" >İşlem</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cargo->result() as $c) :
                                                ?>
                                                <tr class="gridjs-tr">
                                                    <td class="gridjs-td"><?= $c->id ?></td>
                                                    <td class="gridjs-td"><?= $c->option_label ?></td>
                                                    <td class="gridjs-td text-left">
                                                        <?php if ($c->status == 1) { ?>
                                                            <span class="alert alert-success w-100"><strong>Aktif</strong></span>
                                                        <?php } else { ?>
                                                            <span class="alert alert-danger w-100"><strong>Devredışı</strong></span>
                                                        <?php } ?>
                                                    </td class="gridjs-td">
                                                    <td class="gridjs-td">
                                                        <a href="entegrasyon/<?php echo $c->common_id; ?>"><button class="btn btn-warning waves-effect btn-label waves-light"><i class="bx bx-error label-icon"></i> Düzenle</button></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<!-- Wrapper End-->

<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    $(document).ready(function() {
        $('#para-birimleri').DataTable();
    });
    $(document).ready(function() {
        $('#teslimat-suresi').DataTable();
    });
    $(document).ready(function() {
        $('#kargo').DataTable();
    });
</script>