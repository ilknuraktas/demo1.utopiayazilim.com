<?php

class TurkcellSaleRequestData extends TransactionDataWithCardInfo
{

    public $OrderId;

    public $PacketCode;

    public $GsmNo;

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
     * @return the $PacketCode
     */
    public function getPacketCode()
    {
        return $this->PacketCode;
    }

    /**
     *
     * @return the $GsmNo
     */
    public function getGsmNo()
    {
        return $this->GsmNo;
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
     * @param field_type $PacketCode
     */
    public function setPacketCode($PacketCode)
    {
        $this->PacketCode = $PacketCode;
    }

    /**
     *
     * @param field_type $GsmNo
     */
    public function setGsmNo($GsmNo)
    {
        $this->GsmNo = $GsmNo;
    }
}

