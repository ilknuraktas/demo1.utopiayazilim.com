<?php
include_once 'RequestBase.php';
include_once 'ThreeDSecureData.php';
include_once 'CardInformationData.php';
include_once 'AdditionalInfoData.php';

class TransactionDataWithCardInfo extends RequestBase
{

    public $PaymentInstrumentType = "CARD";

    public $CardInformationData;

    public $IsTDSecureMerchant;

    public $ThreeDSecureData;

    public $AdditionalInfoData;

    /**
     *
     * @return the $PaymentInstrumentType
     */
    public function getPaymentInstrumentType()
    {
        return $this->PaymentInstrumentType;
    }

    /**
     *
     * @return the $CardInformationData
     */
    public function getCardInformationData()
    {
        return $this->CardInformationData;
    }

    /**
     *
     * @return the $IsTDSecureMerchant
     */
    public function getIsTDSecureMerchant()
    {
        return $this->IsTDSecureMerchant;
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
     * @return the $AdditionalInfoData
     */
    public function getAdditionalInfoData()
    {
        return $this->AdditionalInfoData;
    }

    /**
     *
     * @param string $PaymentInstrumentType
     */
    public function setPaymentInstrumentType($PaymentInstrumentType)
    {
        $this->PaymentInstrumentType = $PaymentInstrumentType;
    }

    /**
     *
     * @param field_type $CardInformationData
     */
    public function setCardInformationData(CardInformationData $CardInformationData)
    {
        $this->CardInformationData = $CardInformationData;
    }

    /**
     *
     * @param field_type $IsTDSecureMerchant
     */
    public function setIsTDSecureMerchant($IsTDSecureMerchant)
    {
        $this->IsTDSecureMerchant = $IsTDSecureMerchant;
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
     * @param field_type $AdditionalInfoData
     */
    public function setAdditionalInfoData(AdditionalInfoData $AdditionalInfoData)
    {
        $this->AdditionalInfoData = $AdditionalInfoData;
    }
}

