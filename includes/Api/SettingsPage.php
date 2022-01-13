<?php



namespace App\Api;
use WP_REST_Controller;

/**
 * REST_API Handler
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



require_once( MQTTPLUGINPRO_INCLUDES.'/phpMQTT.php' );
require_once MQTTPLUGINPRO_INCLUDES . '/MQTTBackendFunctions.php';


class SettingsPage extends WP_REST_Controller {
    private $wpdb;

    /**
     * [__construct description]
     */
    public function __construct() {
        $this->namespace = 'mqtt-plugin-pro/v1';
        $this->rest_base = 'settings';
        global $wpdb;
        $this->wpdb = $wpdb;

        add_action( 'cron_mqtt', array( $this, 'hook_fn_mqtt') );

    }

    /**
     * Register the routes
     *
     * @return void
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_settings_data' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ],
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'set_settings_data' ],
                    'permission_callback' => [ $this, 'set_settings_data_permission_check' ],
                    'args'                => $this->get_endpoint_args_for_item_schema(true )
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/check-table',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'check_table_exists' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/create-table',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'create_table' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/activate',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'activate_service' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
    
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/disable',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'disable_service' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/check-connection',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'check_connection' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
    }


    public function hook_fn_mqtt(){
        write_log( "GET MQTT" );
        //$MQTTFN = new \APP\MQTTBackendFunctions();
        //$MQTTFN->mqtt_subscribe();
        write_log( "DONE MQTT" );
    }
    public function check_connection($request){
        $mqtt_pro_mqtt_url = isset( $request['mqtt_pro_mqtt_url'] ) ? $request['mqtt_pro_mqtt_url'] : '';
        $mqtt_pro_mqtt_port = isset( $request['mqtt_pro_mqtt_port'] ) ? $request['mqtt_pro_mqtt_port']: '';
        $mqtt_pro_mqtt_client_id = isset( $request['mqtt_pro_mqtt_client_id'] ) ?$request['mqtt_pro_mqtt_client_id'] : '';
        $mqtt_pro_requires_auth = isset( $request['mqtt_pro_requires_auth'] ) ? $request['mqtt_pro_requires_auth'] : 'false';
        $mqtt_pro_mqtt_user = isset( $request['mqtt_pro_mqtt_user'] ) ? $request['mqtt_pro_mqtt_user'] : '';
        $mqtt_pro_mqtt_password = isset( $request['mqtt_pro_mqtt_password'] ) ? $request['mqtt_pro_mqtt_password'] : '';
    }
    public function activate_service(){
        write_log("Go into activate service....");
        do_action( 'mqtt_disable',null);
        $activated = "false";
        $error = "false";
        $cStatus =  get_option( 'mqtt_pro_active', "false" );
        if($cStatus == 'true'){
            $activated = "true";
        }else{
            if($this->checkMQTTConnection()){
                //MQQT Geht -> Hook Registrieren
                write_log("MQTT works, register Hook now!!");

                /*wp_clear_scheduled_hook('cron_mqtt');
                if ( ! wp_get_schedule( 'cron_mqtt' ) ) {
                    wp_schedule_event( time(), '1min', 'cron_mqtt' );
                }*/
                update_option( 'mqtt_pro_active', "true" );

                do_action( 'mqtt_get',null);
                write_log("Hook registred, hopefully...!!");
                $activated = "true";

            }else{
                $error = "true";
            }
        }
        $respObj = [
            'activated' =>  $activated,
            'error'=> $error
        ];

        $response = rest_ensure_response( $respObj );
    }
    public function disable_service(){
        $activated = "false";
        $respObj = [
            'activated' =>  $activated,
        ];
        write_log( "Disabled" );
        //Hook beenden
        do_action( 'mqtt_disable',null);
        update_option( 'mqtt_pro_active', $activated );

        $response = rest_ensure_response( $respObj );
    }

    public function checkMQTTConnection(){
        $settingsData = [
            'mqtt_pro_mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
            'mqtt_pro_mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
            'mqtt_pro_mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
            'mqtt_pro_mqtt_user' => get_option( 'mqtt_pro_mqtt_user', null ),
            'mqtt_pro_mqtt_password' => get_option( 'mqtt_pro_mqtt_password', null ),
            'mqtt_pro_requires_auth' => get_option( 'mqtt_pro_mqtt_topics', "false" ),
        ];

        //@ToDo hier auch auth mit PWD
        $mqtt = new \APP\phpMQTT( $settingsData['mqtt_pro_mqtt_url'], intval($settingsData['mqtt_pro_mqtt_port']), $settingsData['mqtt_pro_mqtt_client_id'] );
        if ($mqtt->connect()) return true;
        else return false;
    }


    public function create_table(){
        $table_name = $this->wpdb->prefix . "mqtt_pro_data"; 
        $sql = "DROP TABLE IF EXISTS ". $table_name;
        $this->wpdb->get_results($sql);
        $sql = "create table " . $table_name . "(ID int auto_increment PRIMARY KEY,Topic varchar(255) null,DataSet varchar(1000) null,RecordCreated TIMESTAMP default CURRENT_TIMESTAMP null);";
        $sql=str_replace("\r\n","",$sql);
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        $respObj = [
            'exist' => true,
            'sql' => $sql
        ];
        $response = rest_ensure_response( $respObj );
        return rest_ensure_response( $response );
    }
    public function check_table_exists(){
        $charset_collate = $this->wpdb->get_charset_collate();
        $table_name = $this->wpdb->prefix . "mqtt_pro_data"; 
        $sql = "SHOW TABLES LIKE '". $table_name ."'";
        $this->wpdb->get_results($sql);
        $respObj = [
            'exist' => true
        ];
        $response = rest_ensure_response( $respObj );
        return rest_ensure_response( $response );
    }

    public function set_settings_data( $request ) {

        // Data validation
        $mqtt_pro_mqtt_url = isset( $request['mqtt_pro_mqtt_url'] ) ? $request['mqtt_pro_mqtt_url'] : '';
        $mqtt_pro_mqtt_port = isset( $request['mqtt_pro_mqtt_port'] ) ? $request['mqtt_pro_mqtt_port']: '';
        $mqtt_pro_mqtt_client_id = isset( $request['mqtt_pro_mqtt_client_id'] ) ?$request['mqtt_pro_mqtt_client_id'] : '';
        $mqtt_pro_requires_auth = isset( $request['mqtt_pro_requires_auth'] ) ? $request['mqtt_pro_requires_auth'] : 'false';
        $mqtt_pro_mqtt_user = isset( $request['mqtt_pro_mqtt_user'] ) ? $request['mqtt_pro_mqtt_user'] : '';
        $mqtt_pro_mqtt_password = isset( $request['mqtt_pro_mqtt_password'] ) ? $request['mqtt_pro_mqtt_password'] : '';
        $mqtt_pro_mqtt_topics = isset( $request['mqtt_pro_mqtt_topics'] ) ? $request['mqtt_pro_mqtt_topics'] : '';
        $mqtt_pro_mqtt_interval = isset( $request['mqtt_pro_mqtt_interval'] ) ? $request['mqtt_pro_mqtt_interval'] : '';
        $mqtt_pro_has_ttl = isset( $request['mqtt_pro_has_ttl'] ) ? $request['mqtt_pro_has_ttl'] : 'false';
        $mqtt_pro_mqtt_ttl = isset( $request['mqtt_pro_mqtt_ttl'] ) ? $request['mqtt_pro_mqtt_ttl'] : '';
        $mqtt_pro_active = isset( $request['mqtt_pro_active'] ) ?  $request['mqtt_pro_active'] : '';


        // Save option data into WordPress
        update_option( 'mqtt_pro_mqtt_url', $mqtt_pro_mqtt_url );
        update_option( 'mqtt_pro_mqtt_port', $mqtt_pro_mqtt_port );
        update_option( 'mqtt_pro_mqtt_client_id', $mqtt_pro_mqtt_client_id );
        update_option( 'mqtt_pro_requires_auth', $mqtt_pro_requires_auth);
        update_option( 'mqtt_pro_mqtt_user', $mqtt_pro_mqtt_user );
        update_option( 'mqtt_pro_mqtt_password', $mqtt_pro_mqtt_password );
        update_option( 'mqtt_pro_mqtt_topics', $mqtt_pro_mqtt_topics );
        update_option( 'mqtt_pro_mqtt_interval', $mqtt_pro_mqtt_interval );
        update_option( 'mqtt_pro_has_ttl', $mqtt_pro_has_ttl );
        update_option( 'mqtt_pro_mqtt_ttl', $mqtt_pro_mqtt_ttl );
        update_option( 'mqtt_pro_active', $mqtt_pro_active );


        $settingsData = [
            'mqtt_pro_mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
            'mqtt_pro_mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
            'mqtt_pro_mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
            'mqtt_pro_requires_auth' => get_option( 'mqtt_pro_requires_auth', "" ),
            'mqtt_pro_mqtt_user' => get_option( 'mqtt_pro_mqtt_user', "" ),
            'mqtt_pro_mqtt_password' => get_option( 'mqtt_pro_mqtt_password', "" ),
            'mqtt_pro_mqtt_topics' => get_option( 'mqtt_pro_mqtt_topics', "" ),
            'mqtt_pro_mqtt_interval' => get_option( 'mqtt_pro_mqtt_interval', "" ),
            'mqtt_pro_has_ttl' => get_option( 'mqtt_pro_has_ttl', false ),
            'mqtt_pro_mqtt_ttl' => get_option( 'mqtt_pro_mqtt_ttl', "" ),
            'mqtt_pro_active' => get_option( 'mqtt_pro_active', "false" ),
        ];

        $response = rest_ensure_response( $settingsData );
        return rest_ensure_response( $response );
    }


    public function get_settings_data( $request ) {
        $settingsData = [
            'mqtt_pro_mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
            'mqtt_pro_mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
            'mqtt_pro_mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
            'mqtt_pro_requires_auth' => get_option( 'mqtt_pro_requires_auth', "" ),
            'mqtt_pro_mqtt_user' => get_option( 'mqtt_pro_mqtt_user', "" ),
            'mqtt_pro_mqtt_password' => get_option( 'mqtt_pro_mqtt_password', "" ),
            'mqtt_pro_mqtt_topics' => get_option( 'mqtt_pro_mqtt_topics', "" ),
            'mqtt_pro_mqtt_interval' => get_option( 'mqtt_pro_mqtt_interval', "30" ),
            'mqtt_pro_has_ttl' => get_option( 'mqtt_pro_has_ttl', false ),
            'mqtt_pro_mqtt_ttl' => get_option( 'mqtt_pro_mqtt_ttl', "180" ),
            'mqtt_pro_active' => get_option( 'mqtt_pro_active', "false" ),
        ];
        $response = rest_ensure_response( $settingsData );
        return $response;
    }


    public function get_items_permissions_check( $request ) {

        return true;
    }

    public function set_settings_data_permission_check( $request ) {
        
        return true;
    }

    public function get_collection_params() {
        return [];
    }
}
