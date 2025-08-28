<?php
include_once 'TrioRequestBase.php';

class TrioSingleRequestData extends TrioRequestBase
{

    public $TerminalDayCount;

    public $DueDate;

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
     * @return the $DueDate
     */
    public function getDueDate()
    {
        return $this->DueDate;
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
     * @param field_type $DueDate
     */
    public function setDueDate($DueDate)
    {
        $this->DueDate = $DueDate;
    }
}

