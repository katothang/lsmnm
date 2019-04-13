<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 31/08/15
 * Time: 10:00 AM
 */
/************************************Main Carousel*************************************/
if(class_exists("woocommerce")){
    if(!function_exists('sv_vc_category_menu2'))
    {
        function sv_vc_category_menu2($attr, $content = false)
        {
            $html = $css_class = '';
            extract(shortcode_atts(array(
                'style'      => 'load-hidden',
                'title'      => '',
                'expand'     => '9',
            ),$attr));
            $html .=    '<div class="category-hover category-hover2">
                            <div class="inner-category-hover clearfix">
                                <div class="inner-left-category-hover">
                                    <div class="content-left-category-hover">
                                        <h2 class="title-category-hover"><span>'.$title.'</span></h2>
                                        <ul class="list-category-hover" data-expand="'.$expand.'">
                                        </ul>
                                        <a href="#" class="expand-list-link"></a>
                                    </div>
                                </div>
                                <div class="content-right-category-hover">';
                $html .=            wpb_js_remove_wpautop($content, false);
                $html .=         '</div>';
                $html .=    '</div>
                        </div>';
            return $html;
        }
    }
    stp_reg_shortcode('sv_category_menu2','sv_vc_category_menu2');
    vc_map(
        array(
            'name'     => esc_html__( 'Product Category Menu2', 'aloshop' ),
            'base'     => 'sv_category_menu2',
            'category' => esc_html__( '7Up-theme', 'aloshop' ),
            'icon'     => 'icon-st',
            'as_parent' => array( 'only' => 'sv_category_item2' ),
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
    if(!function_exists('sv_vc_category_item2'))
    {
        function sv_vc_category_item2($attr, $content = false)
        {
            $html = $content_hover = $el_class = '';
            extract(shortcode_atts(array(
                'cat'           => '',
                'icon'          => '',
                'image'         => '',
                'product_type'  => '',
            ),$attr));
            if(!empty($cat)){
                $term = get_term_by( 'slug',$cat, 'product_cat' );
                $pre = rand(1,100);
                if(is_object($term)){
                    $term_link = get_term_link( $term->term_id, 'product_cat' );
                    $html .=    '<div id="category-'.$term->slug.$pre.'" class="inner-right-category-hover clearfix">
                                    <div class="banner-category-hover">
                                        <div class="banner-cat-hover-thumb">
                                            <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                        </div>
                                        <div class="banner-cat-hover-info">
                                            '.wpb_js_remove_wpautop($content, true).'
                                        </div>
                                    </div>';
                    $args = array(
                        'post_type'         => 'product',
                        'posts_per_page'    => 4,
                        'orderby'           => 'date',
                        );
                    $args['tax_query'][]=array(
                        'taxonomy'  => 'product_cat',
                        'field'     => 'slug',
                        'terms'     => $cat
                    );
                    if($product_type == 'trendding'){
                        $args['meta_query'][] = array(
                                'key'     => 'trending_product',
                                'value'   => 'on',
                                'compare' => '=',
                            );
                    }
                    if($product_type == 'toprate'){
                        $args['meta_key'] = '_wc_average_rating';
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_query'] = WC()->query->get_meta_query();
                        $args['tax_query'][] = WC()->query->get_tax_query();
                    }
                    if($product_type == 'mostview'){
                        $args['meta_key'] = 'post_views';
                        $args['orderby'] = 'meta_value_num';
                    }
                    if($product_type == 'bestsell'){
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                    }
                    if($product_type=='onsale'){
                        $args['meta_query']['relation']= 'OR';
                        $args['meta_query'][]=array(
                            'key'   => '_sale_price',
                            'value' => 0,
                            'compare' => '>',                
                            'type'          => 'numeric'
                        );
                        $args['meta_query'][]=array(
                            'key'   => '_min_variation_sale_price',
                            'value' => 0,
                            'compare' => '>',                
                            'type'          => 'numeric'
                        );
                    }
                    if($product_type == 'featured'){
                        $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                    }
                    $query = new WP_Query($args);
                    $count_query = $query->post_count;
                    $count = 1;
                    if($query->have_posts()) {
                        while($query->have_posts()) {
                            $query->the_post();
                            global $product;
                            if($count % 4 == 1) $html .=    '<div class="large-cat-hover">';
                            if($count % 4 == 1 || $count % 4 == 2){
                                $html .=    '<div class="item-large-cat-hover">
                                                <div class="large-cat-info">
                                                    '.sv_get_saleoff_html('home2').'
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                </div>
                                                <div class="large-cat-thumb">
                                                    '.sv_product_thumb_hover3(array(300,360)).'
                                                </div>
                                            </div>';
                                if($count % 4 == 2 || $count == $count_query) $html .=    '</div>';
                            }
                            if($count % 4 == 3) $html .=    '<div class="small-cat-hover">';
                            if($count % 4 == 3 || $count % 4 == 0){
                                $html .=    '<div class="item-small-cat-hover">
                                                <div class="small-cat-thumb">
                                                    '.sv_product_thumb_hover3(array(300,360)).'
                                                </div>
                                                <div class="small-cat-info">
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                </div>
                                            </div>';
                                if($count % 4 == 0 || $count == $count_query) $html .=    '</div>';
                            }
                            $count++;
                        }
                    }
                    wp_reset_postdata();
                    $html .=        '<ul class="hidden cat-title-list"><li><a href="'.esc_url($term_link).'" data-id="category-'.$term->slug.$pre.'">'.wp_get_attachment_image($icon,'full').' '.$term->name.'</a></li></ul>
                                </div>';
                }
            }
            return $html;
        }
    }
    stp_reg_shortcode('sv_category_item2','sv_vc_category_item2');

    // Banner item
    $check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_admin_category_item2',10,100 );
    if ( ! function_exists( 'sv_admin_category_item2' ) ) {
        function sv_admin_category_item2(){
            vc_map(
                array(
                    'name'     => esc_html__( 'Category Item 2', 'aloshop' ),
                    'base'     => 'sv_category_item2',
                    'icon'     => 'icon-st',
                    'content_element' => true,
                    'as_child' => array('only' => 'sv_category_menu2'),
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
                            'heading'     => esc_html__( 'Icon', 'aloshop' ),
                            'param_name'  => 'icon',
                            'edit_field_class'=>'vc_col-sm-6 vc_column',
                        ),
                        array(
                            'type'        => 'attach_image',
                            'heading'     => esc_html__( 'Image', 'aloshop' ),
                            'param_name'  => 'image',
                            'edit_field_class'=>'vc_col-sm-6 vc_column',
                        ),                    
                        array(
                            'heading'     => esc_html__( 'Product Type', 'aloshop' ),
                            'type'        => 'dropdown',
                            'param_name'  => 'product_type',
                            'value' => array(
                                esc_html__('Default','aloshop')            => '',
                                esc_html__('Trendding','aloshop')          => 'trendding',
                                esc_html__('Featured Products','aloshop')  => 'featured',
                                esc_html__('Best Sellers','aloshop')       => 'bestsell',
                                esc_html__('On Sale','aloshop')            => 'onsale',
                                esc_html__('Top rate','aloshop')           => 'toprate',
                                esc_html__('Most view','aloshop')          => 'mostview',
                            ),
                            'description' => esc_html__( 'Select Product View Type', 'aloshop' ),
                        ),
                        array(
                            'type'        => 'textarea_html',
                            'heading'     => esc_html__( 'Content', 'aloshop' ),
                            'param_name'  => 'content',
                        ),
                    )
                )
            );
        }
    }

    /**************************************END ITEM************************************/

    //Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_Sv_Category_Menu2 extends WPBakeryShortCodesContainer {}
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_Sv_Category_Item2 extends WPBakeryShortCode {}
    }
}