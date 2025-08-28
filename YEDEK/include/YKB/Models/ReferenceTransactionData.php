<?php

class ReferenceTransactionData extends MainTransactionData
{

    public $OrderId;

    public $ReferenceCode;

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
     * @return the $ReferenceCode
     */
    public function getReferenceCode()
    {
        return $this->ReferenceCode;
    }

    /**
     *
     * @param field_type $OrderId
     */
    public function setOrderId($OrderId)
    {
        $this->OrderId = $OrderId;
    }

    /**
     *
     * @param field_type $ReferenceCode
     */
    public function setReferenceCode($ReferenceCode)
    {
        $this->ReferenceCode = $ReferenceCode;
    }
}

