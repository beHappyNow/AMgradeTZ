<?php
namespace AMgradeTZ\GeoCoding;

class State
{
    /** @var string Google API key */
    public $instanceKey;

    public $language = 'en';

    public $address = '';

    public $latlng = '';

    public $cache = '';

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) == 'set') {
            $property = lcfirst(substr($name, 3));
            $this->$property = $arguments[0];
        }
        return $this;
    }


}