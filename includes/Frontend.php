<?php
namespace App;

/**
 * Frontend Pages Handler
 */
class Frontend {

    public function __construct() {
        add_shortcode( 'mqtt-pro', [ $this, 'render_frontend' ] );
    }

    /**
     * Render frontend app
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_frontend( $atts, $content = '' ) {
      $topic =  $atts['topic'];
        if(isset($atts['type'])){
            $type = $atts['type'];
        }else $type = 'simple';
        if(isset($atts['icon'])){
            $icon = $atts['icon'];
        }else $icon = 'poo';
        if(isset($atts['format'])){
            $format = $atts['format'];
        }else $format = null;
        if(isset($atts['suffix'])){
            $suffix = $atts['forsuffixmat'];
        }else $suffix = "";
     $id = uniqid();
        $url = get_site_url();
        $vue_atts = esc_attr( json_encode( [
            'type' => $type, 
            'icon' => $icon,
            'topic' => $topic,
            'format' => $format,
            'suffix' => $suffix,
            'id' => $id,
            'site_url' => $url
        ] ) );
        wp_enqueue_style( 'mqttpluginpro-frontend' );
        wp_enqueue_script( 'mqttpluginpro-frontend' );

        $content .= "<div class='mqtt-pro-whopper-$id' data-pk-atts='{$vue_atts}'><div id='vue-frontend-app-$id'><div class='123'></div></div></div>";

        return $content;
    }
}
