<?php
include_once 'TrioRequestBase.php';

class TrioMultipleRequestData extends TrioRequestBase
{

    public $TerminalDayCount;

    public $InstallmentCount;

    /**
     *
     * @return the $TerminalDayCount
     */
    public function getTerminalDayCount()
    {
        return $this->TerminalDayCount;
    }

    /**
     *
     * @return the $InstallmentCount
     */
    public function getInstallmentCount()
    {
        return $this->InstallmentCount;
    }

    /**
     *
     * @param field_type $TerminalDayCount
     */
    public function setTerminalDayCount($TerminalDayCount)
    {
        $this->TerminalDayCount = $TerminalDayCount;
    }

    /**
     *
     * @param field_type $InstallmentCount
     */
    public function setInstallmentCount($InstallmentCount)
    {
        $this->InstallmentCount = $InstallmentCount;
    }
}

