<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_service'))
{
    function s7upf_vc_service($attr,$content = false)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'type'        => 'fontawesome',
            'icon_fontawesome'        => 'fa fa-adjust',
            'icon_openiconic'        => 'vc-oi vc-oi-dial',
            'icon_typicons'        => 'typcn typcn-adjust-brightness',
            'icon_entypo'        => 'entypo-icon entypo-icon-note',
            'icon_linecons'        => 'vc_li vc_li-heart',
            'title'       => '',
            'des'       => '',
            'link'        => '',
        ),$attr));        
        $iconClass = isset( ${'icon_' . $type} ) ? esc_attr( ${'icon_' . $type} ) : 'fa fa-adjust';
        $icon_html = '<span class="vc_icon_element-icon '.esc_attr($iconClass).'"></span>';
        $html .=    '<div class="item-service_fe table border">
                        <div class="service-icon"><a href="'.esc_url($link).'">'.$icon_html.'</a></div>
                        <div class="service-info text-uppercase">
                            <p><a href="'.esc_url($link).'">'.esc_html($title).'</a></p>
                        </div>
                    </div>';
        
        return $html;
    }
}

stp_reg_shortcode('s7upf_service','s7upf_vc_service');

vc_map( array(
    "name"      => esc_html__("SV Service icon", 'aloshop'),
    "base"      => "s7upf_service",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array_merge(s7upf_get_icon_params(),array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'aloshop'),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description",'aloshop'),
            "param_name" => "des",
            "dependency"    => array(
                "element"   => "style",
                "value"     => "image",
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link",'aloshop'),
            "param_name" => "link",
        ),
    ))
));