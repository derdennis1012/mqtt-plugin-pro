<?php
/*
Plugin Name: MQTT Plugin Pro
Plugin URI: https://hs-furtwangen.de/
Description: A WordPress Vue.js starter plugin
Version: 0.1
Author: Your Name
Author URI: https://hs-furtwangen.de/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: mqttpluginpro
Domain Path: /languages
*/

/**
 * Copyright (c) YEAR Your Name (email: Email). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

//Add a utility function to handle logs more nicely.
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
            'display' => __('Once every 30 Seconds'));
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


/**
 * MQTT_Plugin_Pro class
 *
 * @class MQTT_Plugin_Pro The class that holds the entire MQTT_Plugin_Pro plugin
 */
final class MQTT_Plugin_Pro {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.1.0';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = array();

    /**
     * Constructor for the MQTT_Plugin_Pro class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {

        $this->define_constants();
    

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );


        add_action( 'mqtt_get', array( $this, 'register_the_hook') );
        add_action( 'mqtt_disable', array( $this, 'disable_the_hook') );

	
        do_action( 'mqtt_get',null);
        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
        add_action( 'woocsp_cron_delivery', array( $this, 'scheduleTriggered') );

    }



//Add cron schedules filter with upper defined schedule.

    /**
     * Initializes the MQTT_Plugin_Pro() class
     *
     * Checks for an existing MQTT_Plugin_Pro() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new MQTT_Plugin_Pro();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }
    //Custom function to be called on schedule triggered.
    function scheduleTriggered() {
        write_log( "Scheduler triggered!" );
        //@ToDo -> loop -> array -> get_m... mit Parameter Topic aufrufen
        $this->get_mqtt_data();
    }
    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'mqtt_pro_version', $this->version );
        define( 'MQTTPLUGINPRO_FILE', __FILE__ );
        define( 'MQTTPLUGINPRO_PATH', dirname( MQTTPLUGINPRO_FILE ) );
        define( 'MQTTPLUGINPRO_INCLUDES', MQTTPLUGINPRO_PATH . '/includes' );
        define( 'MQTTPLUGINPRO_LIB', MQTTPLUGINPRO_PATH . '/lib' );
        define( 'MQTTPLUGINPRO_URL', plugins_url( '', MQTTPLUGINPRO_FILE ) );
        define( 'MQTTPLUGINPRO_ASSETS', MQTTPLUGINPRO_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugis are loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
    }


    public function get_mqtt_data(){
        write_log( "GET MQTT" );
        $topics = get_option( 'mqtt_pro_mqtt_topics' );
        $topicsArr = explode(',', $topics);

        $MQTTFN = new APP\MQTTBackendFunctions();


        foreach($topicsArr as $key => $value) 
        {
            $MQTTFN->mqtt_subscribe($value);
            write_log( "DONE MQTT: ".$value );
        }
    }


 

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {

        $installed = get_option( 'mqtt_pro_installed' );

        if ( ! $installed ) {
            update_option( 'mqtt_pro_installed', time() );
        }
        include('installer.php');
        
        update_option( 'mqtt_pro_version', mqtt_pro_version );

        write_log("Plugin activating.");

  
    
        write_log("Plugin activated.");
/*
             //Trigger our method on our custom schedule event.
          
*/
        
       // wp_schedule_event( time(), '5min', 'mqtt_get' );
    }


    public function register_the_hook(){
        write_log("Wenn das nicht klappt rast ich aus!");
        $cStatus =  get_option( 'mqtt_pro_active', false );
        write_log($cStatus.'Hello??');
        wp_clear_scheduled_hook('woocsp_cron_delivery');
        if ( true ) {
            write_log($cStatus.'Hat geklappt...');
            wp_schedule_event( time(), '1min', 'woocsp_cron_delivery' );
        }else{
            write_log('Scheiße .. nicht ausrasten....');
        }
        
    }
    
    public function disable_the_hook(){
        write_log("Ist deaktiviert!");
        wp_clear_scheduled_hook('woocsp_cron_delivery');
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {
        //wp_clear_scheduled_hook( 'mqtt_get' );
        write_log("Plugin deactivating.");

        //Remove our scheduled hook.
        wp_clear_scheduled_hook('woocsp_cron_delivery');
    
        write_log("Plugin deactivated.");
    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {

        require_once MQTTPLUGINPRO_INCLUDES . '/Assets.php';

        if ( $this->is_request( 'admin' ) ) {
            require_once MQTTPLUGINPRO_INCLUDES . '/Admin.php';
        }

        if ( $this->is_request( 'frontend' ) ) {
            require_once MQTTPLUGINPRO_INCLUDES . '/Frontend.php';
        }

        if ( $this->is_request( 'ajax' ) ) {
            // require_once MQTTPLUGINPRO_INCLUDES . '/class-ajax.php';
        }

        require_once MQTTPLUGINPRO_INCLUDES . '/Api.php';
        require_once MQTTPLUGINPRO_INCLUDES . '/MQTTBackendFunctions.php';

    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {

        add_action( 'init', array( $this, 'init_classes' ) );

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes() {

        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new App\Admin();
        }

        if ( $this->is_request( 'frontend' ) ) {
            $this->container['frontend'] = new App\Frontend();
        }

        //@ToDO
       /* if ( $this->is_request( 'ajax' ) ) {
            $this->container['ajax'] =  new App\Ajax();
        }
        */
        $this->container['api'] = new App\Api();
        $this->container['assets'] = new App\Assets();

    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'mqttpluginpro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     *
     * @return bool
     */
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


} // MQTT_Plugin_Pro

$mqttpluginpro = MQTT_Plugin_Pro::init();
