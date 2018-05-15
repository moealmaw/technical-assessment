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