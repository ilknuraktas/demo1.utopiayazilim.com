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
							<div class="kayitBaslik">Henüz Üye Deðil misiniz?<br /></div>
							<div class="kayitaciklama">Tek adýmda kolayca üye olabilirsiniz ...</div>
								<ul>
									<li> <strong>&middot;</strong> Sipariþ formunu doldurmadan, hýzlý alýþveriþ yapmak,  </li>
									<li> <strong>&middot;</strong> Kampanyalarda öncelikli haberdar olmak,  </li>
									<li> <strong>&middot;</strong> Alýþveriþlerden puan kazanmak, </li>
									<li> <strong>&middot;</strong> Sacece üyelere özel indirimlerden yararlanmak  </li>
									<li> <strong>&middot;</strong> ve daha fazlasý için ...  </li>
								</ul>
							<div class="kayit"><input type="button" onclick="window.location.href=\''.slink('register').'\'" class="sf-button sf-button-large sf-primary-button" value="ÜCRETSÝZ KAYIT OL"/></div>
							</div>
						</div>
					</div>';
	}
	return 	$modLang[$siteDili][$str];
}
?>