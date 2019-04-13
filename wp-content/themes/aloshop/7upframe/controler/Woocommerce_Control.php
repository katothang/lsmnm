<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
/*********************************** ADD TO CART AJAX *******************************************/
if(class_exists("woocommerce")){
	add_action( 'wp_ajax_add_to_cart', 'sv_minicart_ajax' );
	add_action( 'wp_ajax_nopriv_add_to_cart', 'sv_minicart_ajax' );
	if(!function_exists('sv_minicart_ajax')){
		function sv_minicart_ajax() {
			
			$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
			$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
			$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

			if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity ) ) {
				do_action( 'woocommerce_ajax_added_to_cart', $product_id );
				WC_AJAX::get_refreshed_fragments();
			} else {
				$this->json_headers();

				// If there was an error adding to the cart, redirect to the product page to show any errors
				$data = array(
					'error' => true,
					'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
					);
				echo json_encode( $data );
			}
			die();
		}
	}
	/*********************************** END ADD TO CART AJAX ****************************************/

    /*********************************** BEGIN UPDATE CART AJAX ****************************************/
    
    add_action( 'wp_ajax_update_mini_cart', 's7upf_update_mini_cart' );
    add_action( 'wp_ajax_nopriv_update_mini_cart', 's7upf_update_mini_cart' );
    if(!function_exists('s7upf_update_mini_cart')){
        function s7upf_update_mini_cart() {
            WC_AJAX::get_refreshed_fragments();
            die();
        }
    }
    /*********************************** END UPDATE CART  AJAX ****************************************/
    
	/********************************** Shop ajax ************************************/

    add_action( 'wp_ajax_load_shop', 's7upf_load_shop' );
    add_action( 'wp_ajax_nopriv_load_shop', 's7upf_load_shop' );
    if(!function_exists('s7upf_load_shop')){
        function s7upf_load_shop() {
            $data_filter = $_POST['filter_data'];
            extract($data_filter);            
            $paged = ( isset($page) ) ? absint( $page ) : 1;
            $args = array(
                'post_type'         => 'product',
                'post_status'       => 'publish',
                'order'             => 'ASC',
                'posts_per_page'    => $number,
                'paged'             => $paged,
            );
            if(isset($s)) if(!empty($s)){
                $args['s'] = $s;
                $args['order'] = 'DESC';
            }
            $attr_taxquery = array();
            if(!empty($attributes)){                
                $attr_taxquery['relation'] = 'AND';
                foreach($attributes as $attr => $term){
                    $attr_taxquery[] =  array(
                                            'taxonomy'      => $attr,
                                            'terms'         => $term,
                                            'field'         => 'slug',
                                            'operator'      => 'IN'
                                        );
                }
            }
            if(!empty($cats)) {
                $attr_taxquery[]=array(
                    'taxonomy'=>'product_cat',
                    'field'=>'slug',
                    'terms'=> $cats
                );
            }
            if ( !empty($attr_taxquery)){                
                $args['tax_query'] = $attr_taxquery;
            }
            if( isset( $price['min']) && isset( $price['max']) ){
                $min = $price['min'];
                $max = $price['max'];
                if($max != $max_price || $min != $min_price) $args['post__in'] = sv_filter_price($min,$max);
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
            ?>

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
                                            '.sv_get_saleoff_html().'
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
            wp_reset_postdata();
        }
    }

    /********************************** REMOVE ITEM MINICART AJAX ************************************/

	add_action( 'wp_ajax_product_remove', 'sv_product_remove' );
	add_action( 'wp_ajax_nopriv_product_remove', 'sv_product_remove' );
	if(!function_exists('sv_product_remove')){
		function sv_product_remove() {
		    global $wpdb, $woocommerce;
		    $cart_item_key = $_POST['cart_item_key'];
		    if ( $woocommerce->cart->get_cart_item( $cart_item_key ) ) {
				$woocommerce->cart->remove_cart_item( $cart_item_key );
			}
		    WC_AJAX::get_refreshed_fragments();
            die();
		}
	}

	//remove woo breadcrumbs
    add_action( 'init','sv_remove_wc_breadcrumbs' );
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

    // Remove page title
    add_filter( 'woocommerce_show_page_title', 'sv_remove_page_title');

	// remove action wrap main content
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    // Custom wrap main content
    add_action('woocommerce_before_main_content', 'sv_add_before_main_content', 10);
    add_action('woocommerce_after_main_content', 'sv_add_after_main_content', 10);

    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
   	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
   	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

    update_option('yith_woocompare_compare_button_in_product_page','no');
    add_filter( 'yith_wcwl_positions', 'sv_wcwl_positions', 100, 2 );
    if(!function_exists('sv_wcwl_positions')){
        function sv_wcwl_positions($data){
            if(isset($data['add-to-cart']['hook'])) $data['add-to-cart']['hook'] = '';
            return $data;
        }
    }

   	add_filter( 'woocommerce_get_price_html', 'sv_change_price_html', 100, 2 );

    function sv_add_before_main_content() {
        $col_class = 'shop-width-'.sv_get_option('woo_shop_column',3);
        global $count_product;
        $count_product = 1;
        global $wp_query;
        $cats = '';
        if(isset($wp_query->query_vars['product_cat'])) $cats = $wp_query->query_vars['product_cat'];
        ?>
        <?php sv_display_breadcrumb();?>
        <div id="main-content" class="content-shop <?php echo esc_attr($col_class);?>" data-cats="<?php echo esc_attr($cats);?>">
            <div class="container">            	            
                <div class="row">
                	<?php sv_output_sidebar('left')?>
                	<div class="<?php echo esc_attr(sv_get_main_class()); ?>">
                		<div class="main-content-shop">
                            <?php do_action('content_append_before')?>
                			<?php sv_header_slider_shop()?>
                			<?php echo sv_list_cat_shop()?>
        <?php
    }

    function sv_add_after_main_content() {
        ?>
                		</div>
                	</div>
                	<?php sv_output_sidebar('right')?>
            	</div>
            </div>
        </div>
        <?php
    }

    function sv_remove_wc_breadcrumbs()
    {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    }

    function sv_remove_page_title() {
        return false;
    }
    if(!function_exists('sv_change_price_html')){
    	function sv_change_price_html($price, $product){
    		$price = str_replace('&ndash;', '<span class="slipt">&ndash;</span>', $price);
            $show_mode = sv_check_catelog_mode();
            $hide_price = sv_get_option('hide_price');
            if($show_mode == 'on' && $hide_price == 'on') $price = '';
    		return $price;
    	}
    }
	/********************************* END REMOVE ITEM MINICART AJAX *********************************/

	/********************************** FANCYBOX POPUP CONTENT ************************************/

	add_action( 'wp_ajax_product_popup_content', 'sv_product_popup_content' );
	add_action( 'wp_ajax_nopriv_product_popup_content', 'sv_product_popup_content' );
	if(!function_exists('sv_product_popup_content')){
		function sv_product_popup_content() {
			$product_id = $_POST['product_id'];
			$query = new WP_Query( array(
				'post_type' => 'product',
				'post__in' => array($product_id)
				));
			if( $query->have_posts() ):
				echo '<div class="woocommerce single-product product-popup-content"><div class="product has-sidebar">';
				while ( $query->have_posts() ) : $query->the_post();	
					global $post,$product,$woocommerce;			
					sv_product_main_detai(true);
				endwhile;
				echo '</div></div>';
			endif;
			wp_reset_postdata();
		}
	}
	//Custom woo shop column
    add_filter( 'loop_shop_columns', 'sv_woo_shop_columns', 1, 10 );
    function sv_woo_shop_columns( $number_columns ) {
        $col = sv_get_option('woo_shop_column',3);
        return $col;
    }
    add_filter( 'loop_shop_per_page', 'sv_woo_shop_number', 20 );
    function sv_woo_shop_number( $number) {
        $col = sv_get_option('woo_shop_number',12);
        return $col;
    }

    add_filter( 'woocommerce_loop_add_to_cart_link', 'sv_custom_add_to_cart_link' );
    if(!function_exists('sv_custom_add_to_cart_link')){
    	function sv_custom_add_to_cart_link($content){
    		$show_mode = sv_check_catelog_mode();
    		if($show_mode == 'on') $content = '';
    		return $content;
    	}
    }
    // Add the code below to your theme's functions.php file to add a confirm password field on the register form under My Accounts.
    $gen_pas = get_option( 'woocommerce_registration_generate_password' );
    if($gen_pas != 'yes'){
        add_filter('woocommerce_registration_errors', 'sv_registration_errors_validation', 10,3);
        function sv_registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
            global $woocommerce;
            extract( $_POST );
            if(isset($password2)){
                if ( strcmp( $password, $password2 ) !== 0 ) {
                    return new WP_Error( 'registration-error', esc_html__( 'Passwords do not match.', 'aloshop' ) );
                }
            }
            return $reg_errors;
        }

        add_action( 'woocommerce_register_form', 'sv_register_form_password_repeat' );
        function sv_register_form_password_repeat() {
            ?>
            <p class="form-row form-row-wide">
                <label for="reg_password2"><?php esc_html_e( 'Password Repeat', 'aloshop' ); ?> <span class="required">*</span></label>
                <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
            </p>
            <?php
        }
    }
    // Gitem filter
    add_filter('vc_gitem_add_link_param', 's7upf_add_grid_link');
    if(!function_exists('s7upf_add_grid_link')){
        function s7upf_add_grid_link($data){
            $data['value'][esc_html__( 'Wishlist link', 'lucky' )] = 'wishlist';
            $data['value'][esc_html__( 'Compare link', 'lucky' )] = 'compare';
            $data['value'][esc_html__( 'Quick view link', 'lucky' )] = 'quickview';
            return $data;
        }
    }
    add_filter( 'vc_gitem_post_data_get_link_link', 's7upf_gitem_post_data_get_link_link',10,2 );
    if(!function_exists('s7upf_gitem_post_data_get_link_link')){
        function s7upf_gitem_post_data_get_link_link($link, $atts, $css_class){
            if ( isset( $atts['link'] )){
                switch ($atts['link']) {
                    case 'compare':
                        $link = 'a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( array('action' => 'yith-woocompare-add-product','id' => '' )))).'={{ woocommerce_product:id }}" class="product-compare compare compare-link vc_gitem-link vc_icon_element-link" data-product_id="{{ woocommerce_product:id }}"></a';
                        break;
                    
                    case 'wishlist':
                        if(class_exists('YITH_WCWL_Init')) $link = 'a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', '' ))).'={{ woocommerce_product:id }}" class="add_to_wishlist wishlist-link vc_gitem-link vc_icon_element-link" data-product-id="{{ woocommerce_product:id }}"></a';
                        break;

                    case 'quickview':
                        $link = 'a data-product-id="{{ woocommerce_product:id }}" href="{{ woocommerce_product_link }}" class="product-quick-view quickview-link vc_gitem-link vc_icon_element-link"></a';
                        break;

                    default:
                        
                        break;
                }
            }
            return $link;
        }
    }

    add_filter( 'vc_gitem_template_attribute_woocommerce_product', 's7upf_gitem_template_attribute_woocommerce_product', 100, 99 );
    function s7upf_gitem_template_attribute_woocommerce_product($value, $data){
        extract( array_merge( array(
            'post' => null,
            'data' => ''
        ), $data ) );
        $atts = array();
        parse_str( $data, $atts );
        $html = '';
        switch ($data) {
            case 'ratting_html':
                $id = $post->ID;
                $product = wc_get_product( $id );
                $star = $product->get_average_rating();
                $review_count = $product->get_review_count();
                $width = $star / 5 * 100;
                $html .=    '<div class="product-rate">
                                <div class="product-rating" style="width:'.$width.'%;"></div>';
                $html .=    '</div>';
                return $html;
                break;

            case 'ratting_hover':
                $id = $post->ID;
                $product = wc_get_product( $id );
                $star = $product->get_average_rating();
                $review_count = $product->get_review_count();
                $width = $star / 5 * 100;
                $html .=    '<div class="product-rate gitem-hover">
                                <div class="product-rating" style="width:'.$width.'%;"></div>';
                $html .=    '</div>';
                return $html;
                break;

            case 'quick_view_hover':
                $id = $post->ID;
                $html = '<a data-product-id="'.esc_attr($id).'" href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link quickview-gitem-hover"><i class="fa fa-search" aria-hidden="true"></i></a>';
                return $html;
                break;

            case 'meta_links_html':
                $id = $post->ID;
                $product = wc_get_product( $id );
                $html .=    '<div class="product-extra-link product-extra-link-hover hidden-text product">
                                <a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( array('action' => 'yith-woocompare-add-product','id' => $product->get_id() )))).'" class="product-compare compare compare-link vc_gitem-link vc_icon_element-link" data-product_id="'.esc_attr($product->get_id()).'"><i class="fa fa-file-o" aria-hidden="true"></i><span>'.esc_html__("Compare","lucky").'</span></a>
                                '.s7upf_addtocart_link($product).'
                                '.s7upf_wishlist_link($product->get_id()).'
                            </div>';
                return $html;
                break;

            case 'hover-overlay':
                return '<div class="product-extra-overlay"></div>';
                break;

            case 's7upf_price_html':
                $id = $post->ID;
                $product = wc_get_product( $id );
                return '<div class="info-price">'.$product->get_price_html().'</div>';
                break;

            case 'product_html':
                $id = $post->ID;
                $product = wc_get_product( $id );
                $html =     '<div class="item">
                                <div class="item-product">
                                    '.sv_product_thumb_hover(array(268,268),$product).'
                                </div>
                            </div>';
                return $html;
                break;

            case 'product_html2':
                $id = $post->ID;
                $product = wc_get_product( $id );
                $html = '';
                return $html;
                break;

            case 'product_html3':
                $id = $post->ID;
                $product = wc_get_product( $id );
                $html = '';
                return $html;
                break;
            
            default:
                return $value;
                break;
        }   
    }

    add_filter( 'woocommerce_product_tabs', 's7upf_custom_product_tab', 98 );
    if(!function_exists('s7upf_custom_product_tab')){
        function s7upf_custom_product_tab( $tabs ) {
            $data_tabs = get_post_meta(get_the_ID(),'s7upf_product_tab_data',true);
            if(!empty($data_tabs) and is_array($data_tabs)){
                foreach ($data_tabs as $key=>$data_tab){
                    $tabs['s7upf_custom_tab_' . $key] = array(
                        'title' => (!empty($data_tab['title']) ? $data_tab['title'] : $key),
                        'priority' => (!empty($data_tab['priority']) ? (int)$data_tab['priority'] : 50),
                        'callback' => 's7upf_render_tab',
                        'content' => apply_filters('the_content', $data_tab['tab_content']) //this allows shortcodes in custom tabs
                    );
                }
            }
            return $tabs;
        }

    }

        

    if(!function_exists('s7upf_render_tab')){

        function s7upf_render_tab($key, $tab) {

            echo apply_filters('s7upf_product_custom_tab_content', $tab['content'], $tab, $key);

        }

    }
}