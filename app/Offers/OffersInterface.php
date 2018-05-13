<?php
namespace App\Offers;

use App\Http\Requests\OfferSearchRequest;
use Illuminate\Support\Collection;

/**
 * Class Offers
 *
 * @package App\Offers
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
interface OffersInterface
{
    /**
     * @param OfferSearchRequest $params
     *
     * @return Collection
     */
    public function searchFromRequest(OfferSearchRequest $params): Collection;
}