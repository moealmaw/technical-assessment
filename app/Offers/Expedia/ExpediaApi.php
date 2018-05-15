<?php
namespace App\Offers\Expedia;

use App\Http\Requests\OfferSearchRequest;
use App\Offers\OffersInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Class ExpediaApi
 *
 * @package App\Offers
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class ExpediaApi implements OffersInterface
{
    /**
     * @var string
     */
    private $baseUri = "https://offersvc.expedia.com/offers/v2/";
    /**
     * @var Client
     */
    private $http;
    /**
     * @var ExpediaTransformer
     */
    private $transformer;

    /**
     * ExpediaApi constructor.
     *
     * @param ExpediaTransformer $transformer
     */
    {
        $this->transformer = $transformer;
    }

    /**
     * @param OfferSearchRequest $request
     *
     * @return Collection
     * @internal param array $params
     *
     */
    public function searchFromRequest(OfferSearchRequest $request): Collection
    {
        $params      = $request->all();
        $searchQuery = $this->transformer->mapRequest($params);
        $response    = $this->makeRequest("getOffers", $searchQuery);

        return $this->mapResponse($response['body']);
    }


    /**
     * @param $responseBody
     *
     * @return Collection
     *
     */
    private function mapResponse(string $responseBody): Collection
    {
        $body = \GuzzleHttp\json_decode($responseBody);

        $results = $this->transformer->mapResponse((array)object_get($body, "offers.Hotel"));

        return $results;

    }

    /**
     * @param $path
     * @param array $query
     *
     * @return mixed
     * @throws \Exception
     */
    private function makeRequest($path, Array $query): array
    {
        $queryString = http_build_query(array_filter($query));
        try {
            $response = Cache::remember($queryString/*cache key*/, 720000, function () use ($path, $queryString) {
                $httpCall = $this->http->get($path, ['query' => $queryString]);

                return [
                    "cache_key"   => $queryString,
                    "status_code" => $httpCall->getStatusCode(),
                    "headers"     => $httpCall->getHeaders(),
                    "body"        => $httpCall->getBody()->getContents(),
                ];
            });

            return $response;
        } catch (\Exception $exception) {

            throw $exception;
        }
    }
}