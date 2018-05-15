<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\TestUtilities;

/**
 * Class ExpediaApiHttpTest
 *
 * @package Tests\Feature
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class ExpediaApiHttpTest extends TestCase
{
    use TestUtilities;

    /**
     * Today date
     * @var
     */
    private $todayDate;

    public function setUp()
    {
        parent::setup();
        $this->todayDate = Carbon::now()->format('Y-m-d');
        $this->mockHttpClient($status = 200);
    }

    /**
     * tests the home page redirect to the offer main page
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
        $response->assertSee($this->todayDate);
        $response->assertStatus(200);
    }

    /**
     * Test the offers search page given no parameters, and it must have the (today's date pre-filled)
     */
    public function test_offers_search_handles_no_params()
    {
        $response = $this->get('/offers/search');
        $response->assertSee($this->todayDate);
        $response->assertStatus(200);
    }

    /**
     * Test API Too many requests Response
     */
    public function test_offers_search_API_Too_Many_Requests_429()
    {
        $this->mockHttpClient($status = 429);

        $response = $this->get('/offers/search');
        $response->assertSee("Too Many Requests");

        $response->assertStatus(200);
    }

    /**
     * Test API Too many requests Response
     */
    public function test_offers_search_handles_API_Server_Error_500()
    {
        $this->mockHttpClient($status = 500);

        $response = $this->get('/offers/search');
        $response->assertSee("Internal Server Error");

        $response->assertStatus(200);
    }

    public function test_offers_search_handles_API_Server_Error_404()
    {
        $this->mockHttpClient($status = 404);

        $response = $this->get('/offers/search');
        $response->assertSee("Not Found");

        $response->assertStatus(200);
    }

    /**
     * Test the offers search page given no parameters, and it must have the (today's date pre-filled)
     */
    public function test_offers_search_with_trip_date()
    {
        $this->checkWithTripDate("2018-05-10", 302);
        $this->checkWithTripDate("2018-05", 302);
        //valid
        $this->checkWithTripDate($this->todayDate, 200);
    }

    /**
     * tests the length of stay to be between 1-29 days
     */
    public function test_offers_search_with_length_of_stay()
    {
        //invalid
        $this->checkWithLengthOfStay(30, 302);
        $this->checkWithLengthOfStay(0, 302);
        //valid
        $this->checkWithLengthOfStay(1, 200);
        $this->checkWithLengthOfStay(3, 200);
        $this->checkWithLengthOfStay(10, 200);
    }

    /**
     * test flexibility to be (null | 0 | 3 | 5 | 7)
     */
    public function test_offers_search_with_flexibility()
    {
        //invalid

        $this->checkWithFlexibility(1, 302);
        $this->checkWithFlexibility(2, 302);
        $this->checkWithFlexibility(9, 302);
        $this->checkWithFlexibility("string", 302);

        //valid
        $this->checkWithFlexibility(null, 200);
        $this->checkWithFlexibility(0, 200);
        $this->checkWithFlexibility(3, 200);
        $this->checkWithFlexibility(5, 200);
        $this->checkWithFlexibility(7, 200);
    }

    /*
     * Tests success response render
     */
    public function test_offers_search_handles_Success_Response()
    {
        $this->mockHttpClient($status = 200);
        //we hit the search endpoint
        $response = $this->get('/offers/search');
        //then compare the results with the mock render that we expect to have
        $response->assertSee($this->getMockRendered());
    }


    /**
     * @param $date
     * @param $status
     */
    private function checkWithTripDate($date, $status)
    {
        $response = $this->get("/offers/search?trip_date={$date}");
        $response->assertStatus($status);

    }

    /**
     * @param $length
     * @param $status
     */
    private function checkWithLengthOfStay($length, $status)
    {
        $response = $this->get("/offers/search?length_of_stay={$length}");
        $response->assertStatus($status);

    }

    /**
     * @param $flexibility
     * @param $status
     */
    private function checkWithFlexibility($flexibility, $status)
    {
        $response = $this->get("/offers/search?flexibility={$flexibility}");
        $response->assertStatus($status);
    }
}
