<?php

namespace App\system;


class ApiRoute
{

    public function routes()
    {
        route_file($this);
    }

    public function get($route, $callback, $secure = false)
    {
        $options = [
            'method' => 'GET',
            'callback' => $callback
        ];

        if ($secure) {
            $options['permission_callback'] = array($this, 'check_permission');
        }

        register_rest_route(
            'botNinja/v1',
            '/' . $route,
            $options
        );
    }

    public function post($route, $callback, $secure = false)
    {
        $options = [
            'methods' => 'POST',
            'callback' => $callback
        ];

        if ($secure) {
            $options['permission_callback'] = array($this, 'check_permission');
        }

        register_rest_route(
            'botNinja/v1',
            '/' . $route,
             $options
        );



    }

    public function check_permission()
    {
        return current_user_can('manage_options');
    }

}