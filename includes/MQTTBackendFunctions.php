<?php

namespace App;
require_once( MQTTPLUGINPRO_INCLUDES.'/phpMQTT.php' );


class MQTTBackendFunctions {

    /**
     * [__construct description]
     */
    public function __construct() {
        $this->includes();
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->mqtt_subscribe();

    }

    /**
     * Include the controller classes
     *
     * @return void
     */
    private function includes() {
  
    }
    public function check_ready(){
       /* $active = get_option( 'mqtt_pro_active', "false" );
        if($active == "true") return true;
        else return false;*/
        return true;
    }



    private function mqtt_subscribe(){
        if($this->check_ready()){
            $settingsData = [
                'mqtt_url' => get_option( 'mqtt_pro_mqtt_url', "" ),
                'mqtt_port' => get_option( 'mqtt_pro_mqtt_port', "1883" ),
                'mqtt_client_id' => get_option( 'mqtt_pro_mqtt_client_id', "" ),
                'mqtt_user' => get_option( 'mqtt_pro_mqtt_user', null ),
                'mqtt_password' => get_option( 'mqtt_pro_mqtt_password', null ),
                'mqtt_topics' => get_option( 'mqtt_pro_mqtt_topics', "" ),
            ];
            //$mqtt = new phpMQTT( $settingsData['mqtt_url'], intval($settingsData['mqtt_port']), $settingsData['mqtt_client_id'] );
           if ($mqtt->connect()) {
                //Verbindung erfolgreich
                //Topic festlegen
                
                $test = $mqtt->subscribeAndWaitForMessage('ferries', 0);
                $this->procmsg('ferries',$test);
                //Verbindung schließen
                $mqtt->close();

            }else{
                trigger_error("Kann nicht durch 0 teilen", E_USER_ERROR);

                exit(1);
                //Hier fehler behandeln
            }
        }else return;
    }

    function procmsg($topic,$msg){
        $table_name = $this->wpdb->prefix . "mqtt_pro_data";
		echo "Msg Recieved: ".date("r")."\nTopic:{$topic}\n$msg\n";
        $sql = "INSERT INTO `".$table_name."` VALUES(null,'".$topic."','".$msg."',CURRENT_TIMESTAMP());";
        $this->wpdb->query($sql);
        trigger_error("Kann nicht durch 0 teilen", E_USER_ERROR);
    }


}
