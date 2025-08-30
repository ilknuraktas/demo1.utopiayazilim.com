<link href="https://pro.fontawesome.com/releases/v5.15.0/css/all.css" rel="stylesheet">
<link href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/shop.css" />

<!--Mağaza Header-->
<nav class="navbar navbar-expand-lg tk-dash-nav">
    <a href="/magazam">
        <img src="uploads/logo/logo-white.png" height="20" class="logo" alt="logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDash" aria-controls="navbarDash" aria-expanded="false" aria-label="Toggle navigation">
        <i class="far fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarDash">
        <ul class="navbar-nav mr-auto">

            <!--li class="nav-item"><a href="#" class="nav-link">Ürünler</a></li-->
            <!--li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    Ürün
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Ürün Listesi</a>
                    <a class="dropdown-item" href="/satis-yap">Tekil Ürün Ekle</a>
                    <a class="dropdown-item" href="/bekleyen-urunler">Bekleyen Ürünler</a>
                    <a class="dropdown-item" href="/gizli-urunnler">Pasif Ürünler</a>
                    <a class="dropdown-item" href="#">Taslaklar</a>
                </div>
            </li-->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    Satışlar
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/satislar">Aktif Satışlar</a>
                    <a class="dropdown-item" href="/satislar/tamamlanan-satislar">Tamamlanan Satışlar</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    Kazançlar
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/satis_kazanclari">Kazançlar</a>
                    <a class="dropdown-item" href="/odemeler">Ödemeler</a>
                    <a class="dropdown-item" href="/odeme-tanimlari">Ödeme Tanımları</a>
                </div>
            </li>
            <li class="nav-item"><a href="/satis-yap" target="_blank" class="nav-link">Tekil Ürün Ekle</a></li>
            <li class="nav-item"><a href="/excel_aktar" class="nav-link">Toplu Ürün İşlemleri</a></li>
            <li class="nav-item"><a href="/toplu_veri" class="nav-link">Toplu Ürün Verileri</a></li>
            <li class="nav-item"><a href="/entegrasyon" class="nav-link">Entegrasyon Ayarları</a></li>
            <!--li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    İşlemler
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">İndirilenler</a>
                    <a class="dropdown-item" href="#">Favoriler</a>
                    <a class="dropdown-item" href="#">Takipçileri</a>
                    <a class="dropdown-item" href="#">Takip Ettikleri</a>
                    <a class="dropdown-item" href="#">Değerlendirmeler</a>
                </div>
            </li>
            <li class="nav-item"><a href="#" class="nav-link">Teklif İstekleri</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Mesajlar</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    Ayarlar
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Profili GÜncelle</a>
                    <a class="dropdown-item" href="#">Hesap Bilgileri</a>
                    <a class="dropdown-item" href="#">Mağaza Ayarları</a>
                    <a class="dropdown-item" href="#">Kargo Adresi</a>
                    <a class="dropdown-item" href="#">Sosyal Medya</a>
                    <a class="dropdown-item" href="#">Şifre Değiştir</a>
                </div>
            </li-->
        </ul>
    </div>
    <div class="collapse navbar-collapse justify-content-end" id="navbarDash">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link profile" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>" style="height: 25px;width: 25px;">
                    <?php if ($unread_message_count > 0) : ?>
                        <span class="notification"><?php echo $unread_message_count; ?></span>
                    <?php endif; ?>
                    <?php echo character_limiter(get_shop_name($this->auth_user), 15, '..'); ?>
                    <i class="icon-arrow-down"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-danger" href="logout">Çıkış Yap</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!--Mağaza Header Alt-->
<div class="container-fluid">
    <div class="row" style="margin-top:15px">
        <div class="col-sm-12 col-md-12">
            <div class="tk-dash-card">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="tk-dash-stat">
                            <div class="left">
                                <p class="price">Mağaza Başvuru Süreci</p>
                                <p class="title">Mağazanız Onaylanmıştır! Mağaza bilgilerinizi düzenledikten sonra ürün eklemeye başlayabilir.</p>
                            </div>
                            <div class="icon">
                                <img src="<?php echo base_url("<?php echo base_url(); ?>assets/img/d-tex.png") ?>" height="100px" alt="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="tk-dash-stat">
                            <div class="left">
                                <p class="price">Çözüm Ortağım</p>
                                <p class="title">Sizin için bir çok firma ile birlikte çalışıyoruz. İşletmeniz için ihtiyacınız olan hizmete hızlıca ulaşın!</p>
                            </div>
                            <div class="icon">
                                <img src="<?php echo base_url("<?php echo base_url(); ?>assets/img/cozum-ortaklari.png") ?>" height="100px" alt="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="tk-dash-stat">
                            <div class="left">
                                <p class="price">Excel ile Toplu Ürün Yükleme</p>
                                <p class="title">Excel üzerinden ürün bilgilerinizi girerek toplu bir şekilde ürün eklemesi yapabilirsiniz.</p>
                            </div>
                            <div class="icon">
                                <img src="<?php echo base_url("<?php echo base_url(); ?>assets/img/toplu-urun.png") ?>" height="100px" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>