<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 18/08/15
 * Time: 10:00 AM
 */
// Start at 24/3/2016
if(!function_exists('sv_vc_menu'))
{
    function sv_vc_menu($attr,$content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'      => '',
            'menu'      => 'main-nav1',
        ),$attr));
        if(!empty($menu)){
            $html .= '<nav class="main-nav '.$style.'">';
                ob_start();
                wp_nav_menu( array(
                    'menu' => $menu,
                    'container'=>false,
                    'walker'=>new SV_Walker_Nav_Menu(),
                ));
            $html .= @ob_get_clean();
            $html .= '<a href="#" class="toggle-mobile-menu"><span>'.esc_html__("Menu","aloshop").'</span></a>';
            $html .= '</nav>';
        }
        else{
            $html .= '<nav class="main-nav '.$style.'">';
                ob_start();
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'=>false,
                    'walker'=>new SV_Walker_Nav_Menu(),
                ));
            $html .= @ob_get_clean();
            $html .= '<a href="#" class="toggle-mobile-menu"><span>'.esc_html__("Menu","aloshop").'</span></a>';
            $html .= '</nav>';
        }        
        return $html;
    }
}

stp_reg_shortcode('sv_menu','sv_vc_menu');

vc_map( array(
    "name"      => esc_html__("SV Menu", 'aloshop'),
    "base"      => "sv_menu",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Home 1",'aloshop')   => 'main-nav1',
                esc_html__("Home 2",'aloshop')   => 'main-nav2',
                esc_html__("Home 3",'aloshop')   => 'main-nav3',
                esc_html__("Home 4",'aloshop')   => 'main-nav4',
                esc_html__("Home 5",'aloshop')   => 'main-nav5',
                esc_html__("Home 6",'aloshop')   => 'main-nav6',
                esc_html__("Home 7",'aloshop')   => 'main-nav7',
                esc_html__("Home 8",'aloshop')   => 'main-nav8',
                esc_html__("Home 9",'aloshop')   => 'main-nav8 main-nav9',
                esc_html__("Home 10",'aloshop')  => 'main-nav10',
                esc_html__("Home 21",'aloshop')  => 'main-nav21',
                )
        ),
        array(
            'type' => 'dropdown',
            'holder' => 'div',
            'heading' => esc_html__( 'Menu name', 'aloshop' ),
            'param_name' => 'menu',
            'value' => sv_list_menu_name(),
            'description' => esc_html__( 'Select Menu name to display', 'aloshop' )
        ),
    )
));