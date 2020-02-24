<?php
      function view($path){
        require_once plugin_dir_path(__FILE__) . '../../resources/view/'.$path.'.php';
    }

    function route_file($routeObject){
          $route = $routeObject;
        require_once plugin_dir_path(__FILE__) . '../../routes/route.php';
    }


    function json($data, $status = 200){
      return wp_send_json($data, $status);
    }