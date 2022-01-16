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
        //$this->mqtt_subscribe();

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



    public function mqtt_subscribe($topic){
        $table_name = $this->wpdb->prefix . "mqtt_pro_data";
        write_log( "Starting subscribe" );

        if($this->check_ready()){
            write_log( "Starting subscribe 2" );

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
                write_log( "Starting subscribe 3" );
                write_log( $settingsData['mqtt_pro_requires_auth'] );
                
                try{
                    $mqtt = new phpMQTT( $settingsData['mqtt_pro_mqtt_url'], intval($settingsData['mqtt_pro_mqtt_port']), $settingsData['mqtt_pro_mqtt_client_id'] );
                    write_log( "Starting subscribe 4" );

                    if($settingsData['mqtt_pro_requires_auth'] === "true" || $settingsData['mqtt_pro_requires_auth'] === true ){
                        write_log( "Starting subscribe Auth" );

                        if(!$settingsData['mqtt_pro_mqtt_user'] || $settingsData['mqtt_pro_requires_auth']) return;
                        if ($mqtt->connect(true,NULL,$settingsData['mqtt_pro_mqtt_user'],$settingsData['mqtt_pro_requires_auth'])) {
                            //Verbindung erfolgreich
                            //Topic festlegen
                            $test = $mqtt->subscribeAndWaitForMessage($topic, 0);
                            $this->procmsg($topic,$test);
                            //Verbindung schließen
                            $mqtt->close();
            
                        }else{
                            trigger_error("Kann nicht durch 0 teilen", E_USER_ERROR);
            
                            exit(1);
                            //Hier fehler behandeln
                        }
                    }else{
                        write_log( "Connection to MQTT..." );
                        if ($mqtt->connect()) {
                            //Verbindung erfolgreich
                            //Topic festlegen
                            write_log( "Connected" );
                            $test = $mqtt->subscribeAndWaitForMessage($topic, 0);
                            write_log( "Topic there" );

                            $this->procmsg($topic,$test);
                            //Verbindung schließen
                            $mqtt->close();
            
                        }else{
                            trigger_error("Kann nicht durch 0 teilen", E_USER_ERROR);
            
                            exit(1);
                            //Hier fehler behandeln
                        }
                    }
                    
                }catch(Exeption $e){
            write_log( $e );
            write_log( "Error .. above" );
                }
            }else{
                exit(1);
            }
        }else return;
    }

    function procmsg($topic,$msg){
        $table_name = $this->wpdb->prefix . "mqtt_pro_data";
		echo "Msg Recieved: ".date("r")."\nTopic:{$topic}\n$msg\n";
        $sql = "INSERT INTO `".$table_name."` VALUES(null,'".$topic."','".$msg."',CURRENT_TIMESTAMP());";
        $this->wpdb->query($sql);
    }


}
