<?
if (!$_SESSION['orandStr'])
    $_SESSION['orandStr'] = $_SESSION['randStr'];
$orandStr = $_SESSION['orandStr'];

function facebookPixelSearchID()
{
    $q = getSearchQuery($_GET['str']);
    while ($d = my_mysql_fetch_array($q)) {
            $ID[] = "'" . $d['ID'] . "'";
        }
    return implode(',', $ID);
}

function facebookPixelCatID()
{
    $q = my_mysql_query("select * from urun where (catID='" . $_GET['catID'] . "' OR showCatIDs like '%|" . $_GET['catID'] . "|%') AND active = 1");
    while ($d = my_mysql_fetch_array($q)) {
            $ID[] = "'" . $d['ID'] . "'";
        }
    return implode(',', $ID);
}

function facebookPixelBasket($randStr)
{
    $q = my_mysql_query("select urunID from sepet where randStr = '" . $randStr . "' AND adet > 0");
    while ($d = my_mysql_fetch_array($q)) {
            if($d['urunID']) $ID[] = "'" . $d['urunID'] . "'";
        }
    return implode(',', $ID);
}

function facebookPixel()
{
    global $tamamlandi, $orandStr;
    $out = '';
    switch ($_GET['act']) {
        case 'urunDetay':
            $out .= "<script type='text/javascript'>
						fbq('track', 'ViewContent', {
						content_ids: ['" . urun('ID') . "'],
						content_type: 'product',
						value: " . str_replace(',', '', my_money_format('', YTLfiyat(urun('fiyat'), urun('fiyatBirim')))) . ",
						currency: 'TRY'
						});
						</script>";

                        
                    $data = '{
                        "data": [
                           {
                              "event_name": "ViewContent",
                              "event_time": '.time().',
                              "event_source_url": "'.selfURL().'",         
                              "action_source": "website",
                              "user_data": {
                                 "client_ip_address": "'.$_SERVER['REMOTE_ADDR'].'",
                                 "client_user_agent": "'.$_SERVER['HTTP_USER_AGENT'].'"
                              },
                              "custom_data": {
                                 content_ids: [
                                    '.urun('ID') .'
                                 ],
                                 value: '.str_replace(',', '', my_money_format('', YTLfiyat(urun('fiyat'), urun('fiyatBirim')))).',
                                 currency: "TRY",
                                 content_type: "product"
                              },
                              "opt_out": false
                           }
                        ]
                     }'; 
            break;
        case 'kategoriGoster':
            $out .= "<script type='text/javascript'>
					fbq('track', 'ViewCategory', {
					content_category: '" . str_replace('&raquo;', '>', strip_tags(breadCrumb())) . "',
					content_ids: [" . facebookPixelCatID() . "],
					content_type: 'product',
					});
					</script>";

                    $data = '{
                        "data": [
                           {
                              "event_name": "ViewCategory",
                              "event_time": '.time().',
                              "event_source_url": "'.selfURL().'",         
                              "action_source": "website",
                              "user_data": {
                                 "client_ip_address": "'.$_SERVER['REMOTE_ADDR'].'",
                                 "client_user_agent": "'.$_SERVER['HTTP_USER_AGENT'].'"
                              },
                              "custom_data": {
                                 content_category: "' . str_replace('&raquo;', '>', strip_tags(breadCrumb())) . '",
                                 content_ids: [
                                    '.facebookPixelCatID() .'
                                 ],
                                 content_type: "product"
                              },
                              "opt_out": false
                           }
                        ]
                     }';   
            break;
        case 'sepet':
            //	if($_GET['op'] == 'ekle')
            {
                $out .= "<script type='text/javascript'>
						fbq('track', 'AddToCart', {
						content_ids: [" . facebookPixelBasket($_SESSION['randStr']) . "],
						content_type: 'product',
						value: " . str_replace(',', '', my_money_format('', basketInfo('ModulFarkiIle', $_SESSION['randStr']))) . ",
						currency: 'TRY'
						});
						</script>";
            }
            $data = '{
                "data": [
                   {
                      "event_name": "AddToCart",
                      "event_time": '.time().',
                      "event_source_url": "'.selfURL().'",         
                      "action_source": "website",
                      "user_data": {
                         "client_ip_address": "'.$_SERVER['REMOTE_ADDR'].'",
                         "client_user_agent": "'.$_SERVER['HTTP_USER_AGENT'].'"
                      },
                      "custom_data": {
                         "content_ids": [
                            '.facebookPixelSearchID($orandStr) .'
                         ],
                         value: ' . str_replace(',', '', my_money_format('', basketInfo('ModulFarkiIle', $_SESSION['randStr']))) . ',
                         currency: "TRY",
                         content_type: "product"
                      },
                      "opt_out": false
                   }
                ]
             }';         
            break;
        case 'arama':
            if ($_GET['str']) {
                    $out .= "
					<script type='text/javascript'>
					fbq('track', 'Search', {
					search_string: '" . addslashes(strip_tags($_GET['str'])) . "',
					content_ids: [" . facebookPixelSearchID() . "],
					content_type: 'product'
					});
					</script>";
                }
            $data = '{
                    "data": [
                       {
                          "event_name": "Serch",
                          "event_time": '.time().',
                          "event_source_url": "'.selfURL().'",         
                          "action_source": "website",
                          "user_data": {
                             "client_ip_address": "'.$_SERVER['REMOTE_ADDR'].'",
                             "client_user_agent": "'.$_SERVER['HTTP_USER_AGENT'].'"
                          },
                          "custom_data": {
                             search_string: "' . addslashes(strip_tags($_GET['str'])) . '",
                             "content_ids": [
                                '.facebookPixelSearchID($orandStr) .'
                             ],
                             "content_type": "product"
                          },
                          "opt_out": false
                       }
                    ]
                 }';
            break;
        case 'register':
            if (!$_POST['data_name'])
            {
                $track = 'Lead';
                $out .= "<script type='text/javascript'>
					fbq('track', 'Lead');
					</script>
					 ";
            }

            else
            {
                $track = 'CompleteRegistration';
                $out .= "<script type='text/javascript'>
					fbq('track', 'CompleteRegistration', {
                        value: 0,
                        currency: 'TRY'
                        });
					</script>
					 ";
            }
                     $data = '{
                        "data": [
                           {
                              "event_name": "'.$track.'",
                              "event_time": '.time().',
                              "event_source_url": "'.selfURL().'",         
                              "action_source": "website",
                              "user_data": {
                                 "client_ip_address": "'.$_SERVER['REMOTE_ADDR'].'",
                                 "client_user_agent": "'.$_SERVER['HTTP_USER_AGENT'].'",
                                 "em": [
                                    "'. hash('sha256', $_POST['data_email']).'"
                                 ],
                                 "ph": [
                                    "'. hash('sha256', $_POST['data_ceptel']).'"
                                 ]
                              }
                           }
                        ]
                     }';
            break;
        case 'satinal':
            if ($_GET['op'] == 'odeme' && !$tamamlandi) {
                    $track = 'InitiateCheckout';
                    $out .= "<script type='text/javascript'>
						fbq('track', 'InitiateCheckout');
						</script>";
                }
            if ($_GET['op'] == 'odeme' && $tamamlandi) {
                    $track = 'Purchase';

                    $out .= "<script type='text/javascript'>
					fbq('track', 'Purchase', {
					content_ids: [" . facebookPixelBasket($orandStr) . "],
					content_type: 'product',
					value: " . str_replace(',', '', my_money_format('', basketInfo('ModulFarkiIle', $orandStr))) . ",
					currency: 'TRY'
					});
					</script>
					
					";
                }

                $data = '{
                    "data": [
                       {
                          "event_name": "'.$track.'",
                          "event_time": '.time().',
                          "event_source_url": "'.selfURL().'",         
                          "action_source": "website",
                          "user_data": {
                             "client_ip_address": "'.$_SERVER['REMOTE_ADDR'].'",
                             "client_user_agent": "'.$_SERVER['HTTP_USER_AGENT'].'",
                             "em": [
                                "'. hash('sha256', hq("select email from siparis where randStr = '$orandStr'")).'"
                             ],
                             "ph": [
                                "'. hash('sha256', hq("select ceptel from siparis where randStr = '$orandStr'")).'"
                             ]
                          },
                          "custom_data": {
                             "value": '.str_replace(',', '', my_money_format('', basketInfo('ModulFarkiIle', $orandStr))).',
                             "currency": "TRY",
                             "content_ids": [
                                '.facebookPixelBasket($orandStr) .'
                             ],
                             "content_type": "product"
                          },
                          "opt_out": false
                       }
                    ]
                 }';

            break;
    }

    if($data)
    {
        $ch = curl_init( 'https://graph.facebook.com/v13.0/'.siteConfig('facebook_pixelID').'/events?access_token='.siteConfig('facebook_token'));;
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        echo "<!--Facebook Result : $result | Data : $data_-->";
        curl_close($ch);
    }
    return $out;
}
?>