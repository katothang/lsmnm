<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 31/08/15
 * Time: 10:00 AM
 */
/************************************Main Carousel*************************************/
if(class_exists("woocommerce")){
    if(!function_exists('sv_vc_category_menu'))
    {
        function sv_vc_category_menu($attr, $content = false)
        {
            $html = $css_class = '';
            extract(shortcode_atts(array(
                'style'      => 'load-hidden',
                'home_style' => 'default',
                'title'      => '',
                'expand'     => '9',
            ),$attr));                
            $html .=    '<div class="category-dropdown '.$home_style.'">';
            $html .=    '<h2 class="title-category-dropdown set-'.$style.'"><span>'.$title.'</span></h2>';
            $html .=        '<div class="wrap-category-dropdown '.$style.'">';
            $html .=            '<ul class="list-category-dropdown" data-expand="'.$expand.'">';
            $html .=                wpb_js_remove_wpautop($content, false);
            $html .=            '</ul>';
            if($home_style == 'category-dropdown8' || $home_style == 'category-dropdown8 category-dropdown9') $html .=  '<a class="expand-category-link expand-category-link8" href="#">'.esc_html__("All Categories","aloshop").'</a>';
            else $html .=            '<a href="#" class="expand-category-link"></a>';
            $html .=         '</div>';
            $html .=    '</div>';
            return $html;
        }
    }
    stp_reg_shortcode('sv_category_menu','sv_vc_category_menu');
    vc_map(
        array(
            'name'     => esc_html__( 'Product Category Menu', 'aloshop' ),
            'base'     => 'sv_category_menu',
            'category' => esc_html__( '7Up-theme', 'aloshop' ),
            'icon'     => 'icon-st',
            'as_parent' => array( 'only' => 'sv_category_item' ),
            'content_element' => true,
            'js_view' => 'VcColumnView',
            'params'   => array(
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Style', 'aloshop' ),
                    'param_name'  => 'style',
                    'value'       => array(
                        esc_html__( 'Default', 'aloshop' )  => 'load-hidden',
                        esc_html__( 'Active', 'aloshop' )   => 'load-active',
                        ),
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Home Style', 'aloshop' ),
                    'param_name'  => 'home_style',
                    'value'       => array(
                        esc_html__( 'Default', 'aloshop' )  => 'default',
                        esc_html__( 'Home 4', 'aloshop' )   => 'wrap-category-hover4',
                        esc_html__( 'Home 5', 'aloshop' )   => 'right-category-dropdown',
                        esc_html__( 'Home 6', 'aloshop' )   => 'category-dropdown6 right-category-dropdown',
                        esc_html__( 'Home 8', 'aloshop' )   => 'category-dropdown8',
                        esc_html__( 'Home 9', 'aloshop' )   => 'category-dropdown8 category-dropdown9',
                        ),
                ),
                array(
                    'type'        => 'textfield',
                    'holder'      => 'h3',
                    'heading'     => esc_html__( 'Title', 'aloshop' ),
                    'param_name'  => 'title',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__( 'Expand Number', 'aloshop' ),
                    'param_name'  => 'expand',
                ),
            )
        )
    );

    /*******************************************END MAIN*****************************************/


    /**************************************BEGIN ITEM************************************/
    //Banner item Frontend
    if(!function_exists('sv_vc_category_item'))
    {
        function sv_vc_category_item($attr, $content = false)
        {
            $html = $content_hover = $el_class = '';
            extract(shortcode_atts(array(
                'cat'          => '',
                'icon'          => '',
                'mega_content'  => '',
                'page_id'       => '',
            ),$attr));
            if(!empty($cat)){
                switch ($mega_content) {
                    case 'page':
                        $content_hover .=    '<div class="cat-mega-menu cat-mega-style1">';
                        $content_hover .=       balanceTags(SV_Template::get_vc_pagecontent($page_id));
                        $content_hover .=    '</div>';
                        break;
                    
                    case 'editor':
                        $content_hover .=    '<div class="cat-mega-menu cat-mega-style1">';
                        $content_hover .=       wpb_js_remove_wpautop($content, true);
                        $content_hover .=    '</div>';
                        break;

                    case 'featured':
                        $content_hover .=       '<div class="cat-mega-menu cat-mega-style2">
                                                    <h2 class="title-cat-mega-menu">'.esc_html__("Special products","aloshop").'</h2>
                                                    <div class="row">';
                        $args = array(
                            'post_type'         => 'product',
                            'posts_per_page'    => 3,
                            );
                        $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        $args['tax_query'][]=array(
                            'taxonomy'  => 'product_cat',
                            'field'     => 'slug',
                            'terms'     => $cat
                        );
                        $query = new WP_Query($args);
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $content_hover .=   '<div class="col-md-4 col-sm-3">
                                                        <div class="item-category-featured-product first-item">
                                                            '.sv_product_thumb_hover(array(199,239)).'
                                                            <div class="product-info">
                                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                '.sv_get_product_price().'
                                                                '.sv_get_rating_html().'
                                                            </div>
                                                        </div>
                                                    </div>';
                            }
                        }
                        $content_hover .=           '</div>
                                                </div>';
                        wp_reset_postdata();
                        break;

                    default:
                        # code...
                        break;
                }
                if(!empty($content_hover)) $el_class = 'has-cat-mega';
                $term = get_term_by( 'slug',$cat, 'product_cat' );
                if(is_object($term)){
                    $term_link = get_term_link( $term->term_id, 'product_cat' );
                    $html .=    '<li class="'.$el_class.'">
                                    <a href="'.esc_url($term_link).'">'.$term->name.'
                                        '.wp_get_attachment_image($icon,'full').'
                                    </a>
                                    '.$content_hover.'
                                </li>';
                }
            }
            return $html;
        }
    }
    stp_reg_shortcode('sv_category_item','sv_vc_category_item');

    // Banner item
    $check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_admin_category_item',10,100 );
    if ( ! function_exists( 'sv_admin_category_item' ) ) {
        function sv_admin_category_item(){
            vc_map(
                array(
                    'name'     => esc_html__( 'Category Item', 'aloshop' ),
                    'base'     => 'sv_category_item',
                    'icon'     => 'icon-st',
                    'content_element' => true,
                    'as_child' => array('only' => 'sv_category_menu'),
                    'params'   => array(
                        array(
                            'type'        => 'dropdown',
                            'holder'      => 'div',
                            'heading'     => esc_html__( 'Product Category', 'aloshop' ),
                            'param_name'  => 'cat',
                            'value'       => sv_list_taxonomy('product_cat',true),
                        ),
                        array(
                            'type'        => 'attach_image',
                            'heading'     => esc_html__( 'Icon image', 'aloshop' ),
                            'param_name'  => 'icon',
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Content hover', 'aloshop' ),
                            'param_name'  => 'mega_content',
                            'value'       => array(
                                esc_html__( 'None', 'aloshop' )             => '',
                                esc_html__( 'Content page', 'aloshop' )     => 'page',
                                esc_html__( 'Content Editor', 'aloshop' )   => 'editor',
                                esc_html__( 'Featured Product', 'aloshop' ) => 'featured',
                                ),
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => esc_html__( 'Choose page content', 'aloshop' ),
                            'param_name'  => 'page_id',
                            'value'       => sv_list_all_page(),
                            'dependency'  => array(
                                'element'   => 'mega_content',
                                'value'   => 'page',
                                )
                        ),
                        array(
                            'type'        => 'textarea_html',
                            'heading'     => esc_html__( 'Content', 'aloshop' ),
                            'param_name'  => 'content',
                            'dependency'  => array(
                                'element'   => 'mega_content',
                                'value'   => 'editor',
                                )
                        ),
                    )
                )
            );
        }
    }

    /**************************************END ITEM************************************/

    //Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Sv_Category_Menu extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Sv_Category_Item extends WPBakeryShortCode {}
    }
}