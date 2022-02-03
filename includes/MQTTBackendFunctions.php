<?php
// Edited by Lena Scheit, Dennis Bölling

namespace App;
require_once( MQTTPLUGINPRO_INCLUDES.'/phpMQTT.php' );

class MQTTBackendFunctions {

    public function __construct() {
        $this->includes();
        global $wpdb;
        $this->wpdb = $wpdb;
        //$this->mqtt_subscribe();

    }

    private function includes() {
  
    }
    public function check_ready(){
        return true;
    }

    public function mqtt_subscribe($topic){
        $table_name = $this->wpdb->prefix . "mqtt_pro_data";
        if($this->check_ready()){
            $settingsData = [
                'mqtt_pro_mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
                'mqtt_pro_mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
                'mqtt_pro_mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
                'mqtt_pro_requires_auth' => get_option( 'mqtt_pro_requires_auth', false ),
                'mqtt_pro_mqtt_user' => get_option( 'mqtt_pro_mqtt_user', null ),
                'mqtt_pro_mqtt_password' => get_option( 'mqtt_pro_mqtt_password', null ),
                'mqtt_pro_mqtt_topics' => get_option( 'mqtt_pro_mqtt_topics', "" ),
            ];
            if($settingsData['mqtt_pro_mqtt_url'] != "" && $settingsData['mqtt_pro_mqtt_port'] != "" ){
                write_log( $settingsData['mqtt_pro_requires_auth'] );
                try{
                    $mqtt = new phpMQTT( $settingsData['mqtt_pro_mqtt_url'], intval($settingsData['mqtt_pro_mqtt_port']), $settingsData['mqtt_pro_mqtt_client_id'] );
                    if($settingsData['mqtt_pro_requires_auth'] === "true" || $settingsData['mqtt_pro_requires_auth'] === true ){
                        if(!$settingsData['mqtt_pro_mqtt_user'] || $settingsData['mqtt_pro_requires_auth']) return;
                        if ($mqtt->connect(true,NULL,$settingsData['mqtt_pro_mqtt_user'],$settingsData['mqtt_pro_requires_auth'])) {
                            //Verbindung erfolgreich
                            //Topic festlegen
                            $test = $mqtt->subscribeAndWaitForMessage($topic, 0);
                            $this->insertValue($topic,$test);
                            //Verbindung schließen
                            $mqtt->close();
            
                        }else{
                            exit(1);
                            //Connection or subscribe error
                        }
                    }else{
                        if ($mqtt->connect()) {
                            $test = $mqtt->subscribeAndWaitForMessage($topic, 0);
                            $this->insertValue($topic,$test);
                            $mqtt->close();
            
                        }else{            
                            exit(1);
                            //Connection or subscribe error
                        }
                    }
                    
                }catch(Exeption $e){
            write_log( $e );
                }
            }else{
                exit(1);
            }
        }else return;
    }

    function insertValue($topic,$msg){
        $table_name = $this->wpdb->prefix . "mqtt_pro_data";
        $sql = "INSERT INTO `".$table_name."` VALUES(null,'".$topic."','".$msg."',CURRENT_TIMESTAMP());";
        $this->wpdb->query($sql);
    }


}
