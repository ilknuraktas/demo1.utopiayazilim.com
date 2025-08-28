    <div class="container-fluid">



        <!-- start page title -->

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

        <!-- end page title -->



        <div class="row">

            <div class="col-lg-12">

                <div class="card">



                    <div class="card-body">

                        <table id="table" class="display" style="width:100%">

                            <thead>

                                <tr>

                                    <th width="2">ID</th>

                                    <th width="4">Resim</th>

                                    <th width="10">Ürün Adı</th>

                                    <th width="5">Stok Kodu</th>

                                    <th width="5">Barkod</th>

                                    <th width="5">GTİN Kodu</th>

                                    <th width="5">Marka</th>

                                    <th width="5">Stok Sayısı</th>

                                    <th width="5">Fiyat</th>

                                    <th width="20">İşlemler</th>

                                </tr>

                            </thead>

                            <tbody>



                                <?php

                                foreach ($products as $product) {

                                ?>

                                    <tr>

                                        <td><?= $product->id ?></td>

                                        <td>

                                            <a href="<?= base_url() . "uploads/images" ?>/<?= $product->image_default ?>" target="_blank"> <img src="<?= base_url() . "uploads/images" ?>/<?= $product->image_small ?>" width="100" height="100" alt=""></a>

                                        </td>

                                        <td><?= $product->title ?></td>



                                        <td><?= $product->sku ?></td>



                                        <td><?= $product->barcode ?></td>

                                        <td><?= $product->GTIN_code ?></td>

                                        <td><?= $product->brand ?></td>

                                        <td><?= $product->stock ?></td>



                                        <td><?= $product->price ?> <?= $product->currency ?></td>

                                        <td>

                                            <a target="_blank" href="/satis-yap/urunu-duzenle/<?= $product->id ?>" class="btn btn-warning waves-effect waves-light">

                                                <i class="bx bx-error font-size-16 align-middle me-2"></i> Düzenle
                                            </a>

			<div class="row-custom" style="margin-top:10px !important;">
				<?php if (!$product->is_promoted && $this->general_settings->promoted_products == 1): ?>
					<a href="<?php echo generate_url("promote_product", "pricing") . "/" . $product->id; ?>?type=exist" class="btn btn-sm btn-info"><i class="icon-plus"></i>&nbsp;<?php echo trans("promote"); ?></a>
				<?php endif; ?>
				<a href="javascript:void(0)" class="btn btn-sm btn-outline-danger" onclick="delete_product(<?php echo $product->id; ?>,'<?php echo trans("confirm_product"); ?>');"><i class="icon-trash"></i>&nbsp;<?php echo trans("delete"); ?></a>
			</div>

                                        </td>
										

                                    </tr>

                                <?php } ?>





                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- end card -->

            </div>

            <!-- end col -->

        </div>

        <!-- end row -->



    </div> <!-- container-fluid -->