<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\OfferSearchRequest;
use App\Offers\OffersInterface;
use Illuminate\Support\Collection;

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
     * @var OffersInterface
     */
    private $offers;

    /**
     * OffersController constructor.
     *
     * @param OffersInterface $offers
     */
    public function __construct(OffersInterface $offers)
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
        try {
            $offers = $this->offers->searchFromRequest($request);
        } catch (\Exception $exception) {
            return view('offers.results', [
                "exceptionMessage" => $exception->getMessage(),
                "exceptionCode"    => $exception->getCode(),
            ]);
        }

        //convert offer objects to array so they can be serialized to JSON
        $offers = $offers->map(function ($item) {
            /** @var $item Collection */
            return $item->toArray();
        });

        return view('offers.results', compact('offers'));
    }
}
