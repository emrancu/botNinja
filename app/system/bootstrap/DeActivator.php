<?php

namespace App\system\bootstrap;

class DeActivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public  function deactivate() {
	    $this->deleteTable();
	}


    public static function deleteTable()
    {
        global $table_prefix, $wpdb;

		$tableName = 'bot_ninja_campaign';
        $table = $table_prefix . $tableName;
		
        $sql = "DROP TABLE $table"  ;
        $wpdb->query( $sql);

		$tableName = 'bot_ninja_settings';
		$table = $table_prefix . $tableName;
		
        $sql = "DROP TABLE $table"  ;
        $wpdb->query( $sql);

    }



}
