<?php

namespace App\controller\api;

use App\system\controller\Controller;
use App\system\Request;

class CampaignController extends Controller
{


    public function getCampaign()
    {

        global $table_prefix, $wpdb;
        $tableName = $table_prefix . 'bot_ninja_settings';

        $endpoint = config('environment')  === 'local' ? config('endpoints.campaign') : config('production_endpoints.campaign') ;
        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
        ];

        $options = [
            'body' => $body,
        ];
        $response = wp_remote_post($endpoint, $options);
        $data = json_decode($response['body'], true);

        return json($data['data'], 200);
    }


    public function createCampaign()
    {

        global $table_prefix, $wpdb;
        $tableName = $table_prefix . 'bot_ninja_campaign';

        $request = new Request;
        $phoneNUmber = $request->numberDetails['phoneNumber'];

        $campaign = $wpdb->get_row("SELECT * FROM $tableName WHERE phone_number = $phoneNUmber", OBJECT);

        if ($campaign) {
            return json(['message' => "Phone number already exist"], 401);
        }

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        try {
            $apiData = $this->phoneNumberCreate($request, $actual_link);
        } catch (\Exception $e) {
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
                "created_at" => date("Y-m-d h:i:s"),
            ));
            return json('Successfully Created');
        } else {
            return json(['message' => "Something went wrong"], 401);
        }
    }


    public function phoneNumberCreate(Request $request, $url)
    {
        global $table_prefix, $wpdb;
        $tableName = $table_prefix . 'bot_ninja_settings';

        $endpoint = config('environment')  === 'local' ? config('endpoints.createCampaign') : config('production_endpoints.createCampaign') ;

        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
            'data' => $request->allData
        ];

        $options = [
            'body' => $body,
            'headers' => [
                'referer' => str_replace('createCampaign', '', $url),
            ]
        ];


        $response = wp_remote_post($endpoint, $options);

        return $response['body'] == 'string' ? $response['body'] : json_decode($response['body'], true);

    }


    public function updateCampaign()
    {
        global $table_prefix, $wpdb;
        $request = new Request;

        $tableName = $table_prefix . 'bot_ninja_settings';
        $settings = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);
        $endpoint = config('environment')  === 'local' ? config('endpoints.updateCampaign') : config('production_endpoints.updateCampaign') ;

        $body = [
            'license_key' => $settings->license_key,
            'api_key' => $settings->api_key,
            'campaign' => $request->allData
        ];


        $options = [
            'body' => $body
        ];


        $response = wp_remote_post($endpoint, $options);

        return json('Successfully Updated');
    }


    public function getCampaignDetails($param)
    {
        global $table_prefix, $wpdb;
        $tableName = $table_prefix . 'bot_ninja_settings';

        $phoneNumber = $param['phoneNumber'];
        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
            'phone_number' => $phoneNumber,
        ];

        $options = [
            'body' => $body,
        ];
        $endpoint = config('environment')  === 'local' ? config('endpoints.campaign_details') : config('production_endpoints.campaign_details') ;

        $response = wp_remote_post($endpoint, $options);
        $data = json_decode($response['body'], true);

        return json($data['data'], 200);

    }


    public function report()
    {

        global $table_prefix, $wpdb;
        $tableName = $table_prefix . 'bot_ninja_settings';
        $request = new Request;
        $phoneNumber = $request->phone_number;
        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
            'phone_number' => $phoneNumber,
            'month' => $request->month,
        ];

        $options = [
            'body' => $body,
        ];

        $endpoint = config('environment')  === 'local' ? config('endpoints.campaign_report') : config('production_endpoints.campaign_report') ;
        $response = wp_remote_post($endpoint, $options);
        $data = json_decode($response['body'], true);

        return json($data, 200);

    }



    public function summery()
    {

        global $table_prefix, $wpdb;

        $tableName = $table_prefix . 'bot_ninja_settings';
        $request = new Request;
        $phoneNumber = $request->phone_number;

        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
            'phone_number' => $phoneNumber
        ];



        $options = [
            'body' => $body,
        ];


        $endpoint = config('environment')  === 'local' ? config('endpoints.summery') : config('production_endpoints.summery') ;
        $response = wp_remote_post($endpoint, $options);
        $data = json_decode($response['body'], true);

        return json($data, 200);

    }

}
