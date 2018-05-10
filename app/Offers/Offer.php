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
     * @return DateRange
     */
    public function getDates(): DateRange
    {
        return $this->dates;
    }

    /**
     * @param DateRange $dates
     */
    public function setDates(DateRange $dates)
    {
        $this->dates = $dates;
    }

    /**
     * @return Destination
     */
    public function getDestination(): Destination
    {
        return $this->destination;
    }

    /**
     * @param Destination $destination
     */
    public function setDestination(Destination $destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     */
    public function setPrice(Price $price)
    {
        $this->price = $price;
    }

    /**
     * @return Hotel
     */
    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    /**
     * @param Hotel $hotel
     */
    public function setHotel(Hotel $hotel)
    {
        $this->hotel = $hotel;
    }

}