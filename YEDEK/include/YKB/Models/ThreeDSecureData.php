<?php

class ThreeDSecureData
{

    public $SecureTransactionId;

    public $CavvData;

    public $Eci;

    public $MdStatus;

    public $MD;

    /**
     *
     * @return the $SecureTransactionId
     */
    public function getSecureTransactionId()
    {
        return $this->SecureTransactionId;
    }

    /**
     *
     * @return the $CavvData
     */
    public function getCavvData()
    {
        return $this->CavvData;
    }

    /**
     *
     * @return the $Eci
     */
    public function getEci()
    {
        return $this->Eci;
    }

    /**
     *
     * @return the $MdStatus
     */
    public function getMdStatus()
    {
        return $this->MdStatus;
    }

    /**
     *
     * @param field_type $SecureTransactionId
     */
    public function setSecureTransactionId($SecureTransactionId)
    {
        $this->SecureTransactionId = $SecureTransactionId;
    }

    /**
     *
     * @param field_type $CavvData
     */
    public function setCavvData($CavvData)
    {
        $this->CavvData = $CavvData;
    }

    /**
     *
     * @param field_type $Eci
     */
    public function setEci($Eci)
    {
        $this->Eci = $Eci;
    }

    /**
     *
     * @param field_type $MdStatus
     */
    public function setMdStatus($MdStatus)
    {
        $this->MdStatus = $MdStatus;
    }

    function __construct($SecureTransactionId, $CavvData, $Eci, $MdStatus, $Md)
    {
        $this->SecureTransactionId = $SecureTransactionId;
        $this->CavvData = $CavvData;
        $this->Eci = $Eci;
        $this->MdStatus = $MdStatus;
        $this->MD = $Md;
    }
}