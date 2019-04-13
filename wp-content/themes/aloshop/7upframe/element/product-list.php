<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 05/09/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
if(!function_exists('sv_vc_product_list'))
{
    function sv_vc_product_list($attr, $content = false)
    {
        $html = $view_html = '';
        extract(shortcode_atts(array(
            'style'         => 'trendding',
            'title'         => '',
            'number'        => '8',
            'cats'          => '',
            'order_by'      => 'date',
            'order'         => 'DESC',
            'product_type'  => '',
            'brands'        => '',
            'prices'        => '',
            'attributes'        => '',
            'view_link'     => '',
            'time'     => '',
            'image_adv'     => '',
            'link_adv'     => '',
        ),$attr));
        $custom_list = array();
        $args = array(
            'post_type'         => 'product',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
            'paged'             => 1,
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
            $args['tax_query'][] =  array(
                                        'taxonomy' => 'product_visibility',
                                        'field'    => 'name',
                                        'terms'    => 'featured',
                                        'operator' => 'IN',
                                    );
        }
        if(!empty($cats)) {
            $custom_list = explode(",",$cats);
            $args['tax_query'][]=array(
                'taxonomy'=>'product_cat',
                'field'=>'slug',
                'terms'=> $custom_list
            );
        }
        $product_query = new WP_Query($args);
        $count = 1;
        $count_query = $product_query->post_count;
        $view_link = vc_build_link( $view_link );
        if(!empty($view_link['url']) && !empty($view_link['title'])){
            $view_html = '<a href="'.esc_url($view_link['url']).'" class="viewall3">'.$view_link['title'].'</a>';
        }
        switch ($style) {
            case 'list-slider-home24-2':
                if(!empty($view_link['url']) && !empty($view_link['title'])){
                    $view_html = '<a href="'.esc_url($view_link['url']).'" class="button24">'.$view_link['title'].'</a>';
                }
                $html .=    '<div class="block-product24">';
                if(!empty($title)){
                    $html .=    '<div class="intro-product-box24">';
                    if(!empty($title)) $html .=    '<h2>'.esc_html($title).'</h2>';
                    $html .= $view_html;
                    $html .=    '</div>';
                }
                $html .=        '<div class="slider-product24">
                                    <div class="wrap-item smart-slider" data-item="" data-speed="" 
                                        data-itemres="0:1,480:2,640:3,990:4,1200:5,1500:6" 
                                        data-prev="" data-next="" 
                                        data-pagination="" data-navigation="true">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=        '<div class="item-product24">
                                            <div class="product-thumb">
                                                <a href="'.get_the_permalink().'" class="product-thumb-link">
                                                    '.get_the_post_thumbnail(get_the_ID(),array(200,240)).'
                                                </a>
                                                '.sv_product_links2().'
                                                '.sv_get_saleoff_html('home24').'
                                            </div>
                                            <div class="product-info">
                                                <h3 class="title-product"><a href="'.get_the_permalink().'">'.get_the_title().' </a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html().'
                                            </div>
                                        </div>';
                    }
                }
                $html .=            '</div>
                                </div>';
                $html .=    '</div>';
                break;

            case 'list-slider-home24':
                if(!empty($view_link['url']) && !empty($view_link['title'])){
                    $view_html = '<a href="'.esc_url($view_link['url']).'" class="button24">'.$view_link['title'].'</a>';
                }
                $html .=    '<div class="block-deal24 clearfix block-product24">';
                if(!empty($title) || !empty($time)){
                    $html .=    '<div class="deal-day24 text-center intro-product-box24">';
                    if(!empty($title)) $html .=    '<h2>'.esc_html($title).'</h2>';
                    if(!empty($title)) $html .=    '<div class="deal-the-day24" data-date="'.esc_attr($time).'"></div>';
                    $html .= $view_html;
                    $html .=    '</div>';
                }
                $html .=        '<div class="slider-product24">
                                    <div class="wrap-item smart-slider" data-item="" data-speed="" 
                                        data-itemres="0:1,480:2,990:3,1200:4,1500:5" 
                                        data-prev="" data-next="" 
                                        data-pagination="" data-navigation="true">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=        '<div class="item-product24">
                                            <div class="product-thumb">
                                                <a href="'.get_the_permalink().'" class="product-thumb-link">
                                                    '.get_the_post_thumbnail(get_the_ID(),array(200,240)).'
                                                </a>
                                                '.sv_product_links2().'
                                                '.sv_get_saleoff_html('home24').'
                                            </div>
                                            <div class="product-info">
                                                <h3 class="title-product"><a href="'.get_the_permalink().'">'.get_the_title().' </a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html().'
                                            </div>
                                        </div>';
                    }
                }
                $html .=            '</div>
                                </div>';
                if(!empty($image_adv)) $html .= '<div class="deal-adv24">
                                                    <a href="'.esc_url($link_adv).'">'.wp_get_attachment_image($image_adv,'full').'</a>
                                                </div>';
                $html .=    '</div>';
                break;

            case 'tab-cat-home18':
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

            case 'mega-item':
                $html .=    '<div class="mega-new-arrival">
                                <h2 class="mega-menu-title">'.$title.'</h2>
                                <div class="mega-new-arrival-slider">
                                    <div class="wrap-item">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=    '<div class="item">
                                        <div class="item-product">
                                            '.sv_product_thumb_hover2(array(300,360)).'
                                            <div class="product-info">
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
                break;

            case 'tab-slider-home12':
                if(!empty($cats)){
                    $pre = rand(1,100);
                    $tabs = explode(",",$cats);
                    $tab_html = $tab_content = '';
                    foreach ($tabs as $key => $tab) {
                        $term = get_term_by( 'slug',$tab, 'product_cat' );
                        if(!empty($term) && is_object($term)){
                            if($key == 0) $active = 'active';
                            else $active = '';
                            $tab_html .=    '<li class="'.$active.'"><a href="'.esc_url('#'.$pre.$term->slug).'" data-toggle="tab" aria-expanded="true">'.$term->name.'</a></li>';
                            $tab_content .=    '<div role="tabpanel" class="tab-pane fade in '.$active.'" id="'.$pre.$term->slug.'">
                                                    <div class="popular-cat-slider popular-cat-slider12 slider-home5">
                                                        <div class="wrap-item">';
                            unset($args['tax_query']);
                            $args['tax_query'][]=array(
                                'taxonomy'=>'product_cat',
                                'field'=>'slug',
                                'terms'=> $tab
                            );
                            $product_query = new WP_Query($args);
                            if($product_query->have_posts()) {
                                while($product_query->have_posts()) {
                                    $product_query->the_post();
                                    global $product;
                                        $tab_content .= '<div class="item">
                                                            <div class="item-product5">
                                                                '.sv_product_thumb_hover2(array(300,360)).'
                                                                <div class="product-info5">
                                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                    '.sv_get_product_price().'
                                                                    '.sv_get_rating_html().'
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
                    $html .=    '<div class="content-popular12">
                                    <div class="popular-cat-title popular-cat-label">
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

            case 'list-sidebar-home2':
                $html .=    '<div class="product-bestseller-slider">
                                <h2>'.$title.'</h2>
                                <div class="slider-home2">
                                    <div class="wrap-item">';
                $count = 1;
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        if($count % 2 == 1) $html .=    '<div class="item">';
                        $html .=        '<div class="item-product-bestseller">
                                            '.sv_product_thumb_hover_only2(array(150,180)).'
                                            <div class="product-info2">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html('rating-style2').'
                                            </div>
                                        </div>';
                        if($count % 2 == 0 || $count == $count_query) $html .=    '</div>';
                        $count++;
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'list-sidebar-home8-2':
                $html .=    '<div class="box-trending8 box-border">
                                <h2><span>'.$title.'</span></h2>
                                <ul class="list-trending8">';
                $count = 1;
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
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

            case 'list-sidebar-home8':
                $html .=    '<div class="box-trending8">
                                <h2><span>'.$title.'</span></h2>
                                <ul class="list-trending8">';
                $count = 1;
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
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

            case 'product-filter':
                $pre =  rand(1,100);
                $cat = '';
                if(!empty($cats)) $cat = $custom_list[0];
                if(!empty($cat)){
                    unset($args['tax_query']);
                    $args['tax_query'][]=array(
                        'taxonomy'=>'product_cat',
                        'field'=>'slug',
                        'terms'=> $cat
                    );
                    $product_query = new WP_Query($args);
                }
                $max_page = $product_query->max_num_pages;
                $html .=    '<div class="new-product-filter">
                                <div class="header-product-filter">
                                    <h2>
                                        <span>'.$title.'</span>
                                        <a href="#" class="toggle-link-filter"><i class="fa fa-filter"></i> '.esc_html__("filter","aloshop").'</a>
                                    </h2>
                                    '.sv_product_filter_box($prices,$attributes).'
                                </div>';
                $html .=    '<div class="category-tab-filter">
                                <div class="category-filter-title">
                                    <ul>';
                $tabs = explode(",",$cats);
                if(is_array(($tabs))){
                    foreach ($tabs as $key => $tab) {
                        $term = get_term_by( 'slug',$tab, 'product_cat' );
                        if(!empty($term) && is_object($term)){
                            if($key == 0) $active = 'active';
                            else $active = '';
                            $html .=    '<li><a class="load-data-filter '.$active.'" href="#" data-cat="'.$term->slug.'">'.$term->name.' </a></li>';
                        }
                    }
                }
                $html .=            '</ul>
                                </div>';
                $html .=        '<div class="category-filter-content">
                                    <div class="tab-content">
                                        <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                        <div class="row">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=    '<div class="col-md-3 col-sm-4 col-xs-6">
                                        <div class="item-product-filter">
                                            '.sv_product_thumb_hover2(array(300,360),'product-thumb6').'                                            
                                            <div class="product-info6">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                            </div>
                                            '.sv_get_saleoff_html().'
                                        </div>
                                    </div>';
                    }
                }
                $html .=                '</div>';
                if($max_page > 1) $f_class= '';
                else $f_class= 'first-hidden';
                $html .=    '<a data-tag="" data-attribute="" data-term=""  data-price="" data-cat="'.$cat.'" data-number="'.$number.'"  data-order="'.$order.'" data-orderby="'.$order_by.'" data-paged="1"  data-maxpage="'.$max_page.'" data-product_type="'.$product_type.'" href="#" class="loadmore-item loadmore-product-filter '.$f_class.'">'.esc_html__("Load more items","aloshop").'</a>';
                $html .=            '</div>
                                </div>
                            </div></div>';

                break;

            case 'tab-cat-home5':
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
                                                    <div class="brand-cat-slider slider-home5">
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
                                    $tab_content .=     '<div class="item">
                                                            <div class="item-product5">
                                                                '.sv_product_thumb_hover2(array(300,360)).'
                                                                <div class="product-info5">
                                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                    '.sv_get_product_price().'
                                                                    '.sv_get_rating_html().'
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
                    $html .=    '<div class="cat-brand">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <div class="sidebar-cat-brand">
                                                <h2 class="title-special">'.$title.'</h2>
                                                <div class="category-brand-slider">
                                                    <div class="wrap-item">';
                                parse_str( urldecode( $brands ), $data);
                                if(is_array($data)){
                                    foreach ($data as $key => $value) {
                                        $html .=        '<div class="item">
                                                            <div class="item-category-brand">
                                                                <a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>
                                                            </div>
                                                        </div>';
                                    }
                                }
                    $html .=                        '</div>
                                                </div>
                                                <ul class="sidebar-cat-childrent">
                                                    '.$tab_html.'
                                                </ul>
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

            case 'hot-category':
                $html .=    '<div class="hot-category">';
                if(!empty($title)) $html .=    '<h2 class="title-special">'.$title.'</h2>';
                $html .=        '<ul class="listcategory-hot list-shop-cat">';
                if(!empty($cats)){
                    foreach ($custom_list as $key => $cat) {
                        $term = get_term_by( 'slug',$cat, 'product_cat' );
                        if(!empty($term) && is_object($term)){
                            if(!empty($term) && is_object($term)){
                                $term_link = get_term_link( $term->term_id, 'product_cat' );
                                $html .=    '<li><a href="'.esc_url($term_link).'">'.$term->name.' <span>'.$term->count.'</span></a></li>';
                            }
                        }
                    }
                }
                                    
                $html .=        '</ul>
                                <div class="hot-category-slider popular-cat-slider slider-home5">
                                    <div class="wrap-item">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=    '<div class="item">
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
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'list-sidebar':
                $html .=    '<div class="special-slider">';
                if(!empty($title)) $html .=    '<div class="special-slider-header">
                                                    <h2 class="title-special">'.$title.'</h2>
                                                </div>';
                $html .=        '<div class="special-slider-content simple-owl-slider slider-home5">
                                    <div class="wrap-item">';
                $count = 1;
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        if($count % 4 == 1) $html .=    '<div class="item-special"><ul>';
                        $html .=        '<li>
                                            '.sv_product_thumb_hover_only2(array(150,180)).'
                                            <div class="product-info5">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html().'
                                            </div>
                                        </li>';
                        if($count % 4 == 0 || $count == $count_query) $html .=    '</ul></div>';
                        $count++;
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'tab-cat':
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
                                                    <div class="best-seller-slider slider-home4">
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
                                    if($count % 5 == 1 || $count % 5 == 0 ) $tab_content .= '<div class="item">';
                                    if($count % 5 == 0){
                                        $tab_content .= '<div class="item-best-seller item-leading">
                                                            <div class="zoom-image-thumb">
                                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(450,540)).'</a>
                                                                '.sv_get_product_price().'
                                                            </div>
                                                        </div>';
                                    }
                                    else{
                                        $tab_content .= '<div class="item-best-seller">
                                                            <div class="zoom-image-thumb">
                                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(200,240)).'</a>
                                                                '.sv_get_product_price().'
                                                            </div>
                                                        </div>';
                                    }
                                    if($count % 5 == 0 || $count % 5 == 4 || $count == $count_query) $tab_content .= '</div>';
                                    $count++;
                                }
                            }
                            $tab_content .=             '</div>
                                                    </div>
                                                </div>';
                        }
                    }
                    $html .=    '<div class="best-seller-tab-slider">
                                    <div class="best-seller-header">
                                        <h2 class="title">'.$title.'</h2>
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

            case 'home4':
                $html .=    '<div class="list-product-new">
                                <div class="row">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=    '<div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="item-product">
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
                $html .=        '</div>
                            </div>';
                break;

            case 'home4-slider':
                $html .=    '<div class="list-product-new list-product-slider-home4 slider-home5">';
                if(!empty($title)) $html .=    '<h2 class="title">'.$title.'</h2>';
                $html .=        '<div class="row">
                                    <div class="wrap-item">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        if($count % 2 == 1) $html .=    '<div class="item">';
                        $html .=        '<div class="item-product">
                                            '.sv_product_thumb_hover(array(300,360)).'
                                            <div class="product-info">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html().'
                                            </div>
                                            '.sv_get_saleoff_html().'
                                        </div>';
                        if($count % 2 == 0 || $count == $count_query) $html .=    '</div>';
                        $count++;
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'list-slider-home21':
                $html .=    '<div class="best-seller3 slider-home3 product-box21">';
                if(!empty($title)) $html .=    '<h2><span>'.$title.'</span></h2>';
                $html .=        '<div class="wrap-item">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=    '<div class="item">
                                        <div class="item-product3">
                                            '.sv_product_thumb_hover2(array(300,360)).'
                                            <div class="product-info3">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html().'
                                            </div>
                                        </div>
                                    </div>';
                    }
                }
                $html .=        '</div>
                                '.$view_html.'
                            </div>';
                break;

            case 'bestsell-home3':
                $html .=    '<div class="best-seller3 slider-home3">';
                if(!empty($title)) $html .=    '<h2><span>'.$title.'</span></h2>';
                $html .=        '<div class="wrap-item">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=    '<div class="item">
                                        <div class="item-product3">
                                            '.sv_product_thumb_hover2(array(300,360)).'
                                            <div class="product-info3">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                                '.sv_get_rating_html().'
                                            </div>
                                        </div>
                                    </div>';
                    }
                }
                $html .=        '</div>
                                '.$view_html.'
                            </div>';
                break;

            default:
                $html .=    '<div class="box-trending3">';
                if(!empty($title)) $html .=    '<h2><span>'.$title.'</span></h2>';
                $html .=        '<ul class="list-trending3">';
                if($product_query->have_posts()) {
                    while($product_query->have_posts()) {
                        $product_query->the_post();
                        global $product;
                        $html .=    '<li class="item-trending3">
                                        '.sv_product_thumb_hover_only2(array(100,120)).'
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
        }
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_product_list','sv_vc_product_list');
$check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_add_list_product',10,100 );
if ( ! function_exists( 'sv_add_list_product' ) ) {
    function sv_add_list_product(){
        vc_map( array(
            "name"      => esc_html__("SV Product list", 'aloshop'),
            "base"      => "sv_product_list",
            "icon"      => "icon-st",
            "category"  => '7Up-theme',
            "params"    => array(
                array(
                    'heading'     => esc_html__( 'Style', 'aloshop' ),
                    'holder'      => 'div',
                    'type'        => 'dropdown',
                    'description' => esc_html__( 'Choose style to display.', 'aloshop' ),
                    'param_name'  => 'style',
                    'value'       => array(
                        esc_html__('Trendding Home 3','aloshop') => 'trendding',
                        esc_html__('BestSeller Home 3','aloshop') => 'bestsell-home3',
                        esc_html__('List Sidebar home 2','aloshop') => 'list-sidebar-home2',
                        esc_html__('Home 4','aloshop') => 'home4',
                        esc_html__('Home 4 slider','aloshop') => 'home4-slider',
                        esc_html__('Tab Categorys','aloshop') => 'tab-cat',
                        esc_html__('List Sidebar','aloshop') => 'list-sidebar',
                        esc_html__('Hot category home 5','aloshop') => 'hot-category',
                        esc_html__('Tab category home 5','aloshop') => 'tab-cat-home5',
                        esc_html__('Product Filter','aloshop') => 'product-filter',
                        esc_html__('List Sidebar home 8(Trendding)','aloshop') => 'list-sidebar-home8',
                        esc_html__('List Sidebar home 8','aloshop') => 'list-sidebar-home8-2',
                        esc_html__('Tab slider home 12','aloshop') => 'tab-slider-home12',
                        esc_html__('Mega item','aloshop') => 'mega-item',
                        esc_html__('Tab category home 18','aloshop') => 'tab-cat-home18',
                        esc_html__('List Slider home 21','aloshop') => 'list-slider-home21',
                        esc_html__('List Slider home 24','aloshop') => 'list-slider-home24',
                        esc_html__('List Slider home 24(2)','aloshop') => 'list-slider-home24-2',
                        )
                ),                
                array(
                    'heading'     => esc_html__( 'Title', 'aloshop' ),
                    'holder'      => 'h4',
                    'type'        => 'textfield',
                    'param_name'  => 'title',
                ),
                array(
                    'heading'     => esc_html__( 'Image adv', 'aloshop' ),
                    'type'        => 'attach_image',
                    'param_name'  => 'image_adv',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('list-slider-home24'),
                        )
                ),
                array(
                    'heading'     => esc_html__( 'Image link', 'aloshop' ),
                    'type'        => 'textfield',
                    'param_name'  => 'link_adv',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('list-slider-home24'),
                        )
                ),
                array(
                    'heading'     => esc_html__( 'Time', 'aloshop' ),
                    'type'        => 'textfield',
                    'param_name'  => 'time',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('list-slider-home24'),
                        )
                ),
                array(
                    'heading'     => esc_html__( 'Number', 'aloshop' ),
                    'type'        => 'textfield',
                    'description' => esc_html__( 'Enter number of product. Default is 8.', 'aloshop' ),
                    'param_name'  => 'number',
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
                    'holder'     => 'div',
                    'heading'     => esc_html__( 'Product Categories', 'aloshop' ),
                    'type'        => 'checkbox',
                    'param_name'  => 'cats',
                    'value'       => sv_list_taxonomy('product_cat',false)
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Order By', 'aloshop' ),
                    'value' => sv_get_order_list(),
                    'param_name' => 'orderby',
                    'description' => esc_html__( 'Select Orderby Type ', 'aloshop' ),
                    'edit_field_class'=>'vc_col-sm-6 vc_column',
                ),
                array(
                    'heading'     => esc_html__( 'Order', 'aloshop' ),
                    'type'        => 'dropdown',
                    'param_name'  => 'order',
                    'value' => array(                   
                        esc_html__('Desc','aloshop')  => 'DESC',
                        esc_html__('Asc','aloshop')  => 'ASC',
                    ),
                    'description' => esc_html__( 'Select Order Type ', 'aloshop' ),
                    'edit_field_class'=>'vc_col-sm-6 vc_column',
                ),                
                array(
                    'heading'     => esc_html__( 'View link', 'aloshop' ),
                    'type'        => 'vc_link',
                    'param_name'  => 'view_link',
                    'dependency'  => array(
                        'element'   => 'style',
                        'value'   => array('bestsell-home3','list-slider-home21','list-slider-home24','list-slider-home24-2'),
                        )
                ),                
                array(
                    "type" => "add_brand",
                    "heading" => esc_html__("Product Brand",'aloshop'),
                    "param_name" => "brands",
                    "group" => esc_html__("Brands",'aloshop'),
                    "dependency"    => array(
                        "element"   => 'style',
                        "value"   => 'tab-cat-home5',
                        )
                ),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Prices",'aloshop'),
                    "param_name" => "prices",
                    "group" => esc_html__("Filter",'aloshop'),
                    "dependency"    => array(
                        "element"   => 'style',
                        "value"   => 'product-filter',
                        )
                ),
                array(
                    "type" => "checkbox",
                    "heading" => esc_html__("Attribute",'aloshop'),
                    "param_name" => "attributes",
                    "group" => esc_html__("Filter",'aloshop'),
                    "value" => sv_get_attr_product_list(),
                    "dependency"    => array(
                        "element"   => 'style',
                        "value"   => 'product-filter',
                        )
                ),
            )
        ));
    }
}
//Home 6
add_action( 'wp_ajax_load_more_product_filter', 'sv_load_more_product_filter' );
add_action( 'wp_ajax_nopriv_load_more_product_filter', 'sv_load_more_product_filter' );
if(!function_exists('sv_load_more_product_filter')){
    function sv_load_more_product_filter() {
        $number         = $_POST['number'];
        $order_by       = $_POST['orderby'];
        $order          = $_POST['order'];
        $product_type   = $_POST['product_type'];
        $cat            = $_POST['cat'];
        $tag            = $_POST['tag'];
        $attribute      = $_POST['attribute'];
        $paged          = $_POST['paged'];
        $price          = $_POST['price'];
        $term           = $_POST['term'];
        $args = array(
            'post_type'         => 'product',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
            'paged'             => 1,
        );
        if(!empty($product_type)){
            switch ($product_type) {
                case 'trendding':
                    $args['meta_query'][] = array(
                        'key'     => 'trending_product',
                        'value'   => 'on',
                        'compare' => '=',
                    );
                    break;

                case 'toprate':
                    $args['meta_key'] = '_wc_average_rating';
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_query'] = WC()->query->get_meta_query();
                    $args['tax_query'][] = WC()->query->get_tax_query();
                    break;

                case 'mostview':
                    $args['meta_key'] = 'post_views';
                    $args['orderby'] = 'meta_value_num';
                    break;

                case 'bestsell':
                    $args['meta_key'] = 'total_sales';
                    $args['orderby'] = 'meta_value_num';
                    break;

                case 'onsale':
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
                    break;

                case 'featured':
                    $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                    break;

                case 'price-asc' :
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
                    add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
                break;

                case 'rating' :
                    $args['meta_key'] = '_wc_average_rating';
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_query'] = WC()->query->get_meta_query();
                    $args['tax_query'][] = WC()->query->get_tax_query();
                break;
                
                default:
                    # code...
                    break;
            }
        }
        if(!empty($attribute) && !empty($term)){
            $args['tax_query']['relation'] = 'AND';
            $args['tax_query'][] =  array(
                                        'taxonomy'      => $attribute,
                                        'terms'         => $term,
                                        'field'         => 'slug',
                                        'operator'      => 'IN'
                                    );
        }
        if(!empty($price)){
            $price_filter = explode(',', $price);
            $min = $price_filter[0];
            $max = $price_filter[1];
            $args['post__in'] = sv_filter_price($min,$max);
        }
        if(!empty($cat)) {
            $args['tax_query'][]=array(
                'taxonomy'  => 'product_cat',
                'field'     => 'slug',
                'terms'     => $cat
            );
        }
        if(!empty($tag)) {
            $args['tax_query'][]=array(
                'taxonomy'  => 'product_tag',
                'field'     => 'slug',
                'terms'     => $tag
            );
        }
        $product_query = new WP_Query($args);
        $max_page = $product_query->max_num_pages;
        $html = '';
        if($product_query->have_posts()) {
            while($product_query->have_posts()) {
                $product_query->the_post();
                global $product;
                $html .=    '<div class="col-md-3 col-sm-4 col-xs-12">
                                <div class="item-product-filter">
                                    '.sv_product_thumb_hover2(array(300,360),'product-thumb6').'                                            
                                    <div class="product-info6">
                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        '.sv_get_product_price().'
                                    </div>
                                    '.sv_get_saleoff_html().'
                                </div>
                            </div>';
            }            
            $html .=    '<input id="current-maxpage" type="hidden" value="'.$max_page.'">';
        }
        echo balanceTags($html);
        wp_reset_postdata();
    }
}
//Home 6
add_action( 'wp_ajax_load_more_product_filter_button', 'sv_load_more_product_filter_button' );
add_action( 'wp_ajax_nopriv_load_more_product_filter_button', 'sv_load_more_product_filter_button' );
if(!function_exists('sv_load_more_product_filter_button')){
    function sv_load_more_product_filter_button() {
        $number         = $_POST['number'];
        $order_by       = $_POST['orderby'];
        $order          = $_POST['order'];
        $product_type   = $_POST['product_type'];
        $cat            = $_POST['cat'];
        $tag            = $_POST['tag'];
        $attribute      = $_POST['attribute'];
        $paged          = $_POST['paged'];
        $price          = $_POST['price'];
        $term           = $_POST['term'];
        $args = array(
            'post_type'         => 'product',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
            'paged'             => (int)$paged+1,
        );
        if(!empty($product_type)){
            switch ($product_type) {
                case 'trendding':
                    $args['meta_query'][] = array(
                        'key'     => 'trending_product',
                        'value'   => 'on',
                        'compare' => '=',
                    );
                    break;

                case 'toprate':
                    $args['meta_key'] = '_wc_average_rating';
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_query'] = WC()->query->get_meta_query();
                    $args['tax_query'][] = WC()->query->get_tax_query();
                    break;

                case 'mostview':
                    $args['meta_key'] = 'post_views';
                    $args['orderby'] = 'meta_value_num';
                    break;

                case 'bestsell':
                    $args['meta_key'] = 'total_sales';
                    $args['orderby'] = 'meta_value_num';
                    break;

                case 'onsale':
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
                    break;

                case 'featured':
                    $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                    break;

                case 'price-asc' :
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
                    add_filter( 'posts_clauses', array( $this, 'order_by_popularity_post_clauses' ) );
                break;

                case 'rating' :
                    $args['meta_key'] = '_wc_average_rating';
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_query'] = WC()->query->get_meta_query();
                    $args['tax_query'][] = WC()->query->get_tax_query();
                break;
                
                default:
                    # code...
                    break;
            }
        }
        if(!empty($attribute) && !empty($term)){
            $args['tax_query']['relation'] = 'AND';
            $args['tax_query'][] =  array(
                                        'taxonomy'      => $attribute,
                                        'terms'         => $term,
                                        'field'         => 'slug',
                                        'operator'      => 'IN'
                                    );
        }
        if(!empty($price)){
            $price_filter = explode(',', $price);
            $min = $price_filter[0];
            $max = $price_filter[1];
            $args['post__in'] = sv_filter_price($min,$max);
        }
        if(!empty($cat)) {
            $args['tax_query'][]=array(
                'taxonomy'  => 'product_cat',
                'field'     => 'slug',
                'terms'     => $cat
            );
        }
        if(!empty($tag)) {
            $args['tax_query'][]=array(
                'taxonomy'  => 'product_tag',
                'field'     => 'slug',
                'terms'     => $tag
            );
        }
        $product_query = new WP_Query($args);
        $max_page = $product_query->max_num_pages;
        $html = '';
        if($product_query->have_posts()) {
            while($product_query->have_posts()) {
                $product_query->the_post();
                global $product;
                $html .=    '<div class="col-md-3 col-sm-4 col-xs-6">
                                <div class="item-product-filter">
                                    '.sv_product_thumb_hover2(array(300,360),'product-thumb6').'                                            
                                    <div class="product-info6">
                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        '.sv_get_product_price().'
                                    </div>
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