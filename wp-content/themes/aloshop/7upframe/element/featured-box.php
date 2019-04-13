<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 9/1/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_featured_box'))
{
    function sv_vc_featured_box($attr, $content = false)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'icon'      => '',
            'link'      => '',
            'style'     => 'feature-box-style-01',
        ),$attr));
        if(!empty($icon)){
            if(strpos($icon,'lnr') !== false) $icon_html = '<span class="lnr '.$icon.'"></span>';
            else $icon_html =   '<i class="fa '.$icon.'"></i>';
        }
        $group1 = array(0=>'feature-box-style-05',1=>'feature-box-style-06',2=>'feature-box-style-07',3=>'feature-box-style-08');
        $group2 = array(0=>'feature-box-style-09',1=>'feature-box-style-10',2=>'feature-box-style-11',3=>'feature-box-style-12');
        switch ($style) {
            case in_array($style, $group1):
                $html .=    '<div class="item-feature-box text-right '.$style.'">';                
                $html .=        '<div class="feature-box-info">                                    
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>';
                $html .=        '<div class="feature-box-icon">
                                    <a href="'.esc_url($link).'" class="feature-box-link">
                                        '.$icon_html.'
                                    </a>
                                </div>';
                $html .=    '</div><div class="clearfix"></div>';
                break;

            case in_array($style, $group2):
                $html .=    '<div class="item-feature-box text-center '.$style.'">';
                $html .=        '<div class="feature-box-icon">
                                    <a href="'.esc_url($link).'" class="feature-box-link">
                                        '.$icon_html.'
                                    </a>
                                </div>';
                $html .=        '<div class="feature-box-info">                                    
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>';                
                $html .=    '</div><div class="clearfix"></div>';
                break;
            
            default:
                $html .=    '<div class="item-feature-box text-left '.$style.'">';
                $html .=        '<div class="feature-box-icon">
                                    <a href="'.esc_url($link).'" class="feature-box-link">
                                        '.$icon_html.'
                                    </a>
                                </div>';
                $html .=        '<div class="feature-box-info">                                    
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>';
                $html .=    '</div><div class="clearfix"></div>';
                break;
        }
        return $html;
    }
}

stp_reg_shortcode('sv_feature_box','sv_vc_featured_box');

vc_map( array(
    "name"      => esc_html__("SV Feature Box", 'aloshop'),
    "base"      => "sv_feature_box",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Icon",'aloshop'),
            "param_name" => "icon",
            'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker',
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link feature",'aloshop'),
            "param_name" => "link",
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Icon left 1",'aloshop') => 'feature-box-style-01',
                esc_html__("Icon left 2",'aloshop') => 'feature-box-style-02',
                esc_html__("Icon left 3",'aloshop') => 'feature-box-style-03',
                esc_html__("Icon left 4",'aloshop') => 'feature-box-style-04',
                esc_html__("Icon right 1",'aloshop') => 'feature-box-style-05',
                esc_html__("Icon right 2",'aloshop') => 'feature-box-style-06',
                esc_html__("Icon right 3",'aloshop') => 'feature-box-style-07',
                esc_html__("Icon right 4",'aloshop') => 'feature-box-style-08',
                esc_html__("Icon top 1",'aloshop') => 'feature-box-style-09',
                esc_html__("Icon top 2",'aloshop') => 'feature-box-style-10',
                esc_html__("Icon top 3",'aloshop') => 'feature-box-style-11',
                esc_html__("Icon top 4",'aloshop') => 'feature-box-style-12',
                esc_html__("Icon box 1",'aloshop') => 'feature-box-style-13',
                esc_html__("Icon box 2",'aloshop') => 'feature-box-style-14',
                )
        ),
        array(
            "type" => "textarea_html",
            "holder" => 'div',
            "heading" => esc_html__("Content",'aloshop'),
            "param_name" => "content",
        ),
    )
));