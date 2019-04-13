<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_contact_review'))
{
    function sv_vc_contact_review($attr,$content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'image'       => '',
            'title'      => '',
            'link'       => '',
        ),$attr));
        $html .=    '<div class="item-about-review">
                        <div class="about-review-thumb">
                            <a href="'.esc_url($link).'">'.wp_get_attachment_image($image).'</a>
                        </div>
                        <div class="about-info">
                            <h3><a href="'.esc_url($link).'">'.$title.'</a></h3>
                            '.wpb_js_remove_wpautop($content, true).'
                        </div>
                    </div>';
        
        return $html;
    }
}

stp_reg_shortcode('sv_contact_review','sv_vc_contact_review');

vc_map( array(
    "name"      => esc_html__("SV Contact Review", 'aloshop'),
    "base"      => "sv_contact_review",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'aloshop'),
            "param_name" => "image",
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Name",'aloshop'),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link",'aloshop'),
            "param_name" => "link",
        ),
        array(
            "type" => "textarea_html",
            "heading" => esc_html__("Content",'aloshop'),
            "param_name" => "content",
        ),
    )
));