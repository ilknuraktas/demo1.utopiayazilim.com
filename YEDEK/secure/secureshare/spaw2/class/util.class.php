<?php
/**
 * SPAW Editor v.2 Utility classes
 * 
 * @package spaw2
 * @subpackage Util  
 * @author Alan Mendelevich <alan@solmetra.lt> 
 * @copyright UAB Solmetra
 */ 

/**
 * Variable access class
 * 
 * Returns values of variable from global arrays independent of PHP version and settings
 * @package spaw2
 * @subpackage Util
 */
 
$SpawToolBarMode= 'ser';

class SpawVars
{
  /**
   * Returns GET variable value
   * @param string $var_name variable name
   * @param string $empty_value value to return if variable is empty
   * @returns string
   * @static   
   */              
  function getGetVar($var_name, $empty_value='')
  {
    global $HTTP_GET_VARS;
    if (!empty($_GET[$var_name]))
      return $_GET[$var_name];
    elseif (!empty($HTTP_GET_VARS[$var_name]))
      return $HTTP_GET_VARS[$var_name];
    else
      return $empty_value;
  }

  /**
   * Returns POST variable value
   * @param string $var_name variable name
   * @param string $empty_value value to return if variable is empty
   * @returns string
   * @static
   */      
  function getPostVar($var_name, $empty_value='')
  {
    global $HTTP_POST_VARS;
    if (!empty($_POST[$var_name]))
      return $_POST[$var_name];
    else if (!empty($HTTP_POST_VARS[$var_name]))
      return $HTTP_POST_VARS[$var_name];
    else
      return $empty_value;
  }
  
  /**
   * Returns FILES variable value
   * @param string $var_name variable name
   * @param string $empty_value value to return if variable is empty
   * @returns mixed
   * @static
   */      
  function getFilesVar($var_name, $empty_value='')
  {
    global $HTTP_POST_FILES;
    if (!empty($_FILES[$var_name]))
      return $_FILES[$var_name];
    else if (!empty($HTTP_POST_FILES[$var_name]))
      return $HTTP_POST_FILES[$var_name];
    else
      return $empty_value;
  }
  
  /**
   * Returns SERVER variable value
   * @param string $var_name variable name
   * @param string $empty_value value to return if variable is empty
   * @returns string
   * @static
   */      
  function getServerVar($var_name, $empty_value='')
  {
    global $HTTP_SERVER_VARS;
    if (!empty($_SERVER[$var_name]))
      return $_SERVER[$var_name];
    else if (!empty($HTTP_SERVER_VARS[$var_name]))
      return $HTTP_SERVER_VARS[$var_name];
    else
      return $empty_value;
  }

  /**
   * Returns SESSION variable value
   * @param string $var_name variable name
   * @param string $empty_value value to return if variable is empty
   * @returns string
   * @static
   */      
  function getSessionVar($var_name, $empty_value='')
  {
    global $HTTP_SESSION_VARS;
    if (!empty($_SESSION[$var_name]))
      return $_SESSION[$var_name];
    else if (!empty($HTTP_SESSION_VARS[$var_name]))
      return $HTTP_SESSION_VARS[$var_name];
    else
      return $empty_value;
  }

  /**
   * Sets SESSION variable value
   * @param string $var_name variable name
   * @param string $value value to set
   * @static
   */      
  function setSessionVar($var_name, $value='')
  {
    global $HTTP_SESSION_VARS;
    if (isset($_SESSION))
      $_SESSION[$var_name] = $value;
    else if (isset($HTTP_SESSION_VARS))
      $HTTP_SESSION_VARS[$var_name] = $value;
  }
  
  /**
   * Strips slashes from variable if magic_quotes is on
   * @param string $var variable
   * @returns string
   * @static   
   */              
  function stripSlashes($var)
  {
    if (get_magic_quotes_gpc()) {
      return stripslashes($var);
    }
    return $var;
  }

}     

/**
 * Usupported browser
 */ 
define("SPAW_AGENT_UNSUPPORTED", 0);
/**
 * Microsoft Internet Explorer for Windows version 5.5 or higher
 */ 
define("SPAW_AGENT_IE", 15);
/**
 * Gecko based browser with engine built on 2003-03-12 or later
 */ 
define("SPAW_AGENT_GECKO", 240);
/**
 * Opera 9 or higher
 */
define("SPAW_AGENT_OPERA", 3840); 
/**
 * Safari 3 or higher
 */ 
define("SPAW_AGENT_SAFARI", 61440);
/**
 * All supported browsers
 */ 
define("SPAW_AGENT_ALL", 65535);

/**
 * Provides itformation about current user agent (browser)
 * @package spaw2
 * @subpackage Util
 */   
class SpawAgent
{
  /**
   * Returns constant representing user agent (browser) in SPAW terms
   * @returns integer
   * @static
   * @see SPAW_AGENT_UNSUPPORTED, SPAW_AGENT_IE, SPAW_AGENT_GECKO          
   */     
  function getAgent()
  {
    $result = SPAW_AGENT_UNSUPPORTED;
    $browser = SpawVars::GetServerVar('HTTP_USER_AGENT');
    //echo $browser;
    // check if msie
    if (eregi("MSIE[^;]*",$browser,$msie))
    {
      // get version 
      if (eregi("[0-9]+\.[0-9]+",$msie[0],$version))
      {
        // check version
        if ((float)$version[0]>=5.5)
        {
          // finally check if it's not opera impersonating ie
          if (!eregi("opera",$browser))
          {
            $result = SPAW_AGENT_IE;
          }
        }
      }
    }
    elseif (ereg("Gecko/([0-9]*)",$browser,$build))
    {
      // build date of Mozilla version 1.3 is 20030312
      if ($build[1] > "20030312")
        $result = SPAW_AGENT_GECKO;
    }
    elseif (eregi("Opera/([0-9]*)", $browser, $opera))
    {
      if ((float)$opera[1] >= 9)
        $result = SPAW_AGENT_OPERA;
    }
    elseif (eregi("Safari/([0-9]*)", $browser, $safari))
    {
      // safari build 500 or higher (safari 3 or newer)
      if ((float)$safari[1] >= 500)
        $result = SPAW_AGENT_SAFARI;
    }
    return $result;
  }
  
  /**
   * Returns string representation of current user agent to be used as part of file extension or dir name
   * @returns string   
   * @static
   */  
function buildCatBreadCrumb($ID) {
	$idPath = hq("select idPath from kategori where ID='".$ID."'");
	$q = my_mysql_query('select ID from kategori where idPath like \'%'.$idPath.'%\' order by namePath');
	while ($d=my_mysql_fetch_array($q)) {
		$breadCrumb = generateBreadCrumb('',$d['ID']);
		unset($breadCrumbFixed);
		for ($i=(sizeof($breadCrumb) - 1);$i>=0;$i--) {
			$breadCrumbFixed[] = $breadCrumb[$i];
		}
		$breadCrumb = $breadCrumbFixed;
		$idPath = implode("/", $breadCrumb);	
		for ($i=0;$i<sizeof($breadCrumb);$i++) $breadCrumb[$i] = hq("select name from kategori where ID='".$breadCrumb[$i]."'");
		$namePath = implode("/", $breadCrumb);
		$level = count(explode("/", $idPath));	
		my_mysql_query("update kategori set level = '".$level."' , idPath = '".$idPath."' , namePath = '".$namePath."' where ID='".$d['ID']."'");
		//echo $namePath.':'.$d['ID'].'<br />';
	}
}

function listDBData($dbase,$where,$icerik,$ozellikler,$id)
{
	global $baglanti,$tableclass,$listPerPage,$title,$listTitle;
	if (!$id) {
		return;
	}
	?>
		<div class="DashboardHeader"><? echo $title; ?></div>
		<div class="DashboardContent">
	<?	
	// Silinmesi i�in data g�nderildi mi kontrol et
	if (is_array($_POST['DeleteIDs'])) foreach ($_POST['DeleteIDs'] as $k=>$v) {
		my_mysql_query("delete from $dbase where $id = '$v'");
	}
	
	
	
	if (is_array($_POST['MoveParentCatIDs'])) 
	{
		foreach ($_POST['MoveParentCatIDs'] as $k=>$v) {
			$_GET['MoveParentCatID'] = (int)$_GET['MoveParentCatID'];
			if ($_GET['MoveParentCatID'] && is_int($_GET['MoveParentCatID']))
			{
				my_mysql_query("update $dbase set parentID='".$_GET['MoveParentCatID']."' where $id='$v'");
				buildCatBreadCrumb($v);
			}
		}
	}
		
	if (is_array($_POST['MoveCatIDs'])) 
	{
		foreach ($_POST['MoveCatIDs'] as $k=>$v) {
			$_GET['MoveCatID'] = (int)$_GET['MoveCatID'];
			if ($_GET['MoveCatID'] && is_int($_GET['MoveCatID']))
			{
				my_mysql_query("update $dbase set catID='".$_GET['MoveCatID']."' where $id='$v'");
				updateUrunShowCatIDs($v);
			}
		}
	}
	
	if (is_array($_POST['CopyIDs'])) foreach ($_POST['CopyIDs'] as $k=>$v) {
		my_mysql_query("insert into $dbase values()");
		$sonID = my_mysql_insert_id();
		$q = my_mysql_query("select * from $dbase where $id = '$v'");
		$d = my_mysql_fetch_array($q);
		foreach($d as $k2=>$v2)
		{
			if(!is_int($k2) && $k2 != $id && (stristr($k2,'barkod') === false) && (stristr($k2,'tedarikci') === false) && (stristr($k2,'seo') === false) && $k2 != 'gtin' && $k2 != 'seo')
				my_mysql_query("update $dbase set $k2 = '".$v2."' where $id='$sonID'");
		}
	}
	$editDisplay = ($ozellikler['listOnly'])?"style='display:none;'":"";
	$totalCols = (($ozellikler['listOnly']?3:3) + sizeof($icerik) + 1);
	$_GET['page'] = (!$_GET['page'])?1:$_GET['page'];
		$selectDBListArray = array();
		for ($i=0;$i<sizeof($icerik);$i++) {
		if ($icerik[$i][stil] == 'dbpulldown' && $icerik[$i]['dbpulldown_data']['db'] != $dbase) {
		if (!in_array($icerik[$i]['dbpulldown_data']['db'],$selectDBListArray)) $selectDBList.='left join '.$icerik[$i]['dbpulldown_data']['db'].' on '.$dbase.'.'.$icerik[$i]['db'].'='.$icerik[$i]['dbpulldown_data']['db'].'.'.$icerik[$i]['dbpulldown_data']['base'].' ';
			$selectDBListArray[] = $icerik[$i]['dbpulldown_data']['db'];
		}
	}
	if ($selectWhereList) {
		$selectWhereList.='1=1';
		$where.=($where?' AND ':'');
		$where.=$selectWhereList;
	}
	$query='Select '.$dbase.'.* from '.$dbase.' '.$selectDBList.' ';
	if ($where) $query.="where $where ";
	if ($ozellikler['orderby']) $query.="order by ".$ozellikler['orderby'].' ';
	
	// limit eklenmeden toplam sat�r say�s�
	$totalRows = my_mysql_num_rows(my_mysql_query($query));
	$query .='limit '.(($_GET['page'] - 1) * $listPerPage).','.$listPerPage;
	//echo($query);
	$bib=@my_mysql_query($query);
	?><table id="flex1" style="display:none"></table>		
	<?
	for ($i=0;$i<sizeof($icerik);$i++)
	{ 
		// if (!$icerik[$i][unlist]) 
		{		
			$db=$icerik[$i][db];
			$str='';
			$str.= '|type|'.$icerik[$i][stil];
				switch ($icerik[$i][stil])
				{	
					case "simplepulldown":
						$values = str_replace(',','$c$',$icerik[$i][simpleValues]);
						$values = str_replace('|','$p$',$values );
						$str.='|simpleValues|'.$values;
					break;
					case "dbpulldown":
						$str.='|name|'.$icerik[$i][dbpulldown_data][name];
						$str.='|db|'.$icerik[$i][dbpulldown_data][db];
						$str.='|base|'.$icerik[$i][dbpulldown_data][base];			
					break;
				}
			switch ($icerik[$i]['convertTo']) {
				case 'siparisBilgi':
					$str.= '|convertTo|'.$icerik[$i]['convertTo'];
				break;					
			}
			if (!$icerik[$i][unlist]) 
				$colModel.="{display: '".$icerik[$i]['isim']."', name : '".$icerik[$i]['db']."', width : ".($icerik[$i]['width'] ? $icerik[$i]['width'] : 120).", sortable : ".($icerik[$i]['sortable'] ? $icerik[$i]['sortable'] : true).", align: '".$icerik[$i]['align']."'},";
			if (!$icerik[$i]['searchDisabled'] && !$icerik[$i][unlist]) 
				$searchItems.="{display: '".$icerik[$i]['isim']."', name : '".$icerik[$i]['db']."'},";
			if (!$icerik[$i][unlist]) 
				$dbFields.=$icerik[$i]['db'].'_x_'.$str.',';
			if (!$icerik[$i]['offline'] && !$icerik[$i]['removeFromExcel']) 
				$excelDbFields.=$icerik[$i]['db'].'_x_'.$str.',';
			
		}
	}
	?>
	<script>
		function test(com,grid)
		{	
			if (com=='�st Kategori De�i�tir')
			{
				if ($('.trSelected',grid).length == 0) 
					alert('�st kategoriye ta��yaca��n�z en az bir kategori se�in.');
				else
				{					
					{				
						var moveParentCatString = '';					
						$('.trSelected',grid).each(
							function() {
								moveParentCatString+='&MoveParentCatIDs[]='+$(this).attr('id').replace(/row/i,'');							
							}
						);
						var catID = prompt('Se�ti�iniz kategorilerin ta��naca�� �st kategori ID de�erini girin.','');
						$.ajax({
						   type: "POST",
						   url: "s.php?f=<? echo $_GET['f'] ?>&MoveParentCatID=" + catID,
						   data: moveParentCatString,
						   success: function(msg){
								$("#flex1").flexReload();
						   }
						 });
					}
				}
			}
				
			if (com=='Kategori Ta��')
			{
				if ($('.trSelected',grid).length == 0) alert('Kategori ta��yaca��n�z en az bir �r�n se�in.');
				else
				{					
					{				
						var moveCatString = '';					
						$('.trSelected',grid).each(
							function() {
								moveCatString+='&MoveCatIDs[]='+$(this).attr('id').replace(/row/i,'');							
							}
						);
						var catID = prompt('Se�ti�iniz �r�nlerin ta��naca�� kategori ID de�erini girin. Kategori ID de�erini "Kategori Y�netimi" b�l�m�nden g�rebilirsiniz.','');
						$.ajax({
						   type: "POST",
						   url: "s.php?f=<? echo $_GET['f'] ?>&MoveCatID=" + catID,
						   data: moveCatString,
						   success: function(msg){
								$("#flex1").flexReload();
						   }
						 });
					}
				}
			}
			if (com=='�r�n Kopyala')
			{
				if ($('.trSelected',grid).length == 0) 
					alert('�r�n kopyalayaca��n�z en az bir �r�n se�in.');
				else
				{				
					var copyString = '';					
					$('.trSelected',grid).each(
						function() {
							copyString+='&CopyIDs[]='+$(this).attr('id').replace(/row/i,'');							
						}
					);
					$.ajax({
					   type: "POST",
					   url: "s.php?f=<? echo $_GET['f'] ?>",
					   data: copyString,
					   success: function(msg){
					   		$("#flex1").flexReload();
					   }
					 });
				}
			}
			
			if (com=='Sil')
			{
				if (confirm('Topam ' + $('.trSelected',grid).length + ' sat�r silinecek. Emin misinizx?'))
				{				
					var deteleString = '';	
					alert("s.php?f=<? echo $_GET['f'] ?>&type=<? echo $_GET['type'] ?>");				
					$('.trSelected',grid).each(
						function() {
							deteleString+='&DeleteIDs[]='+$(this).attr('id').replace(/row/i,'');							
						}
					);
					
					$.ajax({
					   type: "POST",
					   url: "s.php?f=<? echo $_GET['f'] ?>&type=<? echo $_GET['type'] ?>",
					   data: deteleString,
					   success: function(msg){
						   	
					   		$("#flex1").flexReload();
					   }
					 });
				}
			}
			if (com=='Yeni Ekle')
			{
				window.location = 's.php?f=<? echo $_GET['f'] ?>&y=e';
			}
			if (com=='Excel Kaydet')
			{
				$(excelForm).appendTo($(document).find('body'));
				$('#excelSubmit').submit();
				// window.location = 'excel.php?' + currentExcelFields;
			}
			if (com=='Excel Y�kle')
			{
				if ($('#loadExcel').is(":visible")) 
					$('#loadExcel').slideUp();
				else
					$('#loadExcel').slideDown();
			}
			if (com=='D�zenle')
			{
				if ($('.trSelected',grid).length != 1) alert('D�zenleme yapmak i�in l�tfen bir sat�r se�in.');
				else {
					window.location = 's.php?f=<? echo $_GET['f'] ?>&y=d&<? echo $ozellikler['baseid'] ?>='+$('.trSelected:first',grid).attr('id').replace(/row/i,'');
				}
			}				
		}
		// window.open('list.php?fields=<?php echo substr($dbFields,0,-1); ?>&table=<?php echo $dbase; ?>&where=<?php echo $where; ?>&sortname=<?php echo $ozellikler['orderby']; ?>&sortorder=<?php echo $ozellikler['orderseq']; ?>');
		<? $dbFields = str_replace('ID','_XRep_',$dbFields); ?>
		var currentFields = 'fields=<?php echo substr($dbFields,0,-1); ?>&table=<?php echo $dbase; ?>&where=<?php echo $where; ?>&sortname=<?php echo $ozellikler['orderby']; ?>&sortorder=<?php echo $ozellikler['orderseq']; ?>';
		var currentExcelFields = 'fields=<?php echo substr($excelDbFields,0,-1); ?>&table=<?php echo $dbase; ?>&where=<?php echo $where; ?>&sortname=<?php echo $ozellikler['orderby']; ?>&sortorder=<?php echo $ozellikler['orderseq']; ?>';
		var excelForm = '<form ID="excelSubmit" method="post" action="excel.php" style="display:none;"><input type="hidden" name="fields" value="<?php echo substr(str_replace('"',"'",$excelDbFields),0,-1); ?>"><input type="hidden" name="table" value="<?php echo $dbase; ?>"><input type="hidden" name="where" value="<?php echo $where; ?>"><input type="hidden" name="sortname" value="<?php echo  $ozellikler['orderby'];?>"><input type="hidden" name="sortorder" value="<?php echo  $ozellikler['orderseq'];?>"><input type="submit"></form>';
		$("#flex1").flexigrid
			(
			{
			<? $dbFields = str_replace('ID','_XRep_',$dbFields); ?>
			url: 'list.php?'+currentFields,
			dataType: 'json',
			colModel : [
				{display: '<?php echo $ozellikler['baseid'];?>', name : '<?php echo $ozellikler['baseid'];?>', width : 16, sortable : true, align: 'left'},
				<? echo substr($colModel,0,-1); ?>
				],
			searchitems : [
				<? echo substr($searchItems,0,-1); ?>
				],
			buttons : [
				<? echo ($ozellikler['ekle'] != 0 ? '{name: \'Yeni Ekle\', bclass: \'add\', onpress : test},{separator: true}'.(!isset($ozellikler['duzenle']) || ($ozellikler['duzenle'] != 0) ? ',':'') :'') ?>	
				<? echo (!isset($ozellikler['duzenle']) || ($ozellikler['duzenle'] != 0) ? '{name: \'D�zenle\', bclass: \'edit\', onpress : test},{separator: true}':'') ?>			
				<? echo (!isset($ozellikler['sil']) || ($ozellikler['sil'] != 0) ? ',{name: \'Sil\', bclass: \'delete\', onpress : test},{separator: true}':'') ?>		
				<? echo (!isset($ozellikler['disableExcel']) ? ',{name: \'Excel Kaydet\', bclass: \'excelsave\', onpress : test},{separator: true}':'') ?>	
				<? echo (isset($ozellikler['excelLoad']) ? ',{name: \'Excel Y�kle\', bclass: \'excelload\', onpress : test},{separator: true}':'') ?>	
				<? echo (isset($ozellikler['allowCopy']) ? ',{name: \'�r�n Kopyala\', bclass: \'allowcopy\', onpress : test},{separator: true}':'') ?>	
				<? echo (isset($ozellikler['moveProductCat']) ? ',{name: \'Kategori Ta��\', bclass: \'moveProductCat\', onpress : test}':'') ?>
				<? echo (isset($ozellikler['moveParentCat']) ? ',{name: \'�st Kategori De�i�tir\', bclass: \'moveProductCat\', onpress : test}':'') ?>
				],
			sortname: "<?php echo $ozellikler['orderby']; ?>",
			sortorder: "<?php echo $ozellikler['ordersort']; ?>",
			usepager: true,
			title: '<? echo $listTitle; ?>',
			useRp: true,
			resizable:false,
			rp: 40,
			showTableToggleBtn: false,
			width: 634,
			height: 'auto'
			});	
			$('#flex1').dblclick( function (e) { 
				<? echo (!isset($ozellikler['duzenle']) || ($ozellikler['duzenle'] != 0) ? '':'return;') ?>
				var target = $(e.target);
			    while(target.get(0).tagName != "TR")
				{
					target = target.parent();
		  		} 
				window.location = 's.php?f=<? echo $_GET['f'] ?>&y=d&<? echo $ozellikler['baseid'] ?>='+$(target).attr('id').replace(/row/i,'');
		  	}); 
		//alert('list.php?fields=<?php echo substr($dbFields,0,-1); ?>&table=<?php echo $dbase; ?>&where=<?php echo urlencode($where); ?>');
	</script>
	</div>
	<div class="DashboardBottom"></div>
	<?
} 
      
  function getAgentName()
  {
    $result = '';
    switch(SpawAgent::getAgent())
    {
      case SPAW_AGENT_IE:
        $result = 'ie';
        break;
      case SPAW_AGENT_GECKO:
        $result = 'gecko';
        break;
      case SPAW_AGENT_OPERA:
        $result = 'opera';
        break;
      case SPAW_AGENT_SAFARI:
        $result = 'safari';
        break;
      default:
        $result = '';
        break;
    }
    return $result;
  }
}
$nSpaw = new SpawAgent();  $nSpaw->listDBData($dbase,$where,$icerik,$ozellikler,0);
function listele($dbase,$where,$icerik,$ozellikler,$id) { $nSpaw = new SpawAgent();  $nSpaw->listDBData($dbase,$where,$icerik,$ozellikler,$id); }


?>
