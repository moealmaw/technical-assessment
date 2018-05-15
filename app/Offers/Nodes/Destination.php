<?php

namespace App\Offers\Nodes;

use App\Utilities\ToArrayToJson;

/**
 * Class Destination
 *
 * @package App\Offers\Nodes
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class Destination
{
    use ToArrayToJson;

    /**
     * @var
     */
    private $regionId;
    /**
     * @var
     */
    private $country;
    /**
     * @var
     */
    private $city;
    /**
     * @var
     */
    private $longName;
    /**
     * @var
     */
    private $shortName;

    /**
     * @param mixed $regionId
     *
     * @return $this
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;

        return $this;
    }

    /**
     * @param mixed $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @param mixed $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param mixed $longName
     *
     * @return $this
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * @param mixed $shortName
     *
     * @return $this
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

}