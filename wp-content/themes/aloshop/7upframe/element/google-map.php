<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_map'))
{
    function sv_vc_map($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         =>'',
            'market'        =>'',
            'zoom'          =>'16',
            'location'      =>'',
            'control'       =>'yes',
            'scrollwheel'   =>'yes',
            'disable_ui'    =>'no',
            'draggable'     =>'yes',
            'width'     =>'100%',
            'height'     =>'500px'
        ),$attr));
       wp_enqueue_script('google-map');
       wp_enqueue_script('sv-script-map');
        parse_str( urldecode( $location ), $locations);
        $location_text = '';
        foreach ($locations as $values) {
            $location_text .= '|';
            foreach ($values as $value) {
                $location_text .= $value.',';
            }
        }
        $img = array();$img[0]='';
        if($market != '') {
            $img = wp_get_attachment_image_src($market,"full");
        }
        $id = 'sv-map-'.uniqid();
        $map_css = 'width:'.$width.';height:'.$height.';max-width-100%;';
        $html .= '<div class="clearfix"></div><div id="'.esc_attr($id).'" class="sv-ggmaps '.SV_Assets::build_css($map_css).'" data-location="'.$location_text.'" data-market="'.$img[0].'" data-zoom="'.$zoom.'" data-style="'.$style.'" data-control="'.$control.'" data-scrollwheel="'.$scrollwheel.'" data-disable_ui="'.$disable_ui.'" data-draggable="'.$draggable.'"></div>';
        return $html;
    }
}

stp_reg_shortcode('sv_map','sv_vc_map');

vc_map( array(
    "name"      => esc_html__("SV GoogleMap", 'aloshop'),
    "base"      => "sv_map",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "holder" => "div",
            "heading" => esc_html__("Map Style",'aloshop'),
            "param_name" => "style",
            'value' => array(
                esc_html__('Default','aloshop') => '',
                esc_html__('Grayscale','aloshop') => 'grayscale',
                esc_html__('Blue','aloshop') => 'blue',
                esc_html__('Dark','aloshop') => 'dark',
                esc_html__('Pink','aloshop') => 'pink',
                esc_html__('Light','aloshop') => 'light',
                esc_html__('Blueessence','aloshop') => 'blueessence',
                esc_html__('Bentley','aloshop') => 'bentley',
                esc_html__('Retro','aloshop') => 'retro',
                esc_html__('Cobalt','aloshop') => 'cobalt',
                esc_html__('Brownie','aloshop') => 'brownie'
            ),
        ),
        array(
            "type" => "add_location_map",
            "heading" => esc_html__( "Add Map Location", 'aloshop' ),
            "param_name" => "location",
            "description" => esc_html__( "Click Add more button to add location.", 'aloshop' )
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__( "Map Zoom", 'aloshop' ),
            "param_name" => "zoom",
            "description" => esc_html__( "Enter zoom for map. Default is 16", 'aloshop' ),
        ),
        array(
            'type' => 'attach_image',
            "holder" => "div",
            'heading' => esc_html__( 'Marker Image', 'aloshop' ),
            'param_name' => 'market',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Map Width', 'aloshop' ),
            'param_name' => 'width',
            "description" => esc_html__( "This is value to set width for map. Unit % or px. Example: 100%,500px. Default is 100%", 'aloshop' )
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Map Height', 'aloshop' ),
            'param_name' => 'height',
            "description" => esc_html__( "This is value to set height for map. Unit % or px. Example: 100%,500px. Default is 500px", 'aloshop' )
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("MapTypeControl",'aloshop'),
            "param_name" => "control",
            'value' => array(
                esc_html__('Yes','aloshop') => 'yes',
                esc_html__('No','aloshop') => 'no',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Scrollwheel",'aloshop'),
            "param_name" => "scrollwheel",
            'value' => array(
                esc_html__('Yes','aloshop') => 'yes',
                esc_html__('No','aloshop') => 'no',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("DisableDefaultUI",'aloshop'),
            "param_name" => "disable_ui",
            'value' => array(
                esc_html__('No','aloshop') => 'no',
                esc_html__('Yes','aloshop') => 'yes',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Draggable",'aloshop'),
            "param_name" => "draggable",
            'value' => array(
                esc_html__('Yes','aloshop') => 'yes',
                esc_html__('No','aloshop') => 'no',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        )
    )
));