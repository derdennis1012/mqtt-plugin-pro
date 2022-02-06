<?php
// Edited by Lena Scheit, Dennis Bölling

namespace App;

//Register the generated JS & CSS scripts from VueJS
class Assets {

    function __construct() {
        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'register' ], 5 );
        } else {
            add_action( 'wp_enqueue_scripts', [ $this, 'register' ], 5 );
        }
    }

    public function register() {
        $this->register_scripts( $this->get_scripts() );
        $this->register_styles( $this->get_styles() );
    }

    private function register_scripts( $scripts ) {
        foreach ( $scripts as $handle => $script ) {
            $deps      = isset( $script['deps'] ) ? $script['deps'] : false;
            $in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
            $version   = isset( $script['version'] ) ? $script['version'] : mqtt_pro_version;

            wp_register_script( $handle, $script['src'], $deps, $version, $in_footer );
        }
    }

    public function register_styles( $styles ) {
        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, mqtt_pro_version );
        }
    }

    public function get_scripts() {
        $prefix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.min' : '';

        $scripts = [
            'mqttpluginpro-runtime' => [
                'src'       => MQTTPLUGINPRO_ASSETS . '/js/runtime.js',
                'version'   => filemtime( MQTTPLUGINPRO_PATH . '/assets/js/runtime.js' ),
                'in_footer' => true
            ],
            'mqttpluginpro-vendor' => [
                'src'       => MQTTPLUGINPRO_ASSETS . '/js/vendors.js',
                'version'   => filemtime( MQTTPLUGINPRO_PATH . '/assets/js/vendors.js' ),
                'in_footer' => true
            ],
            'mqttpluginpro-frontend' => [
                'src'       => MQTTPLUGINPRO_ASSETS . '/js/frontend.js',
                'deps'      => [ 'jquery', 'mqttpluginpro-vendor', 'mqttpluginpro-runtime' ],
                'version'   => filemtime( MQTTPLUGINPRO_PATH . '/assets/js/frontend.js' ),
                'in_footer' => true
            ],
            'mqttpluginpro-admin' => [
                'src'       => MQTTPLUGINPRO_ASSETS . '/js/admin.js',
                'deps'      => [ 'jquery', 'mqttpluginpro-vendor', 'mqttpluginpro-runtime' ],
                'version'   => filemtime( MQTTPLUGINPRO_PATH . '/assets/js/admin.js' ),
                'in_footer' => true
            ]
        ];

        return $scripts;
    }

    public function get_styles() {

        $styles = [
            'mqttpluginpro-style' => [
                'src' =>  MQTTPLUGINPRO_ASSETS . '/css/style.css'
            ],
            'mqttpluginpro-frontend' => [
                'src' =>  MQTTPLUGINPRO_ASSETS . '/css/frontend.css'
            ],
            'mqttpluginpro-admin' => [
                'src' =>  MQTTPLUGINPRO_ASSETS . '/css/admin.css'
            ],
        ];

        return $styles;
    }

}
