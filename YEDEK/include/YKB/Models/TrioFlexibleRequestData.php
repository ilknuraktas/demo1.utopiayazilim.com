<?php

class TrioFlexibleRequestData extends TransactionDataWithCardInfo
{

    public $NoWarranty;

    public $ExtraRefNo;

    public $FirmTerminalId;

    public $CurrencyCode;

    public $OrderId;

    public $InstallmentCount;

    public $InstalmentType;

    public $TerminalDayCount;

    public $DueInfoList;

    /**
     *
     * @return the $NoWarranty
     */
    public function getNoWarranty()
    {
        return $this->NoWarranty;
    }

    /**
     *
     * @return the $ExtraRefNo
     */
    public function getExtraRefNo()
    {
        return $this->ExtraRefNo;
    }

    /**
     *
     * @return the $FirmTerminalId
     */
    public function getFirmTerminalId()
    {
        return $this->FirmTerminalId;
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
     * @return the $OrderId
     */
    public function getOrderId()
    {
        return $this->OrderId;
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
     * @return the $InstalmentType
     */
    public function getInstalmentType()
    {
        return $this->InstalmentType;
    }

    /**
     *
     * @return the $TerminalDayCount
     */
    public function getTerminalDayCount()
    {
        return $this->TerminalDayCount;
    }

    /**
     *
     * @return the $DueInfoList
     */
    public function getDueInfoList()
    {
        return $this->DueInfoList;
    }

    /**
     *
     * @param field_type $NoWarranty
     */
    public function setNoWarranty($NoWarranty)
    {
        $this->NoWarranty = $NoWarranty;
    }

    /**
     *
     * @param field_type $ExtraRefNo
     */
    public function setExtraRefNo($ExtraRefNo)
    {
        $this->ExtraRefNo = $ExtraRefNo;
    }

    /**
     *
     * @param field_type $FirmTerminalId
     */
    public function setFirmTerminalId($FirmTerminalId)
    {
        $this->FirmTerminalId = $FirmTerminalId;
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
     * @param field_type $OrderId
     */
    public function setOrderId($OrderId)
    {
        $this->OrderId = $OrderId;
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
     * @param field_type $InstalmentType
     */
    public function setInstalmentType($InstalmentType)
    {
        $this->InstalmentType = $InstalmentType;
    }

    /**
     *
     * @param field_type $TerminalDayCount
     */
    public function setTerminalDayCount($TerminalDayCount)
    {
        $this->TerminalDayCount = $TerminalDayCount;
    }

    /**
     *
     * @param field_type $DueInfoList
     */
    public function setDueInfoList($DueInfoList)
    {
        $this->DueInfoList = $DueInfoList;
    }
}

