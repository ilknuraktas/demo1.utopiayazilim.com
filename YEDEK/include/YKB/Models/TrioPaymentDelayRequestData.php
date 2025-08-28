<?php
include_once 'MainTransactionData.php';

class TrioPaymentDelayRequestData extends MainTransactionData
{

    public $DelayData;

    /**
     *
     * @return the $DelayData
     */
    public function getDelayData()
    {
        return $this->DelayData;
    }

    /**
     *
     * @param field_type $DelayData
     */
    public function setDelayData($DelayData)
    {
        $this->DelayData = $DelayData;
    }
}

