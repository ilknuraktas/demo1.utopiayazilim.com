<?php
include_once 'BillingData.php';
include_once 'ShippingData.php';
include_once 'CustomerData.php';

class AdditionalInfoData
{

    public $BillingData;

    public $ShippingData;

    public $CustomerData;

    /**
     *
     * @return the $BillingData
     */
    public function getBillingData()
    {
        return $this->BillingData;
    }

    /**
     *
     * @return the $ShippingData
     */
    public function getShippingData()
    {
        return $this->ShippingData;
    }

    /**
     *
     * @return the $CustomerData
     */
    public function getCustomerData()
    {
        return $this->CustomerData;
    }

    /**
     *
     * @param field_type $BillingData
     */
    public function setBillingData(BillingData $BillingData)
    {
        $this->BillingData = $BillingData;
    }

    /**
     *
     * @param field_type $ShippingData
     */
    public function setShippingData(ShippingData $ShippingData)
    {
        $this->ShippingData = $ShippingData;
    }

    /**
     *
     * @param field_type $CustomerData
     */
    public function setCustomerData(CustomerData $CustomerData)
    {
        $this->CustomerData = $CustomerData;
    }
}

