<?php

namespace App\controller\api;

use App\system\controller\Controller;
use App\system\Request;

class SettingsController
{

    public function saveSetting()
    {


        global $table_prefix, $wpdb;
        $request = new Request;

        $tableName =  $table_prefix.'bot_ninja_settings';

        $id = $request->id;
        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);
 
        if (!$campaign) {

            $wpdb->insert($tableName, array(
                "license_key" => $request->license_key,
                "api_key" => $request->api_key
            ));

        } else {

            $wpdb->update($tableName, array(
                "license_key" => $request->license_key,
                "api_key" => $request->api_key
            ), ["id" => $id]);

        }

        return json('Successfully Updated');
    }


    public function getSetting()
    {
        global $table_prefix, $wpdb;

        $tableName =  $table_prefix.'bot_ninja_settings';
        $results = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        return json($results, 200);
    }


}
