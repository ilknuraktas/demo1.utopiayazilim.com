<?php
include_once 'ServiceResponseData.php';
include_once 'VFTData.php';
include_once 'InstallmentData.php';

class VftQueryResponseData
{

    public $InstallmentData;

    public $VFTData;

    public $ServiceResponseData;

    function __construct()
    {
        $this->InstallmentData = new InstallmentData();
        $this->VFTData = new VFTData();
        $this->ServiceResponseData = new ServiceResponseData();
    }
}

