<?php
namespace AMgradeTZ\GeoCoding;

use GuzzleHttp\Client;

abstract class GeoRequestor
{
    const BASE_API_URI = 'https://maps.googleapis.com/maps/api/geocode/json';
    protected $client;





    public function __construct()
    {
        $this->client = new Client();
    }

    public abstract function makeRequest( State $state );
}