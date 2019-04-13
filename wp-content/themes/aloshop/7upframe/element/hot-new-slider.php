<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 5/09/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_hot_new_slider'))
{
    function sv_vc_hot_new_slider($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'      => '',
        ),$attr));
        wp_enqueue_script('bxslider');
        $html .=    '<div class="hotnews-ticker-slider">
                        <label>'.$title.'</label>
                        <ul class="bxslider-ticker">
                            '.wpb_js_remove_wpautop($content, false).'
                        </ul>
                    </div>';
        
        return $html;
    }
}

stp_reg_shortcode('sv_hot_new_slider','sv_vc_hot_new_slider');

vc_map( array(
    "name"      => esc_html__("SV Hot New Slider", 'aloshop'),
    "base"      => "sv_hot_new_slider",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    'as_parent' => array( 'only' => 'sv_hot_new_item' ),
    'js_view' => 'VcColumnView',
    'content_element' => true,
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'aloshop'),
            "param_name" => "title",
        )
    )
));

if(!function_exists('sv_vc_hot_new_item'))
{
    function sv_vc_hot_new_item($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'      => '',
            'link'       => '',
        ),$attr));
        $html .=    '<li><a href="'.esc_url($link).'">'.$title.'</a></li>';
        
        return $html;
    }
}

stp_reg_shortcode('sv_hot_new_item','sv_vc_hot_new_item');

vc_map( array(
    "name"      => esc_html__("SV Hot New Item", 'aloshop'),
    "base"      => "sv_hot_new_item",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    'as_child' => array('only' => 'sv_hot_new_slider'),
    'content_element' => true,
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'aloshop'),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link",'aloshop'),
            "param_name" => "link",
        )
    )
));

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Sv_Hot_New_Slider extends WPBakeryShortCodesContainer {}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Sv_Hot_New_Item extends WPBakeryShortCode {}
}