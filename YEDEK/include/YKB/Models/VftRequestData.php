<?php
include_once 'IncomingTransactionData.php';

class VftRequestData extends IncomingTransactionData
{

    public $InstallmentCount;

    public $InstallmentType = "N";

    public $KOICode;

    public $VFTCode;

    public $MerchantMessageData;

    public $PointAmount;

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
     * @param field_type $PointAmount
     */
    public function setPointAmount($PointAmount)
    {
        $this->PointAmount = $PointAmount;
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
     * @return the $VFTCode
     */
    public function getVFTCode()
    {
        return $this->VFTCode;
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
     * @param field_type $VFTCode
     */
    public function setVFTCode($VFTCode)
    {
        $this->VFTCode = $VFTCode;
    }

    /**
     *
     * @param field_type $MerchantMessageData
     */
    public function setMerchantMessageData($MerchantMessageData)
    {
        $this->MerchantMessageData = $MerchantMessageData;
    }
}

