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
     * @return mixed
     */
    public function getTravelStartDate()
    {
        return $this->travelStartDate;
    }


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
     * @return mixed
     */
    public function getTravelEndDate()
    {
        return $this->travelEndDate;
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
     * @return mixed
     */
    public function getLengthOfStay()
    {
        return $this->lengthOfStay;
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