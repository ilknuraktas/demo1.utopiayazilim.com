<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="container-fluid">

    <!-- Sayfa Başlığı -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Mağaza Paneli</h4>
				
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Mowww The Online Store Maker</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Alan 1 -->
    <div class="row hstack">
        <!--div class="col-md-12">
            <div class="card bg-danger">
                <div class="card-body">
                    <div>
                        <ul class="bg-bubbles ps-0">
                            <li><i class="bx bx-grid-alt font-size-24"></i></li>
                            <li><i class="bx bx-tachometer font-size-24"></i></li>
                            <li><i class="bx bx-store font-size-24"></i></li>
                            <li><i class="bx bx-cube font-size-24"></i></li>
                            <li><i class="bx bx-cylinder font-size-24"></i></li>
                            <li><i class="bx bx-command font-size-24"></i></li>
                            <li><i class="bx bx-hourglass font-size-24"></i></li>
                            <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                            <li><i class="bx bx-coffee font-size-24"></i></li>
                            <li><i class="bx bx-polygon font-size-24"></i></li>
                        </ul>
                        <div class="d-flex align-items-center">
                            <div>
                                <i class="bx bx-swim" style="font-size:50px;color: #fff;"></i>
                            </div>
                            <div style="margin-left: 25px;">
                                <h3 class="text-white mb-0">Mağazanızın tatil modunda olması sebebiyle ürünleriniz satışa açık değildir!</h3>
                                <p class="text-white-50 mb-0">Ürünlerinizi satışa açmak için mağazanızı tatil modundan çıkarabilirsiniz.</p>
                            </div>
                            <div class="ms-auto">
                                <a href="#">
                                    <button href="#" type="button" class="btn btn-dark waves-effect btn-label waves-light">
                                        <i class="bx bxs-zap label-icon"></i>
                                        Tatil Modunu Kaldır
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card bg-success">
                <div class="card-body">
                    <div>
                        <ul class="bg-bubbles ps-0">
                            <li><i class="bx bx-grid-alt font-size-24"></i></li>
                            <li><i class="bx bx-tachometer font-size-24"></i></li>
                            <li><i class="bx bx-store font-size-24"></i></li>
                            <li><i class="bx bx-cube font-size-24"></i></li>
                            <li><i class="bx bx-cylinder font-size-24"></i></li>
                            <li><i class="bx bx-command font-size-24"></i></li>
                            <li><i class="bx bx-hourglass font-size-24"></i></li>
                            <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                            <li><i class="bx bx-coffee font-size-24"></i></li>
                            <li><i class="bx bx-polygon font-size-24"></i></li>
                        </ul>
                        <div class="d-flex align-items-center">
                            <div>
                                <i class="bx bx-swim" style="font-size:50px;color: #fff;"></i>
                            </div>
                            <div style="margin-left: 25px;">
                                <h3 class="text-white mb-0">Mağazanızı tatil moduna alın!</h3>
                                <p class="text-white-50 mb-0">Ürünlerinizi satışa kapatmak için mağazanızı tatil moduna alabilirsiniz.</p>
                            </div>
                            <div class="ms-auto">
                                <a href="#">
                                    <button type="button" class="btn btn-dark waves-effect btn-label waves-light">
                                        <i class="bx bxs-zap label-icon"></i>
                                        Tatil Moduna Al
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div-->
        <div class="col-md-4">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="text-center py-3">
                        <ul class="bg-bubbles ps-0">
                            <li><i class="bx bx-grid-alt font-size-24"></i></li>
                            <li><i class="bx bx-tachometer font-size-24"></i></li>
                            <li><i class="bx bx-store font-size-24"></i></li>
                            <li><i class="bx bx-cube font-size-24"></i></li>
                            <li><i class="bx bx-cylinder font-size-24"></i></li>
                            <li><i class="bx bx-command font-size-24"></i></li>
                            <li><i class="bx bx-hourglass font-size-24"></i></li>
                            <li><i class="bx bx-pie-chart-alt font-size-24"></i></li>
                            <li><i class="bx bx-coffee font-size-24"></i></li>
                            <li><i class="bx bx-polygon font-size-24"></i></li>
                        </ul>
                        <div class="main-wid position-relative">
                            <h3 class="text-white mb-0"> Hoşgeldin, <?php echo get_shop_name($user); ?></h3>
                            <p class="text-white-50">Detaylandırılmış mağaza paneli ile, mağazan ile ilgili herşeyi kolayca yönetebilirsin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <center>
                        <div class="avatar">
                            <span class="avatar-title bg-soft-primary rounded">
                                <i class="fal fa-planet-moon text-primary font-size-24"></i>
                            </span>
                        </div>
                    </center>
                    <p class="text-muted mt-4 mb-0">
                        Toplam Satış Sayısı
                    </p>
                    <h4 class="mt-1 mb-0"><?php echo $user->number_of_sales; ?> </h4>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <center>
                        <div class="avatar">
                            <span class="avatar-title bg-soft-primary rounded">
                                <i class="fal fa-credit-card-front text-primary font-size-24"></i>
                            </span>
                        </div>
                    </center>
                    <p class="text-muted mt-4 mb-0">
                        Onaylanmış Kazançlar


                    </p>
                    <h4 class="mt-1 mb-0"><?php echo price_formatted($user->balance, $this->payment_settings->default_product_currency); ?> TL</h4>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <center>
                        <div class="avatar">
                            <span class="avatar-title bg-soft-primary rounded">
                                <i class="fal fa-boxes-alt   text-primary font-size-24"></i>
                            </span>
                        </div>
                    </center>
                    <p class="text-muted mt-4 mb-0">
                        Ürün Sayısı
                    </p>
                    <h4 class="mt-1 mb-0"><?php echo get_user_products_count($user->id); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <center>
                        <div class="avatar">
                            <span class="avatar-title bg-soft-primary rounded">
                                <i class="fal fa-users text-primary font-size-24"></i>
                            </span>
                        </div>
                    </center>
                    <p class="text-muted mt-4 mb-0">
                        Takipçiler


                    </p>
                    <h4 class="mt-1 mb-0"><?php echo get_following_users_count($user->id); ?></h4>
                </div>
            </div>
        </div>
        <!--div class="col-md-2 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <center>
                        <div class="avatar">
                            <span class="avatar-title bg-soft-primary rounded">
                                <i class="fal fa-users text-primary font-size-24"></i>
                            </span>
                        </div>
                    </center>
                    <?=get_store_rank_store($user->id)[0]?>
                    <?=get_store_rank_store($user->id)[1]?>
                </div>
            </div>
        </div-->
    </div>

    <!-- Rank -->
    <style>
        .rank img {
            width:70px!important;
        }
    </style>
    <div class="row hstack">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rank">
                            <?=get_store_rank_store($user->id)[0]?>
                        </div>
                        <div class="flex-1 ms-3">
                            <h4 class="font-size-22 mb-1 text-dark"><?=get_store_rank_store($user->id)[1]?></h4>
                            <p class="text-muted mb-0">Ürünün açıklamadaki gibi olması, alıcıyla olan iletişiminiz, ürünün paketleme kalitesi, hızlı kargo hizmeti gibi unsurlar satışlarınızın artmasında önemli bir faktördür.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Erken Ödeme Alanı -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card bg-success border-success text-light">
                <div class="card-body">
                    <h5 class="mb-4 text-light">
                        <i class="mdi mdi-alert-circle-outline me-3"></i>
                        <?php echo price_formatted($user->balance, $this->payment_settings->default_product_currency); ?> TL 'niz Erken Ödeme İle Hazır! 
                    </h5>
                    <p class="card-text">Onaylanan ödemelerinizi uzun süre beklemeden Paypal/IBAN/SWIFT hesaplarınıza hemen talep edebilirsiniz!</p>
                    <a href="/odemeler">
                        <button type="button" class="btn btn-dark waves-effect btn-label waves-light">
                            <i class="bx bx-smile label-icon"></i> Hemen Ödeme Talep Et
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card bg-warning border-warning text-white-50 pb-2">
                <div class="card-body">
                    <h5 class="mb-4 text-white">
                        <i class="mdi mdi-alert-outline me-3"></i>
                        Müşteri Memnuniyeti İçin Kargo Sürecinizi Hızlandırın!
                    </h5>
                    <p class="card-text">Hızlı kargo, internet üzerinden alışverişin son derece büyük bir şekilde artış gösterdiği bu dönemlerde oldukça önem arz etmektedir. Hızlı kargo ile müşteriler sipariş ettikleri ürünü diğer kargo alternatiflerine göre çok daha hızlı bir şekilde temin etmiş olurlar.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksiyonlar -->
    <div class="row hstack">
        <div class="col-6 col-md-2">
            <div class="card bg-dark border-dark">
                <div class="card-body">
                    <p class="text-white" style="display: flex; justify-content: space-between;">
                        <?php echo trans("products"); ?>
                        <i class="mdi mdi-star"></i>
                    </p>
                    <h4 class="text-white"><?php echo get_user_products_count($user->id); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-dark border-dark">
                <div class="card-body">
                    <p class="text-white" style="display: flex; justify-content: space-between;">
                        <?php echo trans("pending_products"); ?>
                        <i class="mdi mdi-alert-circle-outline"></i>
                    </p>
                    <h4 class="text-white"><?php echo get_user_pending_products_count($user->id); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-dark border-dark">
                <div class="card-body">
                    <p class="text-white" style="display: flex; justify-content: space-between;">
                        <?php echo trans("hidden_products"); ?>
                        <i class="mdi mdi-alert-circle-outline"></i>
                    </p>
                    <h4 class="text-white"><?php echo get_user_hidden_products_count($user->id); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-dark border-dark">
                <div class="card-body">
                    <p class="text-white" style="display: flex; justify-content: space-between;">
                        <?php echo trans("drafts"); ?>
                        <i class="mdi mdi-alert-circle-outline"></i>
                    </p>
                    <h4 class="text-white"><?php echo get_user_drafts_count($user->id); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-dark border-dark">
                <div class="card-body">
                    <p class="text-white" style="display: flex; justify-content: space-between;">
                        <?php echo trans("wishlist"); ?>
                        <i class="mdi mdi-alert-circle-outline"></i>
                    </p>
                    <h4 class="text-white"><?php echo get_user_wishlist_products_count($user->id); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="card bg-dark border-dark">
                <div class="card-body">
                    <p class="text-white" style="display: flex; justify-content: space-between;">
                        <?php echo trans("downloads"); ?>
                        <i class="mdi mdi-alert-circle-outline"></i>
                    </p>
                    <h4 class="text-white"><?php echo get_user_downloads_count($user->id); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap align-items-center">
                                <h5 class="card-title mb-0">Güncelleme Geçmişi</h5>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <ol class="activity-feed mb-0 px-4">
                                <li class="feed-item">
                                    <div class="d-flex justify-content-between feed-item-list">
                                        <div>
                                            <h5 class="font-size-15 mb-1">v1.4;</h5>
                                            <p class="text-muted mt-0 mb-0">MNG Kargo Entegrasyonu</p>
                                            <p class="text-muted mt-0 mb-0">Hemen Al Modülü</p>
                                            <p class="text-muted mt-0 mb-0">2. Tema Desteği</p>
                                            <p class="text-muted mt-0 mb-0">X Al Y Öde</p>
                                            <p class="text-muted mt-0 mb-0">X Tutar Üzeri Ücretsiz Kargo</p>
                                            <p class="text-muted mt-0 mb-0">Mağaza Rank Sistemi (5 Farklı Mağaza Seviyesi)</p>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0">01/12/2022</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="feed-item">
                                    <div class="d-flex justify-content-between feed-item-list">
                                       <div>
                                        <h5 class="font-size-15 mb-1">v1.3;</h5>
                                        <p class="text-muted mt-0 mb-0">Yurtiçi Kargo Entegrasyonu</p>
                                        <p class="text-muted mt-0 mb-0">PTT Kargo Entegrasyonları</p>
                                        <p class="text-muted mt-0 mb-0">Hikaye Modülü (Hikaye İle İstediğiniz Linke Yönlendirme Örn. Kategori, Marka, Mağaza vb.)  </p>
                                        <p class="text-muted mt-0 mb-0">Stripe Ödeme Yöntemi Entegrasyonu</p>
                                        <p class="text-muted mt-0 mb-0">PayPal Ödeme Yöntemi Entegrasyonu</p>
                                        <p class="text-muted mt-0 mb-0">PayStack Ödeme Yöntemi Entegrasyonu</p>
                                        <p class="text-muted mt-0 mb-0">Pagseguro Ödeme Yöntemi Entegrasyonu</p>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">17/11/2022</p>
                                    </div>
                                </div>
                            </li>
                            <li class="feed-item">
                                <div class="d-flex justify-content-between feed-item-list">
                                    <div>
                                        <h5 class="font-size-15 mb-1">v1.2;</h5>
                                        <p class="text-muted mt-0 mb-0">Mağaza Başvurusunda Sözleşme İndirip, Geri Yükleme ve Zorunlu Şirket Evrakları Yükleme</p>
                                        <p class="text-muted mt-0 mb-0">Yüklenen Sözleşme ve Şirket Evraklarını Onaylama/Reddetme ve Evrak Durumunu SMS ve Mail İle Otomatik Bilgilendirme</p>
                                        <p class="text-muted mt-0 mb-0">NetGSM Entegrasyonu</p>
                                        <p class="text-muted mt-0 mb-0">İleti Merkezi Entegrasyonu</p>
                                        <p class="text-muted mt-0 mb-0">Ürün Barkod/GTIN Kodu Bilgileri Eklendi</p>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">13/10/2022</p>
                                    </div>
                                </div>
                            </li>
                            <li class="feed-item">
                                <div class="d-flex justify-content-between feed-item-list">
                                    <div>
                                        <h5 class="font-size-15 mb-1"> v1.1;</h5>
                                        <p class="text-muted mt-0 mb-0">Excel'den Toplu Ürün Yükleme</p>
                                        <p class="text-muted mt-0 mb-0">Bayilik Sistemi (Bayiye Özel İndirim Tanımlayabilme)</p>
                                        <p class="text-muted mt-0 mb-0">Özel Mağaza Paneli</p>
                                        <p class="text-muted mt-0 mb-0">Vatan SMS Entegrasyonu</p>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">05/10/2022</p>
                                    </div>
                                </div>
                            </li>

                        </ol>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Takipçiler -->
    <!--div class="row hstack">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Takipçileriniz</h4>
                    <p class="card-title-desc">Mağazanızı takip eden kişileri aşağıda görebilirsiniz.</p>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-2 col-2 text-center">
                                    <div>
                                        <img src="/uploads/profile/avatar_6249e60f78cae1-19297503-28208940.jpg" alt="" class="rounded-circle avatar-lg">
                                        <p class="mt-2 mb-lg-0">Utopia</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div-->

    <!-- Son Eklenen Ürünler -->
    <!--div class="row hstack">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Son Eklediğiniz ürünler</h5>
                    <p class="card-title-desc">Son eklediğiniz ürünleri buradan görebilirsiniz.</p>
                </div>
                <div class="card-body pt-xl-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-centered align-middle table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ürün Adı</th>
                                    <th>Stok Kodu</th>
                                    <th>Barkod</th>
                                    <th>GTIN</th>
                                    <th>Marka</th>
                                    <th>Fiyat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td><a href="javascript: void(0);" class="text-body">Iphone 12 Max Pro</a> </td>
                                    <td>TCR-1001</td>
                                    <td>445554887965</td>
                                    <td>98723454</td>
                                    <td>Adidas</td>
                                    <td>900,00TL</td>
                                </tr>

                                <tr>
                                    <td>2.</td>
                                    <td><a href="javascript: void(0);" class="text-body">Kırmızı ve Beyaz Ceket </a> </td>
                                    <td>TCR-1002</td>
                                    <td>438786564231</td>
                                    <td>82344231</td>
                                    <td>Adidas</td>
                                    <td>650,00TL</td>
                                </tr>

                                <tr>
                                    <td>3.</td>
                                    <td><a href="javascript: void(0);" class="text-body">LG G4 Telefon</a> </td>
                                    <td>TCR-1003</td>
                                    <td>235398723454</td>
                                    <td>76564231</td>
                                    <td>NIKE</td>
                                    <td>350,00TL</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td><a href="javascript: void(0);" class="text-body">Mahşerin 5 Atlısı Kitap</a> </td>
                                    <td>TCR-1004</td>
                                    <td>762616234548</td>
                                    <td>54887965</td>
                                    <td>PUMA</td>
                                    <td>900,00TL</td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td><a href="javascript: void(0);" class="text-body">Smart 4k Android TV</a> </td>
                                    <td>TCR-1005</td>
                                    <td>847836564231</td>
                                    <td>16234548</td>
                                    <td>LCW</td>
                                    <td>600,00TL</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div-->
    
</div>