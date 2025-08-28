<?php
include_once 'ServiceResponseData.php';
include_once 'PointDataList.php';
include_once 'InstallmentData.php';

class SaleResponseData
{

    public $AuthCode;

    public $ReferenceCode;

    public $PointDataList = array();

    public $InstallmentData;

    public $MessageData;

    private $Data;

    public $ServiceResponseData;

    function __construct()
    {
        $this->Data = new PointData();
        $this->InstallmentData = new InstallmentData();
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
?>
