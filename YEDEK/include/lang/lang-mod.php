<?
$modLang = array();
function modLang($str)
{
	global $siteDili,$modLang;
	if(!is_array($modLang['tr']))
	{
		$modLang['tr']['modLoginLeft'] = ' 
					<div class="l-left">    
						<div class="l-innerDiv">
							<div class="kayitBaslik">Hen�z �ye De�il misiniz?<br /></div>
							<div class="kayitaciklama">Tek ad�mda kolayca �ye olabilirsiniz ...</div>
								<ul>
									<li> <strong>&middot;</strong> Sipari� formunu doldurmadan, h�zl� al��veri� yapmak,  </li>
									<li> <strong>&middot;</strong> Kampanyalarda �ncelikli haberdar olmak,  </li>
									<li> <strong>&middot;</strong> Al��veri�lerden puan kazanmak, </li>
									<li> <strong>&middot;</strong> Sacece �yelere �zel indirimlerden yararlanmak  </li>
									<li> <strong>&middot;</strong> ve daha fazlas� i�in ...  </li>
								</ul>
							<div class="kayit"><input type="button" onclick="window.location.href=\''.slink('register').'\'" class="sf-button sf-button-large sf-primary-button" value="�CRETS�Z KAYIT OL"/></div>
							</div>
						</div>
					</div>';
	}
	return 	$modLang[$siteDili][$str];
}
?>