<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Class OffersTest
 *
 * @package Tests\Feature
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
class OffersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/offers');

        $response->assertStatus(200);
    }
}
