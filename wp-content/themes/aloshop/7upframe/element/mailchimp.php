<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 26/12/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_mailchimp'))
{
    function sv_vc_mailchimp($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'    => '',
            'des'      => '',
            'submit'    => '',
            'form_id'    => '',
            'style'      => 'newsletter-footer',
        ),$attr));
        $placeholder = esc_html__("Enter Your Email...","aloshop");
        $form_html = apply_filters('sv_remove_autofill',do_shortcode('[mc4wp_form id="'.$form_id.'"]'));
        switch ($style) {
            case 'newsletter2':
                $html .=    '<div class="box-newsletter">
                                <h2>'.$title.'</h2>
                                <p>'.$des.'</p>
                                <div class="sv-mailchimp-form '.$style.'" data-placeholder="'.$placeholder.'" data-submit="'.$submit.'">
                                    '.$form_html.'
                                </div>
                            </div>';
                break;

            case 'newsletter-footer newsletter-footer8':
                $html .=    '<div class="wrap-newsletter-footer8">
                                <div class="sv-mailchimp-form '.$style.'" data-placeholder="'.$placeholder.'" data-submit="'.$submit.'">
                                    <label>'.$title.'</label>
                                    '.$form_html.'
                                </div>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="sv-mailchimp-form '.$style.'" data-placeholder="'.$placeholder.'" data-submit="'.$submit.'">
                                <label>'.$title.'</label>
                                '.$form_html.'
                            </div>';
                break;
        }        
        return $html;
    }
}

stp_reg_shortcode('sv_mailchimp','sv_vc_mailchimp');

vc_map( array(
    "name"      => esc_html__("SV MailChimp", 'aloshop'),
    "base"      => "sv_mailchimp",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Normal",'aloshop')    => 'newsletter-footer',
                esc_html__("Home 2",'aloshop')    => 'newsletter2',
                esc_html__("Home 6",'aloshop')    => 'newsletter-form',
                esc_html__("Home 8",'aloshop')    => 'newsletter-footer newsletter-footer8',
                )
        ),
        array(
            "type" => "textfield",
            'holder'      => 'div',
            "heading" => esc_html__("Title",'aloshop'),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description",'aloshop'),
            "param_name" => "des",
            "dependency"    => array(
                "element"   =>  'style',
                "value"   =>  array('newsletter2'),
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Submit Label",'aloshop'),
            "param_name" => "submit",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Form ID",'aloshop'),
            "param_name" => "form_id",
        )
    )
));