<?php
namespace App;

/**
 * Admin Pages Handler
 */
class Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register our menu page
     *
     * @return void
     */
    public function admin_menu() {
        global $submenu;

        $capability = 'manage_options';
        $slug       = 'mqtt-plugin-pro';

        $hook = add_menu_page( __( 'MQTT PRO', 'textdomain' ), __( 'MQTT PRO', 'textdomain' ), $capability, $slug, [ $this, 'plugin_page' ], 'dashicons-text' );

        if ( current_user_can( $capability ) ) {
            $submenu[ $slug ][] = array( __( 'App', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/' );
            $submenu[ $slug ][] = array( __( 'Settings', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/settings' );
            $submenu[ $slug ][] = array( __( 'Setup', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/setup' );
            $submenu[ $slug ][] = array( __( 'About', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/about' );
            $submenu[ $slug ][] = array( __( 'API Doc', 'textdomain' ), $capability, 'admin.php?page=' . $slug . '#/api-docs' );

        }

        add_action( 'load-' . $hook, [ $this, 'init_hooks'] );
    }

    /**
     * Initialize our hooks for the admin page
     *
     * @return void
     */
    public function init_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'mqttpluginpro-admin' );
        wp_enqueue_script( 'mqttpluginpro-admin' );
    }

    /**
     * Render our admin page
     *
     * @return void
     */
    public function plugin_page() {
        $url = get_site_url();
        $vue_atts = esc_attr( json_encode( [
            'site_url' => $url
        ] ) );
        $content = '';
        $content .= "<div class='wrap' data-pk-atts='{$vue_atts}' ><div id='vue-admin-app' ></div></div>";
        echo $content;
    }
}
