<?php

namespace AMgradeTZ\GeoCoding;

class RequestorFactory
{

    public static function getRequestor($direction)
    {
        if ($direction == GeoCodingClient::STRAIGHT) {
            $requestor = new StraitRequestor();
            return $requestor;
        }
        if ($direction == GeoCodingClient::REVERSE) {
            $requestor = new ReverseRequestor();
            return $requestor;
        }
    }
}