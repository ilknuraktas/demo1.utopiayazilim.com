<?php
include_once 'DealerData.php';
include_once 'ThreeDSecureData.php';
include_once 'PaymentFacilitatorData.php';

class RequestBase
{

    public $ApiType = Constants::apiType;

    public $ApiVersion = Constants::apiVersion;

    public $MerchantNo;

    public $TerminalNo;

    public $MAC;

    public $MACParams;

    public $IsEncrypted = "N";

    public $DealerData;

    public $ThreeDSecureData;

    public $PaymentFacilitatorData;

    /**
     *
     * @return the $DealerData
     */
    public function getDealerData()
    {
        return $this->DealerData;
    }

    /**
     *
     * @return the $ThreeDSecureData
     */
    public function getThreeDSecureData()
    {
        return $this->ThreeDSecureData;
    }

    /**
     *
     * @return the $PaymentFacilitatorData
     */
    public function getPaymentFacilitatorData()
    {
        return $this->PaymentFacilitatorData;
    }

    /**
     *
     * @param field_type $DealerData
     */
    public function setDealerData(DealerData $DealerData)
    {
        $this->DealerData = $DealerData;
    }

    /**
     *
     * @param field_type $ThreeDSecureData
     */
    public function setThreeDSecureData(ThreeDSecure $ThreeDSecureData)
    {
        $this->ThreeDSecureData = $ThreeDSecureData;
    }

    /**
     *
     * @param field_type $PaymentFacilitatorData
     */
    public function setPaymentFacilitatorData(PaymentFacilitatorData $PaymentFacilitatorData)
    {
        $this->PaymentFacilitatorData = $PaymentFacilitatorData;
    }

    /**
     *
     * @return the $IsEncrypted
     */
    public function getIsEncrypted()
    {
        return $this->IsEncrypted;
    }

    /**
     *
     * @param string $IsEncrypted
     */
    public function setIsEncrypted($IsEncrypted)
    {
        $this->IsEncrypted = $IsEncrypted;
    }
}

