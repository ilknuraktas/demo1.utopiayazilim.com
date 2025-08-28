<table class="urunDetayTable" cellpadding="0" cellspacing="0">
<tbody><tr><td rowspan="3" class="image" valign="top" style="cursor:pointer;"><a class="lightbox" title="{%URUN_BASLIK%}" href="{%URUN_RESIM_SRC_FULLSIZE%}"><img src="{%URUN_RESIM_SRC%}"></a></td>
<td class="urunBaslik">{%URUN_BASLIK%}</td></tr>
<tr><td class="urunKisaAciklama">{%URUN_KISA_ACIKLAMA%}</td></tr>
<tr><td class="urunFiyat" align="right"><br>KDV DAHİL : {%URUN_FIYAT_KDV_DAHIL%} {%URUN_FIYAT2_BIRIM%}<br><span style="font-size: 11px;" id="URUN_FIYAT_KDV_DAHIL_YTL">{%URUN_FIYAT_KDV_DAHIL_YTL%} TL</span>
</td></tr>
</tbody></table><br><table width="100%" cellpadding="0" cellspacing="0"><tbody><tr><td valign="top" width="50%">{%URUN_SECIM%}<br />
<div id="GARANTI_SURESI">Garanti Süresi : {%GARANTI_SURESI%} Ay</div>
</td><td valign="top" width="20%" align="right">{%URUN_TAKSIT_SECENEKLERI%}
</td></tr></tbody></table><div>{%VIDEO%}</div><div class="urunTarih">Ürün kataloğumuza <b>{%URUN_EKLENME_TARIHI%}</b> tarihinde eklenmiştir.</div>
<div class="urunTarih" style="color:red;" id="STOK_DURUM">{%STOK_DURUM%}</div>

<div>{%URUN_KULLANICI_SECENEKLERI%}
	<br>
	<div class="urunMesaj">{%URUN_MESAJ%}</div>
<div class="urunInfo">
	<table cellpadding="0" cellspacing="0"><tbody><tr><td style="padding-right: 6px;" onclick="{%SEPETE_EKLE_LINK%}"><span style="cursor:pointer;"><img src="templates/green/images/form_SepeteAt.gif"></span></td><td onclick="{%HEMEN_AL_LINK%}"><span style="cursor:pointer;"><img src="templates/green/images/form_HemenAl.gif"></span></td></tr></tbody></table>
</div>
<br /><br />{%TAB_MENU%}
<div style="text-align:right" align="right>"><table class="urunFooter" style="cursor:pointer; margin-bottom:5px;" ><tr><td><img src="{%ARKADASIMA_GONDER_IMG_SRC%}"></td><td onclick="{%ARKADASIMA_GONDER_CLICK%}">{%ARKADASIMA_GONDER_LABEL%}</td><td style="font-weight:normal;">|</td><td><img src="{%YAZDIR_IMG_SRC%}"></td><td onclick="{%YAZDIR_CLICK%}">{%YAZDIR_LABEL%}</td></tr></table></div>