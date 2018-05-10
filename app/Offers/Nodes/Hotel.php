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
     * @return mixed
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
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
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
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
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
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
     * @return mixed
     */
    public function getStarRating()
    {
        return $this->starRating;
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
     * @return mixed
     */
    public function getGuestReviewRating()
    {
        return $this->guestReviewRating;
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
     * @return mixed
     */
    public function getReviewTotal()
    {
        return $this->reviewTotal;
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
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
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