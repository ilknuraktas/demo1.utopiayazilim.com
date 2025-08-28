<script>
	$(".siparis-onayla-button").show();
</script>
<div id="pay-screen" class="mb-4 pay-ac">
	<div class="clear mb-4"></div>
	<div class="col-lg-12 col-md-12 p-0 pr-4 p-relative">

		<div class="form-group d-flex flex-column">
			<label class="m-0 nowrap" for="card">Kart Numarası</label>
			<input placeholder="" onkeypress="return ccformats(this,event)" onkeyup="return numberValidation(event)"  id="card-number" type="text" class="p-2 rounded border mt-2 card-input" name="cardno" />
		</div>
        <div class="form-group d-flex flex-column">
			<label class="m-0 nowrap" for="card">Şifre</label>
			<input placeholder="" type="text" class="p-2 rounded border mt-2 card-input" name="sifre" />
		</div>
	</div>	
</div>
<div class="baska-kart">
	<div class="mt-4">
		<a href="ac/satinal/secim"><u>Ödeme seçimini değiştir.</u></a>
	</div>
</div>