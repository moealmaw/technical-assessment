<?php

namespace App\Offers\Nodes;

use App\Utilities\ToArrayToJson;

/**
 * Class DateRange
 *
 * @package App\Offers\Nodes
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class DateRange
{
    use ToArrayToJson;

    /**
     * @var
     */
    private $travelStartDate;
    /**
     * @var
     */
    private $travelEndDate;
    /**
     * @var
     */
    private $lengthOfStay;

    /**
     * @param $travelStartDate
     *
     * @return $this
     */
    public function setTravelStartDate($travelStartDate)
    {
        $this->travelStartDate = $travelStartDate;

        return $this;
    }

    /**
     * @param $travelEndDate
     *
     * @return $this
     */
    public function setTravelEndDate($travelEndDate)
    {
        $this->travelEndDate = $travelEndDate;

        return $this;
    }

    /**
     * @param $lengthOfStay
     *
     * @return $this
     */
    public function setLengthOfStay($lengthOfStay)
    {
        $this->lengthOfStay = $lengthOfStay;

        return $this;
    }

}