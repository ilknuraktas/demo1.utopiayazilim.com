<?php
include_once 'Models/CardInformationData.php';
include_once 'Models/ThreeDSecureData.php';

class MACCalculater
{

    public $encryptionKey;

    public $macMerchantNo;

    public $macTerminalNo;

    // public function getMAcSale(CardInformationData $cardInformationData, $Amount){
    // $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $cardInformationData->CardNo. $cardInformationData->Cvc2 . $cardInformationData->ExpireDate . $Amount . $this->EncryptionKey;
    // $this->MAC = hash("sha256", $this->MAC,true);
    // $this->MAC = base64_encode($this->MAC);
    // return $this->MAC;
    // }
    
    // public function getMACCapture($Amount,$ReferanceCode){
    // $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $Amount . $ReferanceCode . $this->EncryptionKey;
    // $this->MAC = hash("sha256", $this->MAC,true);
    // $this->MAC = base64_encode($this->MAC);
    // return $this->MAC;
    // }
    
    // public function getMACVft(CardInformationData $cardInformationData, $Amount, $VftCode){
    // $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $cardInformationData->CardNo. $cardInformationData->Cvc2 . $cardInformationData->ExpireDate . $Amount . $VftCode . $this->EncryptionKey;
    // $this->MAC = hash("sha256", $this->MAC,true);
    // $this->MAC = base64_encode($this->MAC);
    // return $this->MAC;
    // }
    
    // public function getMACPointInquiry(CardInformationData $cardInformationData){
    // $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $cardInformationData->CardNo. $cardInformationData->Cvc2 . $cardInformationData->ExpireDate. $this->EncryptionKey;
    // $this->MAC = hash("sha256", $this->MAC,true);
    // $this->MAC = base64_encode($this->MAC);
    // return $this->MAC;
    // }
    public function getMACReferenceAndOrderId($ReferanceCode, $OrderId)
    {
        $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $ReferanceCode . $OrderId . $this->encryptionKey;
        $this->MAC = hash("sha256", $this->MAC, true);
        $this->MAC = base64_encode($this->MAC);
        return $this->MAC;
    }

    public function getMACReference($ReferanceCode)
    {
        $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $ReferanceCode . $this->encryptionKey;
        $this->MAC = hash("sha256", $this->MAC, true);
        $this->MAC = base64_encode($this->MAC);
        return $this->MAC;
    }

    public function getMACOrderId($OrderId)
    {
        $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $OrderId . $this->encryptionKey;
        $this->MAC = hash("sha256", $this->MAC, true);
        $this->MAC = base64_encode($this->MAC);
        return $this->MAC;
    }

    public function getMAcWithCardInfo(CardInformationData $cardInformationData)
    {
        $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $cardInformationData->CardNo . $cardInformationData->Cvc2 . $cardInformationData->ExpireDate . $this->encryptionKey;
        $this->MAC = hash("sha256", $this->MAC, true);
        $this->MAC = base64_encode($this->MAC);
        return $this->MAC;
    }

    public function getMac()
    {
        $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $this->encryptionKey;
        $this->MAC = hash("sha256", $this->MAC, true);
        $this->MAC = base64_encode($this->MAC);
        return $this->MAC;
    }

    public function getMac3D(ThreeDSecureData $threeDSecure)
    {
        $this->MAC = $this->macMerchantNo . $this->macTerminalNo . $threeDSecure->SecureTransactionId . $threeDSecure->CavvData . $threeDSecure->Eci . $threeDSecure->MdStatus . $this->encryptionKey;
        $this->MAC = hash("sha256", $this->MAC, true);
        $this->MAC = base64_encode($this->MAC);
        return $this->MAC;
    }

    static public function test()
    {
        return $_SESSION["point"];
    }
}