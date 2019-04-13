<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
    if(!function_exists('sv_vc_mini_cart'))
    {
        function sv_vc_mini_cart($attr)
        {
            $html = $header_cart_html = '';
            extract(shortcode_atts(array(
                'style'     => '',
            ),$attr));
            if(!is_admin()){
                switch ($style) {
                    case 'mini-cart8 mini-cart9':
                    case 'mini-cart8':
                        $header_cart_html = '<a href="'.esc_url(wc_get_cart_url()).'" class="header-mini-cart">
                                                <span class="total-mini-cart-item"><span class="cart-item-count set-cart-number">0</span> '.esc_html__("Item(s)","aloshop").' - </span>
                                                <span class="total-mini-cart-price set-cart-price">'.WC()->cart->get_cart_total().'</span>
                                            </a>';
                        break;

                    case 'mini-cart-7':
                        $header_cart_html = '<a href="'.esc_url(wc_get_cart_url()).'" class="header-mini-cart7">
                                                <span class="total-mini-cart-icon"></span>
                                                <span class="total-mini-cart-item cart-item-count set-cart-number">0</span>
                                            </a>';
                        break;

                    case 'mini-cart6':
                        $header_cart_html = '<a href="'.esc_url(wc_get_cart_url()).'" class="header-mini-cart">
                                                <span class="total-mini-cart-item"><span class=" cart-item-count set-cart-number">0</span> '.esc_html__("Item(s)","aloshop").' - </span>
                                                <span class="total-mini-cart-price set-cart-price">'.WC()->cart->get_cart_total().'</span>
                                            </a>';
                        break;

                    case 'mini-cart-3 mini-cart-5':
                        $header_cart_html = '<a href="'.esc_url(wc_get_cart_url()).'" class="header-mini-cart3 header-mini-cart5">
                                                <span class="total-mini-cart-icon"></span>
                                                <span class="total-mini-cart-item cart-item-count set-cart-number">0</span>
                                            </a>';
                        break;

                    case 'mini-cart-3':
                        $header_cart_html = '<a href="'.esc_url(wc_get_cart_url()).'" class="header-mini-cart3">
                                                <span class="total-mini-cart-icon"></span>
                                                <span class="total-mini-cart-item cart-item-count set-cart-number">0</span>
                                            </a>';
                        break;

                    case 'mini-cart-2':
                        $header_cart_html = '<a href="'.esc_url(wc_get_cart_url()).'" class="header-mini-cart2">
                                                <span class="total-mini-cart-icon"><i class="fa fa-shopping-basket"></i></span>
                                                <span class="total-mini-cart-item cart-item-count set-cart-number">0</span>
                                            </a>';
                        break;
                    
                    default:
                        $header_cart_html = '<div class="header-mini-cart">
                                                <span class="total-mini-cart-item"><span class="cart-item-count set-cart-number">0</span> '.esc_html__("Item(s)","aloshop").' - </span>
                                                <span class="total-mini-cart-price set-cart-price">'.WC()->cart->get_cart_total().'</span>
                                            </div>';
                        break;
                }
                $html .=    '<div class="mini-cart '.$style.'">
                                '.$header_cart_html.'
                                <div class="content-mini-cart">
                                    <h2>(<span class="cart-item-count set-cart-number">0</span>) '.esc_html__("ITEMS IN MY CART","aloshop").'</h2>
                                    <div class="mini-cart-content mini-cart-main-content">'.sv_mini_cart().'</div>                    
                                    <div class="total-default hidden">'.wc_price(0).'</div>
                                </div>
                            </div>';
                $show_mode = sv_check_catelog_mode();
                if($show_mode == 'on') $html = '';
            }
            return $html;
        }
    }

    stp_reg_shortcode('sv_mini_cart','sv_vc_mini_cart');

    vc_map( array(
        "name"      => esc_html__("SV Mini Cart", 'aloshop'),
        "base"      => "sv_mini_cart",
        "icon"      => "icon-st",
        "category"  => '7Up-theme',
        "params"    => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Style",'aloshop'),
                "param_name" => "style",
                "value"     => array(
                    esc_html__("Home 1",'aloshop')   => '',
                    esc_html__("Home 2",'aloshop')   => 'mini-cart-2',
                    esc_html__("Home 3",'aloshop')   => 'mini-cart-3',
                    esc_html__("Home 5",'aloshop')   => 'mini-cart-3 mini-cart-5',
                    esc_html__("Home 6",'aloshop')   => 'mini-cart6',
                    esc_html__("Home 7",'aloshop')   => 'mini-cart-7',
                    esc_html__("Home 8",'aloshop')   => 'mini-cart8',
                    esc_html__("Home 9",'aloshop')   => 'mini-cart8 mini-cart9',
                    )
            )
        )
    ));
}