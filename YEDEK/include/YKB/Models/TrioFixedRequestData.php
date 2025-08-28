<?php
include_once 'TrioRequestBase.php';

class TrioFixedRequestData extends TrioRequestBase
{

    public $NoWarranty;

    /**
     *
     * @return the $NoWarranty
     */
    public function getNoWarranty()
    {
        return $this->NoWarranty;
    }

    /**
     *
     * @param field_type $NoWarranty
     */
    public function setNoWarranty($NoWarranty)
    {
        $this->NoWarranty = $NoWarranty;
    }
}

