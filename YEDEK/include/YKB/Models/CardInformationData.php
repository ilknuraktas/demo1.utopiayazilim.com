<?php

class CardInformationData
{

    public $CardNo;

    public $ExpireDate;

    public $Cvc2;

    public $CardHolderName;

    /**
     *
     * @return the $CardNo
     */
    public function getCardNo()
    {
        return $this->CardNo;
    }

    /**
     *
     * @return the $ExpireDate
     */
    public function getExpireDate()
    {
        return $this->ExpireDate;
    }

    /**
     *
     * @return the $Cvc2
     */
    public function getCvc2()
    {
        return $this->Cvc2;
    }

    /**
     *
     * @return the $CardHolderName
     */
    public function getCardHolderName()
    {
        return $this->CardHolderName;
    }

    /**
     *
     * @param field_type $CardNo
     */
    public function setCardNo($CardNo)
    {
        $this->CardNo = $CardNo;
    }

    /**
     *
     * @param field_type $ExpireDate
     */
    public function setExpireDate($ExpireDate)
    {
        $this->ExpireDate = $ExpireDate;
    }

    /**
     *
     * @param field_type $Cvc2
     */
    public function setCvc2($Cvc2)
    {
        $this->Cvc2 = $Cvc2;
    }

    /**
     *
     * @param field_type $CardHolderName
     */
    public function setCardHolderName($CardHolderName)
    {
        $this->CardHolderName = $CardHolderName;
    }

    function __construct($cardNo, $expireDate, $cvc2, $cardHolderName)
    {
        $this->CardNo = $cardNo;
        $this->ExpireDate = $expireDate;
        $this->Cvc2 = $cvc2;
        $this->CardHolderName = $cardHolderName;
    }
}

?>