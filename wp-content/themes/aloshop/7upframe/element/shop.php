<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_shop'))
{
    function s7upf_vc_shop($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'      => 'grid',
            'number'     => '12',
            'orderby'    => 'menu_order',
            'column'     => 'col-md-12 col-sm-12',
        ),$attr));
        $type = $style;
        if(isset($_GET['orderby'])){
            $orderby = $_GET['orderby'];
        }
        if(isset($_GET['type'])){
            $type = $_GET['type'];
        }
        if(isset($_GET['number'])){
            $number = $_GET['number'];
        }
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'order'             => 'ASC',
            'posts_per_page'    => $number,
            'paged'             => $paged,
            );
        $attr_taxquery = array();
        global $wpdb;
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        if(!empty($attribute_taxonomies)){
            foreach($attribute_taxonomies as $attr){
                if(isset($_REQUEST['pa_'.$attr->attribute_name])){
                    $term = $_REQUEST['pa_'.$attr->attribute_name];
                    $term = explode(',', $term);
                    $attr_taxquery[] =  array(
                                            'taxonomy'      => 'pa_'.$attr->attribute_name,
                                            'terms'         => $term,
                                            'field'         => 'slug',
                                            'operator'      => 'IN'
                                        );
                }
            }            
        }
        if ( !is_admin() && !empty($attr_taxquery)){
            $attr_taxquery = array('relation ' => 'AND');
            $args['meta_query'][]  = array(
                'key'           => '_visibility',
                'value'         => array('catalog', 'visible'),
                'compare'       => 'IN'
            );
            $args['tax_query'] = $attr_taxquery;
        }
        if( isset( $_GET['min_price']) && isset( $_GET['max_price']) ){
            $min = $_GET['min_price'];
            $max = $_GET['max_price'];
            $args['post__in'] = s7upf_filter_price($min,$max);
        }
        switch ($orderby) {
            case 'price' :
                $args['orderby']  = "meta_value_num ID";
                $args['order']    = 'ASC';
                $args['meta_key'] = '_price';
            break;

            case 'price-desc' :
                $args['orderby']  = "meta_value_num ID";
                $args['order']    = 'DESC';
                $args['meta_key'] = '_price';
            break;

            case 'popularity' :
                $args['meta_key'] = 'total_sales';
                add_filter( 'posts_clauses', array( WC()->query, 'order_by_popularity_post_clauses' ) );
            break;

            case 'rating' :
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby'] = 'meta_value_num';
                $args['meta_query'] = WC()->query->get_meta_query();
                $args['tax_query'][] = WC()->query->get_tax_query();
            break;

            case 'date':
                $args['orderby'] = 'date';
                break;
            
            default:
                $args['orderby'] = 'menu_order title';
                break;
        }
        $grid_active = $list_active = '';
        if($type == 'grid') $grid_active = 'active'; 
        if($type == 'list') $list_active = 'active';
        $product_query = new WP_Query($args);
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        ob_start();?>
        <div class="shop-tab-product main-shop-load">
            <div class="shop-tab-title">
                <?php if(!is_cart() && !is_single()):?>
                    <h2><?php woocommerce_page_title(); ?></h2>
                <?php endif;?>
                <ul class="shop-tab-select">
                    <li class="<?php if($type == 'grid') echo 'active'?>"><a data-type="grid" href="<?php echo esc_url(sv_get_key_url('type','grid'))?>" class="load-shop-ajax grid-tab <?php echo esc_attr($grid_active)?>"></a></li>
                    <li class="<?php if($type == 'list') echo 'active'?>"><a data-type="list" href="<?php echo esc_url(sv_get_key_url('type','list'))?>" class="load-shop-ajax list-tab <?php echo esc_attr($list_active)?>"></a></li>
                </ul>
            </div>
            <ul class="product-content-list product-<?php echo esc_attr($type)?> clearfix" data-number="<?php echo esc_attr($number)?>" data-column="<?php echo esc_attr($column)?>" data-currency="<?php echo esc_attr(get_woocommerce_currency_symbol())?>"> 
        <?php
        $count_product = 1;
        if($product_query->have_posts()) {
            while($product_query->have_posts()) {
                $product_query->the_post();
                global $product;
                ?>
                <?php if($type == 'list'){
                    ?>
                    <li>
                        <div class="item-product">
                            <div class="row">
                                <?php
                                $sku = get_post_meta(get_the_ID(),'_sku',true);
                                $stock = get_post_meta(get_the_ID(),'_stock_status',true);
                                echo    '<div class="col-md-4 col-sm-4 col-xs-12">
                                            '.sv_product_thumb_hover_only().'
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <div class="product-info">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html().'
                                                <div class="product-code">
                                                    <label>'.esc_html("Item Code","aloshop").': </label> <span>#'.$sku.'</span>
                                                </div>
                                                <div class="product-stock">
                                                    <label>'.esc_html("Availability","aloshop").': </label> <span>'.$stock.'</span>
                                                </div>
                                                '.sv_product_links('list-view').'
                                            </div>
                                            <p class="product-desc">'.get_the_excerpt().'</p>
                                        </div>';
                                ?>
                            </div>
                        </div>
                    </li>
                <?php }
                else{
                    $b_col = 12;$col = 4;$size = array(268,322);
                    $col_option = $column;
                    if(!empty($col_option)) $col = $b_col/(int)$col_option;
                    if($col_option == 2) $size = array(268*1.5,322*1.5);
                    if($col_option == 1) $size = 'full';
                    if($count_product % $col_option == 1) $break_class = 'break-item';
                    else $break_class = '';
                    $li_class = 'col-md-'.$col.' col-sm-6 col-xs-12 '.$break_class;
                    if($col_option == 5 || $col_option == 7 || $col_option == 8){
                        $li_class = 'custom-item-col item-'.$count_product.' custom-item-col-'.$col_option.' '.$break_class;
                    }
                ?>
                    <li class="<?php echo esc_attr($li_class)?>">
                        <?php 
                            echo    '<div class="item-product">
                                        '.sv_product_thumb_hover($size).'
                                        <div class="product-info">
                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            '.sv_get_product_price().'
                                            '.sv_get_rating_html().'
                                        </div>
                                    </div>'
                        ?>
                    </li>
                <?php 
                $count_product++;
                }
            }
        }
        ?>
            </ul>
            <div class="sort-pagi-bar">
                <?php if(!is_cart() && !is_single()):?>
                    <div class="product-order">
                        <?php s7upf_catalog_ordering($product_query,$orderby)?>
                    </div>
                    <div class="product-per-page">
                        <a href="#" class="per-page-toggle"><?php esc_html_e("show","aloshop")?> <span><?php echo esc_attr($number)?></span></a>
                        <ul class="per-page-list">
                            <li><a data-number="<?php echo '6'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','6'))?>"><?php esc_html_e("6","aloshop")?></a></li>
                            <li><a data-number="<?php echo '9'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','9'))?>"><?php esc_html_e("9","aloshop")?></a></li>
                            <li><a data-number="<?php echo '12'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','12'))?>"><?php esc_html_e("12","aloshop")?></a></li>
                            <li><a data-number="<?php echo '18'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','18'))?>"><?php esc_html_e("18","aloshop")?></a></li>
                            <li><a data-number="<?php echo '24'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','24'))?>"><?php esc_html_e("24","aloshop")?></a></li>
                            <li><a data-number="<?php echo '48'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','48'))?>"><?php esc_html_e("48","aloshop")?></a></li>
                        </ul>
                    </div>
                <?php endif;?>
                <?php if($product_query->max_num_pages > 1){?>
                <div class="product-pagi-nav">
                    <?php
                        echo paginate_links( array(
                            'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
                            'format'       => '',
                            'add_args'     => '',
                            'current'      => max( 1, $paged ),
                            'total'        => $product_query->max_num_pages,
                            'prev_text'    => '<span class="lnr lnr-chevron-left"></span>',
                            'next_text'    => '<span class="lnr lnr-chevron-right"></span>',
                            'type'         => 'plain',
                            'end_size'     => 2,
                            'mid_size'     => 1
                        ) );
                    ?>
                </div>
                <?php }?>
            </div>
        </div>
        <?php
        $html .= ob_get_clean();
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_shop','s7upf_vc_shop');

vc_map( array(
    "name"      => esc_html__("SV Shop", 'aloshop'),
    "base"      => "sv_shop",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Grid",'aloshop')   => 'grid',
                esc_html__("List",'aloshop')   => 'list',
                ),
            ),
        array(
            'heading'     => esc_html__( 'Number', 'aloshop' ),
            'type'        => 'textfield',
            'description' => esc_html__( 'Enter number of product. Default is 12.', 'aloshop' ),
            'param_name'  => 'number',
            ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Order By",'aloshop'),
            "param_name" => "orderby",
            "value"         => array(
                esc_html__( 'Default sorting (custom ordering + name)', 'aloshop' ) => 'menu_order',
                esc_html__( 'Popularity (sales)', 'aloshop' )       => 'popularity',
                esc_html__( 'Average Rating', 'aloshop' )           => 'rating',
                esc_html__( 'Sort by most recent', 'aloshop' )      =>'date',
                esc_html__( 'Sort by price (asc)', 'aloshop' )      => 'price',
                esc_html__( 'Sort by price (desc)', 'aloshop' )     =>'price-desc',
                ),
            ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Column",'aloshop'),
            "param_name" => "column",
            "value"         => array(
                esc_html__("1 Column","aloshop")          => '1',
                esc_html__("2 Column","aloshop")          => '2',
                esc_html__("3 Column","aloshop")          => '3',
                esc_html__("4 Column","aloshop")          => '4',
                esc_html__("5 Column","aloshop")          => '5',
                esc_html__("6 Column","aloshop")          => '6',
                esc_html__("7 Column","aloshop")          => '7',
                esc_html__("8 Column","aloshop")          => '8',
                ),
            "dependency"    => array(
                "element"   => "style",
                "value"   => "grid",
                )
            ),
        ),
));