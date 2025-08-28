<?php
include_once 'ServiceResponseData.php';

class TrioResponseBase
{

    public $AuthCode;

    public $ReferenceCode;

    public $ServiceResponseData;

    function __construct()
    {
        $this->ServiceResponseData = new ServiceResponseData();
    }
}

