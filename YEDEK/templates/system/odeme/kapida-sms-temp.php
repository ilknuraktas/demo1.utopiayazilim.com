<script>
	$(".siparis-onayla-button").show();
</script>
<div id="pay-screen" class="mb-4 pay-kapide">
	<ul>
		<li><a href="page.php?act=satinal&op=odeme&paytype={%DB_ID%}">Onay kodunu tekrar gönder.</a></li>
		<li><a href="page.php?act=satinal&op=adres">Cep telefonu numaramu değiştirmek istiyorum.</a></li>
	</ul>
	<div class="clear mb-4"></div>
	<div class="col-lg-12 col-md-12 p-0 pr-4 p-relative">

		<div class="form-group d-flex flex-column">
			<label class="m-0 nowrap" for="card">SMS Onay Kodu - {%SIPARIS_CEPTEL%}</label>
			<input placeholder="" type="text" class="p-2 rounded border mt-2 card-input" name="sms_code" />
		</div>
	</div>	
</div>
<div class="baska-kart float-right">
	<div class="mt-4">
		<a href="ac/satinal/secim"><u>Ödeme seçimini değiştir.</u></a>
	</div>
</div>