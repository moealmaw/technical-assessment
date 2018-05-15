<?php

namespace App\Offers\Nodes;

use App\Utilities\ToArrayToJson;

/**
 * Class Price
 *
 * @package App\Offers\Nodes
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class Hotel
{
    use ToArrayToJson;
    /**
     * @var
     */
    private $streetAddress;
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;
    /**
     * @var float
     */
    private $starRating;
    /**
     * @var
     */
    private $guestReviewRating;
    /**
     * @var
     */
    private $reviewTotal;
    /**
     * @var array
     */
    private $imageUrl;

    /**
     * @param mixed $streetAddress
     *
     * @return $this
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * @param mixed $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @param mixed $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @param mixed $starRating
     *
     * @return $this
     */
    public function setStarRating($starRating)
    {
        $this->starRating = $starRating;

        return $this;
    }

    /**
     * @param mixed $guestReviewRating
     *
     * @return $this
     */
    public function setGuestReviewRating($guestReviewRating)
    {
        $this->guestReviewRating = $guestReviewRating;

        return $this;
    }

    /**
     * @param mixed $reviewTotal
     *
     * @return $this
     */
    public function setReviewTotal($reviewTotal)
    {
        $this->reviewTotal = $reviewTotal;

        return $this;
    }

    /**
     * @param mixed $imageUrl
     *
     * @return $this
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = [
            "thumb"  => str_replace("_t.jpg", "_t.jpg", $imageUrl),
            "small"  => str_replace("_t.jpg", "_s.jpg", $imageUrl),
            "large"  => str_replace("_t.jpg", "_l.jpg", $imageUrl),
            "xlarge" => str_replace("_t.jpg", "_z.jpg", $imageUrl),
        ];

        return $this;
    }


}