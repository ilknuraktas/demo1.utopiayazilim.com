<?php

class ThreeDHelper
{

    function getThreeDMac($cardNo, $expiredDate, $ccv2, $encryptionKey, $merchantNo, $terminalNo)
    {
        $MAC = "";
        $MAC = $merchantNo . $terminalNo . $cardNo . $ccv2 . $expiredDate . $encryptionKey;
        $MAC = hash("sha256", $MAC, true);
        $MAC = base64_encode($MAC);
        return $MAC;
    }

    static function getThreeDMacStatic($cardNo, $expiredDate, $ccv2, $encryptionKey, $merchantNo, $terminalNo)
    {
        $MAC = "";
        $MAC = $merchantNo . $terminalNo . $cardNo . $ccv2 . $expiredDate . $encryptionKey;
        $MAC = hash("sha256", $MAC, true);
        $MAC = base64_encode($MAC);
        return $MAC;
    }

    function getThreeDMacParams()
    {
        return "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
    }

    static function getThreeDMacParamsStatic()
    {
        return "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
    }
}
?>
