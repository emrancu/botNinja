<?php

namespace App\system;


class ApiRoute
{

    public $args = [] ;

    public function routes()
    {
        route_file($this);
    }


    private function requiredParam($route){

        preg_match_all('#\{(.*?)\}#', $route, $match);
        foreach($match[0] as $k=>$v){
            $route =   str_replace($v, '(?P<'.$match[1][$k].'>\d+)', $route  ) ;
            array_push($this->args,$match[1][$k] );
        }


        return $route;
    }


    private function optionalParam($route){

        preg_match_all('#\{(.*?)\}#', $route, $match);

        foreach($match[0] as $k=>$v){
            $route =   str_replace('/'.$v, '(?:/(?P<'.str_replace('?','',$match[1][$k]).'>\d+))?', $route  ) ;
            array_push($this->args,$match[1][$k] );

        }

        return $route;
    }

    private function formatRoute($route){

        if (strpos($route, '?}') !== false) {
            $route =  $this->optionalParam($route) ;
        }else{
            $route =  $this->requiredParam($route) ;
        }

        return $route  ;
    }


    public function get($route, $callback, $secure = false)
    {

        $formattedRoute = $this->formatRoute($route) ;
        $exp = explode('@', $callback);

        $class = "App" . "\\controller\\" . "api\\" . $exp[0];
        $options = [
            'method' => 'GET',
            'callback' => [new $class(), $exp[1]],
            'args' => $this->args
        ];


        //  $middleware = 'Admin' ;
        //$m = (new Config())->middleware[$middleware];

        // $middlewareCall = new $m;


        //  $options['permission_callback'] = array($middlewareCall, 'handle');


        register_rest_route(
            'botNinja/v1',
            '/' . $formattedRoute,
            $options
        );
    }


    public function post($route, $callback, $secure = false)
    {

        $formattedRoute = $this->formatRoute($route) ;

        $exp = explode('@', $callback);


        $class = "App" . "\\controller\\" . "api\\" . $exp[0];

        $options = [
            'methods' => 'POST',
            'callback' => [new $class, $exp[1]],
            'args' => $this->args
        ];

        if ($secure) {
            $options['permission_callback'] = array($this, 'check_permission');
        }

        register_rest_route(
            'botNinja/v1',
            '/' . $formattedRoute,
            $options
        );


    }


    public function check_permission()
    {
        return current_user_can('manage_options');
    }

}
