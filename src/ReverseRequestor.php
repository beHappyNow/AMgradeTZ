<?php
namespace AMgradeTZ\GeoCoding;

class ReverseRequestor extends GeoRequestor
{
    public function makeRequest(State $state)
    {
        $cache = $state->cache;
        $cacheKey = $state->latlng.$state->language;

        if ($cache && $cache::has($cacheKey)) {
            return $cache::get($cacheKey);
        }

        if ($state->latlng !== "") {
            $response = $this->client->request('GET', self::BASE_API_URI, [
                'query' => ['latlng' => $state->latlng,
                    'language' => $state->language,
                    'key' => $state->instanceKey]
            ]);

            $body = $response->getBody();

            $value = \GuzzleHttp\json_decode($body->getContents());

            if ($cache) {
                $cache::put($cacheKey, $value, 15);
            }
            
            return $value;

        } else {
            $msg = 'Coordinates must be assigned if You want to use REVERSE mode of GeoCoding request';
            throw new GeoCodingClientException($msg);
        }


    }
}