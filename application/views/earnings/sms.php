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
                        <a class="nav-link " href="/entegrasyon" role="tab">Kargo Ayarları</a>
                    </li>
                       <li class="nav-item">
                        <a class="nav-link active" href="/sms-ayarlari">SMS Ayarları </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" role="tab" disabled>Pazaryeri Ayarları <small>(YAKINDA)</small> </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" role="tab" disabled>Muhasebe Ayarları <small>(YAKINDA)</small> </a>
                    </li>
                </ul>
                <?php $active_tab_content = 'paypal'; ?>
                <!-- Tab panes -->
                <?php if ($show_all_tabs) : ?>
                    <div class="tab-content card mt-5">

                        <div class="tab-pane <?php echo ($active_tab == 'kargo') ? 'active' : 'fade'; ?>" id="tab_kargo">

                            <div >

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