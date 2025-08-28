<?php
if(isset($_GET['getHTML']))
{
	include('all.php');
	switch($_GET['getHTML'])
	{
		case 'tutar':
			//exit(basketInfo('toplamUrun'));
			exit(mf(basketInfo('ModulFarkiIle')).' '.fiyatBirim('TL'));
		case 'sepet':
			$q = my_mysql_query("select * from sepet where randStr = '".$_SESSION['randStr']."'");
			if(!my_mysql_num_rows($q))
			{
				exit('<img src="assets/images/emptycart.png" class="empty-cart"><style>#sepet-sub-info { visibility:hidden; } .hizli-sepet-footer { opacity:0.5; pointer-events: none; }</style>');
			}
			while($d = my_mysql_fetch_array($q))
			{
				$urunIlkResim = getFirstPic($d['urunID']);
				$urunResim =  'include/resize.php?path=images/urunler/' . $urunIlkResim . '&amp;width=' . tempConfig('maximumSepet_en') . '&amp;height=' . tempConfig('maximumSepet_boy');

				$sepetAdetOK = false;
				if (!$d['relUrunID'] && $d['urunID'] && substr($d['prefix'], 0, 9) != '__bundle_' && !dbInfo('urun', 'promosyon', $d['urunID']))
					$sepetAdetOK = true;

				if($sepetAdetOK)
					$sepetAdet = '
						<div class="h-8 w-22 md:w-24 lg:w-24 flex flex-wrap items-center justify-evenly p-1 border border-gray-100 bg-white text-gray-600 rounded-md"><button class="hizli-sepet-adet-guncelle" data-line="'.$d['ID'].'" data-adet="'.($d['adet'] - 1).'"><span class="text-dark text-base"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
							<line x1="5" y1="12" x2="19" y2="12"></line>
						</svg></span></button>
						<p class="text-sm font-semibold text-dark px-1 m-0">'.$d['adet'].'</p><button class="hizli-sepet-adet-guncelle" data-line="'.$d['ID'].'" data-adet="'.($d['adet'] + 1).'"><span class="text-dark text-base"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
									<line x1="12" y1="5" x2="12" y2="19"></line>
									<line x1="5" y1="12" x2="19" y2="12"></line>
								</svg></span></button>
					</div>';
				else
					$sepetAdet = '<p class="text-sm font-semibold text-dark px-1 m-0">'.$d['adet'].'</p>';

				$out.='<div class="group w-full h-auto flex justify-start items-center bg-white py-3 px-4 border-b hover:bg-gray-50 transition-all border-gray-100 relative last:border-b-0">
				<div class="relative flex rounded-full border border-gray-100 shadow-sm overflow-hidden flex-shrink-0  mr-4"><span style="box-sizing: border-box; display: inline-block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative; max-width: 100%;"><span style="box-sizing: border-box; display: block; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; max-width: 100%;"><img alt="" aria-hidden="true" src="data:image/svg+xml,%3csvg%20xmlns=%27http://www.w3.org/2000/svg%27%20version=%271.1%27%20width=%2740%27%20height=%2740%27/%3e" style="display: block; max-width: 100%; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px;"></span><img alt="'.$d['urunName'].'" src="'.$urunResim.'" decoding="async" data-nimg="intrinsic" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;" /></span></div>
				<div class="flex flex-col w-full overflow-hidden"><a class="truncate text-left text-sm font-medium text-gray-700 text-heading line-clamp-1" href="'.urunLink((int) $d['urunID']).'">'.$d['urunName'].'</a><span class="text-xs text-left text-gray-400 mb-1">'.lc('_lang_adetTutar','adet fiyatı').' '.mf($d['fiyat']).' '.fiyatBirim(hq("select fiyatBirim from urun where ID='".$d['urunID']."'")).'</span>
					<div class="flex items-center justify-between">
						<div class="font-bold text-sm md:text-base text-heading leading-5"><span class="min-100 text-left">'.mf($d['ytlFiyat'] * $d['adet']).' '.fiyatBirim('TL').'</span></div>'.$sepetAdet.'
						<button data-line="'.$d['ID'].'" data-urunID="'.$d['urunID'].'" class="hizli-sepet-satir-sil hover:text-red-600 text-red-400 text-lg cursor-pointer"><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
				<polyline points="3 6 5 6 21 6"></polyline>
				<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
				<line x1="10" y1="11" x2="10" y2="17"></line>
				<line x1="14" y1="11" x2="14" y2="17"></line>
			</svg></button>
					
					</div>
				</div>
			</div>';
			}
			exit($out);
			break;
	}
}

Class SepetHizli
{
	public static function drawerCSS()
	{
		return '<link rel="stylesheet" href="assets/css/sepet-hizli.min.css" />';
	}
	public static function drawerJS()
	{
		return '<script src="assets/js/drawer.min.js" type="text/javascript"></script>' . "\n";
	}
	public static function drawerHTML()
	{
		$out = '<div class="drawer js-drawer drawer-content-wrapper" id="drawer-1">
		<div class="drawer-content drawer__content">
			<div class=" drawer__body js-drawer__body flex flex-col w-full h-full justify-between items-middle bg-white rounded">
				<div class="w-full flex justify-between items-center relative px-5 py-4 border-b border-gray-100">
					<h2 class="font-semibold font-serif text-lg m-0 text-heading flex items-center"><span class="text-xl mr-2 mb-1"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
								<path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M320 264l-89.6 112-38.4-44.88"></path>
								<path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M80 176a16 16 0 00-16 16v216c0 30.24 25.76 56 56 56h272c30.24 0 56-24.51 56-54.75V192a16 16 0 00-16-16zm80 0v-32a96 96 0 0196-96h0a96 96 0 0196 96v32"></path>
							</svg></span>'.lc('_lang_sepetHizliTitle','Alışveriş Sepetim').'</h2><button class="js-drawer__close inline-flex text-base items-center justify-center text-gray-500 p-2 focus:outline-none transition-opacity hover:text-red-400"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
							<path d="M289.94 256l95-95A24 24 0 00351 127l-95 95-95-95a24 24 0 00-34 34l95 95-95 95a24 24 0 1034 34l95-95 95 95a24 24 0 0034-34z"></path>
						</svg><span class="font-sens text-sm text-gray-500 hover:text-red-400 ml-1 js-drawer__close">'.lc('_lang_kapat','Kapat').'</span></button>
				</div>
				<div class="overflow-y-scroll flex-grow scrollbar-hide w-full max-h-full" id="sepet-hizli-urunler"></div>


				<div class="mx-5 my-3 hizli-sepet-footer">
				<ul id="sepet-sub-info"></ul>
				<div class="border-t mb-4"></div>
			
						<div class="pointer" onclick="window.location.href=\'ac/sepet\';"><button class="w-full py-2 px-3 rounded-lg bg-emerald-500 flex items-center justify-between bg-heading text-sm sm:text-base focus:outline-none transition duration-300 hizli-button-sepet"><span class="align-middle font-bold" id="satin-al-bilgi">Sepete Git</span></button></div>

						<div class="pointer" onclick="window.location.href=\'ac/sepet/hizli\';"><button class="w-full py-2 px-3 rounded-lg bg-emerald-500 flex items-center justify-between bg-heading text-sm sm:text-base text-white focus:outline-none transition duration-300 hizli-button-siparis"><span class="align-middle font-bold" id="satin-al-bilgi">Siparişi Tamamla</span></button></div>
					</div>
			</div>
		</div>
		<div class="drawer-handle"><i class="drawer-handle-icon"></i></div>
	</div>
	';
	return $out;
	}
}

/*
<div class="pointer" onclick="window.location.href=\'ac/sepet/hizli\';"><button class="w-full py-2 px-3 rounded-lg bg-emerald-500 hover:bg-emerald-600 flex items-center justify-between bg-heading text-sm sm:text-base text-white focus:outline-none transition duration-300"><span class="align-middle font-bold" id="satin-al-bilgi">'._lang_sepetiOnaylaveSatinAl.'</span><span class="rounded-lg font-bold font-serif py-2 px-3 bg-white text-emerald-600" id="sepet-hizli-tutar">'.mf(basketInfo('ModulFarkiIle')).' '.fiyatBirim('TL').'</span></button></div>
*/

$footerJS.=SepetHizli::drawerJS();
$headerCSS.=SepetHizli::drawerCSS();
$bodyHTML.=SepetHizli::drawerHTML();
?>