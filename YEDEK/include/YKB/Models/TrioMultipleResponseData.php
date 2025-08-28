<?php
include_once 'InstallmentData.php';

class TrioMultipleResponseData extends TrioSingleResponseData
{

    public $InstallmentData;

    function __construct()
    {
        $this->InstallmentData = new InstallmentData();
    }
}

