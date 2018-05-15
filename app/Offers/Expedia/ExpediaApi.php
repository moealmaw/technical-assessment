<?php
namespace App\Offers\Expedia;

use App\Exceptions\ApiException;
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
     * @param Client $http
     */
    public function __construct(ExpediaTransformer $transformer, Client $http)
    {
        $this->http        = $http;
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
        $response    = $this->makeRequest("/getOffers", $searchQuery);

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
     * @return array
     * @throws ApiException
     */
    private function makeRequest($path, Array $query): array
    {
        $queryString = http_build_query(array_filter($query));
        $requestUri  = $this->makeFullPath($path);
        try {
            $httpCall = $this->http->get($requestUri, ['query' => $queryString]);

            return [
                "request_uri"   => $requestUri,
                "request_query" => $queryString,
                "status_code"   => $httpCall->getStatusCode(),
                "headers"       => $httpCall->getHeaders(),
                "body"          => $httpCall->getBody()->getContents(),
            ];
        } catch (\Exception $e) {
            throw new ApiException($this->exceptionMessage($e));
        }
    }

    /**
     * Makes full path for the API (base_uri/path)
     *
     * @param $path
     *
     * @return string
     */
    private function makeFullPath($path): string
    {
        return sprintf("%s/%s", $this->getBaseUri(), $this->getPath($path));
    }

    /**
     * API base uri getter
     *
     * @return string
     * @throws \Exception
     */
    private function getBaseUri(): string
    {
        if ( ! isset($this->baseUri) || empty($this->baseUri)) {
            throw new \Exception(
                sprintf('Error:\n[baseUri] variable in [%s] is required and must be a valid URI', __CLASS__)
            );
        }
        if (ends_with($this->baseUri, "/")) {
            return substr($this->baseUri, 0, -1);
        }

        return $this->baseUri;
    }

    /**
     * Removes slash from the path if it exists
     *
     * @param $path
     *
     * @return string
     */
    private function getPath($path): string
    {
        if (starts_with($path, "/")) {
            $path = substr($path, 1);
        }

        return $path;
    }

    /**
     * @param \Exception $exception
     *
     * @return string
     * @throws \Exception
     */
    private function exceptionMessage(\Exception $exception)
    {
        switch ($exception->getCode()) {
            case 429:
                $message = "API Request Error (429): Too Many Requests";
                break;
            case 404:
                $message = "API Request Error (404): Not Found";
                break;
            case 500:
                $message = "API Request Error (500): Internal Server Error";
                break;
            default:
                $message = $exception->getMessage();
                break;
        }

        return $message;
    }


}