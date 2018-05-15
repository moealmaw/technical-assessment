<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * Class TestUtilities
 *
 * @package Tests
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 */
trait TestUtilities
{

    /**
     * Access/Calls non-public methods from the given object/class
     *
     * @param $object
     * @param $methodName
     * @param array $parameters
     *
     * @return mixed
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method     = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Access non-public props from the given object / class
     *
     * @param $object
     * @param $propertyName
     * @param null $value
     * @param bool $forceValue
     *
     * @return mixed
     * @internal param bool $force
     *
     */
    public function invokeProperty(&$object, $propertyName, $value = null, $forceValue = false)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $property   = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        if($value || $forceValue){
            $property->setValue($object, $value);
        }

        return $property->getValue($object);
    }

    /**
     * Creates a mock for the Guzzle Http Client
     *
     * @param int $status
     */
    private function mockHttpClient($status = 200)
    {
        //create a mock for the HTTP client so we test how our app renders a successful response
        $responses = [
            200 => $this->getMockApiResponse(),
            500 => "Internal Server Error",
            429 => "Too Many Requests",
            404 => "Not Found",
        ];
        //create a mock handler and set it to always respond with mock data
        $mock = new MockHandler([
            new Response($status, [], $responses[$status]),
        ]);

        //create a new guzzle http client and attach the mock as a handler
        $client = new Client([
            'handler'  => HandlerStack::create($mock),
            'base_uri' => "/",
        ]);

        //attach the new client to the app service container so it returns this client whenever the Guzzle client is requested through the life cycle of the app

        $this->app->instance(\GuzzleHttp\Client::class, $client);
    }

    /**
     * Creates a mock for the API response
     *
     * @return string
     */
    private function getMockApiResponse(): string
    {
        $mockApiResponse = file_get_contents(base_path('tests/mock/sample_response_raw.json'));

        return $mockApiResponse;
    }

    /**
     * @return string
     */
    private function getMockRendered(): string
    {
        $mockRendered = file_get_contents(base_path('tests/mock/sample_response_rendered.json'));

        return $mockRendered;
    }

}