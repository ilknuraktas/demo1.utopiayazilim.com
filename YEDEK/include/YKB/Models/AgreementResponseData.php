<?php
include_once 'TransactionData.php';
include_once 'ServiceResponseData.php';

class AgreementResponseData extends ServiceResponseData
{

    public $TransactionData = array();

    private $data;

    function __construct()
    {
        $this->data = new TransactionData();
    }

    function getTransactionData($order)
    {
        if (($order) >= count($this->TransactionData))
            return "";
        else {
            $this->data = (object) $this->TransactionData[$order];
            return $this->data;
        }
    }
}

