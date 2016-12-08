<?php
namespace AMgradeTZ\GeoCoding;

class GeoCodingClient
{

    const STRAIGHT = 1;
    const REVERSE  = 2;
    const BASE_API_URI = 'https://maps.googleapis.com/maps/api/geocode/json';

    /** @var object IValidator  */
    private $validator;

    /** @var object GeoRequestor encapsulate behavior of request. Straight or reverse. */
    private $requestor;


    /** @var object State encapsulate variables of state of request */
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

    /**
     * Execution of the request is delegated to the requestor object
     *
     * @return \stdClass mixed. The same fields and values, as in json response from API.
     *
     * public array 'results'
     * * address_components
     * * formatted_address
     * * geometry
     * * place_id
     * * types
     *
     * public string 'status'.
     * Possible values: 'OK', 'ZERO_RESULTS', 'OVER_QUERY_LIMIT', 'REQUEST_DENIED', 'INVALID_REQUEST', 'UNKNOWN_ERROR'
     */
    public function makeRequest()
    {
        $response = $this->requestor->makeRequest($this->state);

        return $response;
    }


    /**
     * @param $direction GeoCodingClient::STRAIGHT or GeoCodingClient::REVERSE
     * @return $this
     * @throws GeoCodingClientException
     */
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

    /**
     * Set language of answer from Google API
     * @param string $language
     * @return $this
     * @throws GeoCodingClientException
     */
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

    /**
     * Set coordinates parameter of request to API. Is necessary for REVERSE GeoCoding request.
     * @param float $lat
     * @param float $lng
     * @return $this
     */
    public function setCoordinates($lat, $lng)
    {
        $value = $lat.','.$lng;
        $this->state->setLatlng($value);
        return $this;
    }

    /**
     * Set address parameter of request to API. Is necessary for STRAIT GeoCoding request.
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->state->setAddress($address);
        return $this;
    }


}