<?php

$dbase = "siteConfig";

$title = 'Google Ayaları';

$ozellikler = array(

	ekle => '0',

	baseid => 'ID',

	listDisabled => true,

	listBackMsg => 'Kaydedildi',

	editID => 1,

);



$icerik = array(

	array(

		isim => 'Google Rich Snippets Aktif',

		info => 'Ürün, blog ve site içi arama kodlarını içerir.',

		db => 'google_snippets',

		stil => 'checkbox',

		gerekli => '0'

	),

	array(

		isim => 'Google Doğrulama Kodu',

		db => 'google_meta',

		stil => 'normaltext',

		gerekli => '0'

	),

	array(

		isim => 'Google reCAPTCHA API Site Key',

		db => 'google_rSiteKey',

		stil => 'normaltext',

		gerekli => '0'

	),

	array(

		isim => 'Google reCAPTCHA API Secret Key',

		db => 'google_rSecretKey',

		info => 'Sadece "Genel Ayarlar" kısmından, "Form Koruma" olarak "Google reCAPTCHA v2" seçiliyse gereklidir. <a href="https://www.google.com/recaptcha/" target="_blank">https://www.google.com/recaptcha/</a> adresinden "v3 Admin Console" düğmesine tıkladıktans sonra gelen ekrandan + tuşuna tıklayarak, reCAPTCHA Key bilgilerinizi alabilirsiniz.',

		stil => 'normaltext',

		gerekli => '0'

	),

	array(

		isim => 'Google Dinamik Remarketing AW Kodu<br />(Ör : AW-1000000000)',

		db => 'googledynr',

		stil => 'normaltext',

		gerekli => '0'

	),

	array(

		isim => 'Google Tracking UA Kodu<br />(Ör : UA-00000000-1)',

		db => 'javaScript',

		stil => 'normaltext',

		gerekli => '0'

	),

	array(

		isim => 'Google Tracking Conversion ID<br />(Ör : 1010101010)',

		db => 'google_conversion_id',

		stil => 'normaltext',

		gerekli => '0'

	),

	array(

		isim => 'Google Track Purchases Aktif',

		info => '<a href="https://developers.google.com/analytics/devguides/collection/gtagjs/enhanced-ecommerce#1_track_checkout_steps" target="_blank">https://developers.google.com/analytics/devguides/collection/gtagjs/enhanced-ecommerce#1_track_checkout_steps</a>',

		db => 'google_purchases',

		stil => 'checkbox',

		gerekli => '0'

	),

	array(

		isim => 'Google Data Layer Aktif',

		info => 'Önce Google tag manager kodunun "Body İçerisine Eklenti Kodu" kısmına eklenmiş olması gerekir. Bilgi : <a href="https://developers.google.com/tag-manager/enhanced-ecommerce" target="_blank">https://developers.google.com/tag-manager/enhanced-ecommerce</a>',

		db => 'google_datalayer',

		stil => 'checkbox',

		gerekli => '0'

	),

	array(

		isim => 'Google Map Kodu',

		info => 'Javascript ve Div içeriği ile eksiksiz kodu paste edin.',

		db => 'google_map',

		stil => 'textarea',

		style => 'width:100%; height:100px;',

		gerekli => '0'

	),

	array(

		isim => 'Head İçerisine Eklenti Kodu',

		info => 'Head kısmına eklenmesini istediğiniz HTML kodlarını buraya ekleyebilirsiniz.',

		db => 'google_head',

		stil => 'textarea',

		style => 'width:100%; height:100px;',

		gerekli => '0'

	),

	array(

		isim => 'Body İçerisine Eklenti Kodu',

		info => 'Body kısmına (Google analytics, Tag manager, Canlı Destek App Javascript kodu vs.) eklenmesini istediğiniz HTML kodlarını buraya ekleyebilirsiniz.',

		db => 'google_analytics',

		stil => 'textarea',

		style => 'width:100%; height:200px;',

		gerekli => '0'

	),

	array(

		isim => 'Google Remarketing Kodu',

		db => 'google_remarketing',

		stil => 'textarea',

		style => 'width:100%; height:100px;',

		gerekli => '0'

	),

	array(

		isim => 'Google Conversion Kodu (Satış)',

		db => 'google_conversion',

		stil => 'textarea',

		style => 'width:100%; height:100px;',

		info => 'Toplam Tutar (TL) : {%TOTAL%}<br/>Toplam Tutar (Çoklu Dil Sipariş Birimi) :  {%TOTAL_ORG%}<br/>Çoklu Dil Para birimi : {%CURRENCY%}<br />Sipariş ID : {%SIPARIS_NO%} <br /><br />Örnek :<br /> \'value\': {%TOTAL%},<br />\'transaction_id\': \'{%SIPARIS_NO%}\',<br />\'currency\': \'TRY\' ',

		gerekli => '0'

	),

	array(

		isim => 'Google Conversion Kodu (Üyelik)',

		db => 'google_conversionuye',

		stil => 'textarea',

		style => 'width:100%; height:100px;',

		gerekli => '0'

	),

	array(

		isim => 'Google Customer Reviews Merchant ID<br />',

		db => 'googleMerchantID',

		stil => 'normaltext',

		gerekli => '0'

	),

	array(

		isim => 'Google Customer Reviews Rating Badge Aktif',

		db => 'googleCustomerReviewsBadge',

		stil => 'checkbox',

		gerekli => '0'

	),

);

$tempInfo .= adminInfov5('Verimli Google reklamları için bizim ile <a href="https://utopiayazilim.com/iletisim" target="_blank">iletişime</a> geçin.','search');



admin($dbase, $where, $icerik, $ozellikler);

?>