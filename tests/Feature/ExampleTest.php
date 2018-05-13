<?php

namespace Tests\Feature;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

/**
 * Class ExampleTest
 *
 * @package Tests\Feature
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_homepage_redirects_to_offers_page()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    /**
     * Test the offers home page is loaded, and have the (today's date pre-filled)
     */
    public function test_offers_home_page()
    {
        $response = $this->get('/offers');
        $response->assertDontSee(Carbon::now()->format('Y-m-d'));
        $response->assertStatus(200);
    }

    /**
     * Test the offers search page given no parameters, and it must have the (today's date pre-filled)
     */
    public function test_offers_search_main_with_no_params()
    {
        $response = $this->get('/offers/search');
        $response->assertDontSee(Carbon::now()->format('Y-m-d'));
        $response->assertStatus(200);
    }

    /**
     * Test the offers search page given no parameters, and it must have the (today's date pre-filled)
     */
    public function test_offers_search_main_with_invalid_trip_date()
    {
        $this->checkWithTripDate("2018-05-10", 302);
        $this->checkWithTripDate("2018-05", 302);
    }

    /**
     *
     */
    public function test_offers_search_main_with_length_of_stay()
    {
        $this->checkWithLengthOfStay(30, 302);
        //todo: invalidate zero length of stay
        //$this->invalidLengthOfStay(0, 302);
    }

    /**
     *
     */
    public function test_offers_search_with_flexibility()
    {
        $this->checkWithFlexibility(1, 302);
        $this->checkWithFlexibility(2, 302);
        $this->checkWithFlexibility(9, 302);
        $this->checkWithFlexibility("string", 302);
        $this->checkWithFlexibility(null, 200);
    }

    public function tests_offers_search_success_response()
    {
        $mockResponse = json_encode(["status" => "successful"]);

        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], $mockResponse),
        ]);

        $handler = HandlerStack::create($mock);
        $client  = new Client([
            'handler' => $handler,
        ]);

        $this->app->instance(\GuzzleHttp\Client::class, $client);

        $response = $this->get('/offers/search');
        $response->assertStatus(200);
        dump($response->getContent());
    }



    /**
     * @param $date
     * @param $status
     */
    private function checkWithTripDate($date, $status)
    {
        $this->printMethod(__METHOD__, $date);
        $response = $this->get("/offers/search?trip_date={$date}");
        $response->assertStatus($status);

    }

    /**
     * @param $length
     * @param $status
     */
    private function checkWithLengthOfStay($length, $status)
    {
        $this->printMethod(__METHOD__, $length);
        $response = $this->get("/offers/search?length_of_stay={$length}");
        $response->assertStatus($status);

    }

    /**
     * @param $flexibility
     * @param $status
     */
    private function checkWithFlexibility($flexibility, $status)
    {
        $this->printMethod(__METHOD__, $flexibility);
        $response = $this->get("/offers/search?flexibility={$flexibility}");
        $response->assertStatus($status);
    }

    /**
     * @param $method
     * @param $param
     */
    private function printMethod($method, $param)
    {
        echo("   => " . $method . "($param)" . "\n");
    }


}
