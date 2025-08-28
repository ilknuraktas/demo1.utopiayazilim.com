<?php
include_once 'VFTData.php';

class VftResponseData extends SaleResponseData
{

    public $VFTData;

    function __construct()
    {
        $this->VFTData = new VFTData();
    }
}

