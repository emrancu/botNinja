<?php

namespace App\controller\api;

use App\system\Request;

class CampaignController
{


    public function getCampaignResponse()
    {

        global $table_prefix, $wpdb;
        $tableName = $table_prefix.'bot_ninja_settings';

        $endpoint = 'http://wpapi.chatleads.io/getCampaign';
        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
        ];

        $options = [
            'body' => $body,
        ];
        $response = wp_remote_post($endpoint, $options);
        $data = json_decode($response['body'] ,true) ;

        return json($data['data'], 200);
    }


    public function createCampaignResponse()
    {

        global $table_prefix,$wpdb;
        $tableName = $table_prefix.'bot_ninja_campaign';

        $request = new Request;
        $phoneNUmber = $request->numberDetails['phoneNumber'];

        $campaign = $wpdb->get_row("SELECT * FROM $tableName WHERE phone_number = $phoneNUmber", OBJECT);

        if ($campaign) {
            return json(['message' => "Phone number already exist"], 401);
        }

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        try {
            $apiData = $this->phoneNumberCreate($request, $actual_link);
        }catch(\Exception $e){
            return json_encode($e->getMessage());
        }

        if ($apiData['status']) {
            $success = $wpdb->insert($tableName, array(
                "name" => $request->title,
                "phone_number" => $request->numberDetails['phoneNumber'],
                "friendly_name" => $request->numberDetails['friendlyName'],
                "type" => $request->numberType,
                "code" => $request->numberDetails['countryCode'],
                "capabilities" => json_encode($request->numberDetails['capabilities']),
                "sid" => 'll',
                "status" => "disable",
                "created_at" =>  date("Y-m-d h:i:s"),
            ));
            return json('Successfully Created');
        } else {
            return json(['message' => "Something went wrong"], 401);
        }
    }


    public function phoneNumberCreate(Request $request, $url)
    {
        global $table_prefix,$wpdb;
        $tableName = $table_prefix.'bot_ninja_settings';

        $endpoint = 'http://wpapi.chatleads.io/createBot';
        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
            'data' =>  $request->allData
        ];

        $options = [
            'body' => $body,
            'headers' => [
                'referer' => str_replace('createCampaign', '', $url),
            ]
        ];


        $response = wp_remote_post($endpoint, $options);

        return  $response['body'] == 'string' ?  $response['body']  : json_decode( $response['body'] , true) ;

    }


    public function updateCampaignResponse()
    {
        global $table_prefix,$wpdb;
        $request = new Request;
        $tableName = $table_prefix.'bot_ninja_campaign';
        $id = $request->id;
        $campaign = $wpdb->get_row("SELECT * FROM $tableName WHERE id = $id", OBJECT);

        if (!$campaign) {
            return json(['message' => "Something went wrong"], 401);
        }


        $tableName = $table_prefix.'bot_ninja_settings';
        $settings = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);
        $endpoint = 'http://wpapi.chatleads.io/updateSettings';
        $body = [
            'license_key' => $settings->license_key,
            'api_key' => $settings->api_key,
            'campaign' =>  $request->allData
        ];


        $options = [
            'body' => $body
        ];


        $response = wp_remote_post($endpoint, $options);

        return json('Successfully Updated');
    }


    public function getCampaignDetailsResponse($param)
    {
        global $table_prefix, $wpdb;
        $tableName = $table_prefix.'bot_ninja_settings';

        $phoneNumber = $param['phoneNumber'];
        $endpoint = 'http://wpapi.chatleads.io/getCampaignDetails';
        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
            'phone_number' => $phoneNumber,
        ];

        $options = [
            'body' => $body,
        ];
        $response = wp_remote_post($endpoint, $options);
        $data = json_decode($response['body'] ,true) ;

        return json($data['data'], 200);

    }

}
