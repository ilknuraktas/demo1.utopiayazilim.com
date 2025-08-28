<?php
include_once 'TransactionDataWithCardInfo.php';

class IncomingTransactionData extends TransactionDataWithCardInfo
{

    public $Amount;

    public $CurrencyCode;

    public $OrderId;

    /**
     *
     * @return the $Amount
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     *
     * @return the $CurrencyCode
     */
    public function getCurrencyCode()
    {
        return $this->CurrencyCode;
    }

    /**
     *
     * @return the $OrderId
     */
    public function getOrderId()
    {
        return $this->OrderId;
    }

    /**
     *
     * @param field_type $Amount
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
    }

    /**
     *
     * @param field_type $CurrencyCode
     */
    public function setCurrencyCode($CurrencyCode)
    {
        $this->CurrencyCode = $CurrencyCode;
    }

    /**
     *
     * @param field_type $OrderId
     */
    public function setOrderId($OrderId)
    {
        $this->OrderId = $OrderId;
    }
}

