<?php
namespace App\Api;
use WP_REST_Controller;

/**
 * REST_API Handler
 */
class SettingsPage extends WP_REST_Controller {
    private $wpdb;

    /**
     * [__construct description]
     */
    public function __construct() {
        $this->namespace = 'myapp/v1';
        $this->rest_base = 'settings';
        global $wpdb;
        $this->wpdb = $wpdb;

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
                    'callback'            => [ $this, 'create_items' ],
                    'permission_callback' => [ $this, 'create_items_permission_check' ],
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

    public function create_items( $request ) {

        // Data validation
        $mqtt_url = isset( $request['mqtt_url'] ) ? sanitize_text_field( $request['mqtt_url'] ): '';
        $mqtt_port = isset( $request['mqtt_port'] ) ? sanitize_text_field( $request['mqtt_port'] ): '';
        $mqtt_client_id = isset( $request['mqtt_client_id'] ) ? sanitize_text_field( $request['mqtt_client_id'] ): '';
        $mqtt_user = isset( $request['mqtt_user'] ) ? sanitize_text_field( $request['mqtt_user'] ): '';
        $mqtt_password = isset( $request['mqtt_password'] ) ? sanitize_text_field( $request['mqtt_password'] ): '';
        $mqtt_topics = isset( $request['mqtt_topics'] ) ? sanitize_text_field( $request['mqtt_topics'] ): '';
        $mqtt_intervall = isset( $request['firstname'] ) ? sanitize_text_field( $request['firstname'] ): '';
        $mqtt_ttl = isset( $request['mqtt_ttl'] ) ? sanitize_text_field( $request['mqtt_ttl'] ): '';


        // Save option data into WordPress
        update_option( 'mqtt_pro_mqtt_url', $mqtt_url );
        update_option( 'mqtt_pro_mqtt_port', $mqtt_port );
        update_option( 'mqtt_pro_mqtt_client_id', $mqtt_client_id );
        update_option( 'mqtt_pro_mqtt_user', $mqtt_user );
        update_option( 'mqtt_pro_mqtt_password', $mqtt_password );
        update_option( 'mqtt_pro_mqtt_topics', $mqtt_topics );
        update_option( 'mqtt_pro_mqtt_intervall', $mqtt_intervall );
        update_option( 'mqtt_pro_mqtt_ttl', $mqtt_ttl );


        $settingsData = [
            'mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
            'mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
            'mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
            'mqtt_user' => get_option( 'mqtt_pro_mqtt_user', "" ),
            'mqtt_password' => get_option( 'mqtt_pro_mqtt_password', "" ),
            'mqtt_topics' => get_option( 'mqtt_pro_mqtt_topics', "" ),
            'mqtt_intervall' => get_option( 'mqtt_pro_mqtt_intervall', "30" ),
            'mqtt_ttl' => get_option( 'mqtt_pro_mqtt_ttl', "180" ),

        ];

        $response = rest_ensure_response( $settingsData );

        return rest_ensure_response( $response );
        
    }


    public function get_settings_data( $request ) {
        $settingsData = [
            'mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
            'mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
            'mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
            'mqtt_user' => get_option( 'mqtt_pro_mqtt_user', "" ),
            'mqtt_password' => get_option( 'mqtt_pro_mqtt_password', "" ),
            'mqtt_topics' => get_option( 'mqtt_pro_mqtt_topics', "" ),
            'mqtt_intervall' => get_option( 'mqtt_pro_mqtt_intervall', "30" ),
            'mqtt_ttl' => get_option( 'mqtt_pro_mqtt_ttl', "180" ),

        ];

        $response = rest_ensure_response( $settingsData );

        return $response;
    }


    public function get_items_permissions_check( $request ) {
        return true;
    }

    public function create_items_permission_check( $request ) {
        return true;
    }

    public function get_collection_params() {
        return [];
    }
}
