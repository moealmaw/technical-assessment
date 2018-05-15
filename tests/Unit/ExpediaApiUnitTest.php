<?php

namespace Tests\Unit;

use App\Exceptions\ApiException;
use App\Http\Requests\OfferSearchRequest;
use App\Offers\Expedia\ExpediaApi;
use PHPUnit\Framework\Assert;
use Tests\TestCase;
use Tests\TestUtilities;


/**
 * Class ExpediaApiUnitTest
 *
 * @package Tests\Unit
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class ExpediaApiUnitTest extends TestCase
{
    use TestUtilities;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_SearchFromRequest_too_many_requests_response()
    {
        $this->mockHttpClient($status = 429);
        $api     = app()->make(ExpediaApi::class);
        //creates a $request http object
        $request = app(OfferSearchRequest::class);

        $this->expectException(\Exception::class);
        $api->searchFromRequest($request);
    }

    /**
     * tests SearchFromRequest
     */
    public function test_SearchFromRequest_request_internal_server_error_response()
    {
        $this->mockHttpClient($status = 500);
        $api = app()->make(ExpediaApi::class);
        //creates a $request http object
        $request = app(OfferSearchRequest::class);

        $this->expectException(\Exception::class);
        $api->searchFromRequest($request);
    }

    /**
     * tests makeFullPath
     */
    public function test_makeFullPath_method()
    {
        $api   = app()->make(ExpediaApi::class);
        $tests = [
            ["path" => "getOffersPath", "expected" => "https://expedia.com/getOffersPath"],
            ["path" => "/getOffersPath", "expected" => "https://expedia.com/getOffersPath"],
            ["path" => "/getOffers/Path", "expected" => "https://expedia.com/getOffers/Path"],
        ];

        array_map(function ($test) use ($api) {
            $this->invokeProperty($api, "baseUri", "https://expedia.com");
            $fullPath = $this->invokeMethod($api, "makeFullPath", [$test["path"]]);

            Assert::assertEquals($fullPath, $test["expected"]);
        }, $tests);

        array_map(function ($test) use ($api) {
            $this->invokeProperty($api, "baseUri", "https://expedia.com/");
            $fullPath = $this->invokeMethod($api, "makeFullPath", [$test["path"]]);

            Assert::assertEquals($fullPath, $test["expected"]);
        }, $tests);

    }

    /**
     * tests getBaseUri
     */
    public function test_getBaseUri_method()
    {
        $api = app()->make(ExpediaApi::class);

        //tests uri with a trailing slash
        $this->invokeProperty($api, "baseUri", "https://expedia.com/");
        $expected = "https://expedia.com";
        $baseUri  = $this->invokeMethod($api, 'getBaseUri', []);
        Assert::assertEquals($baseUri, $expected);

        //tests uri without a trailing slash
        $this->invokeProperty($api, "baseUri", "https://expedia.com");
        $expected = "https://expedia.com";
        $baseUri  = $this->invokeMethod($api, 'getBaseUri', []);
        Assert::assertEquals($baseUri, $expected);

        //tests uri with empty value
        $this->invokeProperty($api, "baseUri", null, $force = true);
        $this->expectException(\Exception::class);
        $this->invokeMethod($api, 'getBaseUri', []);
    }

    /**
     * tests getPath
     */
    public function test_getPath_method()
    {
        $api = app()->make(ExpediaApi::class);

        //tests path with a trailing slash
        $baseUri  = $this->invokeMethod($api, 'getPath', ["/some/path"]);
        $expected = "some/path";
        Assert::assertEquals($baseUri, $expected);

        //tests path without a trailing slash
        $baseUri  = $this->invokeMethod($api, 'getPath', ["some/path"]);
        $expected = "some/path";
        Assert::assertEquals($baseUri, $expected);
    }

    /**
     * tests makeRequest
     */
    public function test_makeRequest_method()
    {
        //tests success response
        $this->mockHttpClient($status = 200);
        $api = app()->make(ExpediaApi::class);

        $makeRequest = $this->invokeMethod($api, 'makeRequest',
            ["getOffers", ["trip_date" => "13-12-2018", "flexibility" => 3]]);
        $expected    = [
            "request_uri"   => "https://offersvc.expedia.com/offers/v2/getOffers",
            "request_query" => "trip_date=13-12-2018&flexibility=3",
            "status_code"   => 200,
        ];
        Assert::assertArraySubset($expected, $makeRequest);


        //tests failing response
        $this->mockHttpClient($status = 429);
        $api = app()->make(ExpediaApi::class);
        $this->expectException(ApiException::class);
        $this->invokeMethod($api, 'makeRequest', ["getOffers", []]);
    }

}
