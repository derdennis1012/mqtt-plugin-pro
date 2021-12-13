<?php global $wpdb;
$table_name = $wpdb->prefix . "mqtt_pro_data";
$mqtt_pro_data_db_version = '1.0.0';
$charset_collate = $wpdb->get_charset_collate();

if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {

    $sql = "CREATE TABLE $table_name (
            ID INT NOT NULL AUTO_INCREMENT,
            `Topic` varchar(255) null,
	        `DataSet` varchar(1000) null,
	        `RecordCreated` TIMESTAMP default CURRENT_TIMESTAMP null,
            PRIMARY KEY  (ID)
    ) $charset_collate;";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('my_db_version', $mqtt_pro_data_db_version);
}
?>