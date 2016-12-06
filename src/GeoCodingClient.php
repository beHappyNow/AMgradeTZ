<?php
namespace AMgradeTZ\GeoCoding;

class GeoCodingClient
{

    const STRAIGHT = 1;
    const REVERSE  = 2;
    const BASE_API_URI = 'https://maps.googleapis.com/maps/api/geocode/json';

    /** @var object IValidator  */
    private $validator;

    /** @var object GeoRequestor  */
    private $requestor;

    private $state;


    /**
     * @param string|null $key Токен доступа к API
     * @param object $cache default cache provider by Laravel
     * @throws GeoCodingClientException Если не передан токен
     */
    public function __construct($key = null, $cache)
    {
        $this->validator = new SimpleValidator();
        $this->validator->setLanguagesProvider(new SimpleLanguagesProvider());

        $this->state = new State();

        if ($key === null) {
            $msg = 'Google API key is not assigned';
            throw new GeoCodingClientException($msg);
        } else {
            try {
                $this->validator->validateKey($key);
                $this->state->setInstanceKey($key);
                $this->state->setCache($cache);

            } catch (\InvalidArgumentException $e) {
                throw new GeoCodingClientException($e->getMessage());
            }
        }
    }

    public function makeRequest()
    {

        $response = "";

        $response = $this->requestor->makeRequest($this->state);

        if ($response->status == "OK") {
            echo "<pre>";
            var_dump($response);
            echo "</pre>";
        }

        if ($response->status == "ZERO_RESULTS") {
            echo "error";
            echo "<pre>";
            var_dump($response);
            echo "</pre>";
        }
    }

    public function setDirection($direction)
    {
        try {
            $this->validator->validateDirection($direction);

            $requestor = RequestorFactory::getRequestor($direction);
            $this->requestor = $requestor;
            return $this;

        } catch (\InvalidArgumentException $e) {
            throw new GeoCodingClientException($e->getMessage());
        }
    }

    public function setLanguage($language)
    {
        try {
            $this->validator->validateLanguage($language);
            $this->state->setLanguage($language);
            return $this;
        } catch (\InvalidArgumentException $e) {
            throw new GeoCodingClientException($e->getMessage());
        }
    }

    public function setCoordinates($lat, $lng)
    {
        $value = $lat.','.$lng;
        $this->state->setLatlng($value);
        return $this;
    }

    public function setAddress($address)
    {
        $this->state->setAddress($address);
        return $this;
    }


}