<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 31/08/15
 * Time: 10:00 AM
 */
/************************************Main Carousel*************************************/
if(!function_exists('sv_vc_slide_revslider'))
{
    function sv_vc_slide_revslider($attr, $content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(

        ),$attr));
        wp_enqueue_script('themepunch-revolution');
        wp_enqueue_script('themepunch-plugins');
        $html .=    '<div class="banner-slider">
                        <div class="rev-slider">
                            <ul>';
        $html .=                wpb_js_remove_wpautop($content, false);
        $html .=            '</ul>
                        </div>';
        $html .=    '</div>';
        return $html;
    }
}
stp_reg_shortcode('sv_slide_revslider','sv_vc_slide_revslider');
vc_map(
    array(
        'name'              => esc_html__( 'Rev Slider', 'aloshop' ),
        'base'              => 'sv_slide_revslider',
        'category'          => esc_html__( '7Up-theme', 'aloshop' ),
        'icon'              => 'icon-st',
        'as_parent'         => array( 'only' => 'vc_column_text,sv_rev_item' ),
        'content_element'   => false,
        'js_view'           => 'VcColumnView',
        'params'            => array(

        )
    )
);

/*******************************************END MAIN*****************************************/

/************************************ITEM CONTENT*************************************/

if(!function_exists('sv_vc_rev_item'))
{
    function sv_vc_rev_item($attr, $content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'image'         => '',
            'transition'    => '',
        ),$attr));
        if(!empty($image)){
            $html .=    '<li class="slide" data-transition="'.$transition.'">';
            $html .=        wp_get_attachment_image($image,'full');
            $html .=        wpb_js_remove_wpautop($content, false);
            $html .=    '</li>';
        }
        return $html;
    }
}
stp_reg_shortcode('sv_rev_item','sv_vc_rev_item');
vc_map(
    array(
        "name"              => esc_html__("Rev Item", "aloshop"),
        "base"              => "sv_rev_item",
        "content_element"   => true,
        "as_parent"         => array('only' => 'sv_rev_item_content'),
        "as_child"          => array('only' => 'sv_slide_revslider'),
        "icon"              => "icon-st",
        "category"          => esc_html__( '7Up-theme', 'aloshop' ),
        "params"            => array(
            array(
                "type"          => "attach_image",
                "heading"       => esc_html__("Image",'aloshop'),
                "param_name"    => "image",
            ),
            array(
                "type"          => "dropdown",
                "heading"       => esc_html__("Transition",'aloshop'),
                "param_name"    => "transition",
                "value"         => array(
                    esc_html__("None",'aloshop')                           => '',
                    esc_html__("Slide To Top",'aloshop')                   => 'slideup',
                    esc_html__("Slide To Bottom",'aloshop')                => 'slidedown',
                    esc_html__("Slide To Right",'aloshop')                 => 'slideright',
                    esc_html__("Slide To Left",'aloshop')                  => 'slideleft',
                    esc_html__("Slide Horizonta",'aloshop')                => 'slidehorizontal',
                    esc_html__("Slide Vertical",'aloshop')                 => 'slidevertical',
                    esc_html__("Slide Boxes",'aloshop')                    => 'boxslide',
                    esc_html__("Slide Slots Horizontal",'aloshop')         => 'slotslide-horizontal',
                    esc_html__("Slide Slots Vertical",'aloshop')           => 'slotslide-vertical',
                    esc_html__("Fade Boxes",'aloshop')                     => 'boxfade',
                    esc_html__("Fade Slots Horizontal",'aloshop')          => 'slotfade-horizontal',
                    esc_html__("Fade Slots Vertical",'aloshop')            => 'slotfade-vertical',
                    esc_html__("Fade and Slide from Right",'aloshop')      => 'fadefromright',
                    esc_html__("Fade and Slide from Left",'aloshop')       => 'fadefromleft',
                    esc_html__("Fade and Slide from Top",'aloshop')        => 'fadefromtop',
                    esc_html__("Fade and Slide from Bottom",'aloshop')     => 'fadefrombottom',
                    esc_html__("Fade To Left and Fade From Right",'aloshop')   => 'fadetoleftfadefromright',
                    esc_html__("Fade To Right and Fade From Left",'aloshop')   => 'fadetorightfadefromleft',
                    esc_html__("Fade To Top and Fade From Bottom",'aloshop')   => 'fadetotopfadefrombottom',
                    esc_html__("Fade To Bottom and Fade From Top",'aloshop')   => 'fadetobottomfadefromtop',
                    esc_html__("Parallax to Right",'aloshop')                  => 'parallaxtoright',
                    esc_html__("Parallax to Left",'aloshop')               => 'parallaxtoleft',
                    esc_html__("Parallax to Top",'aloshop')                => 'parallaxtotop',
                    esc_html__("Parallax to Bottom",'aloshop')             => 'parallaxtobottom',
                    esc_html__("Zoom Out and Fade From Right",'aloshop')   => 'scaledownfromright',
                    esc_html__("Zoom Out and Fade From Left",'aloshop')    => 'scaledownfromleft',
                    esc_html__("Zoom Out and Fade From Top",'aloshop')     => 'scaledownfromtop',
                    esc_html__("Zoom Out and Fade From Bottom",'aloshop')  => 'scaledownfrombottom',
                    esc_html__("ZoomOut",'aloshop')                        => 'zoomout',
                    esc_html__("ZoomIn",'aloshop')                         => 'zoomin',
                    esc_html__("Zoom Slots Horizontal",'aloshop')          => 'slotzoom-horizontal',
                    esc_html__("Zoom Slots Vertical",'aloshop')            => 'slotzoom-vertical',
                    esc_html__("Fade",'aloshop')                           => 'fade',
                    esc_html__("Random Flat",'aloshop')                    => 'random-static',
                    esc_html__("Random Flat and Premium",'aloshop')        => 'random',
                    )
            )
        ),
        "js_view" => 'VcColumnView'
    )
);
/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_rev_item_content'))
{
    function sv_vc_rev_item_content($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'data_x'        => '',
            'data_y'        => '',
            'start'         => '',
            'speed'         => '',
            'end_speed'     => '',
        ),$attr));
        switch ($data_y) {
            case 'bottom':
                $el_after = 'b';
                break;

            case 'top':
                $el_after = 't';
                break;
            
            default:
                $el_after = 'l';
                break;
        }
        $html .=    '<div class="tp-caption lf'.$el_after.'" data-x="'.$data_x.'" data-y="'.$data_y.'" data-start="'.$start.'" data-speed="'.$speed.'" data-easing="easeInOutQuint" data-endspeed="'.$end_speed.'">'.wpb_js_remove_wpautop($content, false).'</div>';
        return $html;
    }
}
stp_reg_shortcode('sv_rev_item_content','sv_vc_rev_item_content');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Content Item', 'aloshop' ),
        'base'     => 'sv_rev_item_content',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'sv_rev_item'),
        'params'   => array(            
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Data X', 'aloshop' ),
                'param_name'  => 'data_x',
                'description' => esc_html__( 'Set X position: left, right or number.', 'aloshop' ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Data Y', 'aloshop' ),
                'param_name'  => 'data_y',
                'description' => esc_html__( 'Set Y position: top, bottom or number.', 'aloshop' ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Time start', 'aloshop' ),
                'param_name'  => 'start',
                'description' => esc_html__( 'Enter number. Unit(ms)', 'aloshop' ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Speed', 'aloshop' ),
                'param_name'  => 'speed',
                'description' => esc_html__( 'Enter number. Unit(ms)', 'aloshop' ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Speed end', 'aloshop' ),
                'param_name'  => 'end_speed',
                'description' => esc_html__( 'Enter number. Unit(ms)', 'aloshop' ),
            ),
            array(
                'type'        => 'textarea_html',
                // 'holder'      => 'div',
                'heading'     => esc_html__( 'Content', 'aloshop' ),
                'param_name'  => 'content',
            )
        )
    )
);

/**************************************END ITEM************************************/



//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Sv_Slide_Revslider extends WPBakeryShortCodesContainer {}
    class WPBakeryShortCode_Sv_Rev_Item extends WPBakeryShortCodesContainer {}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Sv_Rev_Item_Content extends WPBakeryShortCode {}
}