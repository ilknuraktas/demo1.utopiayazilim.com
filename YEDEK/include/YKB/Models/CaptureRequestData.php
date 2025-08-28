<?php
include_once 'MainTransactionData.php';

class CaptureRequestData extends MainTransactionData
{

    protected $Amount;

    protected $CurrencyCode;

    protected $InstallmentCount;

    protected $ReferenceCode;

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
     * @return the $CurrencyCode
     */
    public function getCurrencyCode()
    {
        return $this->CurrencyCode;
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
     * @return the $ReferenceCode
     */
    public function getReferenceCode()
    {
        return $this->ReferenceCode;
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
     * @param field_type $CurrencyCode
     */
    public function setCurrencyCode($CurrencyCode)
    {
        $this->CurrencyCode = $CurrencyCode;
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
     * @param field_type $ReferenceCode
     */
    public function setReferenceCode($ReferenceCode)
    {
        $this->ReferenceCode = $ReferenceCode;
    }
}

