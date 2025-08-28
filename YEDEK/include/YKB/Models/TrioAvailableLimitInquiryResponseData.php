<?php
include_once 'LimitInfo.php';

class TrioAvailableLimitInquiryResponseData extends TrioSingleResponseData
{

    public $LimitInfo = array();

    protected $Data;

    function __construct()
    {
        $this->Data = new LimitInfo();
        $this->ServiceResponseData = new ServiceResponseData();
    }

    function getLimitInfo($order)
    {
        if (($order) >= count($this->LimitInfo))
            return "";
        else {
            $this->Data = (object) $this->LimitInfo[$order];
            return $this->Data;
        }
    }
}

