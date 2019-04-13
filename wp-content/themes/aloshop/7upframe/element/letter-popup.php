<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_letter_popup'))
{
    function sv_vc_letter_popup($attr,$content = false)
    {
        $html = $logo = '';
        extract(shortcode_atts(array(
            'title'      => '',
            'image'      => '',
            'form_id'    => '',
        ),$attr));
        $check = true;
        if(isset($_SESSION['dont_show_popup'])){
            $check = !$_SESSION['dont_show_popup'];
        }
        if($check){
            $html .=    '<div  id="boxes-content">
                            <div class="window" id="dialog">
                                <div class="window-popup"> 
                                    <a href="#" class="close-popup"><span class="lnr lnr-cross"></span></a>
                                    <div class="content-popup">
                                        '. wpb_js_remove_wpautop($content, true).'
                                        '.apply_filters('sv_remove_autofill',do_shortcode('[mc4wp_form id="'.$form_id.'"]')).'
                                        <p><input type="checkbox" id="check-popup" /><label for="check-popup">'.esc_html__("Do not show this popup again","aloshop").'</label></p>
                                    </div>
                                    '.wp_get_attachment_image($image,'full',0,array('class' => 'image-popup')).'
                                </div>
                            </div>
                            <div id="mask" ></div>
                        </div>';
        }
        return $html;
    }
}

stp_reg_shortcode('sv_letter_popup','sv_vc_letter_popup');

vc_map( array(
    "name"      => esc_html__("SV Letter Popup", 'aloshop'),
    "base"      => "sv_letter_popup",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Form ID",'aloshop'),
            "param_name" => "form_id",
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'aloshop'),
            "param_name" => "image",
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Content",'aloshop'),
            "param_name" => "content",
        ),
    )
));