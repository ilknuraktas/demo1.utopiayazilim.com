<?php
include_once 'ServiceResponseData.php';
include_once 'KOIData.php';

class KOICampaignQueryData
{

    public $KOIData = array();

    protected $Data;

    public $ServiceResponseData;

    function __construct()
    {
        $this->Data = new KOIData();
        $this->ServiceResponseData = new ServiceResponseData();
    }

    function getKOIData($order)
    {
        if (($order) >= count($this->KOIData))
            return "";
        else {
            $this->Data = (object) $this->KOIData[$order];
            return $this->Data;
        }
    }
}

