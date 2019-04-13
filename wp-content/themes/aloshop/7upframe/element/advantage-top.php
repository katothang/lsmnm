<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_advantage_top'))
{
    function sv_vc_advantage_top($attr,$content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'      => 'home-2',
            'image'      => '',
            'title'      => '',
            'price_regular'      => '',
            'price_sale'      => '',
            'link'       => '',
            'time'       => '',
        ),$attr));
        switch ($style) {
            case 'home24':
                $html .=    '<div class="item-adv24 item-adv-simple"><a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a></div>';
                break;

            case 'home23':
                $html .=    '<div class="item-adv23">
                                <div class="adv-thumb"><a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a></div>
                                <div class="adv-info">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                            </div>';
                break;

            case 'mega-adv':
                $html .=    '<div class="mega-adv">
                                <div class="mega-adv-thumb zoom-image-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="mega-adv-info">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                            </div>';
                break;

            case 'home8':
                $html .=    '<div class="item-product-adv clearfix">
                                <div class="adv-product-thumb zoom-image-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="adv-product-info">
                                    <h3><a href="'.esc_url($link).'">'.$title.'</a></h3>
                                    <div class="info-price">';
                if(!empty($price_regular)) $html .=    '<span>'.$price_regular.'</span> ';
                if(!empty($price_sale)) $html .=    '<del>'.$price_sale.'</del>';
                $html .=            '</div>
                                    <a href="'.esc_url($link).'" class="shopnow">'.esc_html__("shop now","aloshop").'</a>
                                </div>
                            </div>';
                break;

            case 'home3-hoverdir':
                wp_enqueue_script('modernizr-custom');
                wp_enqueue_script('hoverdir');
                $html .=    '<div class="world-ad-box">
                                <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'
                                    <div class="alo-smask"></div>
                                </a>
                            </div>';
                break;

            case 'home3-horizontal':
                $html .=    '<div class="mobile-access-box mobile-access-col2 clearfix">
                                <div class="mobile-access-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="product-info3">
                                    <h3 class="title-product"><a href="'.esc_url($link).'">'.$title.' </a></h3>
                                    <div class="info-price">';
                if(!empty($price_regular)) $html .=    '<span>'.$price_regular.'</span>';
                if(!empty($price_sale)) $html .=    '<del>'.$price_sale.'</del>';
                $html .=            '</div>
                                    <a href="'.esc_url($link).'" class="shopnow-access">'.esc_html__("shop now","aloshop").'</a>
                                </div>
                            </div>';
                break;

            case 'home3-square':
                $html .=    '<div class="mobile-access-box">
                                <div class="mobile-access-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="product-info3">
                                    <h3 class="title-product"><a href="'.esc_url($link).'">'.$title.' </a></h3>
                                    <div class="info-price">';
                if(!empty($price_regular)) $html .=    '<span>'.$price_regular.'</span>';
                if(!empty($price_sale)) $html .=    '<del>'.$price_sale.'</del>';
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'home-3':
                $html .=    '<div class="mobile-access-box mobile-access-long">
                                <div class="mobile-access-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="product-info3">
                                    <h3 class="title-product"><a href="'.esc_url($link).'">'.$title.' </a></h3>
                                    <div class="info-price">';
                if(!empty($price_regular)) $html .=    '<span>'.$price_regular.'</span>';
                if(!empty($price_sale)) $html .=    '<del>'.$price_sale.'</del>';
                $html .=            '</div>
                                    <a href="'.esc_url($link).'" class="shopnow-access">'.esc_html__("shop now","aloshop").'</a>
                                </div>
                            </div>';
                break;
            
            default:
                wp_enqueue_script('timeCircles');
                if(!empty($image)){
                    $img = wp_get_attachment_image_src( $image ,"full");
                    $bg_class = SV_Assets::build_css('background: #333 url("'.esc_url($img[0]).'") no-repeat center center;');
                }
                $html .=    '<div class="top-toggle hidden-xs '.$bg_class.'">
                                <div class="container">
                                    <div class="inner-top-toggle">
                                        <div class="top-toggle-info">
                                            '.wpb_js_remove_wpautop($content, true).'
                                        </div>
                                        <div class="top-toggle-coutdown" data-date="'.$time.'"></div>
                                        <a href="#" class="close-top-toggle"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>';
                break;
        }        
        return $html;
    }
}

stp_reg_shortcode('sv_advantage_top','sv_vc_advantage_top');

vc_map( array(
    "name"      => esc_html__("SV Advantage", 'aloshop'),
    "base"      => "sv_advantage_top",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value" => array(
                esc_html__("Top(Close)",'aloshop') => 'home-2',
                esc_html__("Home 3 Vertical",'aloshop') => 'home-3',
                esc_html__("Home 3 Square",'aloshop') => 'home3-square',
                esc_html__("Home 3 Horizontal",'aloshop') => 'home3-horizontal',
                esc_html__("Home 3 Hover Animation",'aloshop') => 'home3-hoverdir',
                esc_html__("Home 8",'aloshop') => 'home8',
                esc_html__("Home 23",'aloshop') => 'home23',
                esc_html__("Home 24",'aloshop') => 'home24',
                esc_html__("Mega Advantage",'aloshop') => 'mega-adv',
                )
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'aloshop'),
            "param_name" => "image",
        ),
        array(
            "type" => "textfield",
            "holder"    => 'h4',
            "heading" => esc_html__("Title",'aloshop'),
            "param_name" => "title",
            'dependency'  => array(
                'element'   => 'style',
                'value'   => array('home-3','home3-square','home3-horizontal','home8'),
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Price",'aloshop'),
            "param_name" => "price_regular",
            'dependency'  => array(
                'element'   => 'style',
                'value'   => array('home-3','home3-square','home3-horizontal','home8'),
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Price Old",'aloshop'),
            "param_name" => "price_sale",
            'dependency'  => array(
                'element'   => 'style',
                'value'   => array('home-3','home3-square','home3-horizontal','home8'),
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link",'aloshop'),
            "param_name" => "link",
            'dependency'  => array(
                'element'   => 'style',
                'value'   => array('home-3','home3-square','home3-horizontal','home3-hoverdir','home8','home24'),
                )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Time Countdown",'aloshop'),
            "param_name" => "time",            
            'description'   => esc_html__( 'EntertTime for countdown. Format is mm/dd/yyyy. Example: 12/15/2016.', 'aloshop' ),
            'dependency'  => array(
                'element'   => 'style',
                'value'   => 'home-2',
                )
        ),
        array(
            "type" => "textarea_html",
            "holder"    => 'div',
            "heading" => esc_html__("Content",'aloshop'),
            "param_name" => "content",
            'dependency'  => array(
                'element'   => 'style',
                'value'   => array('home-2','mega-adv','home23'),
                )
        )
    )
));