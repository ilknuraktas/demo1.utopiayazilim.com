<?php

class TrioReturnRequestData extends ReferenceTransactionData
{

    public $AuthCode;

    /**
     *
     * @return the $AuthCode
     */
    public function getAuthCode()
    {
        return $this->AuthCode;
    }

    /**
     *
     * @param field_type $AuthCode
     */
    public function setAuthCode($AuthCode)
    {
        $this->AuthCode = $AuthCode;
    }
}

