<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 5/09/16
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
    if(!function_exists('sv_vc_product_cat_list'))
    {
        function sv_vc_product_cat_list($attr, $content = false)
        {
            $html = '';
            extract(shortcode_atts(array(
                'title'      => '',
            ),$attr));
            wp_enqueue_script('bxslider');
            $html .=    '<div class="quick-category">
                            '.wpb_js_remove_wpautop($content, false).'
                        </div>';
            
            return $html;
        }
    }

    stp_reg_shortcode('sv_product_cat_list','sv_vc_product_cat_list');

    vc_map( array(
        "name"      => esc_html__("SV Product Category list", 'aloshop'),
        "base"      => "sv_product_cat_list",
        "icon"      => "icon-st",
        "category"  => '7Up-theme',
        'as_parent' => array( 'only' => 'sv_product_cat_item' ),
        'js_view' => 'VcColumnView',
        'content_element' => true,
        "params"    => array(
            
        )
    ));

    if(!function_exists('sv_vc_product_cat_item'))
    {
        function sv_vc_product_cat_item($attr)
        {
            $html = '';
            extract(shortcode_atts(array(
                'cat'      => '',
                'icon'       => '',
            ),$attr));
            if(!empty($cat)){
                $term = get_term_by( 'slug',$cat, 'product_cat' );
                if(!empty($term) && is_object($term)){
                    $term_link = get_term_link( $term->term_id, 'product_cat' );
                    $html .=    '<a href="'.esc_url($term_link).'">'.wp_get_attachment_image($icon,'full').' '.$term->name.'</a>';
                }
            }
            
            return $html;
        }
    }

    stp_reg_shortcode('sv_product_cat_item','sv_vc_product_cat_item');
    $check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_admin_product_cat_item',10,100 );
    if ( ! function_exists( 'sv_admin_product_cat_item' ) ) {
        function sv_admin_product_cat_item(){
            vc_map( array(
                "name"      => esc_html__("SV Product Category Item", 'aloshop'),
                "base"      => "sv_product_cat_item",
                "icon"      => "icon-st",
                "category"  => '7Up-theme',
                'as_child' => array('only' => 'sv_product_cat_list'),
                'content_element' => true,
                "params"    => array(
                    array(
                        'type'        => 'dropdown',
                        'holder'      => 'div',
                        'heading'     => esc_html__( 'Product Category', 'aloshop' ),
                        'param_name'  => 'cat',
                        'value'       => sv_list_taxonomy('product_cat',true),
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Category Icon",'aloshop'),
                        "param_name" => "icon",
                    ),
                )
            ));
        }
    }

    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Sv_Product_Cat_List extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Sv_Product_Cat_Item extends WPBakeryShortCode {}
    }
}