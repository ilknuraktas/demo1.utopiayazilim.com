<?php
include_once 'ServiceResponseData.php';
include_once 'PointData.php';

class TurkcellSaleResponseData
{

    public $AuthCode;

    public $AcquirerReferenceCode;

    public $PointData = array();

    public $Amount;

    protected $data;

    public $ServiceResponseData;

    function __construct()
    {
        $this->data = new PointData();
        $this->ServiceResponseData = new ServiceResponseData();
    }

    function getPointData($order)
    {
        if ($order - 1 > count($this->PointData))
            return "";
        else {
            $this->data = (object) $this->PointData[$order];
            return $this->data;
        }
    }
}

