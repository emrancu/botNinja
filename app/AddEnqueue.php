<?php
namespace  App;

require_once plugin_dir_path(__FILE__) . '/system/global.php';

use App\system\enqueue\EnqueueController;
class AddEnqueue extends EnqueueController
{


    public static function init()
    {
        (new self)->initAsset();
    }




    function addCss_and_JS($hook)
    {
        if ( 'toplevel_page_BotNinja' == $hook ) {

            
            $this->scriptHeader('assets/cdn/vue.js') ;
            $this->scriptHeader('assets/cdn/vue-router.js') ;
            $this->scriptHeader('assets/cdn/vuex.min.js') ;
            $this->scriptHeader('assets/webToast.min.js') ;
            $this->scriptFooter('assets/cdn/bootstrap.min.js') ;
            $this->scriptFooter('assets/index.js', false, 'botNinjaScriptIndex') ;
            $this->scriptFooter('assets/vueComponent/store.js') ;
            $this->scriptFooter('assets/vueComponent/vueActions.js') ;
            $this->scriptFooter('assets/vueComponent/vueApp.js') ;

            $this->style('assets/cdn/bootstrap.min.css') ;
            $this->style('assets/style.css') ;

            wp_localize_script( 'botNinjaScriptIndex', 'secureAjaxData', array(
                'root' => esc_url_raw( rest_url() ),
                'security' => wp_create_nonce( 'wp_rest' )
            ) );

        }
    }


}

