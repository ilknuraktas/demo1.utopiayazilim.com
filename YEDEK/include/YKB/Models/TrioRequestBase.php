<?php
include_once 'IncomingTransactionData.php';

class TrioRequestBase extends IncomingTransactionData
{

    public $ExtraRefNo;

    public $FirmTerminalId;

    /**
     *
     * @return the $ExtraRefNo
     */
    public function getExtraRefNo()
    {
        return $this->ExtraRefNo;
    }

    /**
     *
     * @return the $FirmTerminalId
     */
    public function getFirmTerminalId()
    {
        return $this->FirmTerminalId;
    }

    /**
     *
     * @param field_type $ExtraRefNo
     */
    public function setExtraRefNo($ExtraRefNo)
    {
        $this->ExtraRefNo = $ExtraRefNo;
    }

    /**
     *
     * @param field_type $FirmTerminalId
     */
    public function setFirmTerminalId($FirmTerminalId)
    {
        $this->FirmTerminalId = $FirmTerminalId;
    }
}

