<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Giriş Yap - Mowww Yönetim Paneli</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="shortcut icon" type="image/png" href="https://mowww.utopiayazilim.com/uploads/logo/logo_6393f81fb2f352.png">
<link rel="stylesheet" href="https://mowww.utopiayazilim.com/assets/admin/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://mowww.utopiayazilim.com/assets/admin/css/AdminLTE.min.css">
<link rel="stylesheet" href="https://mowww.utopiayazilim.com/assets/admin/css/_all-skins.min.css">
<link rel="stylesheet" href="https://mowww.utopiayazilim.com/assets/admin/css/custom.css">
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="hold-transition login-page" style="/*! background-color: #15202b; */">
<div class="container">
<div class="row">
<div class="align-self-center" style="top: 40px; padding:30px 20px;margin-top: 50px;margin-left: auto;margin-right: auto;max-width: 600px;">
<div class="login-logo">
<a href="https://www.utopiayazilim.com" target="_blank" class="text-reset"> <img src="https://www.utopiayazilim.com/assets/media/utopia-logo.png" style="/*! filter: brightness(0) invert(1); */" alt="" padding="10px" height="60px"></a>
<h3 style="color:#ba85a6">
<b>Yönetim Paneli</b>
</h3>
<h4 style="color:#42424A;font-weight:400;">Mowww The Online Online Store Maker</h4></div>
<div class="login-box-body">
                    <!--h4 class="login-box-msg"><?php echo trans("login"); ?></h4-->
                    <?php $this->load->view('partials/_messages'); ?>
                    <?php echo form_open('common_controller/admin_login_post'); ?>
<div class="form-group has-feedback">
<input type="email" name="email" class="form-control form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo old('email'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required style="/*! height: 48px; */ /*! border: none; */ /*! border-radius: 0px; */ /*! background: #253341; */ /*! border-bottom: 2px solid #586d7b; */ box-shadow: none; outline: 0!important; font-size: 13px; color:#353535;background-color: var(--color-white);border-radius: 20px;height: 50px;padding: 10px 10px 10px 55px;box-shadow: 0 24px 48px -15px rgba(153,161,170,.25);margin-bottom: 20px;"><input type="password" name="password" class="form-control form-input" placeholder="<?php echo trans("password"); ?>" value="<?php echo old('password'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required style="/*! height: 48px; */ /*! border: none; */ /*! border-radius: 0px; */ /*! background: #253341; */ /*! border-bottom: 2px solid #586d7b; */ box-shadow: none; outline: 0!important; font-size: 13px; color:#353535;background-color: #fff;border-radius: 20px;height: 50px;padding: 10px 10px 10px 55px;box-shadow: 0 24px 48px -15px rgba(153,161,170,.25);margin-bottom: 20px;">
</div>
<div class="row">
<div class="col-md-12">
<button type="submit" class="btn btn-primary btn-block btn-flat btn-lg">
<?php echo trans("login"); ?> </button>
</div>
</div>
	
	<?php echo form_close(); ?>
	</div>
<div style="/*! top: 40px; */padding: 0 20px;/*! margin-top: 50px; */">

<div class="login-logo">

<h5 style="color:#42424A;text-align: left;font-weight: 300;">Mowww The Online Store Maker ile oluşturulmuştur.</h5>
<h5 style="color:#353535;text-align: left;font-weight: 300;"><span class="copyright-text"> Made with ❤️ by <a href="https://utopiayazilim.com/" style="color: #ba85a6;">Utopia</a>. All rights reserved.</span></h5></div></div>
	</div>
	</div>
</div>
</body></html>