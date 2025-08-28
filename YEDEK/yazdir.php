<?php
include('include/all.php');
if (!$_GET['sipNo'] && $_GET['sipID']) $_GET['sipNo'] = dbInfo('siparis', 'randStr', $_GET['sipID']);
?><html>

<head>
	<title><?= $siparisData['randStr'] ?> Nolu Sipariş Detayları</title>
	<!-- Web Fonts  -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="templates/system/admin/templatev5/assets/css/invoice-bootstrap.css" />

	<!-- Invoice Print Style -->
	<link rel="stylesheet" href="templates/system/admin/templatev5/assets/css/invoice-print.css" />
	<link href="assets/css/sepet.css" rel="stylesheet" type="text/css" />
	<style>

		.basket-left {
			clear: both;
			width: 100% !important;
		}

		.basket-right {
			clear: both;
			float: right;
			margin-top: 15px !important;
		}

		.cart-detail img {
			max-height: 65px;
			max-width: 100px;
		}

		.cart-info h3 {
			padding: 10px;
			color: #000 !important;
			font-size: 12px !important;
		}

		.ib {
			margin-bottom: 30px;
		}

		span.value {
			white-space: nowrap;
		}

		.invoice .bill-data .value {
			width: 120px !important;
		}

		.basket-wrap {
			visibility: visible !important;
		}

		.yazdir-logo {
			max-width: 80%;
		}

		#yazdir {
			float: right;
			margin: 10px;
		}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
	<?
	$q = my_mysql_query("select * from siparis where randStr = '" . $_GET['sipNo'] . "'");
	while ($siparisData = my_mysql_fetch_array($q)) {
		if(md5($siparisData['ID'].'-'.$siparisData['tarih'].'-'.$siparisData['randStr']) != $_GET['c'])
		{
			echo "Hatalı sipariş numarası.";
			break;
		}
		?>
	<page size="A4">
		<div class="invoice">
			<header class="clearfix">
				<div class="row">
					<div class="col-sm-6 mt-md">
						<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">SİPARİŞ BİLGİLERİ</h2>
						<h4 class="h4 m-none text-dark text-weight-bold">#<?= $siparisData['randStr'] ?></h4>
						<img src="include/3rdparty/barcode.php?randStr=<?= $siparisData['randStr'] ?>">
					</div>
					<div class="col-sm-6 text-right mt-md mb-md">
						<address class="ib mr-xlg">
							<?= siteConfig('firma_adi') ?>
							<br />
							<?= siteConfig('firma_adres') ?>
							<br />
							Tel : <?= siteConfig('firma_tel') ?>
							<br />
							<?= (siteConfig('firma_email') ? siteConfig('firma_email') : (siteConfig('iletisimMail') ? siteConfig('iletisimMail') : siteConfig('adminMail'))) ?>

						</address>
						<div class="ib">
							<?= ($siteConfig['templateLogo'] ? '<img class="yazdir-logo" src="images/' . $siteConfig['templateLogo'] . '" alt="' . siteConfig('firma_adi') . ' Sipariş No ' . $siparisData['randStr'] . '" />' : '<h2>' . $_SERVER['HTTP_HOST'] . '</h2>') ?>
						</div>
					</div>
				</div>
			</header>
			<div class="bill-info">
				<p class="mb-none">
					<span class="text-dark">Sipariş Notu :</span>
					<span class="value" style="white-space:normal;"><?= $siparisData['notAlici'] ?></span>
				</p>
				<div class="row">
					<div class="col-md-6">
						<div class="bill-to">
							<p class="mb-xs text-dark text-weight-semibold">Sipariş Adresi :</p>
							<address>
								<?= $siparisData['name'] ?> <?= $siparisData['lastname'] ?>
								<br />
								<?= $siparisData['address'] ?> <?= hq("select name from ilceler where ID='" . $siparisData['semt'] . "'") ?> / <?= hq("select name from iller where plakaID='" . $siparisData['city'] . "'") ?>
								<br />
								Tel : <?= $siparisData['ceptel'] ?> <?= $siparisData['istel'] ?> <?= $siparisData['evtel'] ?>
								<br />
								<?= $siparisData['email'] ?>
							</address>
							<?php
							if ($siparisData['address2']) {
							?>
								<p class="mb-xs text-dark text-weight-semibold">Fatura Adresi :</p>
								<address>
									<?= $siparisData['firmaUnvai'] ?><br /><?= $siparisData['vergiDaire'] ?> / <?= $siparisData['vergiNo'] ? $siparisData['vergiNo'] : $siparisData['tckNo'] ?>
									<br />
									<?= $siparisData['address2'] ?> <?= hq("select name from ilceler where ID='" . $siparisData['semt2'] . "'") ?> / <?= hq("select name from iller where plakaID='" . $siparisData['city2'] . "'") ?>
									<br />
									<?= $siparisData['email'] ?>
								</address>
							<?php
							} ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="bill-data text-right">
							<p class="mb-none">
								<span class="text-dark">Sipariş Tarihi :</span>
								<span class="value"><?= mysqlTarih($siparisData['tarih']) ?></span>
							</p>
							<p class="mb-none">
								<span class="text-dark">Yazdırma Tarihi :</span>
								<span class="value"><?= mysqlTarih(date('Y-m-d')) ?></span>
							</p>
							<p class="mb-none">
								<span class="text-dark">Kargo Firması :</span>
								<span class="value"><?= hq("select name from kargofirma where ID='" . ($siparisData['kargoFirma'] ? $siparisData['kargoFirma'] : $siparisData['kargoFirmaID']) . "'") ?></span>
							</p>

						</div>
					</div>
				</div>
			</div>
			<?= str_replace(array('<a ', '</a>'), array('<a_removed ', '</a_removed>'), showBasket(false, $siparisData['randStr'], false)) ?>
		</div>
		<!--
			<hr />
			<input type="button" id="yazdir" onclick="document.getElementById('yazdir').style.display = 'none'; window.print();" value="Yazdır" />
			-->
	</page>
	<? } ?>
	<script>
		window.print();
	</script>
</body>

</html>