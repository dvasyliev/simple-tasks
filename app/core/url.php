<?php

class Url
{
    private $domain;

    public function __construct( $domain )
    {
        $this->domain = $domain;
    }

    public function link( $route, $params = "" )
    {
        $url = $this->domain . $route;
        $url .= $params && is_array( $params ) ? '?' . http_build_query( $params ) : "";

        return $url;
    }
}