<?php
// Edited by Lena Scheit, Dennis Bölling

namespace App\Api;
require_once( MQTTPLUGINPRO_INCLUDES.'/phpMQTT.php' );
use WP_REST_Controller;

/**
 * REST_API Handler for MQTT Functions
 */    


class MQTTFunctions extends WP_REST_Controller {
    public function __construct() {
        $this->namespace = 'mqtt-plugin-pro/v1';
        $this->rest_base = 'mqtt-functions';
        global $wpdb;
        $this->wpdb = $wpdb;
    }
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/test-connection',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'check_connection' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
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
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/get/timestamp',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_timestamp' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
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
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/get/all',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_all_mqtt_values' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                ]
            ]
        );
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base .'/delete/(?P<id>\d+)',
            [
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'delete_mqtt_value' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
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
    public function get_all_mqtt_values( $request ){
        $sql = "SELECT * FROM wp_mqtt_pro_data ORDER BY RecordCreated DESC";
        $res = $this->wpdb->get_results($sql,ARRAY_A);
        $respObj = [
            'res'=>$res
        ];
        $response = rest_ensure_response(  $res  );

        return $response;
    }

    public function get_timestamp( $request ){
        $sql = "SELECT NOW() AS Date";
        $res = $this->wpdb->get_row($sql);
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


    public function delete_mqtt_value( $request ){
        $id = $request['id'];
        $sql = "DELETE FROM wp_mqtt_pro_data WHERE ID =".$id."";
        $res = $this->wpdb->query($sql);
        $respObj = [
            'res'=>'ok'
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
            'mqtt_pro_mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
            'mqtt_pro_mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
            'mqtt_pro_mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
            'mqtt_pro_mqtt_user' => get_option( 'mqtt_pro_mqtt_user', null ),
            'mqtt_pro_mqtt_password' => get_option( 'mqtt_pro_mqtt_password', null ),
        ];
            $mqtt = new \APP\phpMQTT( $settingsData['mqtt_pro_mqtt_url'], intval($settingsData['mqtt_pro_mqtt_port']), $settingsData['mqtt_pro_mqtt_client_id'] );
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
        $settingsData = [
            'mqtt_pro_mqtt_url' => $request['mqtt_pro_mqtt_url'],
            'mqtt_pro_mqtt_port' => $request['mqtt_pro_mqtt_port'],
            'mqtt_pro_mqtt_client_id' =>  $request['mqtt_pro_mqtt_client_id'],
            'mqtt_pro_mqtt_user' => $request['mqtt_pro_mqtt_user'],
            'mqtt_pro_mqtt_password' => $request['mqtt_pro_mqtt_password'],
            'mqtt_pro_requires_auth' => $request['mqtt_pro_requires_auth'],

        ];
        $conncected = false;
            try{
                //INIT MQTT Instance
                $mqtt = new \APP\phpMQTT( $settingsData['mqtt_pro_mqtt_url'], intval($settingsData['mqtt_pro_mqtt_port']), $settingsData['mqtt_pro_mqtt_client_id'] );
                if($settingsData['mqtt_pro_requires_auth'] == 'true'){
                    //Auth login
                    if(!$settingsData['mqtt_pro_mqtt_user'] && $settingsData['mqtt_pro_requires_auth'] == 'true'){
                        if ($mqtt->connect(true,NULL,$settingsData['mqtt_pro_mqtt_user'],$settingsData['mqtt_pro_mqtt_password'])) {
                            $mqtt->close();
                            $conncected =true;
                        }else{
                            //Connection failed
                        }
                    }
                }else{
                    //No Auth
                    if ($mqtt->connect()) {
                        $mqtt->close();
                        $conncected =true;
                    }else{
                           //Connection failed
                    }
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

  
}
