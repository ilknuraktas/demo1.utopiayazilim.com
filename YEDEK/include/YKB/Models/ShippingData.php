<?php

class ShippingData
{

    public $Name;

    public $Company;

    public $Street1;

    public $Street2;

    public $Street3;

    public $City;

    public $StateProv;

    public $PostalCode;

    public $Country;

    public $PhoneNumber;

    /**
     *
     * @return the $Name
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     *
     * @return the $Company
     */
    public function getCompany()
    {
        return $this->Company;
    }

    /**
     *
     * @return the $Street1
     */
    public function getStreet1()
    {
        return $this->Street1;
    }

    /**
     *
     * @return the $Street2
     */
    public function getStreet2()
    {
        return $this->Street2;
    }

    /**
     *
     * @return the $Street3
     */
    public function getStreet3()
    {
        return $this->Street3;
    }

    /**
     *
     * @return the $City
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     *
     * @return the $StateProv
     */
    public function getStateProv()
    {
        return $this->StateProv;
    }

    /**
     *
     * @return the $PostalCode
     */
    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    /**
     *
     * @return the $Country
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     *
     * @return the $PhoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     *
     * @param field_type $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     *
     * @param field_type $Company
     */
    public function setCompany($Company)
    {
        $this->Company = $Company;
    }

    /**
     *
     * @param field_type $Street1
     */
    public function setStreet1($Street1)
    {
        $this->Street1 = $Street1;
    }

    /**
     *
     * @param field_type $Street2
     */
    public function setStreet2($Street2)
    {
        $this->Street2 = $Street2;
    }

    /**
     *
     * @param field_type $Street3
     */
    public function setStreet3($Street3)
    {
        $this->Street3 = $Street3;
    }

    /**
     *
     * @param field_type $City
     */
    public function setCity($City)
    {
        $this->City = $City;
    }

    /**
     *
     * @param field_type $StateProv
     */
    public function setStateProv($StateProv)
    {
        $this->StateProv = $StateProv;
    }

    /**
     *
     * @param field_type $PostalCode
     */
    public function setPostalCode($PostalCode)
    {
        $this->PostalCode = $PostalCode;
    }

    /**
     *
     * @param field_type $Country
     */
    public function setCountry($Country)
    {
        $this->Country = $Country;
    }

    /**
     *
     * @param field_type $PhoneNumber
     */
    public function setPhoneNumber($PhoneNumber)
    {
        $this->PhoneNumber = $PhoneNumber;
    }
    /*
     * function __construct($Name,$Company,$Street1,$Street2,$Street3,$City,$StateProv,$PostalCode,$Country,$PhoneNumber){
     * $this->Name=$Name;
     * $this->Company=$Company;
     * $this->Street1=$Street1;
     * $this->Street2=$Street2;
     * $this->Street3=$Street3;
     * $this->City=$City;
     * $this->StateProv=$StateProv;
     * $this->PostalCode=$PostalCode;
     * $this->Country=$Country;
     * $this->PhoneNumber=$PhoneNumber;
     * }
     */
}
?>