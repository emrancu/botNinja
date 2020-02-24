<?php

namespace App\system\bootstrap;

class Activator
{


    public function __construct()
    {

    }

    /**
     * @return void
     */
    public function activate()
    {
        $this->createTable();
    }


    public function createTable()
    {
        global $wpdb;
        $charset = $wpdb->get_charset_collate();

        $this->createCampaignTable($charset);
        $this->createSettingTable($charset);

    }


    public function createCampaignTable($charset_collate)
    {
        global $table_prefix, $wpdb;

        $tableName = 'bot_ninja_campaign';
        $table = $table_prefix . "$tableName";

        if ($wpdb->get_var("show tables like '$table'") != $table) {
            $sql = "CREATE TABLE " . $table . " ( ";
            $sql .= "  `id`  bigint(20) NOT NULL auto_increment PRIMARY KEY, ";
            $sql .= "  `name`  varchar(255) NOT NULL,";
            $sql .= "  `details`  varchar(500) NULL,";
            $sql .= "  `phone_number`  varchar(20) NOT NULL,";
            $sql .= "  `friendly_name`  varchar(50) NOT NULL,";
            $sql .= "  `type`  varchar(50)   NOT NULL,";
            $sql .= "  `code`  varchar(255)   NOT NULL,";
            $sql .= "  `capabilities`  text   NOT NULL,";
            $sql .= "  `sid`  varchar(255)   NOT NULL,";
            $sql .= "  `status` enum('enabled','disable') NOT NULL,";
            $sql .= "  `ring_time` enum('any','range') NULL,";
            $sql .= "  `start_time` varchar(255) NULL,";
            $sql .= "  `end_time` varchar(255) NULL,";
            $sql .= "  `block_lists` varchar(255) NULL,";
            $sql .= "  `billing_type` enum('call','flat')  NULL,";
            $sql .= "  `call_cost` bigint(20) NULL,";
            $sql .= "  `notification_fire` enum('start','end') NULL,";
            $sql .= "  `email_notification` enum('disable','enabled') NULL,";
            $sql .= "  `notification_email` varchar(255) NULL,";
            $sql .= "  `forward_method` enum('single','multiple') NULL,";
            $sql .= "  `forwarding_numbers` varchar(500) NULL,";
            $sql .= "  `record` enum('enabled','disable')  NULL,";
            $sql .= "  `whisper` enum('enabled','disable')  NULL,";
            $sql .= "  `whisper_type` enum('text','audio')  NULL,";
            $sql .= "  `whisper_text` varchar(255)  NULL,";
            $sql .= "  `whisper_audio` varchar(255)  NULL,";
            $sql .= "  `voicemail_type` enum('text','audio')  NULL,";
            $sql .= "  `voicemail_text` varchar(255)  NULL,";
            $sql .= "  `voicemail_audio` varchar(255)  NULL,";
            $sql .= "  `form_call_number` varchar(255)  NULL,";
            $sql .= "  `form_call_text` varchar(500)  NULL,";
            $sql .= "  `created_at` timestamp NULL DEFAULT NULL,";
            $sql .= "  `updated_at` timestamp NULL DEFAULT NULL";
            $sql .= ") $charset_collate";

            require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }


    public function createSettingTable($charset_collate)
    {
        global $table_prefix, $wpdb;

        $tableName = 'bot_ninja_settings';
        $table = $table_prefix . "$tableName";

        if ($wpdb->get_var("show tables like '$table'") != $table) {
            $sql = "CREATE TABLE " . $table . " ( ";
            $sql .= "  `id`  bigint(20) NOT NULL auto_increment PRIMARY KEY, ";
            $sql .= "  `license_key`  varchar(255) NOT NULL,";
            $sql .= "  `api_key`  varchar(255) NULL";
            $sql .= ") $charset_collate";

            require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }


}
