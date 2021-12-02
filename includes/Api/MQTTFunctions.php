<?php
namespace App\Api;
require_once( 'phpMQTT.php' );
use WP_REST_Controller;

/**
 * REST_API Handler
 */

class MQTTFunctions extends WP_REST_Controller {

    /**
     * [__construct description]
     */
    public function __construct() {
        $this->namespace = 'myapp/v1';
        $this->rest_base = 'mqtt-functions';
    }

    /**
     * Register the routes
     *
     * @return void
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/test-connection',
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

    public function check_connection( $request ) {
        $conncected = null;
        $settingsData = [
            'mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
            'mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
            'mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
            'mqtt_user' => get_option( 'mqtt_pro_mqtt_user', null ),
            'mqtt_password' => get_option( 'mqtt_pro_mqtt_password', null ),
        ];
            $mqtt = new phpMQTT( $settingsData['mqtt_url'], intval($settingsData['mqtt_port']), $settingsData['mqtt_client_id'] );
            if ($mqtt->connect()) {
                $mqtt->close();
                $conncected = true;

            }else{
                $conncected = false;
            }
        
        $respObj = [
            'connected' => $conncected
        ];
        $response = rest_ensure_response( $respObj );

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
