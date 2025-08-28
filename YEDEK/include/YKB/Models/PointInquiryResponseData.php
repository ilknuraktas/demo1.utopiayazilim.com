<?php
include_once 'ServiceResponseData.php';
include_once 'PointDataList.php';

class PointInquiryResponseData
{

    public $PointDataList = array();

    protected $Point;

    public $ServiceResponseData;

    function __construct()
    {
        $this->Data = new PointData();
        $this->ServiceResponseData = new ServiceResponseData();
    }

    function getPointData($order)
    {
        if (($order) >= count($this->PointDataList))
            return "";
        else {
            $this->Data = (object) $this->PointDataList[$order];
            return $this->Data;
        }
    }
}

