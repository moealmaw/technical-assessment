<?php

namespace App\Offers\Expedia;

use App\Offers\Nodes\DateRange;
use App\Offers\Nodes\Destination;
use App\Offers\Nodes\Hotel;
use App\Offers\Nodes\Price;
use App\Offers\Offer;
use App\Utilities\DateUtilities;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class ExpediaTransformer
 *
 * @package App\Offers\Expedia
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class ExpediaTransformer
{
    /**
     * @var array
     */
    private $requestPredefinedParams = [];

    /**
     * ExpediaResponseAdapter constructor.
     *
     */
    public function __construct()
    {
        $this->requestPredefinedParams = [
            "scenario"    => "deal-finder",
            "page"        => "foo",
            "uid"         => "foo",
            "productType" => "Hotel",
        ];
    }

    /**
     *
     * @param array $offers
     *
     * @return Collection
     */
    public function mapResponse(Array $offers): Collection
    {
        $results = [];
        foreach ($offers as $offer) {
            $hotelOffer = new Offer();

            //offerDateRange
            $dates = (new DateRange())
                ->setTravelStartDate($this->toCarbonDate(object_get($offer, "offerDateRange.travelStartDate")))
                ->setTravelEndDate($this->toCarbonDate(object_get($offer, "offerDateRange.travelEndDate")))
                ->setLengthOfStay(object_get($offer, "offerDateRange.lengthOfStay"));
            $hotelOffer->setDates($dates);

            //destination
            $destination = (new Destination())
                ->setRegionId(object_get($offer, "destination.regionID"))
                ->setCountry(object_get($offer, "destination.country"))
                ->setCity(object_get($offer, "destination.city"))
                ->setLongName(object_get($offer, "destination.longName"))
                ->setShortName(object_get($offer, "destination.shortName"));
            $hotelOffer->setDestination($destination);

            //hotel info
            $hotel = (new Hotel())
                ->setId(object_get($offer, "hotelInfo.hotelId"))
                ->setName(object_get($offer, "hotelInfo.hotelName"))
                ->setStreetAddress(object_get($offer, "hotelInfo.hotelStreetAddress"))
                ->setLatitude(object_get($offer, "hotelInfo.hotelLatitude"))
                ->setLongitude(object_get($offer, "hotelInfo.hotelLongitude"))
                ->setStarRating(object_get($offer, "hotelInfo.hotelStarRating"))
                ->setGuestReviewRating(object_get($offer, "hotelInfo.hotelGuestReviewRating"))
                ->setReviewTotal(object_get($offer, "hotelInfo.hotelReviewTotal"))
                ->setImageUrl(object_get($offer, "hotelInfo.hotelImageUrl"));
            $hotelOffer->setHotel($hotel);

            //pricing
            $price = (new Price())
                ->setPricePerNight(object_get($offer, "hotelPricingInfo.averagePriceValue"))
                ->setPriceOriginalPerNight(object_get($offer, "hotelPricingInfo.originalPricePerNight"))
                ->setPriceTotal(object_get($offer, "hotelPricingInfo.totalPriceValue"))
                ->setPriceCurrency(object_get($offer, "hotelPricingInfo.currency"))
                ->setPricePercentSaving(object_get($offer, "hotelPricingInfo.percentSavings"));

            $hotelOffer->setPrice($price);

            array_push($results, $hotelOffer);
        }

        return collect($results);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function mapRequest(Array $params)
    {
        $apiQueryParams = [];

        //append the API required and predefined parameters
        $apiQueryParams = array_merge($apiQueryParams, $this->requestPredefinedParams);

        //map the user submitted query params to the api
        $apiQueryParams = array_merge($apiQueryParams, $this->mapFormParams($params));

        //make minTripStartDate and maxTripStartDate from trip_date
        //(creates range between two dates from a given date and flexibility)
        if ($params['trip_date']) {
            $apiQueryParams = array_merge($apiQueryParams, $this->makeTripDates($params));
        }

        return $apiQueryParams;
    }


    /**
     * @param $params
     *
     * @return array
     */
    private function mapFormParams(Array $params): array
    {
        $queryParams = [
            "destinationName" => array_get($params, "destination_name"),
            "lengthOfStay"    => array_get($params, "length_of_stay"),
            "maxStarRating"   => array_get($params, "max_star_rating"),
            "minStarRating"   => array_get($params, "min_star_rating"),
            "maxTotalRate"    => array_get($params, "max_total_rate"),
            "minTotalRate"    => array_get($params, "min_total_rate"),
            "maxGuestRating"  => array_get($params, "max_guest_rating"),
            "minGuestRating"  => array_get($params, "mins_guest_rating"),
        ];

        return $queryParams;
    }

    /**
     * @param $params
     *
     * @return array
     */
    private function makeTripDates(array $params): array
    {
        $date   = Carbon::createFromFormat("Y-m-d", array_get($params, "trip_date"));
        $offset = (int)array_get($params, "flexibility");

        $dateRange = (new DateUtilities($date))->makeOffset($offset);

        return [
            "minTripStartDate" => $dateRange['min'],
            "maxTripStartDate" => $dateRange['max'],
        ];
    }

    /**
     * @param array $date
     *
     * @return string
     */
    private function toCarbonDate(array $date)
    {
        return Carbon::createFromFormat("Y-m-d", implode($date, "-"))->toDateString();
    }
}