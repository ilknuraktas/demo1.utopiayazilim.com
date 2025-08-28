<?php

class TrioPaymentDelayResponseData extends TrioSingleResponseData
{

    public $DelayTrioDate;

    public $DelayTrioAmount;

    /**
     *
     * @return the $DelayTrioDate
     */
    public function getDelayTrioDate()
    {
        return $this->DelayTrioDate;
    }

    /**
     *
     * @return the $DelayTrioAmount
     */
    public function getDelayTrioAmount()
    {
        return $this->DelayTrioAmount;
    }

    /**
     *
     * @param field_type $DelayTrioDate
     */
    public function setDelayTrioDate($DelayTrioDate)
    {
        $this->DelayTrioDate = $DelayTrioDate;
    }

    /**
     *
     * @param field_type $DelayTrioAmount
     */
    public function setDelayTrioAmount($DelayTrioAmount)
    {
        $this->DelayTrioAmount = $DelayTrioAmount;
    }
}

