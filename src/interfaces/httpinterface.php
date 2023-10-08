<?php

namespace VarejoFacil\Interfaces;

interface HttpInterface
{
    public function post($url, $params, array $headers);
    public function get($url, $params, array $headers);
    public function put($url, $params, array $headers);
    public function delete($url, array $headers);
    public function getInfo();
}
