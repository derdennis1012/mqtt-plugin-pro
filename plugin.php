<?php  
/*
Plugin Name: MQTT Plugin Pro
Plugin URI: https://hs-furtwangen.de/
Description: A plugin to receive MQTT Data
Version: 0.0.1
Author: Lena Scheit, Arif Hünerli , Joshua Wehr, Dennis Bölling 
Author URI: https://hs-furtwangen.de/
License: Free-software license
License URI:https://en.wikipedia.org/wiki/Free-software_license
Text Domain: mqttpluginpro
Domain Path: /languages
*/
/**
 * Copyright (c) 2022 Lena Scheit , Arif Hünerli , Joshua Wehr, Dennis Bölling (email: softwareqad@gmail.com). All rights reserved.
 *
 * Released under the Free Software license
 * https://en.wikipedia.org/wiki/Free-software_license
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 */
if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
        if ( is_array( $log ) || is_object( $log ) ) {
            error_log( print_r( $log, true ) );
        } else {
            error_log( $log );
        }
    }
}

// don't call the file directly
if ( !defined( 'ABSPATH' ) ){
    write_log( "Plugin should not be accessed directly!" );
    exit;
}


function my_cron_schedules($schedules){

    if(!isset($schedules["30sec"])){
        $schedules["30sec"] = array(
            'interval' => 0,5*60,
            'display' => __('Once every 30 seconds'));
    }
    if(!isset($schedules["1min"])){
        $schedules["1min"] = array(
            'interval' => 1*60,
            'display' => __('Once every minute'));
    }
    if(!isset($schedules["5min"])){
        $schedules["5min"] = array(
            'interval' => 5*60,
            'display' => __('Once every 5 minutes'));
    }
    if(!isset($schedules["15min"])){
        $schedules["15min"] = array(
            'interval' => 15*60,
            'display' => __('Once every 15 minutes'));
    }
    if(!isset($schedules["30min"])){
        $schedules["30min"] = array(
            'interval' => 30*60,
            'display' => __('Once every 30 minutes'));
    }
    if(!isset($schedules["1h"])){
        $schedules["1h"] = array(
            'interval' => 60*60,
            'display' => __('Once every hour'));
    }
    if(!isset($schedules["3h"])){
        $schedules["3h"] = array(
            'interval' => 180*60,
            'display' => __('Once every 3 hours'));
    }
    if(!isset($schedules["5h"])){
        $schedules["5h"] = array(
            'interval' => 300*60,
            'display' => __('Once every 5 hours'));
    }
    if(!isset($schedules["1d"])){
        $schedules["1d"] = array(
            'interval' => 1440*60,
            'display' => __('Once every day'));
    }
    if(!isset($schedules["3d"])){
        $schedules["3d"] = array(
            'interval' => 4320*60,
            'display' => __('Once every 3 days'));
    }
    if(!isset($schedules["1w"])){
        $schedules["1w"] = array(
            'interval' => 10080*60,
            'display' => __('Once every week'));
    }
    write_log( "Created Scheduler!" );

    return $schedules;
}
add_filter('cron_schedules','my_cron_schedules');



final class MQTT_Plugin_Pro {

    public $version = '0.1.0';

    private $container = array();

    public function __construct() {

        global $wpdb;
        $this->wpdb = $wpdb;
        global $action_scheduler;

        $this->define_constants();
    
        register_activation_hook( __FILE__, array( $this, 'activate' ),array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
        
        add_action( 'admin_init', array( $this, 'my_plugin_redirect' ) );

        add_action( 'mqtt_get', array( $this, 'register_the_hook') );
        add_action( 'mqtt_disable', array( $this, 'disable_the_hook') );
	
        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
        add_action( 'cron_mqtt_hook', array( $this, 'scheduleTriggered') );
        add_action( 'wp_clean_database', array( $this, 'cleanDatabase') );

    }

    public static function init() {
        static $instance = false;
        if ( ! $instance ) {
            $instance = new MQTT_Plugin_Pro();
        }
        return $instance;
    }


    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }
        return $this->{$prop};
    }
    function scheduleTriggered() {
               $this->get_mqtt_data();
    }

    function cleanDatabase() {
        $ttl =  get_option( 'mqtt_pro_mqtt_ttl', false );
        if($ttl != ""){
            $ttl_int=(int)$ttl;
            $table_name = $this->wpdb->prefix . "mqtt_pro_data";
            $sql = "DELETE FROM `".$table_name."` WHERE(SELECT * FROM `".$table_name."` WHERE CAST(RecordCreated AS DATE) < DATE_SUB(DATE(now()), INTERVAL ".$ttl_int." DAY));";
            $this->wpdb->query($sql);
        }
        return;
    }

    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }


    public function define_constants() {
        define( 'mqtt_pro_version', $this->version );
        define( 'MQTTPLUGINPRO_FILE', __FILE__ );
        define( 'MQTTPLUGINPRO_PATH', dirname( MQTTPLUGINPRO_FILE ) );
        define( 'MQTTPLUGINPRO_INCLUDES', MQTTPLUGINPRO_PATH . '/includes' );
        define( 'MQTTPLUGINPRO_LIB', MQTTPLUGINPRO_PATH . '/lib' );
        define( 'MQTTPLUGINPRO_URL', plugins_url( '', MQTTPLUGINPRO_FILE ) );
        define( 'MQTTPLUGINPRO_ASSETS', MQTTPLUGINPRO_URL . '/assets' );
    }

    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
    }


    public function get_mqtt_data(){
        $topics = get_option( 'mqtt_pro_mqtt_topics' );
        $topicsArr = explode(',', $topics);
        $MQTTFN = new APP\MQTTBackendFunctions();
        foreach($topicsArr as $key => $value) 
        {
            $MQTTFN->mqtt_subscribe($value);
        }
    }

    public function activate() {

        $installed = get_option( 'mqtt_pro_installed' );

        if ( ! $installed ) {
            update_option( 'mqtt_pro_installed', time() );
        }
        include('installer.php');
        
        update_option( 'mqtt_pro_version', mqtt_pro_version );
        
       add_option('my_plugin_do_activation_redirect_', true);


    }
    
    function my_plugin_redirect() {
        write_log("Plugin activated.2..");

        if (get_option('my_plugin_do_activation_redirect_', false)) {
            delete_option('my_plugin_do_activation_redirect_');
            if(get_option( 'mqtt_pro_mqtt_url','' ) != ''){
                exit( wp_redirect( admin_url( 'admin.php?page=mqtt-plugin-pro#/about' ) ));
            }else{
                exit;
            }
        }
    }

    public function register_the_hook(){
        $cStatus =  get_option( 'mqtt_pro_active', false );
        $interval =  get_option( 'mqtt_pro_mqtt_interval', false );

        wp_clear_scheduled_hook('cron_mqtt_hook');
        wp_clear_scheduled_hook('wp_clean_database');
        if ( true ) {
            wp_schedule_event( time(), ''.$interval, 'cron_mqtt_hook' );
            wp_schedule_event( time(), '1d', 'wp_clean_database' );
        }else{
        }
        
    }
    
    public function disable_the_hook(){
        wp_clear_scheduled_hook('cron_mqtt_hook');
    }

   
    public function deactivate() {
        wp_clear_scheduled_hook('cron_mqtt_hook');
    }


    public function includes() {
        require_once MQTTPLUGINPRO_INCLUDES . '/Assets.php';
        if ( $this->is_request( 'admin' ) ) {
            require_once MQTTPLUGINPRO_INCLUDES . '/Admin.php';
        }
        if ( $this->is_request( 'frontend' ) ) {
            require_once MQTTPLUGINPRO_INCLUDES . '/Frontend.php';
        }
        require_once MQTTPLUGINPRO_INCLUDES . '/Api.php';
        require_once MQTTPLUGINPRO_INCLUDES . '/MQTTBackendFunctions.php';
    }


    public function init_hooks() {
        add_action( 'init', array( $this, 'init_classes' ) );
        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    public function init_classes() {
        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new App\Admin();
        }
        if ( $this->is_request( 'frontend' ) ) {
            $this->container['frontend'] = new App\Frontend();
        }
        $this->container['api'] = new App\Api();
        $this->container['assets'] = new App\Assets();
    }

    public function localization_setup() {
        load_plugin_textdomain( 'mqttpluginpro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined( 'DOING_AJAX' );

            case 'rest' :
                return defined( 'REST_REQUEST' );

            case 'cron' :
                return defined( 'DOING_CRON' );

            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }
} 
$mqttpluginpro = MQTT_Plugin_Pro::init();
