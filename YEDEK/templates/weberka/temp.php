<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <?php echo generateTemplateHead(); ?>
    <link rel="stylesheet" type="text/css" href="templates/weberka/css/style.css" />
    <link rel="stylesheet" type="text/css" href="templates/weberka/css/fontawesome.css" />
    <link rel="stylesheet" type="text/css" href="templates/weberka/css/swiper.min.css" />
    <link rel="stylesheet" type="text/css" href="templates/weberka/css/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="templates/weberka/css/mobileMenu.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&amp;subset=latin-ext" rel="stylesheet">

    <script src="templates/weberka/js/swiper.min.js"></script>
    <script src="templates/weberka/js/mobileMenu.min.js"></script>
    <script src="templates/weberka/js/wow.min.js"></script>

</head>

<body>

    <div class="siteyiOrtala">
        <div class="ustMenu">
            <ul>
                <?= simplePageList(2) ?>
            </ul>
        </div>
    </div>

    <div class="logoAlani">
        <div class="siteyiOrtala2">

            <div class="siteLogo">
                <div class="logoSolu">
                    <a class="toggle"><i class="fas fa-bars"></i></a>
                </div>

                <a href="./index.php" title="<?= siteConfig('seo_title') ?>">
                    <img src="<?= slogoSrc('templates/weberka/img/logo.png') ?>" alt="<?= siteConfig('seo_title') ?>" width="" height="" />
                </a>

                <div class="logoSagi">
                    <a class="muyelik" href="./ac/login" title="üye paneli"><i class="fas fa-user"></i></a>
                    <a class="mspt" href="./ac/sepet" title="alışveriş sepeti"><i class="fas fa-shopping-cart"></i><span id="toplamUrun"><?php echo basketInfo('toplamUrun', ''); ?></span></a>
                </div>
            </div>

            <div class="siteArama">
                <form action="page.php" method="get">
                    <input type="hidden" name="act" value="arama" />
                    <input type="text" placeholder="Ürün, kategori veya marka ara..." name="str" class="ara" id="detailSearchKey" />
                    <button type="submit" class="arabtn"></button>
                </form>
            </div>

            <div class="siteGirisSepet">

                <div class="ustUyelik">
                    <i class="fas fa-user"></i>
                    <?
                    if (!$_SESSION['userID']) {
                    ?>
                        <a href="<?= slink('login') ?>" title="Giriş Yap">Giriş Yap</a>
                        <a href="<?= slink('register') ?>" title="Üye Ol">veya Üye Ol</a>
                    <?
                    } else {
                    ?>
                        <div class="dropdown">
                            <button onclick="myFunction()" class="upGoster">Hesabım</button>
                            <div id="myDropdown" class="dropdown-content">
                                <ul>
                                    <li><a title="Hesabım" class="menuItem" href="ac/login"><b>Hesabım</b></a></li>
                                    <li><a title="Üye Bilgilerim" class="menuItem" href="profile_sp.html">Üye Bilgilerim</a></li>
                                    <li><a title="Adreslerim" class="menuItem" href="adres_sp.html">Adreslerim</a></li>
                                    <li><a title="Kredi Yükle" class="menuItem" href="bakiye_sp.html">Kredi Yükle</a></li>
                                    <li><a title="Alışveriş Sepetim" class="menuItem" href="./ac/sepet">Alışveriş Sepetim</a></li>
                                    <li><a title="Önceki Siparişlerim" class="menuItem" href="./ac/showOrders">Önceki Siparişlerim</a></li>
                                    <li><a title="Sipariş Sorun Bildirim / Takip" class="menuItem" href="./ac/hataBildirim">Bildirim Taleplerim</a></li>
                                    <li><a title="Havale Bildirim Formu" class="menuItem" href="./ac/havaleBildirim">Ödeme Bildirimi</a></li>
                                    <li><a title="Alarm Listem" class="menuItem" href="./ac/alarmList">Alarm Listem</a></li>
                                    <li><a title="Çıkış" class="menuItem" href="./ac/logout">Çıkış</a></li>
                                </ul>
                            </div>
                        </div>
                    <?
                    }
                    ?>
                </div>

                <div class="headerSepet imgSepetGoster">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="toplamUrun"><?php echo basketInfo('toplamUrun', ''); ?></span>
                    <strong>Sepetim</strong>
                </div>
                <div class="dropdown2">
                    <button id="imgSepetGoster" onclick="" class="dropbtn2"></button>
                </div>

            </div>


        </div>
        <div class="temizle"></div>
    </div>

    <div class="temizle"></div>

    <header>
        <nav class="headerMenu">
            <ul>
                <?= simpleCatList2() ?>
            </ul>
        </nav>
    </header>
    <nav id="main-nav">
        <ul class="second-nav">
            <?= simpleCatList2() ?>
        </ul>
    </nav>

    <div class="temizle"></div>

    <div class="siteyiOrtala">

        <? if (!$_GET['act'] || $_GET['act'] == 'urunDetay' || $_GET["act"] == "sepet" || $_GET["act"] == "satinal")
            echo "<style>
.siteSag{width: 100%}
</style>"

                . $PAGE_OUT;
        else {
        ?>

            <? {
                echo '<div class="siteSol">';
                echo '<div class="ac-container">
<div>
<input id="ac-1" name="accordion-1" type="radio" checked>
<label for="ac-1">Alt Kategoriler</label>
<article><div class="altKategoriler"><strong>Alt Kategoriler</strong><ul>';
                echo simpleCatList(hq('select ID from kategori where parentID=\'' . currentCat() . '\'') ? currentCat() : currentParentCatID());
                echo '</ul></div></article></div>';
            ?>
                <? if ($_GET['act'] == 'kategoriGoster') {
                    echo '<div>
<input id="ac-2" name="accordion-1" type="radio">
<label for="ac-2">Detaylı Filtrele</label>
<article>';
                    echo $_GET['catID'] ? generateTableBox('Seçiminizi Daraltın', generateFilter('FilterLists'), 'filtre') : '';
                    echo '</article>
</div>';
                }
                ?>
            <?
                echo '</div>';
                echo '<div class="solUrunler"><h3>Popüler Ürünler</h3><div class="swiper-wrapper">';
                echo urunBlockList('select * from urun where active=1 order by sold desc limit 0,5');
                echo '</div><div class="swiper-pagination"></div><div class="solNext"><i class="fas fa-chevron-right"></i></div><div class="solPrev"><i class="fas fa-chevron-left"></i></div></div>';
                echo '</div>';
            }
            echo '<div class="siteSag">';
            ?>

            <?= $PAGE_OUT ?>

        <?
            echo '</div>';
        }
        ?>

    </div>

    <div class="temizle"></div>
    <footer>
        <div class="siteyiOrtala">

            <div style="display: block;">
                <div class="footerBol">
                    <h4>KURUMSAL</h4>
                    <ul>
                        <?= simplePageList(1) ?>
                    </ul>
                </div>
                <div class="footerBol">
                    <h4>ALIŞVERİŞ</h4>
                    <ul>
                        <?= simplePageList(2) ?>
                    </ul>
                </div>
                <div class="footerBol">
                    <h4>POPÜLER KATEGORİLER</h4>
                    <ul>
                        <?= simpleCatList(0) ?>
                    </ul>
                </div>
                <div class="footerBol">
                    <h4>E-BÜLTEN ABONELİĞİ</h4>
                    <div class="eBultenAbone">
                        <form role="form" onSubmit="ebultenSubmit('ebulten'); return false;">
                            <input placeholder="E-Bülten Listemize Katılın" id="ebulten" class="eBultenin">
                            <button type="submit"><i class="fas fa-angle-right"></i></button>
                        </form>
                        <p>E-Bülten aboneliği ile fırsatları kaçırma...</p>
                    </div>
                    <div class="fSosyal">
                        <?= modSocial() ?>
                    </div>
                </div>
            </div>

            <div class="temizle"></div>


            <div class="footerYazi">
                <p><strong>© Tüm hakları saklıdır. Kredi kartı bilgileriniz 256bit SSL sertifikası ile korunmaktadır.</strong></p>
                <p><?=tempData('footerSEO')?>
                </p>
            </div>
        </div>
    </footer>
    <?php echo generateTemplateFinish()?>
    <script src="templates/weberka/js/tema.js"></script>
</body>

</html>