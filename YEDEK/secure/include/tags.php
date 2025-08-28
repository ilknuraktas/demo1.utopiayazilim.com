<? 
function generateCampXML() {
	$q = mysql_query("select * from kampanyaBannerConfig where ID=1");
	$d = mysql_fetch_array($q);
	$out='<gallery>
	<setup path="images/kampanya/">
		<imgWidth>'.$d['resimen'].'</imgWidth>
     	<imgHeight>'.$d['resimboy'].'</imgHeight>
      	<thumbWidth>'.$d['thumben'].'</thumbWidth>
      	<thumbHeight>'.$d['thumbboy'].'</thumbHeight>
      	<transitionType>'.$d['effect'].'</transitionType>
     	<thumbnailRows>1</thumbnailRows>
		<thumbPosition>'.$d['pozisyon'].'</thumbPosition>
		<captionPosition>bottom</captionPosition>
		<showControls>false</showControls>
		<thumbType>'.$d['secim'].'</thumbType>
		<backgroundColor>#FFFFFF</backgroundColor>
		<imgBgColor >#FFFFFF</imgBgColor>
		<numberColor>0xFFFFFF</numberColor>
		<thumbActiveColor>#AAAAAA</thumbActiveColor>
		<thumbColor>#DDDDDD</thumbColor>
		<numberBold>false</numberBold>
		<loopImages>true</loopImages>
		<imageCentering>left</imageCentering>
		<autoPlay>'.$d['hiz'].'</autoPlay>
	 </setup>
';
	$q = mysql_query("select * from kampanyaBanner order by seq");
	while ($d = mysql_fetch_array($q)) {
		$thumb = ($d['thumb']?$d['thumb']:'include/resize.php?path=images/urunler/'.$d['resim'].'&width=50');
		$out.='<item>
				   <thumb>'.htmlspecialchars($thumb).'</thumb>
				   <img>'.$d['resim'].'</img>
				   <imgLink><![CDATA[javascript:window.location.href="'.$d['link'].'";]]></imgLink>
			   </item>
			   ';
	}
	$out.='</gallery>';
	dosyayaz('../gallery_data.xml',$out);
}
?>