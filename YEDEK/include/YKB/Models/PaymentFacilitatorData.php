<?php

class PaymentFacilitatorData
{

    public $PaymentFacilitatorId;

    public $SubMerchantId;

    public $MerchantCategoryCode;

    function __construct($PaymentFacilitatorId, $SubMerchantId, $MerchantCategoryCode)
    {
        $this->PaymentFacilitatorId = $PaymentFacilitatorId;
        $this->SubMerchantId = $SubMerchantId;
        $this->MerchantCategoryCode = $MerchantCategoryCode;
    }

    /**
     *
     * @return the $PaymentFacilitatorId
     */
    public function getPaymentFacilitatorId()
    {
        return $this->PaymentFacilitatorId;
    }

    /**
     *
     * @return the $SubMerchantId
     */
    public function getSubMerchantId()
    {
        return $this->SubMerchantId;
    }

    /**
     *
     * @return the $MerchantCategoryCode
     */
    public function getMerchantCategoryCode()
    {
        return $this->MerchantCategoryCode;
    }

    /**
     *
     * @param field_type $PaymentFacilitatorId
     */
    public function setPaymentFacilitatorId($PaymentFacilitatorId)
    {
        $this->PaymentFacilitatorId = $PaymentFacilitatorId;
    }

    /**
     *
     * @param field_type $SubMerchantId
     */
    public function setSubMerchantId($SubMerchantId)
    {
        $this->SubMerchantId = $SubMerchantId;
    }

    /**
     *
     * @param field_type $MerchantCategoryCode
     */
    public function setMerchantCategoryCode($MerchantCategoryCode)
    {
        $this->MerchantCategoryCode = $MerchantCategoryCode;
    }
}

