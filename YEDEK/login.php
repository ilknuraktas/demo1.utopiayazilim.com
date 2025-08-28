<?php
include('include/all.php');
if (($_SERVER['HTTPS'] == 'off' || !$_SERVER['HTTPS']) && $siteConfig['httpsAktif']) {
  redirect('https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'login.php');
}
SEO::setIndexHeader();
$loginFile = $_SERVER['DOCUMENT_ROOT'] . $siteDizini . 'templates/' . $siteConfig['templateName'] . '/login.php';
if (file_exists($loginFile)) {
  include($loginFile);
  exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayi Girişi</title>
  <?php echo generateTemplateHead(); ?>
  <link href="assets/css/login-style.css" rel="stylesheet" type="text/css" />

  <script src="assets/js/login.js"></script>
</head>

<body>
  <div class="form-body">
    <div class="website-logo">
      <a href="index.php">
        <div class="logo">
          <img class="logo-size" src="<?= slogoSrc('images/logo.png') ?>" alt="">
        </div>
      </a>
    </div>
    <div class="row">
      <div class="img-holder">
        <div class="bg"></div>
        <div class="info-holder">

        </div>
      </div>
      <div class="form-holder">
        <div class="form-content">
          <div class="form-items">
            <h3><?= siteConfig('seo_title') ?></h3>
            <p><?= siteConfig('seo_metaDescription') ?></p>
            <div class="page-links">
              <a href="login.php" class="active">Giriş</a><a href="ac/register">Başvuru Yap</a>
            </div>
            <?
            if (!isset($_GET['p'])) {
            ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?= $login_message ? $login_message : 'Bayi onay e-postasınızı aldıktan sonra, e-posta ve şifrenizi girerek giriş yapabilirsiniz.' ?>
              </div>
              <form method="POST">
                <input class="form-control" type="text" name="username" value="<?php echo $_POST['username'] ?>" placeholder="<?= _lang_epostaAdresiniz ?>" required>
                <input class="form-control" type="password" name="password" placeholder="<?= _lang_sifreniz ?>" required>
                <div class="form-button">
                  <button id="submit" type="submit" class="ibtn"><?= _lang_girisYap ?></button> <a href="login.php?p"><?= _lang_sifremiUnuttum ?></a>
                </div>
              </form>
            <?
            } else {
              if($_POST['username'])
              {
                  $_POST['data_email'] = $_POST['username'];
                  $login_message = 'Talebiniz alındı. Eğer kullanıcı veri tabanımızda ilgili e-posta adresi kayıtlı ise, şifreniz e-posta adresine iletilecek. Gelen şifre ile <a href="login.php">buraya tıklayarak</a> giriş yapabilirsiniz.';
              }
            ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?= $login_message ?$login_message : 'Lütfen kayıt olurken girdiğiniz e-posta adresinizi girin.' ?>
              </div>
              <form method="POST">
                <input class="form-control" type="email" name="username" value="<?php echo $_POST['username'] ?>" placeholder="<?= _lang_epostaAdresiniz ?>" required>
                <div class="form-button">
                  <button id="submit" type="submit" class="ibtn"><?= lc('_lang_sifremiGonder', 'Şifremi Gönder') ?></button>
                </div>
              </form>
            <?
            }
            ?>

            <div class="other-links">
              <span>sosyal medyada biz</span><a target="_blank" href="<?= siteConfig('facebook_URL') ?>"><i class="fa fa-facebook"></i></a><a target="_blank" href="<?= siteConfig('google_URL') ?>"><i class="fa fa-google"></i></a><a target="_blank" href="<?= siteConfig('linkedin_URL') ?>"><i class="fa fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo generateTemplateFinish(); ?>
</body>

</html>