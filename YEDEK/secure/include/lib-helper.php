<?
list($dPrefix) = explode('.', ucfirst(str_replace('www.','',$_SERVER['HTTP_HOST']))); 
/*
$helper['banka']['shopphp']['view'] = 'Firma Bünyesinde Kredi Kartı (Opsiyonel)';
$helper['banka']['shopphp']['bankaAdi']['value'] = 'Kredi Kartı';
$helper['banka']['shopphp']['paymentModulURL']['value'] = 'include/payment_CC.php';
$helper['banka']['shopphp']['odemeAciklama']['value'] =$dPrefix.' Kartım ile ödemek istiyorum.';
$helper['banka']['shopphp']['taksitGosterimCSS']['value'] = 'red,#fff';
*/
$helper['banka']['akbank']['view'] = 'Akbank';
$helper['banka']['akbank']['bankaAdi']['value'] = 'Akbank';
$helper['banka']['akbank']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['akbank']['postURL']['value'] = 'https://vpos.est.com.tr/servlet/cc5ApiServer';
$helper['banka']['akbank']['clientID']['info'] = 'Akbank Müşteri ID değerini girin.';
$helper['banka']['akbank']['username']['info'] = 'Akbank Kullanıcı adı değerini girin.';
$helper['banka']['akbank']['password']['info'] = 'Akbank Şifre değerini girin.';
$helper['banka']['akbank']['odemeAciklama']['value'] = 'Akbank Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['akbank']['taksitGosterimCSS']['value'] = 'red,#fff';

$helper['banka']['akbank3d']['view'] = 'Akbank 3D (3D Pay)';
$helper['banka']['akbank3d']['bankaAdi']['value'] = 'Akbank 3D (3D Pay)';
$helper['banka']['akbank3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['akbank3d']['postURL']['value'] = 'https://www.sanalakpos.com/servlet/est3Dgate';
$helper['banka']['akbank3d']['clientID']['info'] = 'Akbank Müşteri ID değerini girin.';
$helper['banka']['akbank3d']['username']['info'] = 'Akbank Kullanıcı adı değerini girin.';
$helper['banka']['akbank3d']['password']['info'] = 'Akbank Şifre değerini girin.';
$helper['banka']['akbank3d']['modData1']['info'] = 'Akbank Store Key değerini girin.';
$helper['banka']['akbank3d']['odemeAciklama']['value'] = 'Akbank Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['akbank3d']['taksitGosterimCSS']['value'] = 'red,#fff';

$helper['banka']['akbank3dmodel']['view'] = 'Akbank 3D (3D Model)';
$helper['banka']['akbank3dmodel']['bankaAdi']['value'] = 'Akbank 3D (3D Model)';
$helper['banka']['akbank3dmodel']['paymentModulURL']['value'] = 'include/payment_EST3DModel.php';
$helper['banka']['akbank3dmodel']['postURL']['value'] = 'https://www.sanalakpos.com/fim/est3Dgate';
$helper['banka']['akbank3dmodel']['clientID']['info'] = 'Akbank Müşteri ID değerini girin.';
$helper['banka']['akbank3dmodel']['username']['info'] = 'Akbank Kullanıcı adı değerini girin.';
$helper['banka']['akbank3dmodel']['password']['info'] = 'Akbank Şifre değerini girin.';
$helper['banka']['akbank3dmodel']['modData1']['info'] = 'Akbank Store Key değerini girin.';
$helper['banka']['akbank3dmodel']['odemeAciklama']['value'] = 'Akbank Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['akbank3dmodel']['taksitGosterimCSS']['value'] = 'red,#fff';

$helper['banka']['akbank3di']['view'] = 'Akbank 3D (Innova)';
$helper['banka']['akbank3di']['bankaAdi']['value'] = 'Akbank 3D';
$helper['banka']['akbank3di']['paymentModulURL']['value'] = 'include/payment_Akbankyeni3D.php';
$helper['banka']['akbank3di']['clientID']['info'] = 'Akbank Müşteri ID değerini girin.';
$helper['banka']['akbank3di']['username']['info'] = 'Akbank Terminal No eğerini girin.';
$helper['banka']['akbank3di']['password']['info'] = 'Akbank Şifre (XCip) değerini girin.';
$helper['banka']['akbank3di']['odemeAciklama']['value'] = 'Akbank Kredi Kartları ile 3D ödeme Yapmak istiyorum.';

$helper['banka']['aktif3d']['view'] = 'Aktifbank 3D (NKolay)';
$helper['banka']['aktif3d']['bankaAdi']['value'] = 'Aktifbank 3D';
$helper['banka']['aktif3d']['paymentModulURL']['value'] = 'include/payment_Nkolay.php';
$helper['banka']['aktif3d']['clientID']['info'] = 'Aktifbank Müşteri ID değerini girin.';
$helper['banka']['aktif3d']['password']['info'] = 'Aktifbank Şifre (Secret Key) değerini girin.';
$helper['banka']['aktif3d']['modData1']['info'] = 'Aktifbank Token (SX) değerini girin.';
$helper['banka']['aktif3d']['modData2']['info'] = 'Aktifbank 2 POST URL adresini girin.';
$helper['banka']['aktif3d']['modData2']['value'] = 'https://paynkolaytest.nkolayislem.com.tr/Vpos/Payment/CompletePayment';
$helper['banka']['aktif3d']['postURL']['info'] = 'Aktifbank 1 POST URL adresini girin.';
$helper['banka']['aktif3d']['postURL']['value'] = 'https://paynkolaytest.nkolayislem.com.tr/Vpos';
$helper['banka']['aktif3d']['odemeAciklama']['value'] = 'Kredi Kartım ile 3D ödeme Yapmak istiyorum.';
/*
$helper['banka']['albarakaturk']['view'] = 'Albaraka Türk';
$helper['banka']['albarakaturk']['bankaAdi']['value'] = 'Albaraka Türk';
$helper['banka']['albarakaturk']['paymentModulURL']['value'] = 'include/payment_AlbarakaTurk.php';
$helper['banka']['albarakaturk']['postURL']['info'] = 'Albaraka Türk XML Post URL adresini girin.';
$helper['banka']['albarakaturk']['clientID']['info'] = 'Albaraka Türk MID değerini yazın.';
$helper['banka']['albarakaturk']['username']['info'] = 'Albaraka Türk Kullanıcı adı değerini girin.';
$helper['banka']['albarakaturk']['password']['info'] = 'Albaraka Türk Şifre değerini girin.';
$helper['banka']['albarakaturk']['modData1']['info'] = 'Albaraka Türk TID bilginizi girin.';
$helper['banka']['albarakaturk']['odemeAciklama']['value'] = 'Yapıkredi Bankası / Albaraka Türk Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['albarakaturk']['taksitGosterimCSS']['value'] = '#68207f,#fff'; 
*/
$helper['banka']['albarakaturk3d']['view'] = 'AlbarakaTürk 3D';
$helper['banka']['albarakaturk3d']['bankaAdi']['value'] = 'Albaraka Türk 3D';
$helper['banka']['albarakaturk3d']['paymentModulURL']['value'] = 'include/payment_Albaraka3D.php';
$helper['banka']['albarakaturk3d']['postURL']['info'] = 'Test aşamasında bu bölüme sadece TEST yazın.';
$helper['banka']['albarakaturk3d']['postURL']['value'] = '';
$helper['banka']['albarakaturk3d']['clientID']['info'] = 'Albaraka Türk Bankası Müşteri ID değerini girin.';
$helper['banka']['albarakaturk3d']['username']['info'] = 'Albaraka Türk Bankası Kullanıcı adı değerini girin.';
$helper['banka']['albarakaturk3d']['password']['info'] = 'Albaraka Türk Bankası Şifre değerini girin.';
$helper['banka']['albarakaturk3d']['modData1']['info'] = 'Albaraka Türk Bankası TID bilginizi girin.';
$helper['banka']['albarakaturk3d']['modData2']['info'] = 'Albaraka Türk Bankası Posnet ID bilginizi girin.';
$helper['banka']['albarakaturk3d']['modData3']['info'] = 'Albaraka Türk Bankası ENCKEY bilginizi (Posnet Yönetici Ekranlarındaki "Anahtar Yarat" linkine tıklanılarak açılan sayfadan oluşturulur. Test için 10,10,10,10,10,10,10,10 değerini girin.).';
$helper['banka']['albarakaturk3d']['odemeAciklama']['value'] = 'Kredi Kartı ile ödemek istiyorum.';
$helper['banka']['albarakaturk3d']['taksitGosterimCSS']['value'] = '#68207f,#fff';

$helper['banka']['albarakaturk3do']['view'] = 'AlbarakaTürk Ort.Öd. 3D';
$helper['banka']['albarakaturk3do']['bankaAdi']['value'] = 'Albaraka Türk 3D Ortak Ödeme';
$helper['banka']['albarakaturk3do']['paymentModulURL']['value'] = 'include/payment_YK3D_OOS.php';
$helper['banka']['albarakaturk3do']['postURL']['info'] = '';
$helper['banka']['albarakaturk3do']['postURL']['info'] = 'Albaraka Türk Müşteri OOS post URL adresini girin.';
$helper['banka']['albarakaturk3do']['clientID']['info'] = 'Albaraka Türk Müşteri ID değerini girin.';
$helper['banka']['albarakaturk3do']['username']['info'] = 'Albaraka Türk Kullanıcı adı değerini girin.';
$helper['banka']['albarakaturk3do']['password']['info'] = 'Albaraka Türk Şifre değerini girin.';
$helper['banka']['albarakaturk3do']['modData1']['info'] = 'Albaraka Türk TID bilginizi girin.';
$helper['banka']['albarakaturk3do']['modData2']['info'] = 'Albaraka Türk Posnet ID bilginizi girin.';
$helper['banka']['albarakaturk3do']['modData3']['info'] = 'Albaraka Türk ENCKEY bilginizi (Posnet Yönetici Ekranlarındaki "Anahtar Yarat" linkine tıklanılarak açılan sayfadan oluşturulur. Test için 10,10,10,10,10,10,10,10 değerini girin.).';
$helper['banka']['albarakaturk3do']['odemeAciklama']['value'] = 'Yapı Kredi / Albaraka Türk Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['albarakaturk3do']['taksitGosterimCSS']['value'] = '#68207f,#fff';

$helper['banka']['anadolubank']['view'] = 'Anadolu Bank';
$helper['banka']['anadolubank']['bankaAdi']['value'] = 'Anadolu Bank';
$helper['banka']['anadolubank']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['anadolubank']['postURL']['value'] = 'https://vpos.est.com.tr/servlet/cc5ApiServer';
$helper['banka']['anadolubank']['clientID']['info'] = 'AnadoluBank Müşteri ID değerini girin.';
$helper['banka']['anadolubank']['username']['info'] = 'AnadoluBank Kullanıcı adı değerini girin.';
$helper['banka']['anadolubank']['password']['info'] = 'AnadoluBank Şifre değerini girin.';
$helper['banka']['anadolubank']['odemeAciklama']['value'] = 'AnadoluBank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['anadolubank3d']['view'] = 'Anadolu Bank 3D';
$helper['banka']['anadolubank3d']['bankaAdi']['value'] = 'Anadolu Bank 3D';
$helper['banka']['anadolubank3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['anadolubank3d']['postURL']['value'] = 'https://vpos.est.com.tr/servlet/cc5ApiServer';
$helper['banka']['anadolubank3d']['clientID']['info'] = 'AnadoluBank Müşteri ID değerini girin.';
$helper['banka']['anadolubank3d']['username']['info'] = 'AnadoluBank Kullanıcı adı değerini girin.';
$helper['banka']['anadolubank3d']['password']['info'] = 'AnadoluBank Şifre değerini girin.';
$helper['banka']['anadolubank3d']['modData1']['info'] = 'AnadoluBank Store Key değerini girin.';
$helper['banka']['anadolubank3d']['odemeAciklama']['value'] = 'AnadoluBank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['denizbank']['view'] = 'Denizbank';
$helper['banka']['denizbank']['bankaAdi']['value'] = 'Denizbank';
$helper['banka']['denizbank']['paymentModulURL']['value'] = 'include/payment_Deniz.php';
$helper['banka']['denizbank']['postURL']['value'] = 'https://inter-vpos.com.tr/MPI/Default.aspx';
$helper['banka']['denizbank']['clientID']['info'] = 'Denizbank Mağaza Kodu değerini girin.';
$helper['banka']['denizbank']['username']['info'] = 'Denizbank Kullanıcı adı değerini girin.';
$helper['banka']['denizbank']['password']['info'] = 'Denizbank Şifre değerini girin.';
$helper['banka']['denizbank']['odemeAciklama']['value'] = 'Denizbank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['denizbank3d']['view'] = 'Denizbank 3D Yeni';
$helper['banka']['denizbank3d']['bankaAdi']['value'] = 'Denizbank 3D';
$helper['banka']['denizbank3d']['paymentModulURL']['value'] = 'include/payment_Deniz3D.php';
$helper['banka']['denizbank3d']['postURL']['value'] = 'https://spos.denizbank.com/mpi/Default.aspx';
$helper['banka']['denizbank3d']['clientID']['info'] = 'Denizbank Müşteri ID (ShopCode) değerini girin. Bu sadece sayıdan oluşur.';
$helper['banka']['denizbank3d']['modData1']['info'] = 'Denizbank 3D Pass (StoreKey) değerini girin.';
$helper['banka']['denizbank3d']['odemeAciklama']['value'] = 'Denizbank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['est3dpay']['view'] = 'EST 3D Pay';
$helper['banka']['est3dpay']['bankaAdi']['value'] = 'EST 3D Pay';
$helper['banka']['est3dpay']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['est3dpay']['postURL']['info'] = 'Banka Post URL adresini girin (EST3DGate)';
$helper['banka']['est3dpay']['clientID']['info'] = 'Banka Müşteri ID değerini girin.';
$helper['banka']['est3dpay']['username']['info'] = 'Banka Kullanıcı adı değerini girin.';
$helper['banka']['est3dpay']['password']['info'] = 'Banka Şifre değerini girin.';
$helper['banka']['est3dpay']['modData1']['info'] = 'Banka Store Key değerini girin.';
$helper['banka']['est3dpay']['odemeAciklama']['value'] = 'Kredi Kartı ile ödemek istiyorum.';

$helper['banka']['est3dmodel']['view'] = 'EST 3D Model';
$helper['banka']['est3dmodel']['bankaAdi']['value'] = 'EST 3D Model';
$helper['banka']['est3dmodel']['paymentModulURL']['value'] = 'include/payment_EST3DModel.php';
$helper['banka']['est3dmodel']['postURL']['info'] = 'Banka Post URL adresini girin (EST3DGate)';
$helper['banka']['est3dmodel']['clientID']['info'] = 'Banka Müşteri ID değerini girin.';
$helper['banka']['est3dmodel']['username']['info'] = 'Banka Kullanıcı adı değerini girin.';
$helper['banka']['est3dmodel']['password']['info'] = 'Banka Şifre değerini girin.';
$helper['banka']['est3dmodel']['modData1']['info'] = 'Banka Store Key değerini girin.';
$helper['banka']['est3dmodel']['modData2']['info'] = 'Banka Post URL adresini girin (cc5ApiServer)';
$helper['banka']['est3dmodel']['odemeAciklama']['value'] = 'Kredi Kartı ile ödemek istiyorum.';

$helper['banka']['finansbank']['view'] = 'Finansbank (ESKİ EST ALTYAPISI)';
$helper['banka']['finansbank']['bankaAdi']['value'] = 'Finansbank';
$helper['banka']['finansbank']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['finansbank']['postURL']['value'] = 'https://www.fbwebpos.com/servlet/cc5ApiServer';
$helper['banka']['finansbank']['clientID']['info'] = 'Finansbank Müşteri ID değerini girin.';
$helper['banka']['finansbank']['username']['info'] = 'Finansbank Kullanıcı adı değerini girin.';
$helper['banka']['finansbank']['password']['info'] = 'Finansbank Şifre değerini girin.';
$helper['banka']['finansbank']['odemeAciklama']['value'] = 'Finansbank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['finansbank3d']['view'] = 'Finansbank 3D (ESKİ EST ALTYAPISI)';
$helper['banka']['finansbank3d']['bankaAdi']['value'] = 'Finansbank 3D';
$helper['banka']['finansbank3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['finansbank3d']['postURL']['value'] = 'https://www.fbwebpos.com/fim/est3Dgate';
$helper['banka']['finansbank3d']['postURL']['value'] = 'https://www.fbwebpos.com/servlet/est3Dgate';
$helper['banka']['finansbank3d']['clientID']['info'] = 'Finansbank Merchant ID değerini girin.';
$helper['banka']['finansbank3d']['username']['info'] = 'Finansbank Kullanıcı kodu değerini girin.';
$helper['banka']['finansbank3d']['password']['info'] = 'Finansbank Kullanıcı Şifre değerini girin.';
$helper['banka']['finansbank3d']['modData1']['info'] = 'Finansbank MerchantPass değerini girin.';
$helper['banka']['finansbank3d']['modData2']['info'] = 'Finansbank Kurum Kodu değerini girin. (Ör: 5)';
$helper['banka']['finansbank3d']['odemeAciklama']['value'] = 'Finansbank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['finansbank3dy']['view'] = 'Finansbank 3D';
$helper['banka']['finansbank3dy']['bankaAdi']['value'] = 'Finansbank 3D';
$helper['banka']['finansbank3dy']['paymentModulURL']['value'] = 'include/payment_Finans3D.php';
$helper['banka']['finansbank3dy']['postURL']['value'] = 'https://vpos.qnbfinansbank.com/Gateway/Default.aspx';
$helper['banka']['finansbank3dy']['clientID']['info'] = 'Finansbank Merhant ID değerini girin.';
$helper['banka']['finansbank3dy']['username']['info'] = 'Finansbank Kullanıcı adı değerini girin.';
$helper['banka']['finansbank3dy']['password']['info'] = 'Finansbank Şifre değerini girin.';
$helper['banka']['finansbank3dy']['modData1']['info'] = 'Finansbank Merhant Password değerini girin.';
$helper['banka']['finansbank3dy']['modData2']['info'] = 'Finansbank Kurum Kodu değerini girin.';
$helper['banka']['finansbank3dy']['odemeAciklama']['value'] = 'Finansbank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['garanti']['view'] = 'Garanti Bankası';
$helper['banka']['garanti']['bankaAdi']['value'] = 'Garanti Bankası';
$helper['banka']['garanti']['paymentModulURL']['value'] = 'include/payment_Garanti.php';
$helper['banka']['garanti']['postURL']['value'] = 'https://sanalposprov.garanti.com.tr/VPServlet';
$helper['banka']['garanti']['clientID']['info'] = 'Garanti Bankası Müşteri ID değerini girin.';
//$helper['banka']['garanti']['username']['info'] = 'Garanti Bankası Kullanıcı adı değerini girin.';
$helper['banka']['garanti']['password']['info'] = 'Garanti Bankası Provout Şifre değerini girin.';
$helper['banka']['garanti']['modData1']['value'] = 'PROVAUT';
$helper['banka']['garanti']['modData2']['info'] = 'Garanti Bankası Terminal ID değerini girin.';
$helper['banka']['garanti']['odemeAciklama']['value'] = 'Garanti Bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['garanti']['taksitGosterimCSS']['value'] = '#66cc33,#fff';

$helper['banka']['garanti3d']['view'] = 'Garanti Bankası 3D';
$helper['banka']['garanti3d']['bankaAdi']['value'] = 'Garanti Bankası 3D';
$helper['banka']['garanti3d']['paymentModulURL']['value'] = 'include/payment_Garanti3D.php';
$helper['banka']['garanti3d']['postURL']['value'] = 'https://sanalposprov.garanti.com.tr/servlet/gt3dengine';
$helper['banka']['garanti3d']['clientID']['info'] = 'Garanti Bankası Müşteri ID değerini girin.';
$helper['banka']['garanti3d']['username']['info'] = 'Garanti Bankası PROVAUT girin.';
$helper['banka']['garanti3d']['password']['info'] = 'Garanti Bankası PROVAUT şifresini girin.';
$helper['banka']['garanti3d']['modData1']['info'] = 'Garanti Bankası 3D Secure Key bilginizi girin.';
$helper['banka']['garanti3d']['modData2']['info'] = 'Garanti Bankası Terminal numaranızı girin.';
$helper['banka']['garanti3d']['modData3']['info'] = 'Garanti Bankası üye numaranızı girin.';
$helper['banka']['garanti3d']['odemeAciklama']['value'] = 'Garanti Bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['garanti3d']['taksitGosterimCSS']['value'] = '#66cc33,#fff';

$helper['banka']['garantipay']['view'] = 'Garanti Pay';
$helper['banka']['garantipay']['bankaAdi']['value'] = 'Garanti Pay';
$helper['banka']['garantipay']['paymentModulURL']['value'] = 'include/payment_GarantiPay.php';
$helper['banka']['garantipay']['postURL']['value'] = 'https://sanalposprov.garanti.com.tr/servlet/gt3dengine';
$helper['banka']['garantipay']['clientID']['info'] = 'Garanti Bankası Müşteri ID değerini girin.';
$helper['banka']['garantipay']['username']['info'] = 'Garanti Bankası PROVAUT girin.';
$helper['banka']['garantipay']['password']['info'] = 'Garanti Bankası PROVAUT şifresini girin.';
$helper['banka']['garantipay']['modData1']['info'] = 'Garanti Bankası 3D Secure Key bilginizi girin.';
$helper['banka']['garantipay']['modData2']['info'] = 'Garanti Bankası Terminal numaranızı girin.';
$helper['banka']['garantipay']['modData3']['info'] = 'Garanti Bankası üye numaranızı girin.';
$helper['banka']['garantipay']['odemeAciklama']['value'] = 'Garanti Bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['garantipay']['taksitGosterimCSS']['value'] = '#66cc33,#fff';

$helper['banka']['halkbank']['view'] = 'Halkbank';
$helper['banka']['halkbank']['bankaAdi']['value'] = 'Halkbank';
$helper['banka']['halkbank']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['halkbank']['postURL']['value'] = 'https://sanalpos.halkbank.com.tr/servlet/cc5ApiServer';
$helper['banka']['halkbank']['clientID']['info'] = 'Halkbank Müşteri ID değerini girin.';
$helper['banka']['halkbank']['username']['info'] = 'Halkbank Kullanıcı adı değerini girin.';
$helper['banka']['halkbank']['password']['info'] = 'Halkbank Şifre değerini girin.';
$helper['banka']['halkbank']['odemeAciklama']['value'] = 'Halkbank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['halkbank3d']['view'] = 'Halkbank 3D';
$helper['banka']['halkbank3d']['bankaAdi']['value'] = 'Halkbank 3D';
$helper['banka']['halkbank3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['halkbank3d']['postURL']['value'] = 'https://sanalpos.halkbank.com.tr/fim/est3Dgate';
$helper['banka']['halkbank3d']['clientID']['info'] = 'Halkbank Müşteri ID değerini girin.';
$helper['banka']['halkbank3d']['username']['info'] = 'Halkbank Kullanıcı adı değerini girin.';
$helper['banka']['halkbank3d']['password']['info'] = 'Halkbank Şifre değerini girin.';
$helper['banka']['halkbank3d']['modData1']['info'] = 'Halkbank Store Key değerini girin.';
$helper['banka']['halkbank3d']['odemeAciklama']['value'] = 'Halkbank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['ing']['view'] = 'ING Bank';
$helper['banka']['ing']['bankaAdi']['value'] = 'ING Bank';
$helper['banka']['ing']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['ing']['postURL']['value'] = 'https://sanalpos.ingbank.com.tr/servlet/cc5ApiServer';
$helper['banka']['ing']['clientID']['info'] = 'ING Bank Müşteri ID değerini girin.';
$helper['banka']['ing']['username']['info'] = 'ING Bank Kullanıcı adı değerini girin.';
$helper['banka']['ing']['password']['info'] = 'ING Bank Şifre değerini girin.';
$helper['banka']['ing']['odemeAciklama']['value'] = 'ING Bank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['ing3d']['view'] = 'ING Bank 3D';
$helper['banka']['ing3d']['bankaAdi']['value'] = 'ING Bank 3D';
$helper['banka']['ing3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['ing3d']['postURL']['value'] = 'https://sanalpos.ingbank.com.tr/servlet/est3Dgate';
$helper['banka']['ing3d']['clientID']['info'] = 'ING Bank Müşteri ID değerini girin.';
$helper['banka']['ing3d']['username']['info'] = 'ING Bank Kullanıcı adı değerini girin.';
$helper['banka']['ing3d']['password']['info'] = 'ING Bank Şifre değerini girin.';
$helper['banka']['ing3d']['modData1']['info'] = 'ING Bank Store Key değerini girin.';
$helper['banka']['ing3d']['odemeAciklama']['value'] = 'ING Bank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['interv3d']['view'] = 'InterVpos 3DPay';
$helper['banka']['interv3d']['bankaAdi']['value'] = 'InterVpos 3DPay';
$helper['banka']['interv3d']['paymentModulURL']['value'] = 'include/payment_InterVpos3D.php';
$helper['banka']['interv3d']['postURL']['value'] = 'https://inter-vpos.com.tr/mpi/Default.aspx';
$helper['banka']['interv3d']['clientID']['info'] = 'InterVpos Müşteri ID (ShopCode) değerini girin. Bu sadece sayıdan oluşur.';
$helper['banka']['interv3d']['modData1']['info'] = 'InterVpos 3D Pass (StoreKey) değerini girin.';
$helper['banka']['interv3d']['odemeAciklama']['value'] = 'Kredi Kartı ile ödemek istiyorum.';

$helper['banka']['hsbc']['view'] = 'HSBC';
$helper['banka']['hsbc']['bankaAdi']['value'] = 'HSBC';
$helper['banka']['hsbc']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['hsbc']['postURL']['value'] = 'https://vpos.est.com.tr/servlet/cc5ApiServer';
$helper['banka']['hsbc']['clientID']['info'] = 'HSBC Müşteri ID değerini girin.';
$helper['banka']['hsbc']['username']['info'] = 'HSBC Kullanıcı adı değerini girin.';
$helper['banka']['hsbc']['password']['info'] = 'HSBC Şifre değerini girin.';
$helper['banka']['hsbc']['odemeAciklama']['value'] = 'HSBC Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['hsbc3d']['view'] = 'HSBC 3D';
$helper['banka']['hsbc3d']['bankaAdi']['value'] = 'HSBC 3D';
$helper['banka']['hsbc3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['hsbc3d']['postURL']['value'] = 'https://sanalpos.est.com.tr/servlet/cc5ApiServer';
$helper['banka']['hsbc3d']['clientID']['info'] = 'HSBC Müşteri ID değerini girin.';
$helper['banka']['hsbc3d']['username']['info'] = 'HSBC Kullanıcı adı değerini girin.';
$helper['banka']['hsbc3d']['password']['info'] = 'HSBC Şifre değerini girin.';
$helper['banka']['hsbc3d']['modData1']['info'] = 'HSBC Store Key değerini girin.';
$helper['banka']['hsbc3d']['odemeAciklama']['value'] = 'HSBC Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['isbankasi']['view'] = 'İş Bankası ';
$helper['banka']['isbankasi']['bankaAdi']['value'] = 'İş Bankası';
$helper['banka']['isbankasi']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['isbankasi']['postURL']['value'] = 'https://spos.isbank.com.tr/servlet/cc5ApiServer';
$helper['banka']['isbankasi']['clientID']['info'] = 'İş Bankası Müşteri ID değerini girin.';
$helper['banka']['isbankasi']['username']['info'] = 'İş Bankası Kullanıcı adı değerini girin.';
$helper['banka']['isbankasi']['password']['info'] = 'İş Bankası Şifre değerini girin.';
$helper['banka']['isbankasi']['odemeAciklama']['value'] = 'İş Bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['isbankasi']['taksitGosterimCSS']['value'] = '#df1063,#fff';

$helper['banka']['isbankasi3d']['view'] = 'İş Bankası 3D';
$helper['banka']['isbankasi3d']['bankaAdi']['value'] = 'İş Bankası 3D';
$helper['banka']['isbankasi3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['isbankasi3d']['postURL']['value'] = 'https://spos.isbank.com.tr/fim/est3Dgate';
$helper['banka']['isbankasi3d']['clientID']['info'] = 'İş Bankası Müşteri ID değerini girin.';
$helper['banka']['isbankasi3d']['username']['info'] = 'İş Bankası Kullanıcı adı değerini girin.';
$helper['banka']['isbankasi3d']['password']['info'] = 'İş Bankası Şifre değerini girin.';
$helper['banka']['isbankasi3d']['modData1']['info'] = 'İş Bankası Store Key değerini girin.';
$helper['banka']['isbankasi3d']['modData3']['info'] = 'İş Bankası Bölüm değerini girin.';
$helper['banka']['isbankasi3d']['odemeAciklama']['value'] = 'İş bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['isbankasi3d']['taksitGosterimCSS']['value'] = '#df1063,#fff';

$helper['banka']['isbankasi3dyeni']['view'] = 'İş Bankası 3D (Yeni Innova)';
$helper['banka']['isbankasi3dyeni']['bankaAdi']['value'] = 'İş Bankası 3D';
$helper['banka']['isbankasi3dyeni']['paymentModulURL']['value'] = 'include/payment_Isbank3D.php';
$helper['banka']['isbankasi3dyeni']['postURL']['value'] = 'https://trx.vpos.isbank.com.tr/v3/Vposreq.aspx';
$helper['banka']['isbankasi3dyeni']['modData1']['value'] = 'https://mpi.vpos.isbank.com.tr/Enrollment.aspx';
$helper['banka']['isbankasi3dyeni']['clientID']['info'] = 'İş Bankası Müşteri ID değerini girin.';
$helper['banka']['isbankasi3dyeni']['password']['info'] = 'İş Bankası Şifre (XCip) değerini girin.';
$helper['banka']['isbankasi3dyeni']['odemeAciklama']['value'] = 'İş Bankası Kredi Kartları ile 3D ödeme Yapmak istiyorum.';

$helper['banka']['kuveytturk3d']['view'] = 'Kuveyt Turk 3D';
$helper['banka']['kuveytturk3d']['bankaAdi']['value'] = 'Kuveyt Turk';
$helper['banka']['kuveytturk3d']['paymentModulURL']['value'] = 'include/payment_KuveytTurk3D.php';
$helper['banka']['kuveytturk3d']['clientID']['info'] = 'Kuveyt Turk Mağaza Kodu değerini girin.';
$helper['banka']['kuveytturk3d']['modData1']['info'] = 'Kuveyt Turk Müşteri Numarası değerini girin.';
$helper['banka']['kuveytturk3d']['username']['info'] = 'Kuveyt Turk API Role Kullanıcı adı değerini girin.';
$helper['banka']['kuveytturk3d']['password']['info'] = 'Kuveyt Turk API Role Şifre değerini girin.';
$helper['banka']['kuveytturk3d']['odemeAciklama']['value'] = 'Kuveyt Turk Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['teb3d']['view'] = 'TEB 3D';
$helper['banka']['teb3d']['bankaAdi']['value'] = 'TEB';
$helper['banka']['teb3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['teb3d']['postURL']['value'] = 'https://sanalpos.teb.com.tr/servlet/est3Dgate';
$helper['banka']['teb3d']['clientID']['info'] = 'TEB Müşteri ID değerini girin.';
$helper['banka']['teb3d']['username']['info'] = 'TEB Kullanıcı adı değerini girin.';
$helper['banka']['teb3d']['password']['info'] = 'TEB Şifre değerini girin.';
$helper['banka']['teb3d']['modData1']['info'] = 'TEB Store Key değerini girin.';
$helper['banka']['teb3d']['odemeAciklama']['value'] = 'TEB Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['tf']['view'] = 'Türkiye Finans';
$helper['banka']['tf']['bankaAdi']['value'] = 'Türkiye Finans';
$helper['banka']['tf']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['tf']['postURL']['value'] = 'https://sanalpos.turkiyefinans.com.tr/fim/api';
$helper['banka']['tf']['clientID']['info'] = 'Türkiye Finans Müşteri ID değerini girin.';
$helper['banka']['tf']['username']['info'] = 'Türkiye Finans Kullanıcı adı değerini girin.';
$helper['banka']['tf']['password']['info'] = 'Türkiye Finans Şifre değerini girin.';
$helper['banka']['tf']['odemeAciklama']['value'] = 'Türkiye Finans Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['tf3d']['view'] = 'Türkiye Finans 3D';
$helper['banka']['tf3d']['bankaAdi']['value'] = 'Türkiye Finans';
$helper['banka']['tf3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['tf3d']['postURL']['value'] = 'https://sanalpos.turkiyefinans.com.tr/fim/est3Dgate';
$helper['banka']['tf3d']['clientID']['info'] = 'Türkiye Finans Müşteri ID değerini girin.';
$helper['banka']['tf3d']['username']['info'] = 'Türkiye Finans Kullanıcı adı değerini girin.';
$helper['banka']['tf3d']['password']['info'] = 'Türkiye Finans Şifre değerini girin.';
$helper['banka']['tf3d']['modData1']['info'] = 'Türkiye Finans Store Key değerini girin.';
$helper['banka']['tf3d']['odemeAciklama']['value'] = 'Türkiye Finans Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['kibrisuniversal']['view'] = 'Kıbrıs Universal';
$helper['banka']['kibrisuniversal']['bankaAdi']['value'] = 'Kıbrıs Universal';
$helper['banka']['kibrisuniversal']['paymentModulURL']['value'] = 'include/payment_Provus.php';
$helper['banka']['kibrisuniversal']['clientID']['info'] = 'Kıbrıs Universal Firma Numaranızı girin.';
$helper['banka']['kibrisuniversal']['username']['info'] = 'Kıbrıs Universal Terminal Numaranızı girin.';
$helper['banka']['kibrisuniversal']['modData1']['info'] = 'Kıbrıs Universal Merchan Key bilginizi girin.';
$helper['banka']['kibrisuniversal']['odemeAciklama']['value'] = 'Kıbrıs Universal Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['kibrisuniversal']['postURL']['info'] = 'Kıbrıs Universal POST URL adresini girin. ';

$helper['banka']['vakifbank']['view'] = 'Vakıfbank';
$helper['banka']['vakifbank']['bankaAdi']['value'] = 'Vakıfbank';
$helper['banka']['vakifbank']['paymentModulURL']['value'] = 'include/payment_Vakifbank.php';
$helper['banka']['vakifbank']['clientID']['info'] = 'Vakıfbank Terminal No değerini girin.';
$helper['banka']['vakifbank']['username']['info'] = 'Vakıfbank İşyeri No değerini girin.';
$helper['banka']['vakifbank']['password']['info'] = 'Vakıfbank İşyeri Şifre değerini girin.';
$helper['banka']['vakifbank']['postURL']['info'] = 'Vakıfbank Sanal Pos POST URL adresini girin. (Bu pos için sunucunuzda 4443 porta iletişin açılması gereklidir.)';
$helper['banka']['vakifbank']['postURL']['value'] = 'https://onlineodeme.vakifbank.com.tr:4443/VposService/v3/Vposreq.aspx';
$helper['banka']['vakifbank']['odemeAciklama']['value'] = 'Vakıfbank Kredi Kartları ile ödemek istiyorum.';

$helper['banka']['vakifbank3d']['view'] = 'Vakıfbank 3D';
$helper['banka']['vakifbank3d']['bankaAdi']['value'] = 'Vakıfbank 3D';
$helper['banka']['vakifbank3d']['bankaAdi']['info'] = '<span style="color:red">ÖNEMLİ :</span> Vakıfbank 3D Modül kurulumu için sunucu (hosting) yöneticinizden <span style="color:red">4443 port</span> ile iletişimi açmasını talep etmeniz gerekmektedir. İlgili adres <a href="https://3dsecure.vakifbank.com.tr:4443/MPIAPI/MPI_Enrollment.asp" target="_blank">https://3dsecure.vakifbank.com.tr:4443/MPIAPI/MPI_Enrollment.asp</a>.';
$helper['banka']['vakifbank3d']['paymentModulURL']['value'] = 'include/payment_Vakifbank3D.php';
$helper['banka']['vakifbank3d']['clientID']['info'] = 'Vakıfbank Müşteri ID değerini girin.';
$helper['banka']['vakifbank3d']['username']['info'] = 'Vakıfbank Terminal No eğerini girin.';
$helper['banka']['vakifbank3d']['password']['info'] = 'Vakıfbank Şifre (XCip) değerini girin.';
$helper['banka']['vakifbank3d']['odemeAciklama']['value'] = 'Vakıfbank Kredi Kartları ile 3D ödeme Yapmak istiyorum.';

$helper['banka']['vakifkatilim']['view'] = 'Vakıf Katılım Bankası 3D';
$helper['banka']['vakifkatilim']['bankaAdi']['value'] = 'Vakıf Katılım';
$helper['banka']['vakifkatilim']['paymentModulURL']['value'] = 'include/payment_Vakifkatilim3D.php';
$helper['banka']['vakifkatilim']['clientID']['info'] = 'Vakıf Katılım Merchant ID (Müşteri Numarası) değerini girin.';
$helper['banka']['vakifkatilim']['username']['info'] = 'Vakıf Katılım API Username (Kullanıcı Adı) değerini girin.';
$helper['banka']['vakifkatilim']['password']['info'] = 'Vakıf Katılım API Password (Şifre) değerini girin.';
$helper['banka']['vakifkatilim']['postURL']['value'] = 'https://boa.vakifkatilim.com.tr/VirtualPOS.Gateway/Home/ThreeDModelPayGate';
$helper['banka']['vakifkatilim']['odemeAciklama']['value'] = 'Vakıf Katılım bankası kredi kartı ile ödeme Yapmak istiyorum.';

$helper['banka']['wirecard']['view'] = 'Wirecard';
$helper['banka']['wirecard']['bankaAdi']['value'] = 'Kredi Kartı ile Ödeme';
$helper['banka']['wirecard']['paymentModulURL']['value'] = 'include/payment_wirecard.php';
$helper['banka']['wirecard']['clientID']['info'] = 'WireCard UserCode bilgisini girin.';
$helper['banka']['wirecard']['username']['info'] = 'WireCard Pin bilgisini girin.';
$helper['banka']['wirecard']['odemeAciklama']['value'] = 'Kredi kartım ile ödemek istiyorum.';
$helper['banka']['wirecard']['taksitGosterimCSS']['value'] = '#68207f,#fff';
/*
$helper['banka']['yapikredi']['view'] = 'Yapıkredi Bankası';
$helper['banka']['yapikredi']['bankaAdi']['value'] = 'Yapıkredi Bankası';
$helper['banka']['yapikredi']['paymentModulURL']['value'] = 'include/payment_YapiKredi.php';
$helper['banka']['yapikredi']['postURL']['value'] = 'https://www.posnet.ykb.com/PosnetWebService/XML';
$helper['banka']['yapikredi']['clientID']['info'] = 'Yapıkredi Bankası MID değerini yazın.';
$helper['banka']['yapikredi']['username']['info'] = 'Yapıkredi Bankası Kullanıcı adı değerini girin.';
$helper['banka']['yapikredi']['password']['info'] = 'Yapıkredi Bankası Şifre değerini girin.';
$helper['banka']['yapikredi']['modData1']['info'] = 'Yapıkredi Bankası TID bilginizi girin.';
$helper['banka']['yapikredi']['odemeAciklama']['value'] = 'Yapıkredi Bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['yapikredi']['taksitGosterimCSS']['value'] = '#68207f,#fff';
*/
$helper['banka']['yapikredi3d']['view'] = 'Yapıkredi Bankası 3D';
$helper['banka']['yapikredi3d']['bankaAdi']['value'] = 'Yapıkredi Bankası 3D';
$helper['banka']['yapikredi3d']['paymentModulURL']['value'] = 'include/payment_YapiKredi3Dv2.php';
$helper['banka']['yapikredi3d']['postURL']['info'] = 'Test aşamasında bu bölüme sadece TEST yazın.';
$helper['banka']['yapikredi3d']['postURL']['value'] = '';
$helper['banka']['yapikredi3d']['clientID']['info'] = 'Yapıkredi Bankası Müşteri ID değerini girin.';
$helper['banka']['yapikredi3d']['username']['info'] = 'Yapıkredi Bankası Kullanıcı adı değerini girin.';
$helper['banka']['yapikredi3d']['password']['info'] = 'Yapıkredi Bankası Taksit Kampanya Kodu (vftCode) değerini girin.';
$helper['banka']['yapikredi3d']['modData1']['info'] = 'Yapıkredi Bankası TID bilginizi girin.';
$helper['banka']['yapikredi3d']['modData2']['info'] = 'Yapıkredi Bankası Posnet ID bilginizi girin.';
$helper['banka']['yapikredi3d']['modData3']['info'] = 'Yapıkredi Bankası ENCKEY bilginizi (Posnet Yönetici Ekranlarındaki "Anahtar Yarat" linkine tıklanılarak açılan sayfadan oluşturulur. Test için 10,10,10,10,10,10,10,10 değerini girin.).';
$helper['banka']['yapikredi3d']['odemeAciklama']['value'] = 'Yapıkredi Bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['yapikredi3d']['taksitGosterimCSS']['value'] = '#68207f,#fff';
/*
$helper['banka']['yapikredi3do']['view'] = 'Yapıkredi Bankası Ortak Ö. 3D';
$helper['banka']['yapikredi3do']['bankaAdi']['value'] = 'Yapıkredi Bankası 3D Ortak Ödeme';
$helper['banka']['yapikredi3do']['paymentModulURL']['value'] = 'include/payment_YK3D_OOS.php';
$helper['banka']['yapikredi3do']['postURL']['info'] = '';
$helper['banka']['yapikredi3do']['postURL']['value'] = 'https://www.posnet.ykb.com/3DSWebService/OOS';
$helper['banka']['yapikredi3do']['clientID']['info'] = 'Yapıkredi Bankası Müşteri ID değerini girin.';
$helper['banka']['yapikredi3do']['username']['info'] = 'Yapıkredi Bankası Kullanıcı adı değerini girin.';
$helper['banka']['yapikredi3do']['password']['info'] = 'Yapıkredi Bankası Şifre değerini girin.';
$helper['banka']['yapikredi3do']['modData1']['info'] = 'Yapıkredi Bankası TID bilginizi girin.';
$helper['banka']['yapikredi3do']['modData2']['info'] = 'Yapıkredi Bankası Posnet ID bilginizi girin.';
$helper['banka']['yapikredi3do']['modData3']['info'] = 'Yapıkredi Bankası ENCKEY bilginizi (Posnet Yönetici Ekranlarındaki "Anahtar Yarat" linkine tıklanılarak açılan sayfadan oluşturulur. Test için 10,10,10,10,10,10,10,10 değerini girin.).';
$helper['banka']['yapikredi3do']['odemeAciklama']['value'] = 'Yapıkredi Bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['yapikredi3do']['taksitGosterimCSS']['value'] = '#68207f,#fff';
*/
$helper['banka']['ziraat']['view'] = 'Ziraat Bankası';
$helper['banka']['ziraat']['bankaAdi']['value'] = 'Ziraat Bankası (EST)';
$helper['banka']['ziraat']['paymentModulURL']['value'] = 'include/payment_EST.php';
$helper['banka']['ziraat']['postURL']['value'] = 'https://sanalpos2.ziraatbank.com.tr/fim/api';
$helper['banka']['ziraat']['clientID']['info'] = 'Ziraat Bankası Müşteri ID değerini girin.';
$helper['banka']['ziraat']['username']['info'] = 'Ziraat Bankası Kullanıcı adı değerini girin.';
$helper['banka']['ziraat']['password']['info'] = 'Ziraat Bankası Şifre değerini girin.';
$helper['banka']['ziraat']['odemeAciklama']['value'] = 'Ziraat Bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['ziraat']['taksitGosterimCSS']['value'] = '#df1063,#fff';

$helper['banka']['ziraat3d']['view'] = 'Ziraat Bankası 3D (EST 3D)';
$helper['banka']['ziraat3d']['bankaAdi']['value'] = 'Ziraat Bankası 3D';
$helper['banka']['ziraat3d']['paymentModulURL']['value'] = 'include/payment_EST3D.php';
$helper['banka']['ziraat3d']['postURL']['value'] = 'https://sanalpos2.ziraatbank.com.tr/fim/est3Dgate';
$helper['banka']['ziraat3d']['clientID']['info'] = 'Ziraat Bankası Müşteri ID değerini girin.';
$helper['banka']['ziraat3d']['username']['info'] = 'Ziraat Bankası Kullanıcı adı değerini girin.';
$helper['banka']['ziraat3d']['password']['info'] = 'Ziraat Bankası Şifre değerini girin.';
$helper['banka']['ziraat3d']['modData1']['info'] = 'Ziraat Bankası Store Key değerini girin.';
$helper['banka']['ziraat3d']['odemeAciklama']['value'] = 'Ziraat bankası Kredi Kartları ile ödemek istiyorum.';
$helper['banka']['ziraat3d']['taksitGosterimCSS']['value'] = '#df1063,#fff';

$helper['banka']['ziraat3dyeni']['view'] = 'Ziraat Bankası 3D (Yeni Innova)';
$helper['banka']['ziraat3dyeni']['bankaAdi']['value'] = 'Ziraat Bankası 3D';
$helper['banka']['ziraat3dyeni']['paymentModulURL']['value'] = 'include/payment_Ziraat3D.php';
$helper['banka']['ziraat3dyeni']['postURL']['info'] = 'Ziraat Bankası POST URL adresini girin.';
$helper['banka']['ziraat3dyeni']['modData1']['info'] = 'Ziraat Bankası MPI Service URL adresini girin.';
$helper['banka']['ziraat3dyeni']['clientID']['info'] = 'Ziraat Bankası Müşteri ID değerini girin.';
$helper['banka']['ziraat3dyeni']['password']['info'] = 'Ziraat Bankası Şifre (XCip) değerini girin.';
$helper['banka']['ziraat3dyeni']['odemeAciklama']['value'] = 'Ziraat Bankası Kredi Kartları ile 3D ödeme Yapmak istiyorum.';

$helper['banka']['']['view'] = '----------------------------------------------------------------------------';

$helper['banka']['cek']['view'] = 'Alışveriş Çeki';
$helper['banka']['cek']['bankaAdi']['value'] = 'Alışveriş Çeki';
$helper['banka']['cek']['odemeAciklama']['value'] = 'Ödemeyi Alışveriş Çekim ile yapmak istiyorum.';
$helper['banka']['cek']['paymentModulURL']['value'] = 'include/payment_alisverisceki.php';

$helper['banka']['arena3d']['view'] = 'Arena Paynet 3D (Eski)';
$helper['banka']['arena3d']['bankaAdi']['value'] = 'Arena Paynet 3D';
$helper['banka']['arena3d']['paymentModulURL']['value'] = 'include/payment_ARENAPaynet3D.php';
$helper['banka']['arena3d']['clientID']['info'] = 'Arena Paynet bayiID bilgisini girin.';
$helper['banka']['arena3d']['username']['info'] = 'Arena Paynet bayi kullanıcı adı bilgisini girin.';
$helper['banka']['arena3d']['modData1']['info'] = 'Arena Banka Kodu değerini girin. (ÖR : Bonus için BONS)';
$helper['banka']['arena3d']['odemeAciklama']['value'] = 'Kredi Kartı (Paynet) ile  ödemek istiyorum.';

$helper['banka']['paynet']['view'] = 'Arena Paynet (Yeni)';
$helper['banka']['paynet']['bankaAdi']['value'] = 'Arena Paynet';
$helper['banka']['paynet']['paymentModulURL']['value'] = 'include/payment_paynet.php';
$helper['banka']['paynet']['username']['info'] = 'Arena Publishable Key bilgisini girin.';
$helper['banka']['paynet']['password']['info'] = 'Arena Secret Key değerini girin.';
$helper['banka']['paynet']['modData1']['info'] = 'Test aşaması için buraya test yazın.';
$helper['banka']['paynet']['modData2']['info'] = 'Taksit desteğini pasif etmek için buraya 0 yazın.';
$helper['banka']['paynet']['modData3']['info'] = 'Taksit gösterim ekranı için tek banka kodu (AXSS,WRLD,BONS,MAXM,FINS,PARF,DENZ,ZDGR gibi..).';
$helper['banka']['paynet']['odemeAciklama']['value'] = 'Kredi Kartı (Paynet) ile  ödemek istiyorum.';

$helper['banka']['andropay']['view'] = 'Andropay';
$helper['banka']['andropay']['bankaAdi']['value'] = 'Andropay';
$helper['banka']['andropay']['paymentModulURL']['value'] = 'include/payment_andropay.php';
$helper['banka']['andropay']['clientID']['info'] = 'Andropay Site ID bilgisini girin.';
$helper['banka']['andropay']['odemeAciklama']['value'] = 'Kredi Kartı (Andropay) ile  ödemek istiyorum.';

$helper['banka']['authorize']['view'] = 'Authorize.net';
$helper['banka']['authorize']['bankaAdi']['value'] = 'Authorize';
$helper['banka']['authorize']['paymentModulURL']['value'] = 'include/payment_authorize.php';
$helper['banka']['authorize']['username']['info'] = 'Authorize Login ID değerini girin.';
$helper['banka']['authorize']['password']['info'] = 'Authorize Transaction Key değerini girin.';
$helper['banka']['authorize']['odemeAciklama']['value'] = 'Kredi kartı ile ödemek istiyorum.';

$helper['banka']['avawebs']['view'] = 'Avawebs Sanalpos';
$helper['banka']['avawebs']['paymentModulURL']['value'] = 'include/payment_avawebs.php';
$helper['banka']['avawebs']['bankaAdi']['value'] = 'Avawebs sanalpos';
$helper['banka']['avawebs']['clientID']['info'] = 'Avawebs Müşteri ID bilgisini girin.';
$helper['banka']['avawebs']['username']['info'] = 'Avawebs kullanıcı adı bilgisini girin.';
$helper['banka']['avawebs']['password']['info'] = 'Avawebs şifre bilgisini girin.';
$helper['banka']['avawebs']['odemeAciklama']['value'] = 'Kredi Kartı (Avawebs Sanalpos) ile  ödemek istiyorum.';

$helper['banka']['barclaycard']['view'] = 'Barclaycard';
$helper['banka']['barclaycard']['bankaAdi']['value'] = 'Barclaycard';
$helper['banka']['barclaycard']['paymentModulURL']['value'] = 'include/payment_barclay.php';
$helper['banka']['barclaycard']['username']['info'] = 'Barclaycard PSPID değerini girin.';
$helper['banka']['barclaycard']['password']['info'] = 'Barclaycard ShaInPass değerini girin.';
$helper['banka']['barclaycard']['odemeAciklama']['value'] = 'Barclaycard ile ödemek istiyorum.';

$helper['banka']['bakiyem']['view'] = 'Bakiyem POS (Kredi Kartı)';
$helper['banka']['bakiyem']['bankaAdi']['value'] = 'Bakiyem Pos';
$helper['banka']['bakiyem']['paymentModulURL']['value'] = 'include/payment_moka.php';
$helper['banka']['bakiyem']['modData1']['info'] = 'Test aşamasında bu bölüme sadece TEST yazın.';
$helper['banka']['bakiyem']['username']['info'] = 'Mercant Key bilgisini girin.';
$helper['banka']['bakiyem']['password']['info'] = 'Mercant Password bilgisini girin.';
$helper['banka']['bakiyem']['clientID']['info'] = 'Mercant Client ID bilgisini girin.';
$helper['banka']['bakiyem']['odemeAciklama']['value'] = 'Bakiyem Pos - Kredi kartı ile ödemek istiyorum.';

$helper['banka']['billpro']['view'] = 'BillPro Sanalpos';
$helper['banka']['billpro']['paymentModulURL']['value'] = 'include/payment_BillPro.php';
$helper['banka']['billpro']['bankaAdi']['value'] = 'BillPro sanalpos';
$helper['banka']['billpro']['username']['info'] = 'BillPro kullanıcı adı (account ID) bilgisini girin.';
$helper['banka']['billpro']['password']['info'] = 'BillPro şifre (authcode) bilgisini girin.';
$helper['banka']['billpro']['odemeAciklama']['value'] = 'Kredi Kartı (BillPro Sanalpos) ile  ödemek istiyorum.';

$helper['banka']['birlesik']['view'] = 'Birleşik Ödeme';
$helper['banka']['birlesik']['bankaAdi']['value'] = 'Birleşik Ödeme';
$helper['banka']['birlesik']['paymentModulURL']['value'] = 'include/payment_birlesik.php';
$helper['banka']['birlesik']['clientID']['info'] = 'Birleşik Ödeme Merchant ID değerini girin.';
$helper['banka']['birlesik']['username']['info'] = 'Birleşik Ödeme E-posta adresini girin.';
$helper['banka']['birlesik']['password']['info'] = 'Birleşik Ödeme Şifre değerini girin.';
$helper['banka']['birlesik']['modData1']['info'] = 'Birleşik Ödeme API Key değerini girin.';

$helper['banka']['birlesik']['odemeAciklama']['value'] = 'Kredi kartı ile ödemek istiyorum.';

$helper['banka']['birodeme']['view'] = 'Bir Ödeme';
$helper['banka']['birodeme']['bankaAdi']['value'] = 'Bir Ödeme';
$helper['banka']['birodeme']['paymentModulURL']['value'] = 'include/payment_birodeme.php';
$helper['banka']['birodeme']['clientID']['info'] = 'Bir Ödeme müşteri ID değerini girin.';
$helper['banka']['birodeme']['odemeAciklama']['value'] = 'Birodeme.com ile ödemek istiyorum.';

$helper['banka']['buluttahsilat']['view'] = 'Bulut Tahsilat';
$helper['banka']['buluttahsilat']['bankaAdi']['value'] = 'Bulut Tahsilat';
$helper['banka']['buluttahsilat']['paymentModulURL']['value'] = 'include/payment_BulutTahsilat.php';
$helper['banka']['buluttahsilat']['clientID']['info'] = 'Bulut Tahsilat Firma API Code değerini girin.';
$helper['banka']['buluttahsilat']['username']['info'] = 'Bulut Tahsilat Kullanıcı Adı değerini girin.';
$helper['banka']['buluttahsilat']['password']['info'] = 'Bulut Tahsilat Şifre değerini girin.';
$helper['banka']['buluttahsilat']['modData1']['info'] = 'Bulut Tahsilat Firm Code değerini girin.';
$helper['banka']['buluttahsilat']['odemeAciklama']['value'] = 'Kredi kartım ile ödemek istiyorum.';

$helper['banka']['compay']['view'] = 'Com Pay';
$helper['banka']['compay']['bankaAdi']['value'] = 'Com Pay';
$helper['banka']['compay']['paymentModulURL']['value'] = 'include/payment_Compay.php';
$helper['banka']['compay']['clientID']['info'] = 'Com Pay Direct MüşteriID (merchant_id) değerini girin.';
$helper['banka']['compay']['password']['info'] = 'Com Pay Store Key değerini girin.';
$helper['banka']['compay']['postURL']['value'] = 'https://test.compaypayment.com/integration/app/comPayGate';


$helper['banka']['dskdirect']['view'] = 'DSK Direct';
$helper['banka']['dskdirect']['bankaAdi']['value'] = 'DSK Direct';
$helper['banka']['dskdirect']['paymentModulURL']['value'] = 'include/payment_dsk.php';
$helper['banka']['dskdirect']['clientID']['info'] = 'DSK Direct MüşteriID (merchant_id) değerini girin.';
$helper['banka']['dskdirect']['postURL']['value'] = 'https://www.dskdirect.bg/e-commerce/default.aspx?xml_id=/bg-BG/.CardPayments/';

$helper['banka']['havale']['view'] = 'Havale ile Ödeme';
$helper['banka']['havale']['bankaAdi']['value'] = 'Havale ile Ödeme';
$helper['banka']['havale']['odemeAciklama']['value'] = 'Ödemeyi Banka Havalesi / EFT ile yapmak istiyorum.';
$helper['banka']['havale']['onayAciklama']['info'] = 'Onay açıklamasında {%SIPARIS_NO%} ve {%HAVALE_BILGILERI%} gibi makroları kullanabilirsiniz.';
$helper['banka']['havale']['paymentModulURL']['value'] = 'include/payment_havale.php';

$helper['banka']['eroyal']['view'] = 'E-Royal';
$helper['banka']['eroyal']['bankaAdi']['value'] = 'E-Royal';
$helper['banka']['eroyal']['paymentModulURL']['value'] = 'include/payment_eroyal.php';
$helper['banka']['eroyal']['username']['info'] = 'E-Royal Kullanıcı adı (Acount) değerini girin.';
$helper['banka']['eroyal']['password']['info'] = 'E-Royal sanalpos Şifre değerini girin.';
$helper['banka']['eroyal']['odemeAciklama']['value'] = 'E-Royal ile ödemek istiyorum.';

$helper['banka']['edenred']['view'] = 'Edenred ile Öde';
$helper['banka']['edenred']['bankaAdi']['value'] = 'edenred';
$helper['banka']['edenred']['paymentModulURL']['value'] = 'include/payment_Edenred.php';
$helper['banka']['edenred']['clientID']['info'] = 'Edenred Merchant No değerini girin. (IPN için)';
$helper['banka']['edenred']['username']['info'] = 'Edenred Terminal No değerini girin.';
$helper['banka']['edenred']['password']['info'] = 'Edenred Secret Key girin.';
$helper['banka']['edenred']['modData1']['info'] = 'Edenred Hash Key değerini girin.';
$helper['banka']['edenred']['postURL']['value'] = 'https://vpos-api-test.edenred.com.tr/api/Sales/Start';
$helper['banka']['edenred']['postURL']['info'] = 'Otomatik girilen adres test adresidir.';
$helper['banka']['edenred']['odemeAciklama']['value'] = 'Edenred kart ile ödemek istiyorum.';

$helper['banka']['erpapay']['view'] = 'Erpa pay';
$helper['banka']['erpapay']['bankaAdi']['value'] = 'Erpa Pay';
$helper['banka']['erpapay']['paymentModulURL']['value'] = 'include/payment_Erpapay.php';
$helper['banka']['erpapay']['clientID']['info'] = 'Erpa Pay MerchantId değerini girin.';
$helper['banka']['erpapay']['password']['info'] = 'Erpa Pay Secret Key değerini girin.';
$helper['banka']['erpapay']['odemeAciklama']['value'] = 'Kredi Kartı ile ödemek istiyorum.';

$helper['banka']['esnek']['view'] = 'Esnek Pos';
$helper['banka']['esnek']['bankaAdi']['value'] = 'Esnek Pos';
$helper['banka']['esnek']['paymentModulURL']['value'] = 'include/payment_esnek.php';
$helper['banka']['esnek']['clientID']['info'] = 'Esnek Pos Mağaza Numarası değerini girin.';
$helper['banka']['esnek']['username']['info'] = 'Esnek Pos Mağaza Parolası değerini girin.';
$helper['banka']['esnek']['password']['info'] = 'Esnek Pos Mağaza Gizli Anahtar değerini girin.';
$helper['banka']['esnek']['odemeAciklama']['value'] = 'Esnek Pos ile ödemek istiyorum.';

$helper['banka']['genpa']['view'] = 'Genpa Sanalpos';
$helper['banka']['genpa']['bankaAdi']['value'] = 'Genpa sanalpos';
$helper['banka']['genpa']['paymentModulURL']['value'] = 'include/payment_Genpa.php';
$helper['banka']['genpa']['clientID']['info'] = 'Genpa sanalpos userID bilgisini girin.';
$helper['banka']['genpa']['username']['info'] = 'Genpa sanalpos Kullanıcı adı değerini girin.';
$helper['banka']['genpa']['password']['info'] = 'Genpa sanalpos Şifre değerini girin.';
$helper['banka']['genpa']['modData1']['info'] = 'Genpa sanalpos accountId (ykb-9 finans-8 asya-5 vkf-10) bilgisini girin.';
$helper['banka']['genpa']['modData2']['info'] = 'Genpa sanalpos storeID bilgisini girin.';
$helper['banka']['genpa']['modData3']['info'] = 'Genpa sanalpos bankName ID bilgisini girin. (Genpa Excel olarak gönderdiği dosyadan banka ID numarasını görebilirsiniz.).';
$helper['banka']['genpa']['odemeAciklama']['value'] = 'Genpa sanalpos ile ödemek istiyorum.';

$helper['banka']['gpay']['view'] = 'GPay Sanalpos';
$helper['banka']['gpay']['bankaAdi']['value'] = 'Genpa sanalpos';
$helper['banka']['gpay']['paymentModulURL']['value'] = 'include/payment_gpay.php';
$helper['banka']['gpay']['username']['info'] = 'Genpa sanalpos Kullanıcı adı değerini girin.';
$helper['banka']['gpay']['password']['info'] = 'Genpa sanalpos Bayi Anahtar Kodu değerini girin.';
$helper['banka']['gpay']['odemeAciklama']['value'] = 'Kredi kartı ile ödemek istiyorum.';

$helper['banka']['kvk3d']['view'] = 'KVK 3D Sanalpos';
$helper['banka']['kvk3d']['bankaAdi']['value'] = 'KVK 3D sanalpos';
$helper['banka']['kvk3d']['paymentModulURL']['value'] = 'include/payment_KVK3D.php';
$helper['banka']['kvk3d']['clientID']['info'] = 'KVK 3D Müşteri Kodu bilgisini girin.';
$helper['banka']['kvk3d']['username']['info'] = 'KVK 3D Kullanıcı kodu değerini girin.';
$helper['banka']['kvk3d']['password']['info'] = 'KVK 3D Kullanıcı Şifre değerini girin.';
$helper['banka']['kvk3d']['odemeAciklama']['value'] = 'KVK 3D sanalpos ile ödemek istiyorum.';

$helper['banka']['kapida']['view'] = 'Kapıda Ödeme';
$helper['banka']['kapida']['bankaAdi']['value'] = 'Kapıda Ödeme';
$helper['banka']['kapida']['odemeAciklama']['value'] = 'Ödemeyi kapıda nakit / kredi kartı ile yapmak istiyorum.';
$helper['banka']['genpa']['modData1']['info'] = 'SMS İle onay yapılması için 1 girin, yoksa boş bırakın.';
$helper['banka']['kapida']['paymentModulURL']['value'] = 'include/payment_Kapida.php';

$helper['banka']['klarna']['view'] = 'Klarna';
$helper['banka']['klarna']['bankaAdi']['value'] = 'Kalrna';
$helper['banka']['klarna']['paymentModulURL']['value'] = 'include/payment_Klarna.php';
$helper['banka']['klarna']['username']['info'] = 'Klarna API Username değerini girin.';
$helper['banka']['klarna']['password']['info'] = 'Klarna API Password değerini girin.';
$helper['banka']['klarna']['odemeAciklama']['value'] = 'Kalrna ile ödemek istiyorum.';

$helper['banka']['mailorder']['view'] = 'Mail Order';
$helper['banka']['mailorder']['bankaAdi']['value'] = 'Mail Order';
$helper['banka']['mailorder']['odemeAciklama']['value'] = 'Kredi Kartı ile ödemek istiyorum.';
$helper['banka']['mailorder']['paymentModulURL']['value'] = 'include/payment_MailOrder.php';

$helper['banka']['mobilodememk']['view'] = 'Mikro Ödeme (Kredi Kartı)';
$helper['banka']['mobilodememk']['bankaAdi']['value'] = 'Mikro Ödeme';
$helper['banka']['mobilodememk']['paymentModulURL']['value'] = 'include/payment_MOBILmikrokredi.php';
$helper['banka']['mobilodememk']['clientID']['info'] = 'Mobil Ödeme UserCode bilgisini girin.';
$helper['banka']['mobilodememk']['username']['info'] = 'Mobil Ödeme Pin bilgisini girin.';
$helper['banka']['mobilodememk']['odemeAciklama']['value'] = 'Mikro Ödeme - Kredi kartı ile ödemek istiyorum.';

$helper['banka']['mobilodememo']['view'] = 'Mobil Ödeme (Mikro ödeme)';
$helper['banka']['mobilodememo']['bankaAdi']['value'] = 'Mobil Ödeme';
$helper['banka']['mobilodememo']['paymentModulURL']['value'] = 'include/payment_MOBILmikroodeme.php';
$helper['banka']['mobilodememo']['clientID']['info'] = 'Mobil Ödeme UserCode bilgisini girin.';
$helper['banka']['mobilodememo']['username']['info'] = 'Mobil Ödeme Pin bilgisini girin.';
$helper['banka']['mobilodememo']['odemeAciklama']['value'] = 'Cep Telefonumdan Mesaj ile ödemek istiyorum.';

$helper['banka']['mobilpayguru']['view'] = 'Mobil Ödeme (Payguru)';
$helper['banka']['mobilpayguru']['bankaAdi']['value'] = 'Mobil Ödeme';
$helper['banka']['mobilpayguru']['paymentModulURL']['value'] = 'include/payment_MOBILpayguru.php';
$helper['banka']['mobilpayguru']['username']['info'] = 'Mobil Ödeme MerchantID bilgisini girin.';
$helper['banka']['mobilpayguru']['password']['info'] = 'Mobil Ödeme Secret Key bilgisini girin.';
$helper['banka']['mobilpayguru']['modData1']['info'] = 'Mobil Ödeme ServiceID bilgisini girin.';
$helper['banka']['mobilpayguru']['modData2']['info'] = 'Mobil Ödeme CATEGORY bilgisini girin.';
$helper['banka']['mobilpayguru']['odemeAciklama']['value'] = 'Cep Telefonumdan Mesaj ile ödemek istiyorum.';

$helper['banka']['wirecardSMS']['view'] = 'Mobil Ödeme (WireCard)';
$helper['banka']['wirecardSMS']['bankaAdi']['value'] = 'Kredi Kartı ile Ödeme';
$helper['banka']['wirecardSMS']['paymentModulURL']['value'] = 'include/payment_wirecardSMS.php';
$helper['banka']['wirecardSMS']['clientID']['info'] = 'Mobil Ödeme UserCode bilgisini girin.';
$helper['banka']['wirecardSMS']['username']['info'] = 'Mobil Ödeme Pin bilgisini girin.';
$helper['banka']['wirecardSMS']['odemeAciklama']['value'] = 'SMS ile ödemek istiyorum.';

$helper['banka']['mokapos']['view'] = 'Moka POS (Kredi Kartı)';
$helper['banka']['mokapos']['bankaAdi']['value'] = 'Moka Pos';
$helper['banka']['mokapos']['paymentModulURL']['value'] = 'include/payment_moka.php';
$helper['banka']['mokapos']['modData1']['info'] = 'Test aşamasında bu bölüme sadece TEST yazın.';
$helper['banka']['mokapos']['username']['info'] = 'Mercant Key bilgisini girin.';
$helper['banka']['mokapos']['password']['info'] = 'Mercant Password bilgisini girin.';
$helper['banka']['mokapos']['clientID']['info'] = 'Mercant Client ID bilgisini girin.';
$helper['banka']['mokapos']['odemeAciklama']['value'] = 'Moka Pos - Kredi kartı ile ödemek istiyorum.';

$helper['banka']['moneybookers']['view'] = 'Moneybookers';
$helper['banka']['moneybookers']['bankaAdi']['value'] = 'Moneybookers';
$helper['banka']['moneybookers']['paymentModulURL']['value'] = 'include/payment_moneybookers.php';
$helper['banka']['moneybookers']['clientID']['info'] = 'Moneybookers e-posta adresinizi girin.';
$helper['banka']['moneybookers']['odemeAciklama']['value'] = 'Moneybookers ile ödemek istiyorum.';

$helper['banka']['fort7pay']['view'] = 'Fort7pay';
$helper['banka']['fort7pay']['bankaAdi']['value'] = 'Fort7pay';
$helper['banka']['fort7pay']['paymentModulURL']['value'] = 'include/payment_fort7pay.php';
$helper['banka']['fort7pay']['username']['info'] = 'Fort7pay accountID değerini girin.';
$helper['banka']['fort7pay']['password']['info'] = 'Fort7pay password (şifre) girin.';
$helper['banka']['fort7pay']['odemeAciklama']['value'] = 'Fort7pay ile ödemek istiyorum.';

$helper['banka']['ipara']['view'] = 'iPara';
$helper['banka']['ipara']['bankaAdi']['value'] = 'iPara';
$helper['banka']['ipara']['paymentModulURL']['value'] = 'include/payment_ipara.php';
$helper['banka']['ipara']['username']['info'] = 'iPara public key kodunuzu girin.';
$helper['banka']['ipara']['password']['info'] = 'iPara private key kodunuzu girin.';
$helper['banka']['ipara']['modData1']['info'] = 'Sadece TEST aşamasında buraya test yazın. Gerçek aşamada boş bırakın.';
$helper['banka']['ipara']['odemeAciklama']['value'] = 'iPara ile ödemek istiyorum.';
/*
$helper['banka']['iyziv3']['view'] = 'iyzico ile Öde';
$helper['banka']['iyziv3']['bankaAdi']['value'] = 'iyzico';
$helper['banka']['iyziv3']['bankaAdi']['info'] = 'Önemli : Iyzico Panelinden Notify URL adresini (Settings / Merchant Settings / Merchant Notification URL) "https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'ipn.php?bank=iyzico" olarak set edin.';
$helper['banka']['iyziv3']['paymentModulURL']['value'] = 'include/payment_iyzipay.php';
$helper['banka']['iyziv3']['clientID']['info'] = 'iyzico Merhant ID değerini girin. (IPN için)';
$helper['banka']['iyziv3']['username']['info'] = 'iyzico APP Key değerini girin.';
$helper['banka']['iyziv3']['password']['info'] = 'iyzico Secret Key girin.';
$helper['banka']['iyziv3']['odemeAciklama']['value'] = 'iyzico ile ödemek istiyorum.';
*/

$helper['banka']['iyziv3']['view'] = 'iyzico - Auto Form';
$helper['banka']['iyziv3']['bankaAdi']['value'] = 'iyzico';
$helper['banka']['iyziv3']['bankaAdi']['info'] = 'Önemli : Iyzico Panelinden Notify URL adresini (Settings / Merchant Settings / Merchant Notification URL) "https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'ipn.php?bank=iyzico" olarak set edin.';
$helper['banka']['iyziv3']['paymentModulURL']['value'] = 'include/payment_iyziv3.php';
$helper['banka']['iyziv3']['clientID']['info'] = 'iyzico Merhant ID değerini girin. (IPN için)';
$helper['banka']['iyziv3']['username']['info'] = 'iyzico APP Key değerini girin.';
$helper['banka']['iyziv3']['password']['info'] = 'iyzico Secret Key girin.';
$helper['banka']['iyziv3']['modData1']['info'] = 'Buraya popup veya responsive değerlerinden birini girebilirsiniz. popup girerseniz, Popup olarak gelen hazır ekran, responsive girerseniz, klasik form olarak gelecen hazır ekran yüklenir.';
$helper['banka']['iyziv3']['modData2']['info'] = 'Vade oranlarının iyzico dan otomatik çekilmesini isterseniz gireceğiniz bu banka girişini, listeleme ekranından kopyala diyedek çoğaltın ve bu alana ilgili banka kodunu girin. Iyzico otomatik vade güncelleme buttonu, bankayı kaydettikten sonra gözükecektir.<br /><br />64 : İş Bankası (Maximum) - 111 : Finansbank (Cardfinans) - 12 : Halk Bankası (Paraf) - 15 : Vakıfbank (World) - 46 : Akbank (Axess) - 134 : Denizbank (Bonus) - 10 : Ziraat Bankası.';
$helper['banka']['iyziv3']['odemeAciklama']['value'] = 'iyzico ile ödemek istiyorum.';

$helper['banka']['iyziv3c']['view'] = 'iyzico - Custom From';
$helper['banka']['iyziv3c']['bankaAdi']['value'] = 'iyzico';
$helper['banka']['iyziv3c']['bankaAdi']['info'] = 'Önemli : Iyzico Panelinden Notify URL adresini (Settings / Merchant Settings / Merchant Notification URL) "https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'ipn.php?bank=iyzico" olarak set edin.';
$helper['banka']['iyziv3c']['clientID']['info'] = 'iyzico Merhant ID değerini girin. (IPN için)';
$helper['banka']['iyziv3c']['paymentModulURL']['value'] = 'include/payment_iyziv3custom.php';
$helper['banka']['iyziv3c']['username']['info'] = 'iyzico APP Key değerini girin.';
$helper['banka']['iyziv3c']['password']['info'] = 'iyzico Secret Key girin.';
$helper['banka']['iyziv3c']['modData2']['info'] = 'Vade oranlarının iyzico dan otomatik çekilmesini isterseniz gireceğiniz bu banka girişini, listeleme ekranından kopyala diyedek çoğaltın ve bu alana ilgili banka kodunu girin. Iyzico otomatik vade güncelleme buttonu, bankayı kaydettikten sonra gözükecektir.<br /><br />64 : İş Bankası (Maximum) - 111 : Finansbank (Cardfinans) - 12 : Halk Bankası (Paraf) - 15 : Vakıfbank (World) - 46 : Akbank (Axess) - 134 : Denizbank (Bonus) - 10 : Ziraat Bankası.';
$helper['banka']['iyziv3c']['odemeAciklama']['value'] = 'iyzico ile ödemek istiyorum.';


$helper['banka']['metropol']['view'] = 'Metropol Card';
$helper['banka']['metropol']['bankaAdi']['value'] = 'Metropol Card';
$helper['banka']['metropol']['paymentModulURL']['value'] = 'include/payment_Metropol.php';
$helper['banka']['metropol']['clientID']['info'] = 'Metropol Card Merchant ID (İşyeri) değerini girin.';
$helper['banka']['metropol']['username']['info'] = 'Metropol Card Terminal ID değerini girin.';
$helper['banka']['metropol']['password']['info'] = 'Metropol Card  Access Salt Key (Password) değerini girin.';
$helper['banka']['metropol']['modData1']['info'] = 'Metropol Card Consumer Id değerini girin.';
$helper['banka']['metropol']['modData2']['info'] = 'Metropol Card User Name değerini girin.';
$helper['banka']['metropol']['modData3']['info'] = 'Metropol Card Ref No değerini girin.';
$helper['banka']['metropol']['modData4']['info'] = 'Metropol Card Access Key değerini girin.';
$helper['banka']['metropol']['odemeAciklama']['value'] = 'Metropol Card ile ödemek istiyorum.';


$helper['banka']['mollie']['view'] = 'Mollie';
$helper['banka']['mollie']['bankaAdi']['value'] = 'Mollie';
$helper['banka']['mollie']['paymentModulURL']['value'] = 'include/payment_mollie.php';
$helper['banka']['mollie']['clientID']['info'] = 'Mollie API Key değerini girin.';
$helper['banka']['mollie']['odemeAciklama']['value'] = 'Mollie Pos ile ödemek istiyorum.';

$helper['banka']['next']['view'] = 'Next Sanal Pos';
$helper['banka']['next']['bankaAdi']['value'] = 'Next Sanal Pos';
$helper['banka']['next']['paymentModulURL']['value'] = 'include/payment_next.php';
$helper['banka']['next']['clientID']['info'] = 'Next Bayi ID değerini girin.';
$helper['banka']['next']['username']['info'] = 'Next Altbayi ID değerini girin.';
$helper['banka']['next']['modData1']['info'] = 'Next Banka ID değerini girin. (Garanti Bankası 1,FinansBank 2,Yapı Kredi Bankası 3,Bank Asya 6,İş Bankası 7,Halk Bankası 8,AkBank 9, Citi Bank 11)';
$helper['banka']['next']['odemeAciklama']['value'] = 'Next Sanal Pos ile ödemek istiyorum.';

$helper['banka']['netahsilat']['view'] = 'Netahsilat Sanal Pos';
$helper['banka']['netahsilat']['bankaAdi']['value'] = 'Netahsilat Sanal Pos';
$helper['banka']['netahsilat']['paymentModulURL']['value'] = 'include/payment_Netahsilat3D.php';
$helper['banka']['netahsilat']['username']['info'] = 'Netahsilat kullanıcı adı değerini girin.';
$helper['banka']['netahsilat']['password']['info'] = 'Netahsilat şifre değerini girin.';
$helper['banka']['netahsilat']['modData1']['info'] = 'Netahsilat Banka ID değerini girin. (AkBank 1, Yapıkredi 2,Garanti Bankası 3 ...)';
$helper['banka']['netahsilat']['odemeAciklama']['value'] = 'Kredi kartım ile ödemek istiyorum.';


$helper['banka']['octet']['view'] = 'Octet';
$helper['banka']['octet']['bankaAdi']['value'] = 'Octet';
$helper['banka']['octet']['paymentModulURL']['value'] = 'include/payment_Octet.php';
$helper['banka']['octet']['clientID']['info'] = 'Octet partner code değerini girin.';
$helper['banka']['octet']['password']['info'] = 'Octet secret key değerini girin.';
$helper['banka']['octet']['odemeAciklama']['value'] = 'Kredi kartım ile ödemek istiyorum.';

$helper['banka']['paramazing']['view'] = 'Paramazing';
$helper['banka']['paramazing']['bankaAdi']['value'] = 'Paramazing';
$helper['banka']['paramazing']['paymentModulURL']['value'] = 'include/payment_paramazing.php';
$helper['banka']['paramazing']['clientID']['info'] = 'Paramazing marketid değerini girin.';
$helper['banka']['paramazing']['modData1']['info'] = 'Paramazing secret değerini girin.';
$helper['banka']['paramazing']['odemeAciklama']['value'] = 'Paramazing ile ödemek istiyorum.';

$helper['banka']['paratika']['view'] = 'Paratika';
$helper['banka']['paratika']['bankaAdi']['value'] = 'Paratika';
$helper['banka']['paratika']['paymentModulURL']['value'] = 'include/payment_paratika.php';
$helper['banka']['paratika']['clientID']['info'] = 'Paratika MERCHANT değerini girin.';
$helper['banka']['paratika']['username']['info'] = 'Paratika MERCHANTUSER (API user e-posta) değerini girin.';
$helper['banka']['paratika']['password']['info'] = 'Paratika MERCHANTPASSWORD değerini girin.';
$helper['banka']['paratika']['modData1']['info'] = 'Paratika SecretKey değerini girin.';
$helper['banka']['paratika']['odemeAciklama']['value'] = 'Paratika ile ödemek istiyorum.';

$helper['banka']['payeu']['view'] = 'Pay EU';
$helper['banka']['payeu']['bankaAdi']['value'] = 'Pay EU';
$helper['banka']['payeu']['paymentModulURL']['value'] = 'include/payment_payeu.php';
$helper['banka']['payeu']['clientID']['info'] = 'Pay EU müşteri ID değerini girin.';
$helper['banka']['payeu']['modData1']['info'] = 'Pay EU ID değerini girin. (HSBC 1,Akbank 2,Garanti 3,FinansBank 4,Yapı Kredi Bankası 5,Halk Bankası 6,İş Bankası 7)';
$helper['banka']['payeu']['odemeAciklama']['value'] = 'Pay EU ile ödemek istiyorum.';

$helper['banka']['paypal']['view'] = 'Paypal Pro';
$helper['banka']['paypal']['bankaAdi']['value'] = 'Paypal Pro';
$helper['banka']['paypal']['paymentModulURL']['value'] = 'include/payment_paypalx.php';
$helper['banka']['paypal']['clientID']['info'] = 'Paypal Pro paypal e-posta adresinizi girin.';
$helper['banka']['paypal']['username']['info'] = 'Paypal Pro Client ID değerini girin.';
$helper['banka']['paypal']['password']['info'] = 'Paypal Pro Secret değerini girin.';
$helper['banka']['paypal']['odemeAciklama']['value'] = 'Paypal ile ödemek istiyorum.';

$helper['banka']['paypalipn']['view'] = 'Paypal IPN SSL';
$helper['banka']['paypalipn']['bankaAdi']['value'] = 'Paypal IPN';
$helper['banka']['paypalipn']['paymentModulURL']['value'] = 'include/payment_paypalauto.php';
$helper['banka']['paypalipn']['clientID']['info'] = 'Paypal paypal e-posta adresinizi girin.';
$helper['banka']['paypalipn']['odemeAciklama']['value'] = 'Paypal ile ödemek istiyorum.';

$helper['banka']['paymec']['view'] = 'Paymec (Ortak Ödeme Sayfası)';
$helper['banka']['paymec']['bankaAdi']['value'] = 'Paymec';
$helper['banka']['paymec']['paymentModulURL']['value'] = 'include/payment_paymec.php';
$helper['banka']['paymec']['clientID']['info'] = 'Paymec site numaranızı girin.';
$helper['banka']['paymec']['username']['info'] = 'Paymec işyeri anahtar kodunu girin.';
$helper['banka']['paymec']['odemeAciklama']['value'] = 'Paymec ile ödemek istiyorum.';

$helper['banka']['paytr']['view'] = 'PayTR';
$helper['banka']['paytr']['bankaAdi']['value'] = 'PayTR';
$helper['banka']['paytr']['bankaAdi']['info'] = 'Önemli : PayTR Panelinden notify URL adresini "https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'index.php?paytr-ok=true" olarak set edin.';
$helper['banka']['paytr']['paymentModulURL']['value'] = 'include/payment_paytr.php';
$helper['banka']['paytr']['clientID']['info'] = 'PayTR Mağaza No değerini girin.';
$helper['banka']['paytr']['username']['info'] = 'PayTR Mağaza Parola değerini girin.';
$helper['banka']['paytr']['password']['info'] = 'PayTR Mağaza Gizli Anahtar değerini girin.';
$helper['banka']['paytr']['modData1']['info'] = 'PayTR Token (PayTR Taksit Ayarlar altındaki Taksit Token) değerini girin.';
$helper['banka']['paytr']['modData2']['info'] = 'PayTR Taksit desteği kapansım mı? (0: Hayır, 1 Evet)';
$helper['banka']['paytr']['odemeAciklama']['value'] = 'PayTR ile ödemek istiyorum.';

$helper['banka']['payu']['view'] = 'Payu (Ortak Ödeme Sayfası)';
$helper['banka']['payu']['bankaAdi']['value'] = 'Payu';
$helper['banka']['payu']['bankaAdi']['info'] = 'Önemli : Payu panelinden notify URL adresini "https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'ipn.php?bank=payu" olarak set edin.';
$helper['banka']['payu']['paymentModulURL']['value'] = 'include/payment_payu.php';
$helper['banka']['payu']['username']['info'] = 'Payu müşteri kodunuzu (İşyeri entegrasyon ismi) girin.';
$helper['banka']['payu']['password']['info'] = 'Payu şifrenizi (Kodlama anahtarı) girin.';
$helper['banka']['payu']['odemeAciklama']['value'] = 'Payu ile ödemek istiyorum.';

$helper['banka']['payualu']['view'] = 'Payu (Site İçerisinden Ödeme - ALU)';
$helper['banka']['payualu']['bankaAdi']['info'] = 'Önemli <br />1 : PayU firmasından "ORDER_REF" değerini dönüş değeleri içerisinde açılmasını talep edin.<br />2 : Payu panelinden notify URL adresini "https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'ipn.php?bank=payu" olarak set edin.';
$helper['banka']['payualu']['bankaAdi']['value'] = 'Payu';
$helper['banka']['payualu']['paymentModulURL']['value'] = 'include/payment_payualu.php';
$helper['banka']['payualu']['username']['info'] = 'Payu müşteri kodunuzu (İşyeri entegrasyon ismi) girin.';
$helper['banka']['payualu']['password']['info'] = 'Payu şifrenizi (Kodlama anahtarı) girin.';
$helper['banka']['payualu']['odemeAciklama']['value'] = 'Payu ile ödemek istiyorum.';

$helper['banka']['payueu']['view'] = 'Payu Avrupa (EU)';
$helper['banka']['payueu']['bankaAdi']['value'] = 'Payu';
$helper['banka']['payueu']['paymentModulURL']['value'] = 'include/payment_payueu.php';
$helper['banka']['payueu']['clientID']['info'] = 'Payu Oauth Client Id değerini girin.';
$helper['banka']['payueu']['username']['info'] = 'Payu Merchant Pos Id değerini girin.';
$helper['banka']['payueu']['password']['info'] = 'Payu Signature Key değerini girin.';
$helper['banka']['payueu']['modData1']['info'] = 'Payu Oauth Client Secret değerini girin.';
$helper['banka']['payueu']['modData2']['info'] = 'Test ortamı için buraya test yazın.';
$helper['banka']['payueu']['odemeAciklama']['value'] = 'Payu ile ödemek istiyorum.';

$helper['banka']['paytrek']['view'] = 'Paytrek';
$helper['banka']['paytrek']['bankaAdi']['value'] = 'Paytrek';
$helper['banka']['paytrek']['postURL']['value'] = 'https://secure.paytrek.com.tr/api/v2/direct_charge/';
$helper['banka']['paytrek']['paymentModulURL']['value'] = 'include/payment_paytrek.php';
$helper['banka']['paytrek']['username']['info'] = 'Paytrek API Key deperini girin.';
$helper['banka']['paytrek']['password']['info'] = 'Paytrek API Password değerini girin.';
$helper['banka']['paytrek']['odemeAciklama']['value'] = 'Paytrek ile ödemek istiyorum.';

$helper['banka']['posnetodeme']['view'] = 'Posnet Ödeme';
$helper['banka']['posnetodeme']['bankaAdi']['value'] = 'Posnet Ödeme';
$helper['banka']['posnetodeme']['paymentModulURL']['value'] = 'include/payment_posnetodeme.php';
$helper['banka']['posnetodeme']['clientID']['info'] = 'Posnetödeme cari numaranızı girin.';
$helper['banka']['posnetodeme']['odemeAciklama']['value'] = 'Kredi Kartı (Ponsetodeme) ile ödemek istiyorum.';

$helper['banka']['spturk']['view'] = 'Sanal Pos Türk';
$helper['banka']['spturk']['bankaAdi']['value'] = 'Sanal Post Türk';
$helper['banka']['spturk']['paymentModulURL']['value'] = 'include/payment_spturk.php';
$helper['banka']['spturk']['username']['info'] = 'Sanal Pos Türk API KEY değerini girin.';
$helper['banka']['spturk']['password']['info'] = 'Sanal Pos Türk API şifre değerini girin.';
$helper['banka']['spturk']['odemeAciklama']['value'] = 'Sanal Pos Türk ile ödemek istiyorum.';

$helper['banka']['senet']['view'] = 'Senet ile Ödeme';
$helper['banka']['senet']['bankaAdi']['value'] = 'Senet';
$helper['banka']['senet']['paymentModulURL']['value'] = 'include/payment_senet.php';
$helper['banka']['senet']['odemeAciklama']['value'] = 'Senet ile ödemek istiyorum.';

$helper['banka']['segment']['view'] = 'Segment Bilgisayar';
$helper['banka']['segment']['bankaAdi']['value'] = 'Segment Bilgisayar';
$helper['banka']['segment']['paymentModulURL']['value'] = 'include/payment_Segment.php';
$helper['banka']['segment']['clientID']['info'] = 'Segment Bilgisayar Cari Kod değerini girin.';
$helper['banka']['segment']['modData1']['info'] = 'Segment Bilgisayar ID (Banka ID) Değerini girin. (1 -> Axcess (Ak Bankası), 2 -> World Card (Yapıkredi Bankası), 3 -> Maximum (İş Bankası), 4 -> Card Finans (Finans Bankası), 5 -> Bonus (Garanti Bankası), 6 -> VakıfCard+World (VakıfBank), 7 -> Advantage (HSBC Bankası), 8 -> Asya Kart (Bank Asya), 9 -> CitiCard (Citibank), 11 -> Türkiye Finans (Türkiye Finans Bank))';
$helper['banka']['segment']['odemeAciklama']['value'] = 'Kredi Kartı ile ödemek istiyorum.';

$helper['banka']['sipay3D']['view'] = 'SiPay 3D';
$helper['banka']['sipay3D']['bankaAdi']['value'] = 'SiPay 3D';
$helper['banka']['sipay3D']['clientID']['info'] = 'SiPay Merchant Key bilgisini girin.';
$helper['banka']['sipay3D']['paymentModulURL']['value'] = 'include/payment_Sipay.php';
$helper['banka']['sipay3D']['odemeAciklama']['value'] = 'Kredi kartı ile ödemek istiyorum.';

$helper['banka']['sipay3Dcustom']['view'] = 'SiPay 3D - Custom Form';
$helper['banka']['sipay3Dcustom']['bankaAdi']['value'] = 'SiPay 3D';
$helper['banka']['sipay3Dcustom']['clientID']['info'] = 'SiPay Merchant Key bilgisini girin.';
$helper['banka']['sipay3Dcustom']['password']['info'] = 'SiPay App Secret bilgisini girin.';
$helper['banka']['sipay3Dcustom']['paymentModulURL']['value'] = 'include/payment_SipayCustom.php';
$helper['banka']['sipay3Dcustom']['odemeAciklama']['value'] = 'Kredi kartı ile ödemek istiyorum.';


$helper['banka']['shopier']['view'] = 'Shopier';
$helper['banka']['shopier']['bankaAdi']['value'] = 'Shopier';
$helper['banka']['iyziv3']['bankaAdi']['info'] = 'Önemli : Shopier Entegrasyonlar / Sipariş Bildirimi Panelinden,  Bildirim URL adresini "https://' . $_SERVER['HTTP_HOST'] . $siteDizini . 'ipn.php?bank=shopier" olarak set edin.';
$helper['banka']['shopier']['paymentModulURL']['value'] = 'include/payment_shopier.php';
$helper['banka']['shopier']['username']['info'] = 'Shopier Username değerini girin.';
$helper['banka']['shopier']['modData1']['info'] = 'Shopier KEY değerini girin.';
$helper['banka']['shopier']['modData2']['info'] = 'Shopier Secret değerini girin.';
$helper['banka']['shopier']['clientID']['info'] = 'Shopier OSB Kullanıcı Adı değerini girin.';
$helper['banka']['shopier']['modData3']['info'] = 'Shopier OSB Şifre değerini girin.';
$helper['banka']['shopier']['odemeAciklama']['value'] = 'Kredi Kartı ile ödemek istiyorum.';


$helper['banka']['telpa3d']['view'] = 'Telpa 3D Sanal Pos';
$helper['banka']['telpa3d']['bankaAdi']['value'] = 'Telpa 3D Sanal Pos';
$helper['banka']['telpa3d']['paymentModulURL']['value'] = 'include/payment_telpa3D.php';
$helper['banka']['telpa3d']['clientID']['info'] = 'Bayi kodunuzu girin.';
$helper['banka']['telpa3d']['odemeAciklama']['value'] = 'Telpa 3D Sanal Pos ile ödemek istiyorum.';

$helper['banka']['turkpos']['view'] = 'ParamPOS / TurkPOS';
$helper['banka']['turkpos']['bankaAdi']['value'] = 'ParamPOS';
$helper['banka']['turkpos']['paymentModulURL']['value'] = 'include/payment_Turkpos.php';
$helper['banka']['turkpos']['clientID']['info'] = 'ParamPOS Client ID değerini girin.';
$helper['banka']['turkpos']['username']['info'] = 'ParamPOS Kullanıcı adı değerini girin.';
$helper['banka']['turkpos']['password']['info'] = 'ParamPOS Şifre değerini girin.';
$helper['banka']['turkpos']['modData1']['info'] = 'ParamPOS Sanalpos ID (Banka ID) Değerini girin. (1008:Combo, 1009:World Card, 1018:Param, 1028: Maximum, 1029: Diğer, 1011:CardFinans, 1012:Paraf, 1013:Bonus, 1014 Axess, 1052: Saglam)';
$helper['banka']['turkpos']['modData2']['info'] = 'ParamPOS Anahtar (GUID) Değerini girin.';
$helper['banka']['turkpos']['odemeAciklama']['value'] = 'ParamPOS ile ödemek istiyorum.';

$helper['banka']['setcard']['view'] = 'Set Card';
$helper['banka']['setcard']['bankaAdi']['value'] = 'Set Card';
$helper['banka']['setcard']['paymentModulURL']['value'] = 'include/payment_SetCard.php';
$helper['banka']['setcard']['postURL']['value'] = 'https://api.setcard.com.tr/VirtualPayment';
$helper['banka']['setcard']['clientID']['info'] = 'Set Card Merchant ID değerini girin.';
$helper['banka']['setcard']['username']['info'] = 'Set Card Terminal ID değerini girin.';
$helper['banka']['setcard']['password']['info'] = 'Set Card Store Key değerini girin.';
$helper['banka']['setcard']['odemeAciklama']['value'] = 'Set Card ile ödemek istiyorum.';

$helper['banka']['setcard']['view'] = 'Sodexo';
$helper['banka']['setcard']['bankaAdi']['value'] = 'Sodexo';
$helper['banka']['setcard']['paymentModulURL']['value'] = 'include/payment_Sodexo.php';
$helper['banka']['setcard']['clientID']['info'] = 'Sodexo Merchant No değerini girin.';
$helper['banka']['setcard']['username']['info'] = 'Sodexo API Username değerini girin.';
$helper['banka']['setcard']['password']['info'] = 'Sodexo API Password değerini girin.';
$helper['banka']['setcard']['modData1']['info'] = 'Sodexo Terminal No değerini girin.';
$helper['banka']['setcard']['odemeAciklama']['value'] = 'Sodexo ile ödemek istiyorum.';

$helper['banka']['yuvarla']['view'] = 'Yuvarla.org';
$helper['banka']['yuvarla']['bankaAdi']['value'] = 'Yuvarla.org';
$helper['banka']['yuvarla']['paymentModulURL']['value'] = 'auto_yuvarla';
$helper['banka']['yuvarla']['username']['info'] = 'Yuvarla.org MERCHANT USER değerini girin.  (Bu modülü aktif etmeyin. Sadece kurulum yapılması yeterlidir.)';
$helper['banka']['yuvarla']['password']['info'] = 'Yuvarla.org MERCHANT PASSWORD değerini girin.';

$helper['banka']['']['view'] = '----------------------------------------------------------------------------';

$helper['banka']['cibhu']['view'] = 'CIB - Macaristan';
$helper['banka']['cibhu']['bankaAdi']['value'] = 'CIB';
$helper['banka']['cibhu']['paymentModulURL']['value'] = 'include/payment_CIB-hu.php';
$helper['banka']['cibhu']['clientID']['info'] = 'CIB PID değerini girin.)';
?>