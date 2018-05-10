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
class Price
{
    use ToArrayToJson;
    /**
     * @var
     */
    private $pricePerNight;
    /**
     * @var
     */
    private $priceOriginalPerNight;
    /**
     * @var
     */
    private $priceTotal;
    /**
     * @var
     */
    private $priceCurrency;
    /**
     * @var
     */
    private $pricePercentSaving;


    /**
     * @return mixed
     */
    public function getPricePerNight()
    {
        return $this->pricePerNight;
    }


    /**
     * @param $pricePerNight
     *
     * @return $this
     */
    public function setPricePerNight($pricePerNight)
    {
        $this->pricePerNight = $pricePerNight;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceOriginalPerNight()
    {
        return $this->priceOriginalPerNight;
    }


    /**
     * @param $priceOriginalPerNight
     *
     * @return $this
     */
    public function setPriceOriginalPerNight($priceOriginalPerNight)
    {
        $this->priceOriginalPerNight = $priceOriginalPerNight;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceTotal()
    {
        return $this->priceTotal;
    }


    /**
     * @param $priceTotal
     *
     * @return $this
     */
    public function setPriceTotal($priceTotal)
    {
        $this->priceTotal = $priceTotal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceCurrency()
    {
        return $this->priceCurrency;
    }


    /**
     * @param $priceCurrency
     *
     * @return $this
     */
    public function setPriceCurrency($priceCurrency)
    {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPricePercentSaving()
    {
        return $this->pricePercentSaving;
    }


    /**
     * @param $pricePercentSaving
     *
     * @return $this
     */
    public function setPricePercentSaving($pricePercentSaving)
    {
        $this->pricePercentSaving = $pricePercentSaving;

        return $this;
    }
}