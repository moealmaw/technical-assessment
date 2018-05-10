<?php
namespace App\Offers;

use App\Offers\Expedia\ExpediaApi;
use Illuminate\Support\Collection;

/**
 * Class Offers
 *
 * @package App\Offers
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class Offers
{
    /**
     * @var ExpediaApi
     */
    private $api;

    /**
     * Offers constructor.
     *
     * @param ExpediaApi $api
     */
    public function __construct(ExpediaApi $api)
    {
        $this->api = $api;
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function searchFromRequest(Array $params): Collection
    {
        return $this->api->searchFromRequest($params);
    }
}