<?php
namespace  App\system;

class ConfigHandler
{
    public $config;
    private static $instance = null;

    public function __construct()
    {
        $this->config = include plugin_dir_path(__FILE__) . '../../app/config/config.php';

    }

    public static function init()
    {
        if (self::$instance == null)
        {
            self::$instance = new ConfigHandler();
        }

        return self::$instance;
    }


    public function get( $key ){
        $data = explode('.', $key);
        $finalData = $this->config;
        foreach ($data as $k => $v) {
            $finalData = $finalData[$v];
        }
        return $finalData;
    }

}
