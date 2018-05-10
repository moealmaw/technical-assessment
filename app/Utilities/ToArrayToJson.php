<?php

namespace App\Utilities;


/**
 * Class ToArrayToJson
 *
 * @package App\Offers\Utilities
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
trait ToArrayToJson
{
    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            if (is_object($value) && method_exists($value, "toArray")) {
                return $value->toArray();
            }

            return $value;
        }, get_object_vars($this));
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return \GuzzleHttp\json_encode($this->toArray());
    }
}