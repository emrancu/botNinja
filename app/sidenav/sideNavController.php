<?php

namespace  App\sidenav;
use App\sidenav\sideNavContent;

class sideNavController
{
    use sideNavContent;

    public $plugin   ;
    public $pluginRoot   ;
    public $namespace ;
    public function __construct()
    {
        $this->namespace = 'BotNinja/v1' ;
        $this->plugin = $GLOBALS['plugin_base'];
        $this->pluginRoot = plugin_dir_path($this->plugin);
    }


    /**
     * @return void
     */
    public function  init()
    {
        add_action('admin_menu', array($this, 'addAdminMenu'));
    }

    /**
     * @return void
     */
    public function addAdminMenu() {
        $this->registerMenu();
        $this->registerSubMenu();
    }


    /**
     * Register submenu
     * @return void
     */
    public function registerMenu()
    {
        add_menu_page(
            __('BotNinja', 'Dashboard'),
            'BotNinja',
            'manage_options',
            'BotNinja',
            [$this, 'DashboardContent'],
            'dashicons-admin-site',
            100
        );
    }


    /**
     * Register submenu
     * @return void
     */
    public function registerSubMenu() {

        add_submenu_page(
            'BotNinja',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'BotNinja#/Dashboard',
            array($this, 'DashboardContent')
        );

        add_submenu_page(
            'BotNinja',
            'Campaign',
            'Campaign',
            'manage_options',
            'BotNinja#/Campaign',
            array($this, 'CampaignContent')
        );

        add_submenu_page(
            'BotNinja',
            'Report',
            'Report',
            'manage_options',
            'BotNinja#/Report',
            array($this, 'DashboardContent')
        );

        add_submenu_page(
            'BotNinja',
            'Settings',
            'Settings',
            'manage_options',
            'BotNinja#/Settings',
            array($this, 'DashboardContent')
        );

      
        remove_submenu_page('BotNinja','BotNinja');
    }

}