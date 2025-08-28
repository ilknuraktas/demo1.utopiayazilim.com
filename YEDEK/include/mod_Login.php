<?
if (file_exists('include/mod_FacebookConnect.php')) require_once('include/mod_FacebookConnect.php');
if (file_exists('mod_FacebookConnect.php')) require_once('mod_FacebookConnect.php');
if (file_exists('include/mod_GoogleConnect.php')) require_once('include/mod_GoogleConnect.php');
if (file_exists('mod_GoogleConnect.php')) require_once('mod_GoogleConnect.php');
if (file_exists('include/mod_AppleConnect.php')) require_once('include/mod_AppleConnect.php');
if (file_exists('mod_AppleConnect.php')) require_once('mod_AppleConnect.php');
//exit(debugArray($_POST));


$loginOut = '<link href="assets/css/login.css" rel="stylesheet" type="text/css" />
<div class="col-sm-12 pt-20">
<nav class="col-sm-nav" id="hizli-uye-menu">
    <a data-type="#divUyeGirisForm" class="active">'._lang_titleLogin.'</a>
    <a data-type="#divUyeRegisterForm">'.lc('_lang_hizliUyelik','Hızlı Üyelik').'</a>
</nav>
</div>
<div class="row" id="main-login-form">
    <div class="col-sm-6" id="divUyeGirisForm">
        <form id="form1" name="form1" method="post" action="" class="col-sm-left-login">
            <div>
                <span class="spanTittle">'._lang_titleLogin.'</span>
                <div class="userWrapper emailDiv">
                    <input class="textbox txtUyeGirisEmail" id="txtUyeGirisEmail" name="username"
                        placeholder="'._lang_kullaniciAdi.'" type="text" />
                </div>
                <div class="userWrapper passDiv" style="position:relative;">
                    <input class="textbox txtUyeGirisPassword" id="txtUyeGirisPassword" name="password"
                        placeholder="'._lang_sifre.'" type="password" />
                    <span class="TcxPassEye">
                        <a id="eyeTrue">
                            <svg aria-hidden="true" class="stUf5b" fill="currentColor" focusable="false" width="20px"
                                height="20px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                <path
                                    d="M12,7c-2.48,0-4.5,2.02-4.5,4.5S9.52,16,12,16s4.5-2.02,4.5-4.5S14.48,7,12,7z M12,14.2c-1.49,0-2.7-1.21-2.7-2.7 c0-1.49,1.21-2.7,2.7-2.7s2.7,1.21,2.7,2.7C14.7,12.99,13.49,14.2,12,14.2z">
                                </path>
                                <path
                                    d="M12,4C7,4,2.73,7.11,1,11.5C2.73,15.89,7,19,12,19s9.27-3.11,11-7.5C21.27,7.11,17,4,12,4z M12,17 c-3.79,0-7.17-2.13-8.82-5.5C4.83,8.13,8.21,6,12,6s7.17,2.13,8.82,5.5C19.17,14.87,15.79,17,12,17z">
                                </path>
                            </svg>
                        </a>
                        <a id="eyeFalse" style="display:none;">
                            <svg aria-hidden="true" class="stUf5b" fill="currentColor" focusable="false" width="20px"
                                height="20px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                                <path
                                    d="M10.58,7.25l1.56,1.56c1.38,0.07,2.47,1.17,2.54,2.54l1.56,1.56C16.4,12.47,16.5,12,16.5,11.5C16.5,9.02,14.48,7,12,7 C11.5,7,11.03,7.1,10.58,7.25z">
                                </path>
                                <path
                                    d="M12,6c3.79,0,7.17,2.13,8.82,5.5c-0.64,1.32-1.56,2.44-2.66,3.33l1.42,1.42c1.51-1.26,2.7-2.89,3.43-4.74 C21.27,7.11,17,4,12,4c-1.4,0-2.73,0.25-3.98,0.7L9.63,6.3C10.4,6.12,11.19,6,12,6z">
                                </path>
                                <path
                                    d="M16.43,15.93l-1.25-1.25l-1.27-1.27l-3.82-3.82L8.82,8.32L7.57,7.07L6.09,5.59L3.31,2.81L1.89,4.22l2.53,2.53 C2.92,8.02,1.73,9.64,1,11.5C2.73,15.89,7,19,12,19c1.4,0,2.73-0.25,3.98-0.7l4.3,4.3l1.41-1.41l-3.78-3.78L16.43,15.93z M11.86,14.19c-1.38-0.07-2.47-1.17-2.54-2.54L11.86,14.19z M12,17c-3.79,0-7.17-2.13-8.82-5.5c0.64-1.32,1.56-2.44,2.66-3.33 l1.91,1.91C7.6,10.53,7.5,11,7.5,11.5c0,2.48,2.02,4.5,4.5,4.5c0.5,0,0.97-0.1,1.42-0.25l0.95,0.95C13.6,16.88,12.81,17,12,17z">
                                </path>
                            </svg>
                        </a>
                    </span>
                </div>
                <button type="submit" class="userLoginBtn button">
                    <span>'.lc('_lang_loginGirisYap','Giriş Yap').'</span>
                </button>
                <div class="userPassBtnContainer">
                    <a href="'.slink('sifre').'" class="userPassBtn">'._lang_sifremiUnuttum.'</a>
                </div>
                <div class="socialMediaLoginButtons" '.($_SESSION['facebookBackURL']?'':'style="display:none;"').'>
                    <span><span>'.lc('_lang_veya','veya').'</span></span>
                      <button class="button" href="#" onclick="window.location.href = \''.$_SESSION['facebookBackURL'].'\'; return false;">
                        <span>Facebook ile Bağlan</span>
                      </button>
                      
                    '.($_GET["control"]=="devam" ? " <a href=\"./satinal_sp__op-adres.html\">Üyeliksiz Devam Et</a>" :
                    "").'
                </div>
                ' . ($login_message?'<script>window.addEventListener("load", (event) => {myalert("'.strip_tags($login_message).'","error",0);});</script>':'') . '
            </div>
        </form>
    </div>
    <div class="col-sm-6" id="divUyeRegisterForm">
        <div class="col-sm-right-register">
            <span class="spanTittle">Hızlı Üyelik</span>
            <div class="userWrapper nameDiv">
                <input class="textbox" id="q_name" name="txtQuickName" placeholder="'._lang_form_adiniz.'" type="text" />
            </div>
            <div class="userWrapper lastDiv">
                <input class="textbox" id="q_lastname" name="txtQuickLastName" placeholder="'._lang_form_soyadiniz.'" type="text" />
            </div>
            <div class="userWrapper emailDiv">
                <input class="textbox" id="q_email" autocomplete="off" placeholder="'._lang_kullaniciAdi.'" type="email" />
            </div>
            <div class="userWrapper passDiv" style="position:relative">
                <input class="textbox" id="q_password" autocomplete="off" placeholder="'._lang_sifre.'" type="password" />
                <span class="TcxPassEye">
                    <a id="eyeTrueFast">
                        <svg aria-hidden="true" class="stUf5b" fill="currentColor" focusable="false" width="20px"
                            height="20px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M12,7c-2.48,0-4.5,2.02-4.5,4.5S9.52,16,12,16s4.5-2.02,4.5-4.5S14.48,7,12,7z M12,14.2c-1.49,0-2.7-1.21-2.7-2.7 c0-1.49,1.21-2.7,2.7-2.7s2.7,1.21,2.7,2.7C14.7,12.99,13.49,14.2,12,14.2z">
                            </path>
                            <path
                                d="M12,4C7,4,2.73,7.11,1,11.5C2.73,15.89,7,19,12,19s9.27-3.11,11-7.5C21.27,7.11,17,4,12,4z M12,17 c-3.79,0-7.17-2.13-8.82-5.5C4.83,8.13,8.21,6,12,6s7.17,2.13,8.82,5.5C19.17,14.87,15.79,17,12,17z">
                            </path>
                        </svg>
                    </a>
                    <a id="eyeFalseFast" style="display:none;">
                        <svg aria-hidden="true" class="stUf5b" fill="currentColor" focusable="false" width="20px"
                            height="20px" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg">
                            <path
                                d="M10.58,7.25l1.56,1.56c1.38,0.07,2.47,1.17,2.54,2.54l1.56,1.56C16.4,12.47,16.5,12,16.5,11.5C16.5,9.02,14.48,7,12,7 C11.5,7,11.03,7.1,10.58,7.25z">
                            </path>
                            <path
                                d="M12,6c3.79,0,7.17,2.13,8.82,5.5c-0.64,1.32-1.56,2.44-2.66,3.33l1.42,1.42c1.51-1.26,2.7-2.89,3.43-4.74 C21.27,7.11,17,4,12,4c-1.4,0-2.73,0.25-3.98,0.7L9.63,6.3C10.4,6.12,11.19,6,12,6z">
                            </path>
                            <path
                                d="M16.43,15.93l-1.25-1.25l-1.27-1.27l-3.82-3.82L8.82,8.32L7.57,7.07L6.09,5.59L3.31,2.81L1.89,4.22l2.53,2.53 C2.92,8.02,1.73,9.64,1,11.5C2.73,15.89,7,19,12,19c1.4,0,2.73-0.25,3.98-0.7l4.3,4.3l1.41-1.41l-3.78-3.78L16.43,15.93z M11.86,14.19c-1.38-0.07-2.47-1.17-2.54-2.54L11.86,14.19z M12,17c-3.79,0-7.17-2.13-8.82-5.5c0.64-1.32,1.56-2.44,2.66-3.33 l1.91,1.91C7.6,10.53,7.5,11,7.5,11.5c0,2.48,2.02,4.5,4.5,4.5c0.5,0,0.97-0.1,1.42-0.25l0.95,0.95C13.6,16.88,12.81,17,12,17z">
                            </path>
                        </svg>
                    </a>
                </span>
            </div>
            <div class="userWrapper telDiv">
                <input class="textbox ticiTelInput" placeholder="'._lang_form_cepTelefonunuz.'" id="q_gsm" name="txtQuickTel"
                    type="tel">
            </div>
            <div class="mb-10 mt-10"><label class="sf-text-label"></label>
                <div class="checkbox-fa"><input class="sf-form-checkbox" id="gf_ebulten" type="checkbox"
                        name="data_ebulten" value="1"><label for="gf_ebulten">'._lang_ebulten.' (Email / SMS)</label></div>
            </div>
            <div class="checkbox-fa"><input id="gf_acceptRulesCB_uyelikKural" class="sf-form-checkbox"
                    type="checkbox"><label for="gf_acceptRulesCB_uyelikKural" class="sf-form-info st-form-onay">'.lc(_lang_uyeOnayi,'<a class="uye-kural" href="#" onclick="return false;">Üyelik kuralları</a> ve <a class="uye-kvkk" href="#" onclick="return false;">kişisel verilerin korunması kurallarını</a> okudum ve onaylıyorum.').'</label></div>
            <button type="button" class="userLoginBtn QuickMember button"
                onclick="quickRegister($(\'#q_name\').val(),$(\'#q_lastname\').val(),$(\'#q_email\').val(),$(\'#q_password\').val(),$(\'#q_gsm\').val(),$(\'#gf_ebulten\').is(\':checked\'),$(\'#gf_acceptRulesCB_uyelikKural\').is(\':checked\'));">
                <span>'.lc('_lang_uyeOl','Üye Ol').'</span>
            </button>
        </div>
    </div>
</div>
</div>
<script>
    $("#eyeTrue").click(function () {
        $("#eyeTrue").hide();
        $("#eyeFalse").show();
        $("#txtUyeGirisPassword").attr("type", "text");
    });
    $("#eyeFalse").click(function () {
        $("#eyeFalse").hide();
        $("#eyeTrue").show();
        $("#txtUyeGirisPassword").attr("type", "password");
    });
    $("#eyeTrueFast").click(function () {
        $("#eyeTrueFast").hide();
        $("#eyeFalseFast").show();
        $("#q_password").attr("type", "text");
    });
    $("#eyeFalseFast").click(function () {
        $("#eyeFalseFast").hide();
        $("#eyeTrueFast").show();
        $("#q_password").attr("type", "password");
    });
    $("#hizli-uye-menu a").click(function () {
        $("#hizli-uye-menu a.active").removeClass("active");
        $(this).addClass("active");
        $("#divUyeGirisForm,#divUyeRegisterForm").hide();
        $($(this).attr("data-type")).show();
        return false;
    });
</script>
';
return $loginOut;
?>