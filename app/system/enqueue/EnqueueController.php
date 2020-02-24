<?php
namespace  App\system\enqueue;

class EnqueueController
{

    public $plugin   ;
    public $pluginRoot   ; 

    public function __construct()
    { 
        $this->plugin = $GLOBALS['plugin_base'];
        $this->pluginRoot = plugin_dir_path($this->plugin);

    }

    /**
     * @param $path
     * @param bool $external
     * @param string $id
     */
    public function scriptFooter($path, $external = false, $id = '')
    {
        $handler = $id ? $id : uniqid();
        $path = $external ? $path : plugins_url($this->pluginRoot) . $path ;
        wp_enqueue_script($handler, $path , array(), '1.0.0', true);
    }

    /**
     * @param $path
     * @param bool $external
     * @param string $id
     */
    public function scriptHeader($path, $external = false, $id = '')
    {
        $handler = $id ? $id : uniqid();
        $path = $external ? $path : plugins_url($this->pluginRoot) . $path ;
        wp_enqueue_script($handler, $path , array(), '1.0.0', false);
    }

    /**
     * @param $path
     * @param bool $external
     */
    public function style($path, $external = false)
    {
        $path = $external ? $path : plugins_url($this->pluginRoot) . $path ; 
          wp_enqueue_style(uniqid(), $path, array(), '1.0.0', 'all');
    }

    public function initAsset()
    {
        add_action('admin_enqueue_scripts', array($this, 'addCss_and_JS'));
        $this->initSettingLink(); 
    }

    public  function initSettingLink()
    { 
        add_filter('plugin_action_links_'.$this->plugin, [$this, 'settings_link']);
    }




    public function settings_link($links)
    {
        $settings_link = "<a href='admin.php?page=Bot-Ninja-Page'> Settings </a>";
        array_push($links, $settings_link) ;
        return $links;
    }

 

}