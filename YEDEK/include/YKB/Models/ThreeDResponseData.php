<?php

class ThreeDResponseData
{

    public $CCPrefix;

    public $TranType;

    public $Amount;

    public $OrderId;

    public $MerchantId;

    public $CAVV;

    public $CAVVAlgorithm;

    public $ECI;

    public $MD;

    public $MdErrorMessage;

    public $MdStatus;

    public $SecureTransactionId;

    public $Mac;

    public $MacParams;

    /**
     *
     * @return the $CCPrefix
     */
    public function getCCPrefix()
    {
        return $this->CCPrefix;
    }

    /**
     *
     * @return the $TranType
     */
    public function getTranType()
    {
        return $this->TranType;
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
     * @return the $OrderId
     */
    public function getOrderId()
    {
        return $this->OrderId;
    }

    /**
     *
     * @return the $MerchantId
     */
    public function getMerchantId()
    {
        return $this->MerchantId;
    }

    /**
     *
     * @return the $CAVV
     */
    public function getCAVV()
    {
        return $this->CAVV;
    }

    /**
     *
     * @return the $CAVVAlgorithm
     */
    public function getCAVVAlgorithm()
    {
        return $this->CAVVAlgorithm;
    }

    /**
     *
     * @return the $ECI
     */
    public function getECI()
    {
        return $this->ECI;
    }

    /**
     *
     * @return the $MD
     */
    public function getMD()
    {
        return $this->MD;
    }

    /**
     *
     * @return the $MdErrorMessage
     */
    public function getMdErrorMessage()
    {
        return $this->MdErrorMessage;
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
     * @return the $SecureTransactionId
     */
    public function getSecureTransactionId()
    {
        return $this->SecureTransactionId;
    }

    /**
     *
     * @return the $Mac
     */
    public function getMac()
    {
        return $this->Mac;
    }

    /**
     *
     * @return the $MacParams
     */
    public function getMacParams()
    {
        return $this->MacParams;
    }

    /**
     *
     * @param field_type $CCPrefix
     */
    public function setCCPrefix($CCPrefix)
    {
        $this->CCPrefix = $CCPrefix;
    }

    /**
     *
     * @param field_type $TranType
     */
    public function setTranType($TranType)
    {
        $this->TranType = $TranType;
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
     * @param field_type $OrderId
     */
    public function setOrderId($OrderId)
    {
        $this->OrderId = $OrderId;
    }

    /**
     *
     * @param field_type $MerchantId
     */
    public function setMerchantId($MerchantId)
    {
        $this->MerchantId = $MerchantId;
    }

    /**
     *
     * @param field_type $CAVV
     */
    public function setCAVV($CAVV)
    {
        $this->CAVV = $CAVV;
    }

    /**
     *
     * @param field_type $CAVVAlgorithm
     */
    public function setCAVVAlgorithm($CAVVAlgorithm)
    {
        $this->CAVVAlgorithm = $CAVVAlgorithm;
    }

    /**
     *
     * @param field_type $ECI
     */
    public function setECI($ECI)
    {
        $this->ECI = $ECI;
    }

    /**
     *
     * @param field_type $MD
     */
    public function setMD($MD)
    {
        $this->MD = $MD;
    }

    /**
     *
     * @param field_type $MdErrorMessage
     */
    public function setMdErrorMessage($MdErrorMessage)
    {
        $this->MdErrorMessage = $MdErrorMessage;
    }

    /**
     *
     * @param field_type $MdStatus
     */
    public function setMdStatus($MdStatus)
    {
        $this->MdStatus = $MdStatus;
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
     * @param field_type $Mac
     */
    public function setMac($Mac)
    {
        $this->Mac = $Mac;
    }

    /**
     *
     * @param field_type $MacParams
     */
    public function setMacParams($MacParams)
    {
        $this->MacParams = $MacParams;
    }
}

