<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 15/12/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_title'))
{
    function sv_vc_title($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'      => '',
            'des'      => '',
        ),$attr));
        $html .=    '<div class="box-intro">';
        if(!empty($title)) $html .=        '<h2><span class="title">'.$title.'</span></h2>';
        if(!empty($des)) $html .=        '<span class="desc-title">'.$des.'</span>';
        $html .=    '</div>';
        return $html;
    }
}

stp_reg_shortcode('sv_title','sv_vc_title');

vc_map( array(
    "name"      => esc_html__("SV Title", 'aloshop'),
    "base"      => "sv_title",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'aloshop'),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Description",'aloshop'),
            "param_name" => "des",
        )
    )
));