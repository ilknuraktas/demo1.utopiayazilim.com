<?php

class DealerData
{

    // TODO - Insert your code here
    public $DealerCode;

    public $SubDealerCode;

    public $Tckn;

    public $TaxId;

    function __construct($DealerCode, $SubDealerCode, $Tckn, $TaxId)
    {
        $this->DealerCode = $DealerCode;
        $this->SubDealerCode = $SubDealerCode;
        $this->Tckn = $Tckn;
        $this->TaxId = $TaxId;
    }

    /**
     *
     * @return the $DealerCode
     */
    public function getDealerCode()
    {
        return $this->DealerCode;
    }

    /**
     *
     * @return the $SubDealerCode
     */
    public function getSubDealerCode()
    {
        return $this->SubDealerCode;
    }

    /**
     *
     * @return the $Tckn
     */
    public function getTckn()
    {
        return $this->Tckn;
    }

    /**
     *
     * @return the $TaxId
     */
    public function getTaxId()
    {
        return $this->TaxId;
    }

    /**
     *
     * @param field_type $DealerCode
     */
    public function setDealerCode($DealerCode)
    {
        $this->DealerCode = $DealerCode;
    }

    /**
     *
     * @param field_type $SubDealerCode
     */
    public function setSubDealerCode($SubDealerCode)
    {
        $this->SubDealerCode = $SubDealerCode;
    }

    /**
     *
     * @param field_type $Tckn
     */
    public function setTckn($Tckn)
    {
        $this->Tckn = $Tckn;
    }

    /**
     *
     * @param field_type $TaxId
     */
    public function setTaxId($TaxId)
    {
        $this->TaxId = $TaxId;
    }
}

