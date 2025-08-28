<div class="col-lg-6 col-md-12 p-0 border-right pr-4 p-relative float-left">

	<div class="form-group d-flex flex-column">
		<label class="m-0" for="card">Kart Üzerindeki Ad Soyad</label>
		<input placeholder="" id="card-name" type="text" class="p-2 rounded border mt-2 card-input" name="kart_isim" />
	</div>
	<div class="form-group d-flex flex-column">
		<label class="m-0" for="card">Kart Numarası</label>
		<input placeholder="" onkeypress="return ccformats(this,event)" onkeyup="return numberValidation(event)" id="card-number" type="text" class="p-2 rounded border mt-2 card-input" name="cardno" />
	</div>
	<div class="form-group d-flex payment-card-form justify-content-between">
		<div class="w-100">
			<label class="m-0" for="date">Son Kullanma Tarihi</label>
			<div class="d-flex justify-content-start">
				<select name="expmonth" id="date-m">
					{%AY%}
				</select>
				<select name="expyear" id="date-y">
					{%YIL%}
				</select>
			</div>
		</div>
		<div class="mx-90px">
			<label class="m-0 cvc-label">CVV <i class="fa fa-info-circle" onclick="$('#cvc-info').slideToggle('fast');"></i><span id="cvc-info">Kartınızın arka tarafında bulunan 3 haneli numara.</span></label>

			<input class="border-box w-100" type="text" maxlength="3" id="card-cvv" onkeyup="return numberValidation(event)" name="cv2" placeholder="" />
		</div>
	</div>
</div>
<div class="col-lg-6 col-md-12 p-0 pl-4 float-left">
	<!--
	<h5>Taksit Seçenekleri</h5>
	<span>Kartınız uygun taksiti seçeneğini seçiniz.</span>-->
	<div class="taksit" id="taksit-view"></div>
	<div id="taksit-select">{%TAKSIT%}</div>
	<script>
		$(document).ready(function(data) {
			ccTaksitGosterim();
		});
	</script>
</div>

<div class="d-flex justify-content-between baska-kart">
	<div>
		<a href="ac/satinal/secim"><u>Ödeme seçimini değiştir.</u></a>
	</div>
</div>