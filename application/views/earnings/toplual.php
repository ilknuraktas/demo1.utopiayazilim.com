    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?= $page_title ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Ürünler</a></li>
                            <li class="breadcrumb-item active"><?= $page_title ?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table id="table" class="display">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Resim</th>
                                    <th>Ürün Adı</th>
                                    <th>Stok Kodu</th>
                                    <th>Barkod</th>
                                    <th>Marka</th>
                                    <th>Toplu Alınacak Miktar</th>
                                    <th>Odenecek Ürün Miktarı</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($products as $product) {
                                    ?>
                                    <tr style="background-color: <?=  $color = ($product->odenecek_miktar && $product->alinacak_miktar)? '#0080001c' : '#ff00001c';   ?>">
                                        <td style="background-color: <?=  $color = ($product->odenecek_miktar && $product->alinacak_miktar)? '#0080001c' : '#ff00001c';   ?>"><?= $product->id ?></td>
                                        <td>
                                            <a href="<?= base_url() . "uploads/images" ?>/<?= $product->image_default ?>" target="_blank">
                                                <img src="<?= base_url() . "uploads/images" ?>/<?= $product->image_small ?>" width="30" height="30" style="border-radius: 5px;" alt="">
                                            </a>
                                        </td>
                                        <td><?= $product->title ?></td>
                                        <td class="text-center"><?= $product->sku ?></td>
                                        <td class="text-center"><?= $product->barcode ?></td>
                                        <td class="text-center"><?= $product->brand ?></td>
                                        <td class="text-center"><?= $product->alinacak_miktar ?></td>
                                        <td class="text-center"><?= $product->odenecek_miktar ?></td>
                                        <td>
                                            <a target="_blank" href="/satis-yap/toplu-al-duzenle/<?= $product->id ?>" class="btn btn-warning waves-effect btn-label waves-light">
                                                <i class="bx bx-error label-icon"></i> Düzenle
                                            </a>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>