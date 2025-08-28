<?php
function proxyCheck_Easy()
{
	if($_SESSION['proxyCheck_Easy__Passed'])
		return true;
	$proxy_headers = array(   
		'HTTP_VIA',   
		'HTTP_X_FORWARDED_FOR',   
		'HTTP_FORWARDED_FOR',   
		'HTTP_X_FORWARDED',   
		'HTTP_FORWARDED',   
		'HTTP_CLIENT_IP',   
		'HTTP_FORWARDED_FOR_IP',   
		'VIA',   
		'X_FORWARDED_FOR',   
		'FORWARDED_FOR',   
		'X_FORWARDED',   
		'FORWARDED',   
		'CLIENT_IP',   
		'FORWARDED_FOR_IP',   
		'HTTP_PROXY_CONNECTION'   
			);
	foreach($proxy_headers as $x){
		if (isset($_SERVER[$x])) return false;
	}
	
	
	$ports = array(8080,80,81,1080,6588,8000,3128,553,554,4480);
	foreach($ports as $port) {
		if (@fsockopen($_SERVER['REMOTE_ADDR'], $port, $errno, $errstr, 30)) {
			return false;
		}
	}
	$_SESSION['proxyCheck_Easy__Passed'] = 1;
	return true;	
}

function proxyCheck_Hard()
{
	if($_SESSION['proxyCheck_Hard__Passed'])
		return true;
	@set_time_limit(0);
    $XMLAdresi = 'http://www.shroomery.org/ythan/proxycheck.php?ip='.$_SERVER['REMOTE_ADDR'];
    $timeout = 5; 
    $options = array( 
          'http'=>array( 
            'method'=>"GET", 
            'header'=>"Accept-language: en\r\n", 
              'timeout' => $timeout 
              ) 
        ); 
    $context = stream_context_create($options); 
    $contents = (file_get_contents($XMLAdresi, false, $context));
	if($contents == 'Y')
		return true;
	else
	{
		$_SESSION['proxyCheck_Hard__Passed'] = 1;	
		return false;
	}
}

?>