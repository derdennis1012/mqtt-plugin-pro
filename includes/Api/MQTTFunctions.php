<?php
namespace App\Api;
require_once( MQTTPLUGINPRO_INCLUDES.'/phpMQTT.php' );
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
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/test-connection-without',
            [
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'check_connection_without' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/get',
            [
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'get_mqtt_values' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/get-latest',
            [
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'get_mqtt_value_latest' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/get-avg',
            [
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'get_mqtt_value_avg' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'                => $this->get_collection_params(),
                ]
            ]
        );
    }

    public function get_mqtt_values( $request ){
        $topic = $request['topic'];
        $sql = "SELECT * FROM wp_mqtt_pro_data WHERE topic = '".$topic."' ORDER BY RecordCreated DESC";
        $res = $this->wpdb->get_results($sql,ARRAY_A);
        $respObj = [
            'res'=>$res
        ];
        $response = rest_ensure_response(  $res  );

        return $response;
    }

    public function get_mqtt_value_latest( $request ){
        $topic = $request['topic'];
        $sql = "SELECT * FROM wp_mqtt_pro_data WHERE topic = '".$topic."' ORDER BY RecordCreated DESC";
        $res = $this->wpdb->get_results($sql,ARRAY_A);
        $respObj = [
            'res'=>$res[0]
        ];
        $response = rest_ensure_response( $respObj  );

        return $response;
    }
    public function get_mqtt_value_avg( $request ){
        $topic = $request['topic'];
        $sql = "SELECT AVG(CAST(DataSet AS DECIMAL(10,2) )) AS AVG FROM wordpress.wp_mqtt_pro_data WHERE topic = '".$topic."' ORDER BY RecordCreated DESC";
        $res = $this->wpdb->get_results($sql,ARRAY_A);
        $respObj = [
            'res'=>$res
        ];
        $response = rest_ensure_response(  $res  );

        return $response;
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
            $mqtt = new \APP\phpMQTT( $settingsData['mqtt_url'], intval($settingsData['mqtt_port']), $settingsData['mqtt_client_id'] );
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
    public function check_connection_without( $request ) {
        $conncected = null;
        $settingsData = [
            'mqtt_url' => $request['mqtt_pro_mqtt_url'],
            'mqtt_port' => $request['mqtt_pro_mqtt_port'],
            'mqtt_client_id' =>  $request['mqtt_pro_mqtt_client_id'],
            'mqtt_user' => $request['mqtt_pro_mqtt_user'],
            'mqtt_password' => $request['mqtt_pro_mqtt_password'],
            'is_secured' => $request['mqtt_pro_mqtt_is_secured']

        ];
            try{
                $mqtt = new \APP\phpMQTT( $settingsData['mqtt_url'], intval($settingsData['mqtt_port']), $settingsData['mqtt_client_id'] );
            if ($mqtt->connect()) {
                $mqtt->close();
                $conncected = true;

            }else{
                $conncected = false;
            }
        }catch(Exeption $e){

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
