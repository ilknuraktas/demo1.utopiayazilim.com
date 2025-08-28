<?php
include_once 'PaymentInfo.php';

class TrioPaymentListInquiry extends TrioSingleResponseData
{

    public $PaymentInfo = array();

    protected $Data;

    function __construct()
    {
        $this->Data = new PaymentInfo();
    }

    function getPaymentIfo($order)
    {
        if (($order) >= count($this->PaymentInfo))
            return "";
        else {
            $this->Data = (object) $this->PaymentInfo[$order];
            return $this->Data;
        }
    }
}

