<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 5/09/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_testimonial_slider'))
{
    function sv_vc_testimonial_slider($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'      => '',
            'link'       => '',
            'nav'        => '',
        ),$attr));
        wp_enqueue_script('bxslider');
        $html .=    '<div class="box-bottom-home2 box-testimo">
                        <h2>'.$title.'</h2>
                        <div class="testimo-slider slider-home2 '.$nav.'">
                            <div class="wrap-item">
                                '.wpb_js_remove_wpautop($content, false).'
                            </div>
                        </div>';
        if(!empty($link)) $html .=  '<a href="'.esc_url($link).'" class="viewall">'.esc_html__("View All","aloshop").'</a>';
        $html .=    '</div>';
        
        return $html;
    }
}

stp_reg_shortcode('sv_testimonial_slider','sv_vc_testimonial_slider');

vc_map( array(
    "name"      => esc_html__("SV Testimonial Slider", 'aloshop'),
    "base"      => "sv_testimonial_slider",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    'as_parent' => array( 'only' => 'sv_testimonial_item' ),
    'js_view' => 'VcColumnView',
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
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Navigation",'aloshop'),
            "param_name" => "nav",
            "value"     => array(
                esc_html__("Circle",'aloshop')      => '',
                esc_html__("Square",'aloshop')      => 'rect-arrow',
                )
        )
    )
));

if(!function_exists('sv_vc_testimonial_item'))
{
    function sv_vc_testimonial_item($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'name'       => '',
            'image'      => '',
            'pos'        => '',
            'des'        => '',
            'link'       => '',
        ),$attr));
        $html .=    '<div class="item-testimo">
                        <div class="author-testimo">
                            <div class="author-test-link">
                                <a href="'.esc_url($link).'">'.wp_get_attachment_image($image).'</a>
                            </div>
                            <div class="author-test-info">
                                <h3><a href="'.esc_url($link).'">'.$name.'</a></h3>
                                <span>'.$pos.'</span>
                            </div>
                        </div>
                        <p class="desc">'.$des.'</p>
                    </div>';
        
        return $html;
    }
}

stp_reg_shortcode('sv_testimonial_item','sv_vc_testimonial_item');

vc_map( array(
    "name"      => esc_html__("SV Testimonial Item", 'aloshop'),
    "base"      => "sv_testimonial_item",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    'as_child' => array('only' => 'sv_testimonial_slider'),
    'content_element' => true,
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Name",'aloshop'),
            "param_name" => "name",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Position",'aloshop'),
            "param_name" => "pos",
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Avatar",'aloshop'),
            "param_name" => "image",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description",'aloshop'),
            "param_name" => "des",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link",'aloshop'),
            "param_name" => "link",
        )
    )
));

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Sv_Testimonial_Slider extends WPBakeryShortCodesContainer {}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Sv_Testimonial_Item extends WPBakeryShortCode {}
}