<?php
// Edited by Lena Scheit, Dennis Bölling

namespace App;

use WP_REST_Controller;

/**
 * Register the REST API Routes
 */
class Api extends WP_REST_Controller {
    public function __construct() {
        $this->includes();

        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }
    private function includes() {
        if ( !class_exists( __NAMESPACE__ . '\Api\SettingsPage'  ) ) {
            require_once __DIR__ . '/Api/SettingsPage.php';
        }
        if ( !class_exists( __NAMESPACE__ . '\Api\MQTTFunctions'  ) ) {
            require_once __DIR__ . '/Api/MQTTFunctions.php';
        }
    }
    public function register_routes() {
        (new Api\SettingsPage())->register_routes();
        (new Api\MQTTFunctions())->register_routes();
    }

}
