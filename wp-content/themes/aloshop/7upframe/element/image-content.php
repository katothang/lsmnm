<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(!function_exists('sv_vc_image_content'))
{
    function sv_vc_image_content($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'image'          => '',
            'link'          => '',
        ),$attr));
        $html .=    '<div class="item-aloshop-brand">
                        <a href="'.esc_url($link).'" class="aloshop-brand-link">
                            '.wp_get_attachment_image($image,'full').'
                        </a>
                        '.wpb_js_remove_wpautop($content, true).'
                    </div>';
		return  $html;
    }
}

stp_reg_shortcode('sv_image_content','sv_vc_image_content');


vc_map( array(
    "name"      => esc_html__("SV Image Content", 'aloshop'),
    "base"      => "sv_image_content",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            'type'        => 'attach_image',
            'heading'     => esc_html__( 'Image', 'aloshop' ),
            'param_name'  => 'image',            
        ),
		array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Link', 'aloshop' ),
            'param_name'  => 'link',            
        ),
        array(
            'type'        => 'textarea_html',
            'heading'     => esc_html__( 'Content', 'aloshop' ),
            'param_name'  => 'content',
        )
    )
));