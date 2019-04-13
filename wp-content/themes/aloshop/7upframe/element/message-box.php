<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 9/1/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_message_box'))
{
    function sv_vc_message_box($attr, $content = false)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'style'     => 'item-message-info',
            'icon'      => '',
            'message'   => '',
        ),$attr));
        if(!empty($icon)){
            if(strpos($icon,'lnr') !== false) $icon_html = '<span class="lnr '.$icon.'"></span>';
            else $icon_html =   '<i class="fa '.$icon.'"></i>';
        }
        $html .=    '<div class="item-message-box '.$style.'">
                        <p>'.$icon_html.' '.$message.'</p>
                    </div>';
        return $html;
    }
}

stp_reg_shortcode('sv_message_box','sv_vc_message_box');

vc_map( array(
    "name"      => esc_html__("SV Message Box", 'aloshop'),
    "base"      => "sv_message_box",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Info",'aloshop')   => 'item-message-info',
                esc_html__("Success",'aloshop')   => 'item-message-success',
                esc_html__("Error",'aloshop')   => 'item-message-error',
                esc_html__("Warning",'aloshop')   => 'item-message-warning',
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Icon",'aloshop'),
            "param_name" => "icon",
            'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker',
        ),
        array(
            "type" => "textarea",
            "holder"    => 'div',
            "heading" => esc_html__("Message",'aloshop'),
            "param_name" => "message",
        ),
    )
));