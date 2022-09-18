<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class routesTest extends TestCase
{
    public function testAirports()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://localhost:8888/airports');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testFlights(): void
    {
        $client = new Client();
        $response = $client->request('GET', 'http://localhost:8888/cheapest_flight/BLQ/LHR');
        $this->assertEquals(200, $response->getStatusCode());
    }
}
