<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferSearchRequest;
use App\Offers\HotelOffer;
use App\Offers\Offer;
use App\Offers\Offers;

/**
 * Class OffersController
 *
 * @package App\Http\Controllers
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class OffersController extends Controller
{
    /**
     * @var Offers
     */
    private $offers;

    /**
     * OffersController constructor.
     *
     * @param Offers $offers
     */
    public function __construct(Offers $offers)
    {
        $this->offers = $offers;
    }

    /**
     * Handles the offers search call
     *
     * @param OfferSearchRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function search(OfferSearchRequest $request)
    {
        $offers = $this->offers->searchFromRequest($request->all());

        //convert offer objects to array so they can be serialized to JSON
        $offers = $offers->map(
            function ($item) {
                return $item->toArray();
            }
      );

        return view('offers.results', compact('offers'));
    }
}
