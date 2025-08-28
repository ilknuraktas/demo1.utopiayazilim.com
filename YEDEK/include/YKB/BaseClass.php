<?php
include_once 'Constants.php';
include_once 'MACCalculater.php';

class BaseClass extends MACCalculater
{

    public $ApiType = Constants::apiType;

    public $ApiVersion = Constants::apiVersion;

    public $url;

    public $encryptionKey;

    function doTransaction($RequestBase, $Type)
    {
        $url = $this->url . $Typex;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       // curl_setopt($curl, CURLOPT_SSLVERSION, 6);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Accept-Encoding: gzip,deflate,sdch",
            "Accept-Language: en-US,en;q=0.8,fa;q=0.6,sv;q=0.4",
            "Host: posnetict.yapikredi.com.tr",
            "Cache-Control: no-cache",
            "Connection: keep-alive"
        ));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 250);
        curl_setopt($curl, CURLOPT_TIMEOUT, 250);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $RequestBase);
        
        $json_response = curl_exec($curl);

        $response = json_decode($json_response, true, JSON_UNESCAPED_UNICODE);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
echo debugArray(curl_getinfo($curl));
        /*
         * echo "<br> Curl <br>" . print_r($status) . "<br>";
         * print_r(curl_getinfo($curl)) ;
         * print_r($response);
         */
		          //print_r(json_decode($json_response, true,JSON_UNESCAPED_UNICODE));
        if (! is_array($response) or is_null($response['ServiceResponseData'])) {
            $response['ServiceResponseData']['ResponseCode'] = "0042";
            $response['ServiceResponseData']['ResponseDescription'] = "Yanlis data";
        }
        if ($status < 200 or $status > 299) {
            echo "<br> hata kodu: " . curl_errno($curl) . "<br> url: " . $url . "<br> a��klama: " . curl_error($curl) . "<br> Status: " . $status . "<br>";
            $response['ServiceResponseData']['ResponseCode'] = "0041";
            $response['ServiceResponseData']['ResponseDescription'] = curl_error($curl);
        }
        
        curl_close($curl);
         print_r(json_decode($json_response, true,JSON_UNESCAPED_UNICODE));
        return $response;
    }

    function array_to_obj($array, &$obj)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value) && $key != "PointDataList") {
                    if ($key != "TransactionData") {
                        if ($key != "KOIData") {
                            if ($key != "LimitInfo") {
                                if ($key != "PaymentInfo") {
                                    $obj->$key = new stdClass();
                                    $this->array_to_obj($value, $obj->$key);
                                } else {
                                    $obj->$key = $value;
                                }
                            } else {
                                $obj->$key = $value;
                            }
                        } else {
                            $obj->$key = $value;
                        }
                    } else {
                        $obj->$key = $value;
                    }
                } else {
                    $obj->$key = $value;
                }
            }
            return $obj;
        }
    }
}
?>