<?php

class CustomerData
{

    public $IPAddress;

    public $EmailAddress;

    function __construct()
    {}

    /**
     *
     * @return the $IPAddress
     */
    public function getIPAddress()
    {
        return $this->IPAddress;
    }

    /**
     *
     * @return the $EmailAddress
     */
    public function getEmailAddress()
    {
        return $this->EmailAddress;
    }

    /**
     *
     * @param field_type $IPAddress
     */
    public function setIPAddress($IPAddress)
    {
        $this->IPAddress = $IPAddress;
    }

    /**
     *
     * @param field_type $EmailAddress
     */
    public function setEmailAddress($EmailAddress)
    {
        $this->EmailAddress = $EmailAddress;
    }
}
?>