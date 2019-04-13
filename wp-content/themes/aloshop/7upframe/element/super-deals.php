<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
if(!function_exists('sv_vc_super_deals'))
{
    function sv_vc_super_deals($attr)
    {
        $html = $view_html = '';
        extract(shortcode_atts(array(
            'style'      => 'home-1',
            'title'      => '',
            'des'        => '',
            'adv_link'   => '',
            'img_adv'    => '',
            'time'       => '',
            'cats'       => '',
            'number'     => '',
            'view_link'  => '',
        ),$attr));
        wp_enqueue_script('timeCircles');
        $view_link = vc_build_link( $view_link );
        if(!empty($view_link['url']) && !empty($view_link['title'])){
            $view_html = '<a href="'.esc_url($view_link['url']).'" class="view-all-deal" data-hover="'.$view_link['title'].'"><span>'.$view_link['title'].'</span></a>';
        }
        $args = array(
            'post_type'=>'product',
            'posts_per_page'    =>$number,
            'meta_query'        => array(
                'relation'      => 'OR',
                array( // Simple products type
                    'key'           => '_sale_price',
                    'value'         => 0,
                    'compare'       => '>',
                    'type'          => 'numeric'
                ),
                array( // Variable products type
                    'key'           => '_min_variation_sale_price',
                    'value'         => 0,
                    'compare'       => '>',
                    'type'          => 'numeric'
                )
            )
        );
        if(!empty($cats)) {
            $custom_list = explode(",",$cats);
            $args['tax_query'][]=array(
                'taxonomy'=>'product_cat',
                'field'=>'slug',
                'terms'=> $custom_list
            );
        }
        $query = new WP_Query($args);
        $count_query = $query->post_count;
        $count = 1;
        $date_to = $time;
        switch ($style) {
            case 'list-page':
                $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
                $args['paged']  =   $paged;
                $query = new WP_Query($args);
                $html .=    '<div class="list-super-deal">
                                <div class="super-deal-content">
                                    <div class="row">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        global $product;
                        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                                sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s">%s</a>',
                                    esc_url( $product->add_to_cart_url() ),
                                    esc_attr( $product->get_id() ),
                                    esc_attr( $product->get_sku() ),
                                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button deal-shop-link' : '',
                                    esc_attr( $product->get_type() ),
                                    esc_html( $product->add_to_cart_text() )
                                ),
                            $product );
                        $html .=    '<div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item-deal-product">
                                            '.sv_product_thumb_hover(array(300,360)).'
                                            <div class="product-info">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <p class="desc">'.sv_substr(get_the_excerpt(),0,60).'</p>
                                                '.sv_get_product_price('sale').'
                                                <div class="deal-shop-social">
                                                    '.$button_html.'
                                                    <div class="social-deal social-network">
                                                        <ul>
                                                            <li><a href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'"><img width="40" height="40" alt="" src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/s1.png').'"></a></li>
                                                            <li><a href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'"><img width="40" height="40" alt="" src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/s2.png').'"></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                    }
                }
                $html .=            '</div>
                                </div>';
                $big = 999999999;
                $html .=        '<div class="post-paginav">';
                $html .=            paginate_links( array(
                                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                        'format'       => '&page=%#%',
                                        'current'      => max( 1, $paged ),
                                        'total'        => $query->max_num_pages,
                                        'prev_text' => '<i class="fa fa-angle-double-left"></i> '.esc_html__( 'Prev', 'aloshop' ),
                                        'next_text' => esc_html__( 'Next', 'aloshop' ).' <i class="fa fa-angle-double-right"></i>',
                                        'end_size'     => 2,
                                        'mid_size'     => 1
                                    ) );
                $html .=        '</div>';
                $html .=    '</div>';
                break;

            case 'mega-item':
                $html .=    '<div class="mega-hot-deal">
                                <h2 class="mega-menu-title">'.$title.'</h2>
                                <div class="mega-hot-deal-slider">
                                    <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        global $product;
                        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                                sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s">%s</a>',
                                    esc_url( $product->add_to_cart_url() ),
                                    esc_attr( $product->get_id() ),
                                    esc_attr( $product->get_sku() ),
                                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button deal-shop-link' : '',
                                    esc_attr( $product->get_type() ),
                                    esc_html( $product->add_to_cart_text() )
                                ),
                            $product );
                        $html .=    '<div class="item-deal-product">
                                        '.sv_product_thumb_hover(array(300,360)).'
                                        <div class="product-info">
                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <p class="desc">'.sv_substr(get_the_excerpt(),0,40).'</p>
                                            '.sv_get_product_price('sale').'
                                            <div class="deal-shop-social">
                                                '.$button_html.'
                                                <div class="social-deal social-network">
                                                    <ul>
                                                        <li><a href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'"><img width="40" height="40" alt="" src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/s1.png').'"></a></li>
                                                        <li><a href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'"><img width="40" height="40" alt="" src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/s2.png').'"></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                    }
                }            
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'home-12':
                if(!empty($cats)){
                    $pre = rand(1,100);
                    $tabs = explode(",",$cats);
                    $tab_html = $tab_content = '';
                    foreach ($tabs as $key => $tab) {
                        $term = get_term_by( 'slug',$tab, 'product_cat' );
                        if(!empty($term) && is_object($term)){
                            if($key == 0) $active = 'active';
                            else $active = '';
                            $tab_html .=    '<li class="'.$active.'"><a href="'.esc_url('#'.$pre.$term->slug).'" data-toggle="tab">'.$term->name.'</a></li>';
                            $tab_content .=    '<div role="tabpanel" class="tab-pane fade in '.$active.'" id="'.$pre.$term->slug.'">
                                                    <div class="hot-deal-slider slider-home2">
                                                        <div class="wrap-item">';
                            unset($args['tax_query']);
                            $args['tax_query'][]=array(
                                'taxonomy'=>'product_cat',
                                'field'=>'slug',
                                'terms'=> $tab
                            );
                            $product_query = new WP_Query($args);
                            $count_query = $product_query->post_count;
                            $count = 1;
                            if($product_query->have_posts()) {
                                while($product_query->have_posts()) {
                                    $product_query->the_post();
                                    global $product;
                                    $tab_content .=         '<div class="item">
                                                                <div class="item-hot-deal-product">
                                                                    <div class="hot-deal-product-thumb">
                                                                        '.sv_get_saleoff_html('home2').'
                                                                        '.sv_product_thumb_hover3(array(300,360)).'
                                                                    </div>
                                                                    <div class="hot-deal-product-info">
                                                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                        '.sv_get_product_price().'
                                                                    </div>
                                                                </div>
                                                            </div>';
                                }
                            }
                            $tab_content .=             '</div>
                                                    </div>
                                                </div>';
                        }
                    }
                    $html .=    '<div class="hot-deal-tab-slider hot-deal-tab-slider12">
                                    <div class="hot-deal-tab-countdown"  data-date="'.$time.'"></div>
                                    <div class="hot-deal-tab-title">
                                        <label>'.$title.'</label>
                                        <ul>
                                            '.$tab_html.'
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        '.$tab_content.'
                                    </div>
                                </div>';
                }
                break;

            case 'home-2':
                if(!empty($cats)){
                    $pre = rand(1,100);
                    $tabs = explode(",",$cats);
                    $tab_html = $tab_content = '';
                    foreach ($tabs as $key => $tab) {
                        $term = get_term_by( 'slug',$tab, 'product_cat' );
                        if(!empty($term) && is_object($term)){
                            if($key == 0) $active = 'active';
                            else $active = '';
                            $tab_html .=    '<li class="'.$active.'"><a href="'.esc_url('#'.$pre.$term->slug).'" data-toggle="tab">'.$term->name.'</a></li>';
                            $tab_content .=    '<div role="tabpanel" class="tab-pane fade in '.$active.'" id="'.$pre.$term->slug.'">
                                                    <div class="hot-deal-slider slider-home2">
                                                        <div class="wrap-item">';
                            unset($args['tax_query']);
                            $args['tax_query'][]=array(
                                'taxonomy'=>'product_cat',
                                'field'=>'slug',
                                'terms'=> $tab
                            );
                            $product_query = new WP_Query($args);
                            $count_query = $product_query->post_count;
                            $count = 1;
                            if($product_query->have_posts()) {
                                while($product_query->have_posts()) {
                                    $product_query->the_post();
                                    global $product;
                                    $tab_content .=         '<div class="item">
                                                                <div class="item-hot-deal-product">
                                                                    <div class="hot-deal-product-thumb">
                                                                        '.sv_get_saleoff_html('home2').'
                                                                        '.sv_product_thumb_hover3(array(300,360)).'
                                                                    </div>
                                                                    <div class="hot-deal-product-info">
                                                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                        '.sv_get_product_price().'
                                                                    </div>
                                                                </div>
                                                            </div>';
                                }
                            }
                            $tab_content .=             '</div>
                                                    </div>
                                                </div>';
                        }
                    }
                    $html .=    '<div class="hot-deal-tab-slider hot-deal-tab-slider2">
                                    <div class="hot-deal-tab-countdown"  data-date="'.$time.'"></div>
                                    <div class="hot-deal-tab-title">
                                        <label>'.$title.'</label>
                                        <ul>
                                            '.$tab_html.'
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        '.$tab_content.'
                                    </div>
                                </div>';
                }
                break;

            case 'home-9':
                $html .=    '<div class="box-trending8 box-trending9">
                                <div class="hot-deal-tab-countdown" data-date="'.$time.'"></div>
                                <h2><span>'.$title.'</span></h2>
                                <ul class="list-trending8 list-trending9">';
                $count = 1;
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        global $product;
                        $html .=    '<li class="item-trending3">
                                        '.sv_product_thumb_hover_only2(array(150,180)).'
                                        <div class="product-info3">
                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <p class="desc">'.sv_substr(get_the_excerpt(),0,20).'</p>
                                            '.sv_get_product_price().'
                                        </div>
                                    </li>';
                    }
                }
                $html .=        '</ul>
                            </div>';
                break;

            case 'home-8':
                if(!empty($cats)){
                    $cat = '';
                    $tabs = explode(",",$cats);
                    if(isset($tabs[0])) $cat = $tabs[0];
                    $html .=    '<div class="supper-deal-box8">
                                    <input type="hidden" class="data-load-ajax-deal" data-cat="'.$cat.'" data-number="'.$number.'"/>
                                    <div class="header-supper-deal8">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="deal-title8">
                                                    <h2>'.$title.'</h2>
                                                    <p>'.$des.'</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="deal-countdown8" data-date="'.$time.'"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-deal8">
                                        <div class="deal-cat-title">
                                            <ul>';
                            foreach ($tabs as $key => $tab) {
                                $term = get_term_by( 'slug',$tab, 'product_cat' );
                                $term_link = get_term_link( $term->term_id, 'product_cat' );
                                $thumb_cat_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                                if(!empty($term) && is_object($term)){
                                    if($key == 0) $active = 'active';
                                    else $active = '';
                                    $html .=    '<li class="'.$active.'">
                                                    <a data-cat="'.$term->slug.'" class="load-data-deal-home8" href="'.esc_url($term_link).'">'.$term->name.'</a>
                                                </li>';  
                                }
                            }
                    $html .=                '</ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="product-tab-slider">
                                                <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                                <div class="wrap-item">';
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
                            $html .=                '<div class="item">
                                                        <div class="item-product item-deal-product8">
                                                            '.sv_product_thumb_hover3(array(300,360)).'
                                                            '.sv_get_saleoff_html().'
                                                        </div>
                                                    </div>';
                        }
                    }
                    $html .=                     '</div>
                                            </div>
                                        </div>';
                    $html .=        '</div>
                                </div>';
                }
                break;

            case 'home-7':
                if(!empty($cats)){
                    $cat = '';
                    $tabs = explode(",",$cats);
                    if(isset($tabs[0])) $cat = $tabs[0];
                    $html .=    '<div class="great-deal">
                                    <h2>'.$title.'</h2>
                                    <h4>'.$des.'</h4>
                                    <div class="great-deal-countdown" data-date="'.$time.'"></div>
                                    <input type="hidden" class="data-load-ajax-deal" data-cat="'.$cat.'" data-number="'.$number.'"/>
                                    <ul class="list-cat-great-deal">';
                        foreach ($tabs as $key => $tab) {
                            $term = get_term_by( 'slug',$tab, 'product_cat' );
                            $term_link = get_term_link( $term->term_id, 'product_cat' );
                            $thumb_cat_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                            if(!empty($term) && is_object($term)){
                                if($key == 0) $active = 'active';
                                else $active = '';
                                $html .=    '<li class="'.$active.'">
                                                <a data-cat="'.$term->slug.'" class="load-data-deal" href="'.esc_url($term_link).'">    
                                                    '.wp_get_attachment_image($thumb_cat_id,array(60,60)).'
                                                    <span>'.$term->name.'</span>
                                                </a>
                                            </li>';  
                            }
                        }
                    $html .=        '</ul>
                                    <div class="great-deal-cat-slider slider-home3">
                                        <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                        <div class="wrap-item">';
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
                            $html .=    '<div class="item">
                                            <div class="item-product7">
                                                '.sv_product_thumb_hover2(array(300,360),'product-thumb7').'
                                                <div class="product-info7">
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html().'
                                                </div>
                                            </div>
                                        </div>';
                        }
                    }
                    $html .=            '</div>
                                    </div>
                                </div>';
                }
                break;

            case 'home-6':
                if(!empty($cats)){
                    $pre = rand(1,100);
                    $tabs = explode(",",$cats);
                    $tab_html = $tab_content = '';
                    foreach ($tabs as $key => $tab) {
                        $term = get_term_by( 'slug',$tab, 'product_cat' );
                        if(!empty($term) && is_object($term)){
                            if($key == 0) $active = 'active';
                            else $active = '';
                            $tab_html .=    '<li class="'.$active.'"><a href="'.esc_url('#'.$pre.$term->slug).'" data-toggle="tab">'.$term->name.'</a></li>';
                            $tab_content .=    '<div role="tabpanel" class="tab-pane fade in '.$active.'" id="'.$pre.$term->slug.'">
                                                    <div class="popular-cat-slider slider-home6">
                                                        <div class="wrap-item">';
                            unset($args['tax_query']);
                            $args['tax_query'][]=array(
                                'taxonomy'=>'product_cat',
                                'field'=>'slug',
                                'terms'=> $tab
                            );
                            $product_query = new WP_Query($args);
                            $count_query = $product_query->post_count;
                            $count = 1;
                            if($product_query->have_posts()) {
                                while($product_query->have_posts()) {
                                    $product_query->the_post();
                                    global $product;
                                    if($count % 2 == 1) $tab_content .=     '<div class="item">';
                                    $tab_content .=         '<div class="item-supperdeal">
                                                                '.sv_product_thumb_hover2(array(300,360),'product-thumb6').'                                                                
                                                                <div class="product-info6">
                                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                    '.sv_get_product_price().'
                                                                </div>
                                                            </div>';
                                    if($count % 2 == 0 || $count == $count_query) $tab_content .=     '</div>';
                                    $count++;
                                }
                            }
                            $tab_content .=             '</div>
                                                    </div>
                                                </div>';
                        }
                    }
                    $html .=    '<div class="supper-deal6">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <div class="supperdeal-sidebar">
                                                <div class="supperdeal-header">
                                                    <h2>'.$title.'</h2>
                                                    <span>'.$des.'</span>
                                                </div>
                                                <div class="supperdeal-tab">
                                                    <ul>
                                                        '.$tab_html.'
                                                    </ul>
                                                </div>
                                                <div class="supperdeal-countdown" data-date="'.$time.'"></div>
                                                <div class="item-adv-simple adv-home6">
                                                    <a href="'.esc_url($adv_link).'">'.wp_get_attachment_image($img_adv,'full').'</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-8 col-xs-12">
                                            <div class="tab-content">
                                                '.$tab_content.'
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                }
                break;

            case 'home-21':
                if(!empty($view_link['url']) && !empty($view_link['title'])){
                    $view_html = '<a href="'.esc_url($view_link['url']).'" class="viewall">'.$view_link['title'].'</a>';
                }
                $html .=    '<div class="hot-deal5 hot-deal21">
                                <h2>'.$title.'</h2>
                                <div class="hot-deal-slider5 simple-owl-slider slider-home5">
                                    <div class="wrap-item">';
                $args['meta_key'] = 'deals_time';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                $product_query = new WP_Query($args);
                $count_query = $query->post_count;
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        global $product;
                        $deals_time = get_post_meta(get_the_ID(),'deals_time',true);
                        if(!empty($deals_time)) $date_to = current_time( 'Y/m/d ' ).$deals_time;
                        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link addcart-single' : '',
                                esc_attr( $product->get_type() )
                            ),
                        $product );
                        $html .=    '<div class="item-hotdeal">
                                        <div class="hotdeal-countdown5" data-date="'.$date_to.'"></div>
                                        '.sv_product_thumb_hover(array(300,360)).'
                                        <div class="product-info5">
                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <ul>
                                                <li>
                                                    '.sv_get_product_price().'
                                                </li>
                                                <li>
                                                    '.sv_get_saleoff_html('home5').'
                                                </li>
                                                <li>
                                                    <span class="count-order">'.get_post_meta(get_the_iD(),'total_sales',true).' '.esc_html__("Order","aloshop").'</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>';
                    }
                }
                $html .=            '</div>';
                $html .=            '<a href="#" class="viewall">View All</a>';
                $html .=        '</div>
                            </div>';
                break;

            case 'home-5':
                $html .=    '<div class="hot-deal5">
                                <div class="special-slider-header">
                                    <h2 class="title-special">'.$title.'</h2>
                                </div>
                                <div class="hot-deal-slider5 simple-owl-slider slider-home5">
                                    <div class="wrap-item">';
                $args['meta_key'] = 'deals_time';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                $product_query = new WP_Query($args);
                $count_query = $query->post_count;
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        global $product;
                        $deals_time = get_post_meta(get_the_ID(),'deals_time',true);
                        if(!empty($deals_time)) $date_to = current_time( 'Y/m/d ' ).$deals_time;
                        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link addcart-single' : '',
                                esc_attr( $product->get_type() )
                            ),
                        $product );
                        $html .=    '<div class="item-hotdeal">
                                        <div class="hotdeal-countdown5" data-date="'.$date_to.'"></div>
                                        '.sv_product_thumb_hover(array(300,360)).'
                                        <div class="product-info5">
                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <ul>
                                                <li>
                                                    '.sv_get_product_price().'
                                                </li>
                                                <li>
                                                    '.sv_get_saleoff_html('home5').'
                                                </li>
                                                <li>
                                                    <span class="count-order">'.get_post_meta(get_the_iD(),'total_sales',true).' '.esc_html__("Order","aloshop").'</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>';
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'home-4':
                $html .=    '<div class="hot-deals">
                                <h2><i class="fa fa-clock-o"></i> '.$title.'</h2>
                                <div class="hotdeals-slider slider-home4 simple-owl-slider">
                                    <div class="wrap-item">';                
                $args['meta_key'] = 'deals_time';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
                $product_query = new WP_Query($args);
                $count_query = $query->post_count;
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        global $product;
                        $deals_time = get_post_meta(get_the_ID(),'deals_time',true);
                        if(!empty($deals_time)) $date_to = current_time( 'Y/m/d ' ).$deals_time;
                        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link addcart-single' : '',
                                esc_attr( $product->get_type() )
                            ),
                        $product );
                        if($count % 3 == 1) $html .=    '<div class="item"><ul class="list-product-hotdeal">';
                        $html .=    '<li>
                                        <div class="zoom-image-thumb product-thumb">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(100,120)).'</a>
                                            '.$button_html.'
                                        </div>
                                        <div class="product-info">
                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            '.sv_get_product_price().'
                                            <div class="hotdeal-countdown" data-date="'.$date_to.'"></div>
                                        </div>
                                    </li>';

                        if($count % 3 == 0 || $count == $count_query) $html .=       '</ul></div>';
                        $count++;
                    }
                }

                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'home-3':
                $html .=    '<div class="dealoff-theday">
                                <h2><span>'.$title.'</span></h2>
                                <div class="dealoff-countdown" data-date="'.$time.'"></div>
                                <div class="dealoff-theday-slider slider-home3">
                                    <div class="wrap-item">';
                if($query->have_posts()) {
                    while($query->have_posts()) {
                        $query->the_post();
                        global $product;
                        if($count % 2 == 1) $html .= '<div class="item-dealoff">';
                        $html .=        '<div class="item-product">
                                            '.sv_product_thumb_hover2(array(300,360)).'
                                            <div class="product-info3">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html().'
                                            </div>
                                        </div>';
                        if($count % 2 == 0 || $count == $count_query) $html .=  '</div>';
                        $count++;
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="super-deal">
                                <div class="super-deal-header">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="supper-deal-title">
                                                <h2>'.$title.'</h2>
                                                <p>'.$des.'</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="super-deal-countdown" data-date="'.$time.'"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="super-deal-content">
                                    <div class="row">';
                    if($query->have_posts()) {
                        while($query->have_posts()) {
                            $query->the_post();
                            global $product;
                            $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s">%s</a>',
                                        esc_url( $product->add_to_cart_url() ),
                                        esc_attr( $product->get_id() ),
                                        esc_attr( $product->get_sku() ),
                                        esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button deal-shop-link' : '',
                                        esc_attr( $product->get_type() ),
                                        esc_html( $product->add_to_cart_text() )
                                    ),
                                $product );
                            $html .=    '<div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item-deal-product">
                                                '.sv_product_thumb_hover(array(300,360)).'
                                                <div class="product-info">
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <p class="desc">'.sv_substr(get_the_excerpt(),0,60).'</p>
                                                    '.sv_get_product_price('sale').'
                                                    <div class="deal-shop-social">
                                                        <a href="'.esc_url(get_the_permalink()).'" class="deal-shop-link">'.esc_html__("shop now","aloshop").'</a>
                                                        <div class="social-deal social-network">
                                                            <ul>
                                                                <li><a href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'"><img width="40" height="40" alt="" src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/s1.png').'"></a></li>
                                                                <li><a href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'"><img width="40" height="40" alt="" src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/s2.png').'"></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                        }
                    }
                $html .=            '</div>
                                    '.$view_html.'
                                </div>
                            </div>';
                break;
        }        
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_super_deals','sv_vc_super_deals');
$check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_super_deals_admin',10,100 );
if ( ! function_exists( 'sv_super_deals_admin' ) ) {
    function sv_super_deals_admin(){
        vc_map( array(
            "name"      => esc_html__("SV Super Deals", 'aloshop'),
            "base"      => "sv_super_deals",
            "icon"      => "icon-st",
            "category"  => '7Up-theme',
            "params"    => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Style",'aloshop'),
                    "param_name" => "style",
                    "value" => array(
                        esc_html__("Home 1",'aloshop') => 'home-1',
                        esc_html__("Home 2",'aloshop') => 'home-2',
                        esc_html__("Home 3",'aloshop') => 'home-3',
                        esc_html__("Home 4",'aloshop') => 'home-4',
                        esc_html__("Home 5",'aloshop') => 'home-5',
                        esc_html__("Home 6",'aloshop') => 'home-6',
                        esc_html__("Home 7",'aloshop') => 'home-7',
                        esc_html__("Home 8",'aloshop') => 'home-8',
                        esc_html__("Home 9",'aloshop') => 'home-9',
                        esc_html__("Home 12",'aloshop') => 'home-12',
                        esc_html__("Mega item",'aloshop') => 'mega-item',
                        esc_html__("List page",'aloshop') => 'list-page',
                        esc_html__("Home 21",'aloshop') => 'home-21',
                        )
                ),
                array(
                    "type" => "textfield",
                    "holder" => "h3",
                    "heading" => esc_html__("Title",'aloshop'),
                    "param_name" => "title",
                ),
                array(
                    "type" => "textfield",
                    "holder" => "p",
                    "heading" => esc_html__("Description",'aloshop'),
                    "param_name" => "des",
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('home-1','home-6','home-8','home-7'),
                        )
                ),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Image Adv",'aloshop'),
                    "param_name" => "img_adv",
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('home-6'),
                        )
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Link Adv",'aloshop'),
                    "param_name" => "adv_link",
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('home-6'),
                        )
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Time CountDown",'aloshop'),
                    "param_name" => "time",
                    'description'   => esc_html__( 'EntertTime for countdown. Format is mm/dd/yyyy. Example: 12/15/2016.', 'aloshop' ),
                ),
                array(
                    'type'        => 'checkbox',
                    'heading'     => esc_html__( 'Product Category', 'aloshop' ),
                    'param_name'  => 'cats',
                    'value'       => sv_list_taxonomy('product_cat',false)
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Number",'aloshop'),
                    "param_name" => "number",
                ),
                array(
                    'heading'     => esc_html__( 'View link', 'aloshop' ),
                    'type'        => 'vc_link',
                    'param_name'  => 'view_link',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('home-1','home-21'),
                        )
                ),
            )
        ));
    }
}
//Home 7
add_action( 'wp_ajax_load_product_deal', 'sv_load_product_deal' );
add_action( 'wp_ajax_nopriv_load_product_deal', 'sv_load_product_deal' );
if(!function_exists('sv_load_product_deal')){
    function sv_load_product_deal() {
        $number         = $_POST['number'];
        $cat            = $_POST['cat'];
        $html = '';
        $args = array(
            'post_type'=>'product',
            'posts_per_page'    =>$number,
            'meta_query'        => array(
                'relation'      => 'OR',
                array( // Simple products type
                    'key'           => '_sale_price',
                    'value'         => 0,
                    'compare'       => '>',
                    'type'          => 'numeric'
                ),
                array( // Variable products type
                    'key'           => '_min_variation_sale_price',
                    'value'         => 0,
                    'compare'       => '>',
                    'type'          => 'numeric'
                )
            )
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
                $html .=    '<div class="item">
                                <div class="item-product7">
                                    '.sv_product_thumb_hover2(array(300,360),'product-thumb7').'
                                    <div class="product-info7">
                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        '.sv_get_product_price().'
                                        '.sv_get_rating_html().'
                                    </div>
                                </div>
                            </div>';
            }
        }
        echo balanceTags($html);
        wp_reset_postdata();
    }
}
//Home 8
add_action( 'wp_ajax_load_product_deal_home8', 'sv_load_product_deal_home8' );
add_action( 'wp_ajax_nopriv_load_product_deal_home8', 'sv_load_product_deal_home8' );
if(!function_exists('sv_load_product_deal_home8')){
    function sv_load_product_deal_home8() {
        $number         = $_POST['number'];
        $cat            = $_POST['cat'];
        $html = '';
        $args = array(
            'post_type'=>'product',
            'posts_per_page'    =>$number,
            'meta_query'        => array(
                'relation'      => 'OR',
                array( // Simple products type
                    'key'           => '_sale_price',
                    'value'         => 0,
                    'compare'       => '>',
                    'type'          => 'numeric'
                ),
                array( // Variable products type
                    'key'           => '_min_variation_sale_price',
                    'value'         => 0,
                    'compare'       => '>',
                    'type'          => 'numeric'
                )
            )
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
                $html .=    '<div class="item">
                                <div class="item-product item-deal-product8">
                                    '.sv_product_thumb_hover3(array(300,360)).'
                                    '.sv_get_saleoff_html().'
                                </div>
                            </div>';
            }
        }
        echo balanceTags($html);
        wp_reset_postdata();
    }
}
}