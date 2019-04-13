<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
if(!function_exists('sv_vc_product_tab'))
{
    function sv_vc_product_tab($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'          => '',
            'title'          => '',
            'title_img'      => '',
            'color'          => '',
            'tabs'          => '',
            'cats'          => '',
            'number'        => '6',
            'order'         => 'DESC',
            'order_by'      => 'date',
            'image_bg'      => '',
        ),$attr));
        if(!empty($tabs)){
            $args=array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => $order_by,
                'order'             => $order,
            );
            if(!empty($cats)) {
                $custom_list = explode(",",$cats);
                $args['tax_query'][]=array(
                    'taxonomy'=>'product_cat',
                    'field'=>'slug',
                    'terms'=> $custom_list
                );
            }
            $tabs = explode(',', $tabs);
            $tab_html = $content_html = $title_tab = '';
            foreach ($tabs as $key => $tab) {
                if($key == 0) $f_class = 'active';
                else $f_class = '';
                if($tab == 'best-sellers'){
                    $title_tab = esc_html__("Best Sellers","aloshop");
                    $args['meta_key'] = 'total_sales';
                    $args['orderby'] = 'meta_value_num';
                }
                if($tab == 'new-arrivals'){
                    unset($args['meta_key']);
                    $title_tab = esc_html__("New Arrivals","aloshop");
                    $args['order'] = 'DESC';
                    $args['orderby'] = 'ID';
                }
                if($tab == 'on-sale'){
                    $args['order'] = $order;
                    $args['orderby'] = $order_by;
                    $title_tab = esc_html__("On sale","aloshop");
                    $args['meta_query']['relation'] = "OR";
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
                if($tab == 'special'){
                    $args['order'] = $order;
                    $args['orderby'] = $order_by;
                    unset($args['meta_query']);
                    $title_tab = esc_html__("Featured","aloshop");
                    $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                }
                if($tab == 'popular'){
                    $args['order'] = $order;
                    unset($args['meta_query']);
                    $title_tab = esc_html__("Most Popular","aloshop");
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_key'] = 'post_views';
                }
                $query = new WP_Query($args);
                $pre = rand(1,100);
                switch ($style) {
                     case 'home-23':
                        $tab_html .=    '<li class="'.$f_class.'"><a href="'.esc_url('#'.$pre.$tab).'" data-toggle="tab">'.$title_tab.'</a></li>';
                        $content_html .=    '<div role="tabpanel" class="tab-pane fade in '.$f_class.'" id="'.$pre.$tab.'">
                                                <div class="popular-cat-slider">
                                                    <div class="wrap-item">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;                      
                                $content_html .=    '<div class="item">
                                                        <div class="item-product5">
                                                            '.sv_product_thumb_hover2(array(300,360),'product-thumb5').'
                                                            <div class="product-info5">
                                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                '.sv_get_product_price().'
                                                                '.sv_get_rating_html().'
                                                            </div>
                                                        </div>
                                                    </div>';            
                            }
                        }
                        $content_html .=            '</div>
                                                </div>
                                            </div>'; 
                        break;

                    case 'home-22':
                        $tab_html .=    '<li class="'.$f_class.'"><a href="'.esc_url('#'.$pre.$tab).'" data-toggle="tab">'.$title_tab.'</a></li>';
                        $content_html .=    '<div role="tabpanel" class="tab-pane fade in '.$f_class.'" id="'.$pre.$tab.'">
                                                <div class="featured-product-category product-tab22">
                                                    <div class="wrap-item">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;                      
                                $content_html .=    '<div class="item">
                                                        <div class="item-category-featured-product">
                                                            '.sv_product_thumb_hover(array(300,360)).'
                                                            <div class="product-info">
                                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                '.sv_get_product_price().'
                                                                '.sv_get_rating_html().'
                                                            </div>
                                                            '.sv_get_saleoff_html().'
                                                        </div>
                                                    </div>';            
                            }
                        }
                        $content_html .=            '</div>
                                                </div>
                                            </div>'; 
                        break;

                    case 'home-5':
                        $tab_html .=    '<li class="'.$f_class.'"><a href="'.esc_url('#'.$pre.$tab).'" data-toggle="tab">'.$title_tab.'</a></li>';
                        $content_html .=    '<div role="tabpanel" class="tab-pane fade in '.$f_class.'" id="'.$pre.$tab.'">
                                                <div class="popular-cat-slider slider-home5">
                                                    <div class="wrap-item">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;                      
                                $content_html .=    '<div class="item">
                                                        <div class="item-product5">
                                                            '.sv_product_thumb_hover2(array(268,322)).'
                                                            <div class="product-info5">
                                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                '.sv_get_product_price().'
                                                                '.sv_get_rating_html().'
                                                            </div>
                                                        </div>
                                                    </div>';            
                            }
                        }
                        $content_html .=            '</div>
                                                </div>
                                            </div>'; 
                        break;
                    
                    default:                        
                        $tab_html .=    '<li class="'.$f_class.'"><a href="#" data-id="'.$tab.'">'.$title_tab.'</a></li>';
                        $content_html .=    '<div id="'.$tab.'" class="tab-pane '.$f_class.'">
                                                <div class="product-tab-slider">
                                                    <div class="wrap-item">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();                        
                                $content_html .=    '<div class="item">
                                                        <div class="item-product">
                                                            '.sv_product_thumb_hover(array(268,322)).'
                                                        </div>
                                                    </div>';            
                            }
                        }
                        $content_html .=            '</div>
                                                </div>
                                            </div>';                        
                        break;
                }
                
            }
            switch ($style) {
                case 'home-23':
                    $html .=    '<div class="block-product23 clearfix">
                                    <div class="aside-product23">';
                    $html .=    '<h2 class="title-aside23">'.wp_get_attachment_image($title_img,'full').$title.'</h2>';
                    $html .=            '<div class="cat-aside23">
                                            <div class="cat-adv23">'.wp_get_attachment_image($image_bg,'full').'</div>
                                            '.wpb_js_remove_wpautop($content, true).'
                                        </div>
                                    </div>
                                    <div class="content-product23">
                                        <div class="content-popular23">
                                            <div class="title-product-box23">
                                                <ul>
                                                    '.$tab_html.'
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                '.$content_html.'
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    break;

                case 'home-22':
                    $html .=    '<div class="product-tab22">
                                    <ul class="list-inline title-tab22 '.esc_attr($color).'">
                                        '.$tab_html.'
                                    </ul>
                                    <div class="tab-content category-product-featured '.esc_attr($color).'">
                                        '.$content_html.'
                                    </div>
                                </div>';
                    break;

                case 'home-5':
                    $html .=    '<div class="content-popular5">
                                    <div class="popular-cat-title">
                                        <ul>
                                            '.$tab_html.'
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        '.$content_html.'
                                    </div>
                                </div>';
                    break;
                
                default: 
                    $html .=    '<div class="list-tab-product">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <div class="title-tab-product">
                                                <h2>'.$title.'</h2>
                                                <ul>
                                                '.$tab_html.'
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-xs-12">
                                            <div class="content-tab-product">
                                                '.$content_html.'
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    break;
            }
        }        
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_product_tab','sv_vc_product_tab');
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_admin_product_tab',10,100 );
if ( ! function_exists( 'sv_admin_product_tab' ) ) {
    function sv_admin_product_tab(){
        vc_map( array(
            "name"      => esc_html__("SV Product Tab", 'aloshop'),
            "base"      => "sv_product_tab",
            "icon"      => "icon-st",
            "category"  => '7Up-theme',
            "params"    => array(
                array(
                    "type"          => "dropdown",
                    "heading"       => esc_html__("Style",'aloshop'),
                    "param_name"    => "style",
                    "value"         => array(
                        esc_html__("Default",'aloshop')     => '',
                        esc_html__("Home 5",'aloshop')     => 'home-5',
                        esc_html__("Home 22",'aloshop')     => 'home-22',
                        esc_html__("Home 23",'aloshop')     => 'home-23',
                        )
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Color', 'aloshop' ),
                    'param_name'  => 'color',
                    'value'       => array(
                        esc_html__( 'Default', 'aloshop' ) => '',
                        esc_html__( 'Red', 'aloshop' ) => 'red-box',
                        esc_html__( 'Blue', 'aloshop' ) => 'blue-box',
                        esc_html__( 'Green', 'aloshop' ) => 'green-box',
                        esc_html__( 'Violet', 'aloshop' ) => 'violet-box',
                        ),
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('home-22'),
                        )
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Title Image before",'aloshop'),
                    "param_name" => "title_img",
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('home-23'),
                        )
                ),
                array(
                    "type"          => "textfield",
                    "holder"        => 'div',
                    "heading"       => esc_html__("Title",'aloshop'),
                    "param_name"    => "title",
                ),
                array(
                    "type"          => "checkbox",
                    "heading"       => esc_html__("Tabs",'aloshop'),
                    "param_name"    => "tabs",
                    "value"         => array(
                        esc_html__("Best Sellers",'aloshop')     => 'best-sellers',
                        esc_html__("New Arrivals",'aloshop')     => 'new-arrivals',
                        esc_html__("On Sale",'aloshop')          => 'on-sale',
                        esc_html__("Featured",'aloshop')         => 'special',
                        esc_html__("Popular",'aloshop')          => 'popular',
                        )
                ),
                array(
                    "type"          => "textfield",
                    "heading"       => esc_html__("Number product",'aloshop'),
                    "param_name"    => "number",
                    'description'   => esc_html__( 'Number of product display in this element. Default is 6.', 'aloshop' ),
                ),
                array(
                    "type"          => "dropdown",
                    "heading"       => esc_html__("Order",'aloshop'),
                    "param_name"    => "order",
                    "value"         => array(
                        esc_html__('Desc','aloshop') => 'DESC',
                        esc_html__('Asc','aloshop')  => 'ASC',
                        ),
                    'edit_field_class'=>'vc_col-sm-6 vc_column'
                ),
                array(
                    "type"          => "dropdown",
                    "heading"       => esc_html__("Order By",'aloshop'),
                    "param_name"    => "order_by",
                    "value"         => sv_get_order_list(),
                    'edit_field_class'=>'vc_col-sm-6 vc_column'
                ),
                array(
                    'holder'     => 'div',
                    'heading'     => esc_html__( 'Product Categories', 'aloshop' ),
                    'type'        => 'checkbox',
                    'param_name'  => 'cats',
                    'value'       => sv_list_taxonomy('product_cat',false)
                ), 
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Background side",'aloshop'),
                    "param_name" => "image_bg",
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('home-23'),
                        )
                ),               
                array(
                    "type" => "textarea_html",
                    "heading" => esc_html__("Content side",'aloshop'),
                    "param_name" => "content",
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('home-23'),
                        )
                ),
            )
        ));
    }
}

}