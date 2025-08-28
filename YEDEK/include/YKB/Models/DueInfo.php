<?php

class DueInfo
{

    public $DueDate;

    public $Amount;

    function __construct($DueDate, $Amount)
    {
        $this->DueDate = $DueDate;
        $this->Amount = $Amount;
    }

    /**
     *
     * @return the $DueDate
     */
    public function getDueDate()
    {
        return $this->DueDate;
    }

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
     * @param field_type $DueDate
     */
    public function setDueDate($DueDate)
    {
        $this->DueDate = $DueDate;
    }

    /**
     *
     * @param
     *            $Amount
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
    }
}

