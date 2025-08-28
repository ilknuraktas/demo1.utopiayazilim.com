<?php
include_once 'IncomingTransactionData.php';

class AuthRequestData extends IncomingTransactionData
{

    public $PointAmount;

    public $InstallmentType = "N";

    public $InstallmentCount;

    public $KOICode;

    public $MerchantMessageData;

    public $IsEncrypted;

    /**
     *
     * @return the $PointAmount
     */
    public function getPointAmount()
    {
        return $this->PointAmount;
    }

    /**
     *
     * @return the $InstallmentType
     */
    public function getInstallmentType()
    {
        return $this->InstallmentType;
    }

    /**
     *
     * @return the $InstallmentCount
     */
    public function getInstallmentCount()
    {
        return $this->InstallmentCount;
    }

    /**
     *
     * @return the $KOICode
     */
    public function getKOICode()
    {
        return $this->KOICode;
    }

    /**
     *
     * @return the $MerchantMessageData
     */
    public function getMerchantMessageData()
    {
        return $this->MerchantMessageData;
    }

    /**
     *
     * @return the $isEncrypted
     */
    public function getIsEncrypted()
    {
        return $this->IsEncrypted;
    }

    /**
     *
     * @param field_type $PointAmount
     */
    public function setPointAmount($PointAmount)
    {
        $this->PointAmount = $PointAmount;
    }

    /**
     *
     * @param field_type $InstallmentCount
     */
    public function setInstallmentCount($InstallmentCount)
    {
        if ($InstallmentCount >= 2)
            $this->InstallmentType = "Y";
        $this->InstallmentCount = $InstallmentCount;
    }

    /**
     *
     * @param field_type $KOICode
     */
    public function setKOICode($KOICode)
    {
        $this->KOICode = $KOICode;
    }

    /**
     *
     * @param field_type $MerchantMessageData
     */
    public function setMerchantMessageData($MerchantMessageData)
    {
        $this->MerchantMessageData = $MerchantMessageData;
    }

    /**
     *
     * @param field_type $isEncrypted
     */
    public function setIsEncrypted($isEncrypted)
    {
        $this->IsEncrypted = $isEncrypted;
    }
}

