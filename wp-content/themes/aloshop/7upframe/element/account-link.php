<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_account_link'))
{
    function sv_vc_account_link($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'        => '',
            'login_link'        => '',
            'register_link'     => '',
            'des'               => '',
        ),$attr));        
        if(empty($login_link)) $login_link = wp_login_url();
        if(empty($register_link)) $register_link = wp_registration_url();
        switch ($style) {
            case 'dropdown':
                $text1 = $t_name = esc_html__("Login","aloshop");
                $text2 = esc_html__("Register","aloshop");
                $icon1 = '<i class="fa fa-user" aria-hidden="true"></i>';
                $icon2 = '<i class="fa fa-user-plus" aria-hidden="true"></i>';
                $html_li = '';
                if(is_user_logged_in()){
                    $login_link = get_author_posts_url( get_the_author_meta( 'ID' ));
                    $current_user = wp_get_current_user();
                    if(class_exists("woocommerce")) {
                        $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
                        $login_link = get_permalink( $myaccount_page );
                    }
                    $text1 = esc_html__("My Account","aloshop");
                    $t_name = esc_html__("Hello, ","aloshop").$current_user->display_name;
                    $register_link = wp_logout_url();
                    $text2 = esc_html__("Log out","aloshop");
                    $icon2 = '<i class="fa fa-sign-out" aria-hidden="true"></i>';
                    if(class_exists('YITH_WCWL_Init')) $html_li .= '<li><a href="'.esc_url(YITH_WCWL()->get_wishlist_url()).'"><i class="fa fa-heart-o"></i> '.esc_html__("Wish List").'</a></li>';
                    if(class_exists('YITH_Woocompare')) $html_li .= '<li><a href="'.get_the_permalink().'action=yith-woocompare-view-table&amp;iframe=yes"><i class="fa fa-toggle-on"></i> '.esc_html__("Compare").'</a></li>';
                    if(class_exists("woocommerce")) $html_li .= '<li><a href="'.get_the_permalink().'action=yith-woocompare-view-table&amp;iframe=yes"><i class="fa fa-sign-in"></i> '.esc_html__("Checkout").'</a></li>';
                }
                $html .=    '<div class="top-account">
                                <a href="'.esc_url($login_link).'">'.esc_html($t_name).'</a>
                                <ul class="sub-menu-top">
                                    <li><a href="'.esc_url($login_link).'">'.$icon1.' '.$text1.'</a></li>
                                    '.$html_li.'
                                    <li><a href="'.esc_url($register_link).'">'.$icon2.' '.$text2.'</a></li>
                                </ul>
                            </div>';
                break;
            
            default:
                $text1 = esc_html__("Login","aloshop");
                $text2 = esc_html__("register","aloshop");
                $icon1 = '<i class="fa fa-user fa-lg" aria-hidden="true"></i>';
                $icon2 = '<i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>';
                if(is_user_logged_in()){
                    $login_link = get_author_posts_url( get_the_author_meta( 'ID' ));
                    $current_user = wp_get_current_user();
                    if(class_exists("woocommerce")) {
                        $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
                        $login_link = get_permalink( $myaccount_page );
                    }
                    $text1 = $current_user->display_name;
                    $register_link = wp_logout_url();
                    $text2 = esc_html__("Log out","aloshop");
                    $icon2 = '<i class="fa fa-sign-out fa-lg" aria-hidden="true"></i>';
                }
                $html .=    '<div class="register-box">
                                <ul>
                                    <li><a href="'.esc_url($login_link).'">'.$icon1.' '.$text1.'</a></li>
                                    <li><a href="'.esc_url($register_link).'">'.$icon2.' '.$text2.'</a></li>
                                </ul>
                                <p>'.$des.'</p>
                            </div>';
                break;
        }
        
        return $html;
    }
}

stp_reg_shortcode('sv_account_link','sv_vc_account_link');

vc_map( array(
    "name"      => esc_html__("SV Account", 'aloshop'),
    "base"      => "sv_account_link",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Style",'aloshop'),
            "param_name"    => "style",
            "value"         => array(
                esc_html__("Default (List)",'aloshop')    => '',
                esc_html__("Dropdown",'aloshop')              => 'dropdown',
            )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Login Link",'aloshop'),
            "param_name" => "login_link",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Register Link",'aloshop'),
            "param_name" => "register_link",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description",'aloshop'),
            "param_name" => "des",
        )
    )
));