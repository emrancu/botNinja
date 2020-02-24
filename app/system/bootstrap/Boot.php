<?php


namespace App\system\bootstrap;


use App\AddEnqueue;
use App\sidenav\sideNavController;
use App\system\ApiRoute;

class Boot
{

    public static function init()
    {
        global $plugin_base;
        $active = new Activator();
        $deActive = new  DeActivator();

        register_activation_hook($plugin_base, [$active, 'activate']);
        register_deactivation_hook($plugin_base, [$deActive, 'deactivate']);

        add_action('rest_api_init', [new ApiRoute, 'routes']);
        $menuRegister = new sideNavController();
        $menuRegister->init();
        AddEnqueue::init();
    }

}