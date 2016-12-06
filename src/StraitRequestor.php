<?php
namespace AMgradeTZ\GeoCoding;

class StraitRequestor extends GeoRequestor
{
    public function makeRequest(State $state)
    {
        $cache = $state->cache;
        $cacheKey = $state->address.$state->language;

        if ($cache && $cache::has($cacheKey)) {
            return $cache::get($cacheKey);
        }

        if ($state->address !== "") {
            $response = $this->client->request('GET', self::BASE_API_URI, [
                'query' => ['address' => $state->address,
                    'language' => $state->language,
                    'key' => $state->instanceKey]
            ]);

            $body = $response->getBody();

            $value = \GuzzleHttp\json_decode($body->getContents());

            if ($cache) {
                $cache::put($cacheKey, $value, 15);
            }

            return $value;
        }  else {
            $msg = 'Address must be assigned if You want to use STRAIGHT mode of GeoCoding request';
            throw new GeoCodingClientException($msg);
        }
    }
}