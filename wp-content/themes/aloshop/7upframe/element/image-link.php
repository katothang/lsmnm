<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(!function_exists('sv_vc_payment'))
{
    function sv_vc_payment($attr, $content = false)
    {
        $html = $icon_html = '';
        extract(shortcode_atts(array(
            'title'          => '',
            'list'          => '',
            'style'         => 'payment-method',
        ),$attr));
		parse_str( urldecode( $list ), $data);        
        switch ($style) {
            case 'brand-slider24':
                if(is_array($data)){
                    foreach ($data as $key => $value) {
                        $icon_html .= '<div class="item-brand24"><a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a></div>';
                    }
                }
                $html .=    '<div class="block-brand24">
                                <h2>'.$title.'</h2>
                                <div class="brand-slider24">
                                    <div class="wrap-item smart-slider" data-item="" data-speed="" 
                                        data-itemres="0:1,640:2,1200:3,1500:4" 
                                        data-prev="" data-next="" 
                                        data-pagination="" data-navigation="true">
                                        '.$icon_html.'
                                    </div>
                                </div>
                            </div>';
                break;
            
            default:
                if(is_array($data)){
                    foreach ($data as $key => $value) {
                        $icon_html .= '<a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>';
                    }
                }
                $html .=    '<div class="'.$style.' clearfix">';
                if(!empty($title)) $html .=    '<label>'.$title.'</label>';
                $html .=        $icon_html;
                $html .=    '</div>';
                break;
        }        
		return  $html;
    }
}

stp_reg_shortcode('sv_payment','sv_vc_payment');


vc_map( array(
    "name"      => esc_html__("SV Image link", 'aloshop'),
    "base"      => "sv_payment",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Payment footer",'aloshop')    => 'payment-method',
                esc_html__("Partner list",'aloshop')    => 'list-partner',
                esc_html__("Brand slider(24)",'fashionstore')    => 'brand-slider24',
                )
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Title', 'aloshop' ),
            'param_name'  => 'title',            
        ),
		array(
            "type" => "add_brand",
            "heading" => esc_html__("Add Image List",'aloshop'),
            "param_name" => "list",
        )
    )
));