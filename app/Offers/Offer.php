<?php

namespace App\Offers;

use App\Offers\Nodes\DateRange;
use App\Offers\Nodes\Destination;
use App\Offers\Nodes\Hotel;
use App\Offers\Nodes\Price;
use App\Utilities\ToArrayToJson;


/**
 * Class Offer
 *
 * @package App\Offers
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class Offer
{
    use ToArrayToJson;

    /**
     * @var DateRange
     */
    private $dates;
    /**
     * @var Destination
     */
    private $destination;
    /**
     * @var Price
     */
    private $price;
    /**
     * @var Hotel
     */
    private $hotel;

    /**
     * @param DateRange $dates
     */
    public function setDates(DateRange $dates)
    {
        $this->dates = $dates;
    }

    /**
     * @param Destination $destination
     */
    public function setDestination(Destination $destination)
    {
        $this->destination = $destination;
    }

    /**
     * @param Price $price
     */
    public function setPrice(Price $price)
    {
        $this->price = $price;
    }

    /**
     * @param Hotel $hotel
     */
    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }

}