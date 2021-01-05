<?php

namespace App\Core;

use Exception;

class Router 
{

    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    public $middleware = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file) {
        $router = new static;
        require $file;
        return $router;
    }
    
    public function get() {
        $argsNum = func_num_args();
        $args = func_get_args();
        $uri = $args[0];

        if($argsNum != 3 && $argsNum != 2) {
            throw new Exception("Parameters invalid for GET route");
        } elseif ($argsNum === 3) {
            $controller = $args[2];
            $this->routes['GET'][$uri] = $controller;
            $this->middleware['GET'][$uri] = $args[1];
        } else {
            $controller = $args[1];
        }
        $this->routes['GET'][$uri] = $controller;
    }

    public function post() {
        $argsNum = func_num_args();
        $args = func_get_args();
        $uri = $args[0];

        if($argsNum != 3 && $argsNum != 2) {
            throw new Exception("Parameters invalid for POST route");
        } elseif ($argsNum === 3) {
            $controller = $args[2];
            $this->routes['POST'][$uri] = $controller;
            $this->middleware['POST'][$uri] = $args[1];
        } else {
            $controller = $args[1];
        }
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType) {
        // Look for uri in the defined routes, these routes do not contain wildcards
        if(array_key_exists($uri, $this->routes[$requestType])) {
            if(array_key_exists($uri, $this->middleware[$requestType])) {
                foreach($this->middleware[$requestType][$uri] as $middleware) {
                    $this->callMiddleware(...explode('@', $middleware));
                }
            }
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }
        // If URI does not exist it could contain wildcards.
        if (!array_key_exists($uri, $this->routes[$requestType])) {
            foreach($this->routes[$requestType] as $route => $controller) {
                // Replace all {param} in route with astrix' 
                // e.g. route/{param} => route/*
                $preparedRoute = preg_replace('#\{.*?\}#s','*',$route);
                // Check if URI fits a route with wildcards
                if(fnmatch($preparedRoute, $uri)) {
                    // Run middleware first
                    if(array_key_exists($route, $this->middleware[$requestType])) {
                        foreach($this->middleware[$requestType][$route] as $middleware) {
                            $this->callMiddleware(...explode('@', $middleware));
                        }
                    }
                    Request::bind('body', $this->getWildcardData($preparedRoute, $route, $uri));
                    // Fire controller and call action
                    return $this->callAction(
                        ...explode('@', $controller)
                    );
                }
            }
        }
        // If the method did not return by now, the uri is invalid
        throw new Exception('No route defined for this URI.');
    }

    private function getWildcardData($preparedRoute, $route, $uri) {
        $rootOfRoute     = explode("/*", $preparedRoute)[0];
        $wildcardKeys    = $this->getWildcardKeys($route);
        $wildcardValues  = $this->getWildcardValues($rootOfRoute, $uri);
        return $this->combineWildcardData($wildcardKeys, $wildcardValues);
    }

    private function combineWildcardData($keys, $values) {
        if(count($keys) !== count($values)) {
            throw new Exception('Wildcard keys and values don\'t add up');
        }
        return array_combine($keys, $values);
    }

    private function getWildcardValues($rootOfRoute, $uri) {
        return array_filter(
            explode('/', str_replace($rootOfRoute, '', $uri))
        );
    }

    private function getWildcardKeys($route) {
        return array_filter(array_map(function($routePart) {
            if($routePart[0] === '{') {
                return trim($routePart, '{}');
            } unset($routePart);
        },explode('/', $route)));
    }

    protected function callMiddleware($middleware, $action) {
        $middleware = "App\\Middleware\\{$middleware}";
        $middleware = new $middleware;

        if(! method_exists($middleware, $action)) {
            throw new Exception("{$middleware} does not respond to the {$action}.");
        }

        $middleware->$action();
    }

    protected function callAction($controller, $action) {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if(! method_exists($controller, $action)) {
            throw new Exception("{$controller} does not respond to the {$action}.");
        }

        return $controller->$action();
    }
}