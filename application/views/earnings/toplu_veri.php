<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">


            <div class="col-sm-12 col-md-12">
                <?php
                $category = $this->db->query("SELECT * FROM categories where parent_id!=0 ");
                $currency = $this->db->query("SELECT * FROM currencies  ");
                $transfer = $this->db->query("SELECT * FROM `language_translations` WHERE id in(1624,1625,1626,1627)");
                $cargo = $this->db->query("SELECT * FROM `product_options` where lang_id=1 ");


                $active_tab = $this->session->flashdata('msg_payout');
                if (empty($active_tab)) {
                    $active_tab = "category";
                }
                $show_all_tabs = true;

                ?>
                <!-- Nav pills -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link nav-link-category <?php echo ($active_tab == 'category') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#tab_category" role="tab">Kategoriler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-bank <?php echo ($active_tab == 'para_birimi') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#tab_para_birimi" role="tab">Para Birimleri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-swift <?php echo ($active_tab == 'teslimat_suresi') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#tab_teslimat_suresi" role="tab">Teslimat Süreleri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-kargo <?php echo ($active_tab == 'kargo') ? 'active' : ''; ?>" data-bs-toggle="tab" href="#tab_kargo" role="tab">Kargo</a>
                    </li>
                </ul>
                <?php $active_tab_content = 'paypal'; ?>
                <!-- Tab panes -->
                <?php if ($show_all_tabs) : ?>
                    <div class="tab-content">
                        <div class="tab-pane <?php echo ($active_tab == 'category') ? 'active' : 'fade'; ?>" role="tabpanel" id="tab_category">
                            <div class="table-responsive">
                                <table role="grid" class="gridjs-table" style="height: auto;" id="myTable">
                                    <thead class="gridjs-thead">
                                        <tr class="gridjs-tr">
                                            <th class="gridjs-th gridjs-th-sort" tabindex="0" width="20%">ID</th>
                                            <th class="gridjs-th gridjs-th-sort" tabindex="0" >Kategori Adı</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($category->result() as $c) :

                                            $category_suc = $this->db->query("SELECT * FROM categories parent WHERE parent_id=" . $c->id);
                                            $row = $category_suc->row();
                                            if ($category_suc->num_rows() == 0) {


                                                $query = $this->db->query("SELECT * FROM categories_lang WHERE category_id=" . $c->id);
                                                $row = $query->row();
                                        ?>
                                                <tr class="gridjs-tr">
                                                    <td class="gridjs-td"><?= $c->id ?></td>
                                                    <td class="gridjs-td"><?= $row->name ?></td>
                                                </tr>
                                        <?php  }
                                        endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane <?php echo ($active_tab == 'para_birimi') ? 'active' : 'fade'; ?>" role="tabpanel" id="tab_para_birimi">

                            <div class="table-responsive">
                                <table role="grid" class="gridjs-table" style="height: auto;" id="para-birimleri">
                                    <thead class="gridjs-thead">
                                        <tr class="gridjs-tr">
                                            <th class="gridjs-th gridjs-th-sort" tabindex="0" width="20%">ID</th>
                                            <th class="gridjs-th gridjs-th-sort" tabindex="0">Para Birimi Adı</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($currency->result() as $c) :
                                        ?>
                                            <tr class="gridjs-tr">
                                                <td  class="gridjs-td"><?= $c->code ?></td>
                                                <td  class="gridjs-td"><?= $c->name ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane <?php echo ($active_tab == 'teslimat_suresi') ? 'active' : 'fade'; ?>" role="tabpanel" id="tab_teslimat_suresi">


                            <div class="table-responsive">
                                <table role="grid" class="gridjs-table" style="height: auto;" id="teslimat-suresi">
                                    <thead class="gridjs-thead">
                                        <tr class="gridjs-tr">
                                            <th class="gridjs-th gridjs-th-sort" tabindex="0" width="20%">ID</th>
                                            <th class="gridjs-th gridjs-th-sort" tabindex="0">Teslimat Süreleri</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($transfer->result() as $c) :
                                        ?>
                                            <tr class="gridjs-tr">
                                                <td class="gridjs-td"><?= $c->label ?></td>
                                                <td class="gridjs-td"><?= $c->translation ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane <?php echo ($active_tab == 'kargo') ? 'active' : 'fade'; ?>" role="tabpanel" id="tab_kargo">


                            <div class="table-responsive">
                                <table role="grid" class="gridjs-table" style="height: auto;" id="kargo">
                                    <thead class="gridjs-thead">
                                        <tr class="gridjs-tr">
                                            <th class="gridjs-th gridjs-th-sort" tabindex="0" width="20%">ID</th>
                                            <th class="gridjs-th gridjs-th-sort" tabindex="0">Kargo Firmaları</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cargo->result() as $c) :
                                        ?>
                                            <tr class="gridjs-tr">
                                                <td class="gridjs-td"><?= $c->id ?></td>
                                                <td class="gridjs-td"><?= $c->option_label ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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