<?php

namespace App\http;

use Exception;

class method_checker
{

    public static function check($route)
    {
        $route_method = $route["method"] ?? null;

        if (!$route_method) {
            throw new Exception("Define a method to this route!", 404);
            die();
            return null;
        }

        if ($route_method == 'all') {
            return $route;
        } else {
            $method = $_SERVER["REQUEST_METHOD"];
            if (strtolower($method) == $route_method) {
                return $route;
            } else {
                throw new Exception("Request method not supported to " . strtoupper($route_method) . ". route.", 404);
                die();
                return null;
            }
        }
    }
}
