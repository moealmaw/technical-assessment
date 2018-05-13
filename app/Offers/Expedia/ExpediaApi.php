<?php
namespace App\Offers\Expedia;

use App\Http\Requests\OfferSearchRequest;
use App\Offers\OffersInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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
    public function __construct(ExpediaTransformer $transformer)
    {
        $jar               = new FileCookieJar('/tmp/expedia_cookie_new', true);
        $this->http        = new Client([
            'cookies'  => $jar,
            'base_uri' => $this->baseUri,
            'headers'  => [
                'user-agent'      => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36",
                'accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'accept-encoding' => 'gzip, deflate, br',
                'accept-language' => 'en-GB,en;q=0.9,en-US;q=0.8,ar;q=0.7',
            ],
        ]);
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