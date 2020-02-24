<?php

namespace App\controller\api;

use App\system\Request;

class CampaignController
{


    public function getCampaignResponse()
    {

        global $table_prefix, $wpdb;

        $tableName = $table_prefix . 'bot_ninja_campaign';
        $results = $wpdb->get_results("SELECT * FROM $tableName");

        return json($results, 200);

    }


    public function createCampaignResponse()
    {
        global $table_prefix, $wpdb;
        $request = new Request;

        $tableName = $table_prefix . 'bot_ninja_campaign';
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
        $endpoint = 'http://wpapi.chatleads.io/createBot';
        $tableName = $table_prefix . 'bot_ninja_settings';
        $campaign = $wpdb->get_row("SELECT * FROM $tableName", OBJECT);

        $body = [
            'license_key' => $campaign->license_key,
            'api_key' => $campaign->api_key,
            'phone_number' => $request->numberDetails['phoneNumber']
        ];

        //  $body = wp_json_encode($body);

        $options = [
            'body' => $body,
            'headers' => [
                //'Content-Type' => 'application/json',
                'referer' => str_replace('createCampaign', '', $url),
            ]
        ];


        $response = wp_remote_post($endpoint, $options);

        return $response['body'] == 'string' ? $response['body'] : json_decode($response['body'], true);

    }


    public function updateCampaignResponse()
    {
        global $table_prefix, $wpdb;
        $request = new Request;

        $tableName = $table_prefix . 'bot_ninja_campaign';

        $phoneNUmber = $request->numberDetails['phoneNumber'];
        $id = $request->id;
        $campaign = $wpdb->get_row("SELECT * FROM $tableName WHERE id = $id", OBJECT);

        if (!$campaign) {
            return json(['message' => "Something went wrong"], 401);
        }

        $success = $wpdb->update($tableName, array(
            "name" => $request->name,
            "status" => "disable",
            "ring_time" => $request->ring_time,
            "start_time" => $request->ring_time == 'any' ? null : $request->start_time,
            "end_time" => $request->ring_time == 'any' ? null : $request->end_time,
            "block_lists" => $request->block_lists,
            "billing_type" => $request->billing_type,
            "call_cost" => $request->call_cost,
            "notification_fire" => $request->notification_fire,
            "email_notification" => $request->email_notification,
            "notification_email" => $request->notification_email,
            "forward_method" => $request->forward_method,
            "forwarding_numbers" => $request->forwarding_numbers,
            "record" => $request->record,
            "whisper" => $request->whisper,
            "whisper_type" => $request->whisper_type,
            "whisper_text" => $request->whisper_type == 'audio' ? null : $request->whisper_text,
            "whisper_audio" => $request->whisper_type == 'text' ? null : $request->whisper_audio,
            "voicemail_type" => $request->voicemail_type,
            "voicemail_text" => $request->voicemail_type == 'audio' ? null : $request->voicemail_text,
            "voicemail_audio" => $request->voicemail_type == 'text' ? null : $request->voicemail_audio,
            "form_call_number" => $request->form_call_number,
            "form_call_text" => $request->form_call_text,
            "updated_at" => date("Y-m-d h:i:s"),
        ), ["id" => $id]);

        return json('Successfully Updated');
    }


    public function getCampaignDetailsResponse($param)
    {

        global $table_prefix, $wpdb;

        $tableName = $table_prefix . 'bot_ninja_campaign';

        $phoneNumber = $param['phoneNumber'];
        $campaign = $wpdb->get_row("SELECT * FROM $tableName WHERE phone_number = +$phoneNumber", OBJECT);


        return json($campaign, 200);

    }

}
