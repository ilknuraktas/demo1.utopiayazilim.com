<?php
include_once 'TransactionDataWithCardInfo.php';

class VftQueryRequestData extends TransactionDataWithCardInfo
{

    public $Amount;

    public $CurrencyCode;

    public $InstallmentCount;

    public $InstallmentType;

    public $VFTCode;

    public $OrderId;

    /**
     *
     * @return the $OrderId
     */
    public function getOrderId()
    {
        return $this->OrderId;
    }

    /**
     *
     * @param field_type $OrderId
     */
    public function setOrderId($OrderId)
    {
        $this->OrderId = $OrderId;
    }

    /**
     *
     * @return the $CurrencyCode
     */
    public function getCurrencyCode()
    {
        return $this->CurrencyCode;
    }

    /**
     *
     * @param field_type $CurrencyCode
     */
    public function setCurrencyCode($CurrencyCode)
    {
        $this->CurrencyCode = $CurrencyCode;
    }

    /**
     *
     * @return the $Amount
     */
    public function getAmount()
    {
        return $this->Amount;
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
     * @return the $InstallmentType
     */
    public function getInstallmentType()
    {
        return $this->InstallmentType;
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
     * @param field_type $Amount
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
    }

    /**
     *
     * @param field_type $InstallmentCount
     */
    public function setInstallmentCount($InstallmentCount)
    {
        $this->InstallmentCount = $InstallmentCount;
    }

    /**
     *
     * @param field_type $InstallmentType
     */
    public function setInstallmentType($InstallmentType)
    {
        $this->InstallmentType = $InstallmentType;
    }

    /**
     *
     * @param field_type $VFTCode
     */
    public function setVFTCode($VFTCode)
    {
        $this->VFTCode = $VFTCode;
    }
}

