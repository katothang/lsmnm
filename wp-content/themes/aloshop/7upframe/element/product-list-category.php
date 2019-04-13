<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 05/09/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
    if(!function_exists('sv_vc_product_category'))
    {
        function sv_vc_product_category($attr, $content = false)
        {
            $html = $el_class = $html_wl = $html_cp = '';
            extract(shortcode_atts(array(
                'style'             => 'home-1',
                'cat'               => '',
                'cat_number'        => '4',
                'color'             => 'red-box',
                'color4'            => 'red-box',
                'color2'            => '',
                'color3'            => 'red-box7',
                'content_pos'       => 'right',
                'icon'              => '',
                'image'             => '',
                'image_side'        => '',
                'image_side2'       => '',
                'image_link'        => '',
                'image_link2'       => '',
                'brands'            => '',
                'advs'              => '',
                'number'            => '',
                'order'             => 'DESC',
                'order_by'          => 'date',
                'types_fillter'     => '',
                'type_home7'        => 'bestsell',
                'title'             => '',
                'tags'              => '',
                'link'              => '',
                'view_more'         => '',
                'el_class'         => '',
            ),$attr));            
            $term = get_term_by( 'slug',$cat, 'product_cat' );
            if(!empty($term) && is_object($term)){
                $term_link = get_term_link( $term->term_id, 'product_cat' );
                $term_childrents = get_term_children( $term->term_id, 'product_cat' );
                $args=array(
                    'post_type'         => 'product',
                    'posts_per_page'    => $number,
                    'orderby'           => $order_by,
                    'order'             => $order
                );
                $args['tax_query'][]=array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $cat
                );
                if($style != 'home-1' || $style != 'home-3'){
                    switch ($type_home7) {
                        case 'mostview':
                            $args['orderby'] = 'meta_value_num';
                            $args['meta_key'] = 'post_views';
                            break;

                        case 'bestsell':
                            $args['meta_key'] = 'total_sales';
                            $args['orderby'] = 'meta_value_num';
                            break;

                        case 'onsale':
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
                            break;

                        case 'featured':
                            $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                            break;

                        case 'mostreview':
                            $args['meta_key'] = '_wc_average_rating';
                            $args['orderby'] = 'meta_value_num';
                            $args['meta_query'] = WC()->query->get_meta_query();
                            $args['tax_query'][] = WC()->query->get_tax_query();
                            break;

                        case 'newarrival':
                            $args['order'] = 'DESC';
                            $args['orderby'] = 'date';
                            break;
                        
                        default:
                            $args['order'] = 'DESC';
                            $args['orderby'] = 'date';
                            break;
                    }
                }
                $query = new WP_Query($args);
                $pre = rand(1,100);
                $cat_count = 1;
                $cat_number = (int)$cat_number;
                switch ($style) {
                    case 'home-19':
                        $html .=    '<div class="featured-product2 '.$color3.' clearfix featured-product-cat '.$el_class.'">
                                        <div class="featured-product-sidebar">
                                            <h2 class="title-cat-parent">'.$term->name.'</h2>';
                        $html .=        '<ul class="list-cat-childrent">';
                                foreach ($term_childrents as $term_child) {
                                    $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                    if(is_object($term_childrent) && $cat_number > 0){
                                        $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                        $thumb_cat_id = get_woocommerce_term_meta( $term_childrent->term_id, 'thumbnail_id', true );
                                        $html .=    '<li>
                                                        <a href="'.esc_url($term_childrent_link).'">
                                                            '.wp_get_attachment_image($thumb_cat_id,array(30,30)).'
                                                            <span>'.$term_childrent->name.'</span>
                                                        </a>
                                                    </li>';
                                    }                                
                                    if($cat_count >= $cat_number) break;
                                    $cat_count ++;
                                }
                        $html .=            '</ul>';                        
                        $html .=        '</div>
                                        <div class="featured-product-content">';
                        $html .=            '<div class="featured-list-brand">
                                                <ul>';
                                parse_str( urldecode( $brands ), $data);
                                if(is_array($data)){
                                    foreach ($data as $key => $value) {
                                        $html .=   '<li><a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a></li>';
                                    }
                                }
                        $html .=                '</ul>
                                            </div>';
                        $html .=            '<div class="main-featured-product clearfix">
                                                <div class="main-featured-left">
                                                    <div class="adv-featured-product item-adv-simple">
                                                        <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                                    </div>
                                                    <div class="list-featured-product">';
                        $args2=array(
                            'post_type'         => 'product',
                            'orderby'           => $order_by,
                            'order'             => $order
                        );
                        $args2['tax_query'][]=array(
                            'taxonomy'  => 'product_cat',
                            'field'     => 'slug',
                            'terms'     => $cat
                        );
                        $args2['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        $args2['posts_per_page'] = 2;
                        $post_f = array();
                        $query = new WP_Query($args2);
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $post_f[] = get_the_ID();
                                $html .=    '<div class="item-featured-product">
                                                <div class="featured-product-info product-info2">
                                                    <div class="featured-info-sale">
                                                        '.sv_get_saleoff_html('home7').'
                                                        <label class="new">'.esc_html__("New","aloshop").'</label>
                                                    </div>
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html(true,'rating-style2').'
                                                </div>
                                                <div class="featured-product-thumb">
                                                    '.sv_product_thumb_hover3(array(150,180)).'
                                                </div>
                                            </div>';
                            }
                        }
                        $html .=                    '</div>
                                                </div>';
                        $html .=                '<div class="main-featured-right">
                                                    <div class="best-seller-right slider-home2">
                                                        <h2>'.$title.'</h2>
                                                        <div class="wrap-item">';
                        $args['post__not_in'] = $post_f;
                        $query = new WP_Query($args);
                        $count_query = $query->post_count;
                        $count = 1;
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                if($count % 3 == 1) $html .=    '<div class="item">';
                                $html .=    '<div class="item-product-right">
                                                '.sv_product_thumb_hover_only2(array(150,180)).'
                                                <div class="product-info">
                                                    <h3 class="title-product">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a>
                                                    </h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html(true,'rating-style2').'
                                                </div>
                                            </div>';
                                if($count % 3 == 0 || $count == $count_query) $html .=    '</div>';
                                $count++;
                            }
                        }
                        $html .=                        '</div>
                                                    </div>
                                                </div>';
                        $html .=            '</div>';
                        $html .=        '</div>';
                        if(!empty($tags)){
                            $html .=        '<div class="tags-featured-product">
                                                <label><i class="fa fa-tags"></i> '.esc_html__("tags","aloshop").':</label>';
                            $tags_list = explode(',', $tags);
                            foreach ($tags_list as $tag) {
                                $tag_obj = get_term_by( 'slug',$tag, 'product_tag' );
                                if(!empty($tag_obj) && is_object($tag_obj)){
                                    $tag_link = get_term_link( $tag_obj->term_id, 'product_tag' );
                                    $html .=    '<a href="'.esc_url($tag_link).'">'.$tag_obj->name.'</a>';
                                }
                            }
                            $html .=        '</div>';
                        }
                        $html .=    '</div>';
                        break;

                    case 'home-12':
                        $html .=    '<div class="clearfix category-product-featured featured-product12 '.$color.' '.$el_class.'">                        
                                        <input type="hidden" class="data-load-ajax" data-cat="'.$term->slug.'" data-number="'.$number.'" data-order="'.$order.'" data-orderby="'.$order_by.'" data-product_type="" />
                                    <div class="category-home-total">
                                        <div class="category-home-label">
                                            <a class="load-product-data-home12 cat-parent" href="'.esc_url($term_link).'" data-cat="'.$term->slug.'">
                                                '.wp_get_attachment_image($icon,'full').'
                                                <span>'.$term->name.'</span>
                                            </a>
                                        </div>
                                        <div class="category-filter-slider">
                                            <div class="wrap-item">';
                            $types_fillter = explode(',', $types_fillter);
                            if(in_array('bestsell', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data-home12" href="#" data-product_type="bestsell">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-best.png').'" alt="" />
                                                                    <span>'.esc_html__("Best seller","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('mostview', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data-home12" href="#" data-product_type="mostview">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-view.png').'" alt="" />
                                                                    <span>'.esc_html__("Most View","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('featured', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data-home12" href="#" data-product_type="featured">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-special.png').'" alt="" />
                                                                    <span>'.esc_html__("Special","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('newarrival', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data-home12" href="#" data-product_type="newest">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-new.png').'" alt="" />
                                                                    <span>'.esc_html__("New Arrivals","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('mostreview', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data-home12" href="#" data-product_type="mostreview">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-review.png').'" alt="" />
                                                                    <span>'.esc_html__("Most Review","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('onsale', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data-home12" href="#"  data-product_type="onsale">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-sale.png').'" alt="" />
                                                                    <span>'.esc_html__("Sale","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';    
                            $html .=        '</div>
                                        </div>
                                        <div class="list-child-category">
                                            <ul>';
                                            foreach ($term_childrents as $term_child) {
                                                $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                                if(is_object($term_childrent) && $cat_number > 0){
                                                    $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                                    $html .=    '<li><a class="load-product-data-home12" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a></li>';
                                                }
                                                if($cat_count >= $cat_number) break;
                                                $cat_count ++;
                                            }
                            $html .=        '</ul>
                                        </div>
                                        <div class="category-brand-slider">
                                            <div class="wrap-item">';
                            parse_str( urldecode( $brands ), $data);
                            if(is_array($data)){
                                foreach ($data as $key => $value) {
                                    $html .=   '<div class="item">
                                                        <div class="item-category-brand">
                                                            <a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>
                                                        </div>
                                                    </div>';
                                }
                            }                    
                            $html .=        '</div>
                                        </div>
                                    </div>
                                    <div class="banner-home-category">
                                        <div class="slide-home-banner owl-directnav">
                                            <div class="wrap-item">';
                            parse_str( urldecode( $advs ), $data);
                            if(is_array($data)){
                                foreach ($data as $key => $value) {
                                    $html .=   '<div class="item-home-banner">
                                                    <div class="home-banner-thumb">
                                                        <a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>
                                                    </div>
                                                    <div class="home-banner-info">
                                                        <p>'.$value['des'].'</p>
                                                    </div>
                                                </div>';
                                }
                            }   
                            $html .=        '</div>
                                        </div>
                                    </div>
                                    <div class="featured-product-category">
                                        <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                        <div class="wrap-item">';
                            $count = 1;
                            $count_query = $query->post_count;
                            if($query->have_posts()) {
                                while($query->have_posts()) {
                                    $query->the_post();
                                    global $product;
                                    if($count % 2 == 1) $html .=    '<div class="item">';
                                    $html .=        '<div class="item-category-featured-product">
                                                        '.sv_product_thumb_hover(array(300,360)).'
                                                        <div class="product-info">
                                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                            '.sv_get_product_price().'
                                                        </div>
                                                        '.sv_get_saleoff_html().'
                                                    </div>';
                                    if($count % 2 == 0 || $count == $count_query) $html .=    '</div>';
                                    $count++;
                                }
                            }
                            $html .=    '</div>
                                    </div>
                                </div>';
                        break;

                    case 'home-11':
                        $view_cat_link = '';
                        if($view_more == 'yes') $view_cat_link = '<div class="super-deal-content"><a href="'.esc_url($term_link).'" class="view-all-deal" data-hover="'.esc_html__("View More","aloshop").'"><span>'.esc_html__("View More","aloshop").'</span></a></div>';
                        $html .=    '<div class="content-popular11 '.$el_class.'">
                                        <input type="hidden" class="data-load-ajax" data-cat="'.$term->slug.'" data-number="'.$number.'" data-order="'.$order.'" data-orderby="'.$order_by.'" data-product_type="'.$type_home7.'" />
                                        <div class="popular-cat-title">
                                            <ul>
                                                <li class="active"><a class="load-product-data-home11" href="'.esc_url($term_link).'" data-cat="'.$term->slug.'">'.$term->name.'</a></li>';
                        if(!empty($term_childrents)){
                            foreach ($term_childrents as $term_child) {
                                $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                if(is_object($term_childrent) && $cat_number > 0){
                                $html .=        '<li><a class="load-product-data-home11" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a></li>';
                                }
                                if($cat_count >= $cat_number) break;
                                $cat_count ++;
                            }
                        }
                        $html .=            '</ul>
                                        </div>
                                        <div class="popular-cat-slider11 slider-home5">
                                            <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                            <div class="wrap-item">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $html .=        '<div class="item">
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
                                            '.$view_cat_link.'
                                        </div>
                                    </div>';
                        break;

                    case 'home-10':
                        $html .=    '<div class="box-category10 '.$color4.' clearfix '.$el_class.'">
                                        <input type="hidden" class="data-load-ajax" data-cat="'.$term->slug.'" data-number="'.$number.'" data-order="'.$order.'" data-orderby="'.$order_by.'" data-product_type="'.$type_home7.'" />
                                        <div class="content-left-category-hover">
                                            <h2 class="title-box10 load-product-data-home10" data-cat="'.$term->slug.'">'.$term->name.'</h2>';
                        if(!empty($term_childrents)){
                            $html .=        '<ul class="list-category-hover">';
                            foreach ($term_childrents as $term_child) {
                                $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                $thumb_cat_id = get_woocommerce_term_meta( $term_childrent->term_id, 'thumbnail_id', true );
                                if(is_object($term_childrent) && $cat_number > 0){
                                $html .=        '<li><a class="load-product-data-home10" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.wp_get_attachment_image($thumb_cat_id,array(20,21)).$term_childrent->name.'</a></li>';
                                }
                                if($cat_count >= $cat_number) break;
                                $cat_count ++;
                            }
                            $html .=        '</ul>';
                        }
                        if(!empty($brands)){
                            parse_str( urldecode( $brands ), $data);
                            $html .=        '<div class="category-brand-slider">
                                                <div class="wrap-item">';
                            if(is_array($data)){
                                foreach ($data as $key => $value) {
                                    $html .=        '<div class="item-cat-brand">
                                                        <a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>
                                                    </div>';
                                }
                            }
                            $html .=            '</div>
                                            </div>';
                        }
                        $html .=        '</div>';
                        $html .=        '<div class="banner-category-hover">
                                            <div class="banner-cat-hover-thumb">
                                                <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                            </div>
                                            <div class="banner-cat-hover-info">
                                                '.wpb_js_remove_wpautop($content, true).'
                                            </div>
                                        </div>';
                        $html .=        '<div class="wrap-cat-hover">
                                            <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                            <div class="cat-hover-content">';
                        $count = 1;$block_left = $block_right = '';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                if($count % 2 == 1){
                                    $block_left .=  '<div class="item-large-cat-hover">
                                                        <div class="large-cat-info">
                                                            '.sv_get_saleoff_html('home2').'
                                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                            '.sv_get_product_price().'
                                                        </div>
                                                        <div class="large-cat-thumb">
                                                            '.sv_product_thumb_hover3(array(300,360)).'
                                                        </div>
                                                    </div>';
                                }
                                else{
                                    $block_right .= '<div class="item-small-cat-hover">
                                                        <div class="small-cat-thumb">
                                                            '.sv_product_thumb_hover3(array(300,360)).'
                                                        </div>
                                                        <div class="small-cat-info">
                                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                            '.sv_get_product_price().'
                                                        </div>
                                                    </div>';
                                }
                                $count++;
                            }
                        }
                        $html .=                '<div class="large-cat-hover">
                                                    '.$block_left.'
                                                </div>
                                                <div class="small-cat-hover">
                                                    '.$block_right.'
                                                </div>';
                        $html .=            '</div>
                                        </div>';
                        $html .=    '</div>';
                        break;

                    case 'home-9-2':
                        $html .=    '<div class="category-adv home-9 '.$color4.' clearfix content-'.$content_pos.' '.$el_class.'">
                                        <input type="hidden" class="data-load-ajax" data-cat="'.$term->slug.'" data-number="'.$number.'" data-order="'.$order.'" data-orderby="'.$order_by.'" data-product_type="'.$type_home7.'" />';
                        if($content_pos == 'right'){
                            $html .=        '<div class="category-adv-sidebar adv-sidebar9">
                                                <h2 class="title-cat-parent load-product-data-home9" data-cat="'.$term->slug.'">'.$term->name.'</h2>
                                                <div class="content-featured-product-sidebar">';
                            if(!empty($term_childrents)){
                                $html .=                '<ul class="sidebar-cat-childrent">';
                                foreach ($term_childrents as $term_child) {
                                    $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                    $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                    if(is_object($term_childrent) && $cat_number > 0){
                                    $html .=                '<li><a class="load-product-data-home9" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a></li>';
                                    }
                                    if($cat_count >= $cat_number) break;
                                    $cat_count ++;
                                }
                                $html .=                '</ul>';
                            }
                            if( !empty($image)){
                            $html .=                '<div class="item-adv-simple">
                                                        <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                                    </div>';
                            }                    
                            $html .=            '</div>
                                            </div>';
                        }
                        $html .=        '<div class="category-adv-content">';
                        $html .=            '<div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                            <div class="list-product-cat list-home-92 clearfix">';
                        if(!empty($brands)){
                            parse_str( urldecode( $brands ), $data);
                            $html .=        '<div class="cat-brand-slider slider-home2">
                                                <div class="wrap-item">';
                            if(is_array($data)){
                                foreach ($data as $key => $value) {
                                    $html .=        '<div class="item-cat-brand">
                                                        <a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>
                                                    </div>';
                                }
                            }
                            $html .=            '</div>
                                            </div>';
                        }
                        $html .=            '<div class="list-img-video">
                                                <div class="zoom-image-thumb video-image-thumb">
                                                    <a href="'.esc_url($image_link).'">'.wp_get_attachment_image($image_side,'full').'</a>
                                                </div>
                                                <div class="zoom-image-thumb">
                                                    <a href="'.esc_url($image_link2).'">'.wp_get_attachment_image($image_side2,'full').'</a>
                                                </div>
                                            </div>';
                        $html .=            '</div>
                                        </div>';
                        if($content_pos == 'left'){
                            $html .=        '<div class="category-adv-sidebar adv-sidebar9">
                                                <h2 class="title-cat-parent load-product-data-home9" data-cat="'.$term->slug.'">'.$term->name.'</h2>
                                                <div class="content-featured-product-sidebar">';
                            if(!empty($term_childrents)){
                                $html .=                '<ul class="sidebar-cat-childrent">';
                                foreach ($term_childrents as $term_child) {
                                    $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                    $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                    if(is_object($term_childrent) && $cat_number > 0){
                                    $html .=                '<li><a class="load-product-data-home9" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a></li>';
                                    }
                                    if($cat_count >= $cat_number) break;
                                    $cat_count ++;
                                }
                                $html .=                '</ul>';
                            }
                            if( !empty($image)){
                            $html .=                '<div class="item-adv-simple">
                                                        <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                                    </div>';
                            }                    
                            $html .=            '</div>
                                            </div>';
                        }
                        if(!empty($tags)){
                            $html .=    '<div class="tags-featured-product">
                                            <label><i class="fa fa-tags"></i> '.esc_html__("tags","aloshop").':</label>';
                            $tags_list = explode(',', $tags);
                            foreach ($tags_list as $tag) {
                                $tag_obj = get_term_by( 'slug',$tag, 'product_tag' );
                                if(!empty($tag_obj) && is_object($tag_obj)){
                                    $tag_link = get_term_link( $tag_obj->term_id, 'product_tag' );
                                    $html .=    '<a href="'.esc_url($tag_link).'">'.$tag_obj->name.'</a>';
                                }
                            }
                            $html .=    '</div>';
                        }
                        $html .=    '</div>';
                        break;

                    case 'home-2-adv':
                        $html .=    '<div class="featured-product2 '.$color3.' clearfix featured-product-cat '.$el_class.'">
                                        <div class="featured-product-sidebar">
                                            <h2 class="title-cat-parent">'.$term->name.'</h2>
                                            <div class="cat-bestsale-slider slider-home2">
                                                <h2>'.$title.'</h2>
                                                <div class="wrap-item">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $html .=    '<div class="item">
                                                <div class="featured-product-thumb">
                                                    <div class="featured-info-sale">
                                                        <div class="featured-info-sale">
                                                            '.sv_get_saleoff_html('home7').'
                                                        </div>
                                                    </div>
                                                    <a href="'.esc_url(get_the_permalink()).'" class="bestsale-thumb-link">
                                                        '.get_the_post_thumbnail(get_the_ID(),array(300,360)).'
                                                    </a>
                                                </div>
                                                <div class="featured-product-info product-info2">
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html('rating-style2').'
                                                </div>
                                            </div>';
                            }
                        }        
                        $html .=                '</div>
                                            </div>
                                        </div>
                                        <div class="featured-product-content">
                                            <ul class="list-cat-childrent">';
                                foreach ($term_childrents as $term_child) {
                                    $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                    if(is_object($term_childrent) && $cat_number > 0){
                                        $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                        $thumb_cat_id = get_woocommerce_term_meta( $term_childrent->term_id, 'thumbnail_id', true );
                                        if(empty($thumb_cat_id)) $cat_icon = 'no-icon';
                                        else $cat_icon = '';
                                        $html .=    '<li class="'.$cat_icon.'">
                                                        <a href="'.esc_url($term_childrent_link).'">
                                                            '.wp_get_attachment_image($thumb_cat_id,array(30,30)).'
                                                            <span>'.$term_childrent->name.'</span>
                                                        </a>
                                                    </li>';
                                    }
                                    if($cat_count >= $cat_number) break;
                                    $cat_count ++;
                                }
                        $html .=            '</ul>';
                        $html .=            '<div class="main-featured-product clearfix">
                                                <div class="paginav-featured-slider">
                                                    <div class="wrap-item">';
                        parse_str( urldecode( $advs ), $data);
                        if(is_array($data)){
                            foreach ($data as $key => $value) {
                                $count = $key++;
                                if($count % 3 == 1) $html .=    '<div class="item clearfix">';
                                $html .=   '<div class="item-paginav-featured">
                                                <div class="inner-item-paginav-featured">
                                                    <a href="'.esc_url($value['link']).'" class="paginav-thumb-link">
                                                        '.wp_get_attachment_image($value['image'],'full').'
                                                    </a>
                                                    <div class="paginav-featured-info">
                                                        '.$value['des'].'
                                                        <a href="'.esc_url($value['link']).'" class="shopnow">'.esc_html__("shop now","aloshop").'</a>
                                                    </div>
                                                </div>
                                            </div>';
                                if($count % 3 == 0 || $count == count($data)) $html .=    '</div>';
                            }
                        }
                        $html .=                    '</div>
                                                </div>
                                            </div>';
                        $html .=        '</div>';
                        if(!empty($tags)){
                            $html .=        '<div class="tags-featured-product">
                                                <label><i class="fa fa-tags"></i> '.esc_html__("tags","aloshop").':</label>';
                            $tags_list = explode(',', $tags);
                            foreach ($tags_list as $tag) {
                                $tag_obj = get_term_by( 'slug',$tag, 'product_tag' );
                                if(!empty($tag_obj) && is_object($tag_obj)){
                                    $tag_link = get_term_link( $tag_obj->term_id, 'product_tag' );
                                    $html .=    '<a href="'.esc_url($tag_link).'">'.$tag_obj->name.'</a>';
                                }
                            }
                            $html .=        '</div>';
                        }
                        $html .=    '</div>';
                        break;

                    case 'home-2-left':
                        $html .=    '<div class="featured-product2 '.$color3.' clearfix featured-product-cat '.$el_class.'">
                                        <div class="featured-product-sidebar">
                                            <h2 class="title-cat-parent">'.$term->name.'</h2>
                                            <div class="content-featured-product-sidebar">
                                                <ul class="sidebar-cat-childrent">';
                                foreach ($term_childrents as $term_child) {
                                    $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                    if(is_object($term_childrent) && $cat_number > 0){
                                        $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                        $html .=    '<li><a href="'.esc_url($term_childrent_link).'">
                                                        '.$term_childrent->name.'
                                                    </a></li>';
                                    }
                                    if($cat_count >= $cat_number) break;
                                    $cat_count ++;
                                }
                                parse_str( urldecode( $brands ), $data);
                                if(is_array($data)){
                                    foreach ($data as $key => $value) {
                                        $html .=   '<li><a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a></li>';
                                    }
                                }
                        $html .=                '</ul>';
                        if($image_side){
                            $html .=    '<div class="item-adv-simple">
                                            <a href="'.esc_url($image_link).'">'.wp_get_attachment_image($image_side,'full').'</a>
                                        </div>';
                        }
                        $html .=            '</div>
                                        </div>
                                        <div class="featured-product-content">';
                        $html .=            '<div class="main-featured-product clearfix">
                                                <div class="adv-featured-product item-adv-simple">
                                                    <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                                </div>
                                                <div class="list-featured-product">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $html .=    '<div class="item-featured-product">
                                                <div class="featured-product-info product-info2">
                                                    <div class="featured-info-sale">
                                                        '.sv_get_saleoff_html('home7').'
                                                        <label class="new">'.esc_html__("New","aloshop").'</label>
                                                    </div>
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html(true,'rating-style2').'
                                                </div>
                                                <div class="featured-product-thumb">
                                                    '.sv_product_thumb_hover3(array(150,180)).'
                                                </div>
                                            </div>';
                            }
                        }
                        $html .=                '</div>';
                        $html .=            '</div>';
                        $html .=        '</div>';
                        if(!empty($tags)){
                            $html .=        '<div class="tags-featured-product">
                                                <label><i class="fa fa-tags"></i> '.esc_html__("tags","aloshop").':</label>';
                            $tags_list = explode(',', $tags);
                            foreach ($tags_list as $tag) {
                                $tag_obj = get_term_by( 'slug',$tag, 'product_tag' );
                                if(!empty($tag_obj) && is_object($tag_obj)){
                                    $tag_link = get_term_link( $tag_obj->term_id, 'product_tag' );
                                    $html .=    '<a href="'.esc_url($tag_link).'">'.$tag_obj->name.'</a>';
                                }
                            }
                            $html .=        '</div>';
                        }
                        $html .=    '</div>';
                        break;

                    case 'home-2':
                        $html .=    '<div class="featured-product2 '.$color3.' clearfix featured-product-cat '.$el_class.'">
                                        <div class="featured-product-sidebar">
                                            <h2 class="title-cat-parent">'.$term->name.'</h2>
                                            <div class="featured-list-brand">
                                                <ul>';
                                parse_str( urldecode( $brands ), $data);
                                if(is_array($data)){
                                    foreach ($data as $key => $value) {
                                        $html .=   '<li><a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a></li>';
                                    }
                                }
                        $html .=                '</ul>
                                            </div>
                                        </div>
                                        <div class="featured-product-content">
                                            <ul class="list-cat-childrent">';
                                foreach ($term_childrents as $term_child) {
                                    $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                    if(is_object($term_childrent) && $cat_number > 0){
                                        $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                        $thumb_cat_id = get_woocommerce_term_meta( $term_childrent->term_id, 'thumbnail_id', true );
                                        if(empty($thumb_cat_id)) $cat_icon = 'no-icon';
                                        else $cat_icon = '';
                                        $html .=    '<li class="'.$cat_icon.'">
                                                        <a href="'.esc_url($term_childrent_link).'">
                                                            '.wp_get_attachment_image($thumb_cat_id,array(30,30)).'
                                                            <span>'.$term_childrent->name.'</span>
                                                        </a>
                                                    </li>';
                                    }                                
                                    if($cat_count >= $cat_number) break;
                                    $cat_count ++;
                                }
                        $html .=            '</ul>';
                        $html .=            '<div class="main-featured-product clearfix">
                                                <div class="adv-featured-product item-adv-simple">
                                                    <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                                </div>
                                                <div class="list-featured-product">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $html .=    '<div class="item-featured-product">
                                                <div class="featured-product-info product-info2">
                                                    <div class="featured-info-sale">
                                                        '.sv_get_saleoff_html('home7').'
                                                        <label class="new">'.esc_html__("New","aloshop").'</label>
                                                    </div>
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html(true,'rating-style2').'
                                                </div>
                                                <div class="featured-product-thumb">
                                                    '.sv_product_thumb_hover3(array(150,180)).'
                                                </div>
                                            </div>';
                            }
                        }
                        $html .=                '</div>';
                        $html .=            '</div>';
                        $html .=        '</div>';
                        if(!empty($tags)){
                            $html .=        '<div class="tags-featured-product">
                                                <label><i class="fa fa-tags"></i> '.esc_html__("tags","aloshop").':</label>';
                            $tags_list = explode(',', $tags);
                            foreach ($tags_list as $tag) {
                                $tag_obj = get_term_by( 'slug',$tag, 'product_tag' );
                                if(!empty($tag_obj) && is_object($tag_obj)){
                                    $tag_link = get_term_link( $tag_obj->term_id, 'product_tag' );
                                    $html .=    '<a href="'.esc_url($tag_link).'">'.$tag_obj->name.'</a>';
                                }
                            }
                            $html .=        '</div>';
                        }
                        $html .=    '</div>';
                        break;

                    case 'home-9':
                        $html .=    '<div class="category-adv home-9 '.$color4.' clearfix '.$el_class.'">
                                        <input type="hidden" class="data-load-ajax" data-cat="'.$term->slug.'" data-number="'.$number.'" data-order="'.$order.'" data-orderby="'.$order_by.'" data-product_type="'.$type_home7.'" />
                                        <div class="category-adv-sidebar adv-sidebar9">
                                            <h2 class="title-cat-parent load-product-data-home9" data-cat="'.$term->slug.'">'.$term->name.'</h2>
                                            <div class="content-featured-product-sidebar">';
                        if(!empty($term_childrents)){
                            $html .=                '<ul class="sidebar-cat-childrent">';
                            foreach ($term_childrents as $term_child) {
                                $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                if(is_object($term_childrent) && $cat_number > 0){
                                $html .=                '<li><a class="load-product-data-home9" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a></li>';
                                }
                                if($cat_count >= $cat_number) break;
                                $cat_count ++;
                            }
                            $html .=                '</ul>';
                        }
                        if( !empty($image)){
                        $html .=                '<div class="item-adv-simple">
                                                    <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                                </div>';
                        }
                        if(!empty($brands)){
                            parse_str( urldecode( $brands ), $data);
                            $html .=    '<div class="list-brand-zoom">';
                            if(is_array($data)){
                                foreach ($data as $key => $value) {
                                    $html .=   '<div class="zoom-image-thumb">
                                                    <a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>
                                                </div>';
                                }
                            }
                            $html .=    '</div>';
                        }
                        $html .=            '</div>
                                        </div>';
                        $html .=        '<div class="category-adv-content">
                                            <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                            <div class="list-product-cat clearfix">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $html .=        '<div class="item-product9">
                                                    '.sv_product_thumb_hover3(array(300,360)).'
                                                    <div class="product-info">
                                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                        '.sv_get_product_price().'
                                                    </div>
                                                </div>';
                                }
                        }
                        $html .=            '</div>
                                        </div>';
                        if(!empty($tags)){
                            $html .=    '<div class="tags-featured-product">
                                            <label><i class="fa fa-tags"></i> '.esc_html__("tags","aloshop").':</label>';
                            $tags_list = explode(',', $tags);
                            foreach ($tags_list as $tag) {
                                $tag_obj = get_term_by( 'slug',$tag, 'product_tag' );
                                if(!empty($tag_obj) && is_object($tag_obj)){
                                    $tag_link = get_term_link( $tag_obj->term_id, 'product_tag' );
                                    $html .=    '<a href="'.esc_url($tag_link).'">'.$tag_obj->name.'</a>';
                                }
                            }
                            $html .=    '</div>';
                        }
                        $html .=    '</div>';
                        break;

                    case 'home-8':
                        $html .=    '<div class="parent-category '.$el_class.'">
                                        <input type="hidden" class="data-load-ajax" data-cat="'.$term->slug.'" data-number="'.$number.'" data-order="'.$order.'" data-orderby="'.$order_by.'" data-product_type="'.$type_home7.'" />
                                        <div class="header-cat-parent">
                                            <label class="load-product-data-home8" data-cat="'.$term->slug.'">'.$term->name.'</label>';
                        foreach ($term_childrents as $term_child) {
                            $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                            if(is_object($term_childrent) && $cat_number > 0){
                                $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                $html .=        '<a class="load-product-data-home8" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a>';
                            }
                            if($cat_count >= $cat_number) break;
                            $cat_count ++;
                        }
                        $html .=        '</div>';
                        $html .=        '<div class="content-cat-parent">
                                            <div class="item-adv-simple">
                                                <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                            </div>
                                            <div class="slider-cat-parent">
                                                <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                                <div class="wrap-item">';
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $html .=    '<div class="item-cat-parent">
                                                '.sv_product_thumb_hover3(array(300,360)).'
                                                <div class="product-info">
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                </div>
                                            </div>';
                            }
                        }
                        $html .=                '</div>
                                            </div>';
                        if(!empty($tags)){
                            $html .=        '<div class="tags-featured-product">
                                                <label><i class="fa fa-tags"></i> '.esc_html__("tags","aloshop").':</label>';
                            $tags_list = explode(',', $tags);
                            foreach ($tags_list as $tag) {
                                $tag_obj = get_term_by( 'slug',$tag, 'product_tag' );
                                if(!empty($tag_obj) && is_object($tag_obj)){
                                    $tag_link = get_term_link( $tag_obj->term_id, 'product_tag' );
                                    $html .=    '<a href="'.esc_url($tag_link).'">'.$tag_obj->name.'</a>';
                                }
                            }
                            $html .=        '</div>';
                        }
                        $html .=        '</div>
                                    </div>';
                        break;

                    case 'home-7':
                        $html .=    '<div class="featured-product2 '.$color3.' clearfix featured-product-cat '.$el_class.'">
                                        <div class="featured-product-sidebar">
                                            <h2 class="title-cat-parent">'.$term->name.'</h2>
                                            <div class="featured-list-brand">
                                                <ul>';
                                parse_str( urldecode( $brands ), $data);
                                if(is_array($data)){
                                    foreach ($data as $key => $value) {
                                        $html .=   '<li><a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a></li>';
                                    }
                                }
                        $html .=                '</ul>
                                            </div>
                                        </div>
                                        <div class="featured-product-content">
                                            <ul class="list-cat-childrent">';
                                foreach ($term_childrents as $term_child) {
                                    $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                    if(is_object($term_childrent) && $cat_number > 0){
                                        $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                        $thumb_cat_id = get_woocommerce_term_meta( $term_childrent->term_id, 'thumbnail_id', true );
                                        $html .=    '<li>
                                                        <a href="'.esc_url($term_childrent_link).'">
                                                            '.wp_get_attachment_image($thumb_cat_id,array(30,30)).'
                                                            <span>'.$term_childrent->name.'</span>
                                                        </a>
                                                    </li>';
                                    }                                
                                    if($cat_count >= $cat_number) break;
                                    $cat_count ++;
                                }
                        $html .=            '</ul>';
                        $html .=            '<div class="main-featured-product clearfix">
                                                <div class="main-featured-left">
                                                    <div class="adv-featured-product item-adv-simple">
                                                        <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                                    </div>
                                                    <div class="list-featured-product">';
                        $args2=array(
                            'post_type'         => 'product',
                            'orderby'           => $order_by,
                            'order'             => $order
                        );
                        $args2['tax_query'][]=array(
                            'taxonomy'  => 'product_cat',
                            'field'     => 'slug',
                            'terms'     => $cat
                        );
                        $args2['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        $args2['posts_per_page'] = 2;
                        $post_f = array();
                        $query = new WP_Query($args2);
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $post_f[] = get_the_ID();
                                $html .=    '<div class="item-featured-product">
                                                <div class="featured-product-info product-info2">
                                                    <div class="featured-info-sale">
                                                        '.sv_get_saleoff_html('home7').'
                                                        <label class="new">'.esc_html__("New","aloshop").'</label>
                                                    </div>
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html(true,'rating-style2').'
                                                </div>
                                                <div class="featured-product-thumb">
                                                    '.sv_product_thumb_hover3(array(150,180)).'
                                                </div>
                                            </div>';
                            }
                        }
                        $html .=                    '</div>
                                                </div>';
                        $html .=                '<div class="main-featured-right">
                                                    <div class="best-seller-right slider-home2">
                                                        <h2>'.$title.'</h2>
                                                        <div class="wrap-item">';
                        $args['post__not_in'] = $post_f;
                        $query = new WP_Query($args);
                        $count_query = $query->post_count;
                        $count = 1;
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                if($count % 3 == 1) $html .=    '<div class="item">';
                                $html .=    '<div class="item-product-right">
                                                '.sv_product_thumb_hover_only2(array(150,180)).'
                                                <div class="product-info">
                                                    <h3 class="title-product">
                                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a>
                                                    </h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html(true,'rating-style2').'
                                                </div>
                                            </div>';
                                if($count % 3 == 0 || $count == $count_query) $html .=    '</div>';
                                $count++;
                            }
                        }
                        $html .=                        '</div>
                                                    </div>
                                                </div>';
                        $html .=            '</div>';
                        $html .=        '</div>';
                        if(!empty($tags)){
                            $html .=        '<div class="tags-featured-product">
                                                <label><i class="fa fa-tags"></i> '.esc_html__("tags","aloshop").':</label>';
                            $tags_list = explode(',', $tags);
                            foreach ($tags_list as $tag) {
                                $tag_obj = get_term_by( 'slug',$tag, 'product_tag' );
                                if(!empty($tag_obj) && is_object($tag_obj)){
                                    $tag_link = get_term_link( $tag_obj->term_id, 'product_tag' );
                                    $html .=    '<a href="'.esc_url($tag_link).'">'.$tag_obj->name.'</a>';
                                }
                            }
                            $html .=        '</div>';
                        }
                        $html .=    '</div>';
                        break;

                    case 'home-3':
                        $html .=    '<div class="popular-cat-box '.$color2.' '.$el_class.'">
                                        <input type="hidden" class="data-load-ajax" data-cat="'.$term->slug.'" data-number="'.$number.'" data-order="'.$order.'" data-orderby="'.$order_by.'" data-product_type="" data-pre="'.$pre.'" />
                                        <div class="row">';
                        if($content_pos == 'right'){
                        $html .=            '<div class="col-md-3 col-sm-4 col-xs-12">
                                                <div class="popular-cat-sidebar">
                                                    <h2><a class="load-product-data-home3" href="'.esc_url($term_link).'" data-cat="'.$term->slug.'">
                                                        '.$term->name.'
                                                    </a></h2>
                                                    <ul class="popular-listcat">';
                                    foreach ($term_childrents as $term_child) {
                                        $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                        if(is_object($term_childrent) && $cat_number > 0){
                                            $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                            $html .=        '<li><a class="load-product-data-home3" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a></li>';
                                        }
                                        if($cat_count >= $cat_number) break;
                                        $cat_count ++;
                                    }
                        $html .=                    '</ul>
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
                                                </div>
                                            </div>';
                        }
                        $html .=            '<div class="col-md-9 col-sm-8 col-xs-12">
                                                <div class="popular-cat-content">
                                                    <div class="popular-cat-tab-title">
                                                        <ul>
                                                            <li class="active"><a href="'.esc_url('#best1-'.$pre).'" data-toggle="tab">'.esc_html__("best sellers","aloshop").'</a></li>
                                                            <li><a href="'.esc_url('#new1-'.$pre).'" data-toggle="tab">'.esc_html__("new products","aloshop").'</a></li>
                                                        </ul>
                                                        <a href="'.esc_url($link).'" class="viewall">'.esc_html__("View all","aloshop").'</a>
                                                    </div>
                                                    <div class="tab-content">';
                        $html .=                        '<div role="tabpanel" class="tab-pane fade in active" id="best1-'.$pre.'">
                                                            <div class="popular-cat-slider slider-home3">
                                                                <div class="wrap-item">';
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                        $query = new WP_Query($args);
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $html .=                            '<div class="item">
                                                                        <div class="item-product3">
                                                                            '.sv_product_thumb_hover2(array(213,256)).'
                                                                            <div class="product-info3">
                                                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                                '.sv_get_product_price().'
                                                                                '.sv_get_rating_html().'
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                            }
                        }
                        $html .=                                '</div>
                                                            </div>
                                                        </div>';
                        $html .=                        '<div role="tabpanel" class="tab-pane" id="new1-'.$pre.'">
                                                            <div class="popular-cat-slider slider-home3">
                                                                <div class="wrap-item">';
                        unset($args['meta_key']);
                        $args['orderby'] = 'date';
                        $query = new WP_Query($args);
                        if($query->have_posts()) {
                            while($query->have_posts()) {
                                $query->the_post();
                                global $product;
                                $html .=                            '<div class="item">
                                                                        <div class="item-product3">
                                                                            '.sv_product_thumb_hover2(array(213,256)).'
                                                                            <div class="product-info3">
                                                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                                                '.sv_get_product_price().'
                                                                                '.sv_get_rating_html().'
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                            }
                        }
                        $html .=                                '</div>
                                                            </div>
                                                        </div>';
                        $html .=                    '</div>
                                                </div>
                                            </div>';
                        if($content_pos == 'left'){
                        $html .=            '<div class="col-md-3 col-sm-4 col-xs-12">
                                                <div class="popular-cat-sidebar">
                                                    <h2><a class="load-product-data-home3" href="'.esc_url($term_link).'" data-cat="'.$term->slug.'">
                                                        '.$term->name.'
                                                    </a></h2>
                                                    <ul class="popular-listcat">';
                                    foreach ($term_childrents as $term_child) {
                                        $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                        if(is_object($term_childrent) && $cat_number > 0){
                                            $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                            $html .=        '<li><a class="load-product-data-home3" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a></li>';
                                        }
                                        if($cat_count >= $cat_number) break;
                                        $cat_count ++;
                                    }
                        $html .=                    '</ul>
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
                                                </div>
                                            </div>';
                        }
                        $html .=        '</div>
                                    </div>';
                        break;
                    
                    default:
                        $html .=    '<div class="clearfix category-product-featured '.$color.' '.$el_class.'">                        
                                        <input type="hidden" class="data-load-ajax" data-cat="'.$term->slug.'" data-number="'.$number.'" data-order="'.$order.'" data-orderby="'.$order_by.'" data-product_type="" />
                                    <div class="category-home-total">
                                        <div class="category-home-label">
                                            <a class="load-product-data" href="'.esc_url($term_link).'" data-cat="'.$term->slug.'">
                                                '.wp_get_attachment_image($icon,'full').'
                                                <span>'.$term->name.'</span>
                                            </a>
                                        </div>
                                        <div class="category-filter-slider">
                                            <div class="wrap-item">';
                            $types_fillter = explode(',', $types_fillter);
                            if(in_array('bestsell', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data" href="#" data-product_type="bestsell">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-best.png').'" alt="" />
                                                                    <span>'.esc_html__("Best seller","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('mostview', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data" href="#" data-product_type="mostview">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-view.png').'" alt="" />
                                                                    <span>'.esc_html__("Most View","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('featured', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data" href="#" data-product_type="featured">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-special.png').'" alt="" />
                                                                    <span>'.esc_html__("Special","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('newarrival', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data" href="#" data-product_type="newest">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-new.png').'" alt="" />
                                                                    <span>'.esc_html__("New Arrivals","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('mostreview', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data" href="#" data-product_type="mostreview">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-review.png').'" alt="" />
                                                                    <span>'.esc_html__("Most Review","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';
                            if(in_array('onsale', $types_fillter))  $html .=    '<div class="item">
                                                            <div class="item-filter">
                                                                <a class="load-product-data" href="#"  data-product_type="onsale">
                                                                    <img src="'.esc_url(get_template_directory_uri() . '/assets/css/images/home1/icon-sale.png').'" alt="" />
                                                                    <span>'.esc_html__("Sale","aloshop").'</span>
                                                                </a>
                                                            </div>
                                                        </div>';    
                            $html .=        '</div>
                                        </div>
                                        <div class="list-child-category">
                                            <ul>';
                                            foreach ($term_childrents as $term_child) {                                            
                                                $term_childrent = get_term_by( 'id',$term_child, 'product_cat' );
                                                if(is_object($term_childrent) && $cat_number > 0){
                                                    $term_childrent_link = get_term_link( $term_childrent, 'product_cat' );
                                                    $html .=    '<li><a class="load-product-data" href="'.esc_url($term_childrent_link).'" data-cat="'.$term_childrent->slug.'">'.$term_childrent->name.'</a></li>';
                                                }
                                                if($cat_count >= $cat_number) break;
                                                $cat_count ++;
                                            }
                            $html .=        '</ul>
                                        </div>
                                        <div class="category-brand-slider">
                                            <div class="wrap-item">';
                            parse_str( urldecode( $brands ), $data);
                            if(is_array($data)){
                                foreach ($data as $key => $value) {
                                    $html .=   '<div class="item">
                                                        <div class="item-category-brand">
                                                            <a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>
                                                        </div>
                                                    </div>';
                                }
                            }                    
                            $html .=        '</div>
                                        </div>
                                    </div>
                                    <div class="banner-home-category">
                                        <div class="item-adv-simple">
                                            <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                        </div>
                                    </div>
                                    <div class="featured-product-category">
                                        <div class="no-product hidden"><h3>'.esc_html__("No Product are display.","aloshop").'</h3></div>
                                        <div class="wrap-item">';
                            if($query->have_posts()) {
                                while($query->have_posts()) {
                                    $query->the_post();
                                    global $product;
                                    $html .=    '<div class="item">
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
                            $html .=    '</div>
                                    </div>
                                </div>';
                        break;
                }
                
            }
            wp_reset_postdata();
            return $html;
        }
    }

    stp_reg_shortcode('sv_product_category','sv_vc_product_category');
    $check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_add_product_category',10,100 );
    if ( ! function_exists( 'sv_add_product_category' ) ) {
        function sv_add_product_category(){
            vc_map( array(
                "name"      => esc_html__("SV Product List Category", 'aloshop'),
                "base"      => "sv_product_category",
                "icon"      => "icon-st",
                "category"  => '7Up-theme',
                "params"    => array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__( 'Style', 'aloshop' ),
                        'param_name'  => 'style',
                        'value'       => array(
                            esc_html__( 'Home 1', 'aloshop' ) => 'home-1',
                            esc_html__( 'Home 2', 'aloshop' ) => 'home-2',
                            esc_html__( 'Home 2 (Advantage)', 'aloshop' ) => 'home-2-adv',
                            esc_html__( 'Home 2 (Category left)', 'aloshop' ) => 'home-2-left',
                            esc_html__( 'Home 3', 'aloshop' ) => 'home-3',
                            esc_html__( 'Home 7', 'aloshop' ) => 'home-7',
                            esc_html__( 'Home 8', 'aloshop' ) => 'home-8',
                            esc_html__( 'Home 9', 'aloshop' ) => 'home-9',
                            esc_html__( 'Home 9 (adv)', 'aloshop' ) => 'home-9-2',
                            esc_html__( 'Home 10', 'aloshop' ) => 'home-10',
                            esc_html__( 'Home 11', 'aloshop' ) => 'home-11',
                            esc_html__( 'Home 12', 'aloshop' ) => 'home-12',
                            esc_html__( 'Home 19', 'aloshop' ) => 'home-19',
                            ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Title",'aloshop'),
                        "param_name" => "title",
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-7','home-19','home-2','home-2-adv'),
                            )
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__( 'Show View More Button', 'aloshop' ),
                        'param_name'  => 'view_more',
                        'value'       => array(
                            esc_html__( 'No', 'aloshop' ) => '',
                            esc_html__( 'Yes', 'aloshop' ) => 'yes',
                            ),
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-11'),
                            )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Link All",'aloshop'),
                        "param_name" => "link",
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => 'home-3',
                            )
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__( 'Content Position', 'aloshop' ),
                        'param_name'  => 'content_pos',
                        'value'       => array(
                            esc_html__( 'Right', 'aloshop' )     => 'right',
                            esc_html__( 'Left', 'aloshop' )   => 'left',
                            ),
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-3','home-9-2'),
                            )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Number",'aloshop'),
                        "param_name" => "number",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Categories Childrent Number",'aloshop'),
                        "param_name" => "cat_number",
                    ),
                    array(
                        'type'        => 'dropdown',
                        'holder'      => 'div',
                        'heading'     => esc_html__( 'Product Category', 'aloshop' ),
                        'param_name'  => 'cat',
                        'value'       => sv_list_taxonomy('product_cat',true),
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__( 'Color', 'aloshop' ),
                        'param_name'  => 'color2',
                        'value'       => array(
                            esc_html__( 'Blue', 'aloshop' )     => '',
                            esc_html__( 'Yellow', 'aloshop' )   => 'yellow-box',
                            ),
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => 'home-3',
                            )
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__( 'Color', 'aloshop' ),
                        'param_name'  => 'color',
                        'value'       => array(
                            esc_html__( 'Red', 'aloshop' ) => 'red-box',
                            esc_html__( 'Yellow', 'aloshop' ) => 'yellow-box',
                            esc_html__( 'Pink', 'aloshop' ) => 'pink-box',
                            esc_html__( 'Blue', 'aloshop' ) => 'blue-box',
                            esc_html__( 'Green', 'aloshop' ) => 'green-box',
                            esc_html__( 'Violet', 'aloshop' ) => 'violet-box',
                            ),
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-1','home-12'),
                            )
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__( 'Color', 'aloshop' ),
                        'param_name'  => 'color4',
                        'value'       => array(
                            esc_html__( 'Red', 'aloshop' ) => 'red-box',
                            esc_html__( 'Blue', 'aloshop' ) => 'blue-box',
                            esc_html__( 'Green', 'aloshop' ) => 'green-box',
                            esc_html__( 'Yellow', 'aloshop' ) => 'yellow-box',
                            esc_html__( 'Pink', 'aloshop' ) => 'pink-box',
                            esc_html__( 'Blood', 'aloshop' ) => 'blood-box',
                            esc_html__( 'Red Dark', 'aloshop' ) => 'darkred-box',
                            esc_html__( 'Blue Sky', 'aloshop' ) => 'cyan-box',
                            ),
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-9','home-9-2','home-10'),
                            )
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => esc_html__( 'Color', 'aloshop' ),
                        'param_name'  => 'color3',
                        'value'       => array(
                            esc_html__( 'Red', 'aloshop' ) => 'red-box7',
                            esc_html__( 'Red Dark', 'aloshop' ) => 'red-dark-box',
                            esc_html__( 'Blue', 'aloshop' ) => 'blue-box7',
                            esc_html__( 'Yellow', 'aloshop' ) => 'yellow-box7',
                            esc_html__( 'Pink', 'aloshop' ) => 'pink-box',
                            ),
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-7','home-19','home-2','home-2-left','home-2-adv'),
                            )
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Category Icon",'aloshop'),
                        "param_name" => "icon",
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-1','home-12'),
                            )
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Category Image",'aloshop'),
                        "param_name" => "image",
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-1','home-7','home-19','home-8','home-9','home-2','home-2-left','home-9-2','home-10'),
                            )
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Image Adv",'aloshop'),
                        "param_name" => "image_side",
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-2-left','home-9-2'),
                            )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Image link",'aloshop'),
                        "param_name" => "image_link",
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-2-left','home-9-2'),
                            )
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Image Adv 2",'aloshop'),
                        "param_name" => "image_side2",
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-9-2'),
                            )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Image link 2",'aloshop'),
                        "param_name" => "image_link2",
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-9-2'),
                            )
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
                        "type" => "checkbox",
                        "heading" => esc_html__("Product type fillter",'aloshop'),
                        "param_name" => "types_fillter",
                        "value" => array(
                            esc_html__("Bestsell",'aloshop')        => 'bestsell',
                            esc_html__("Most View",'aloshop')       => 'mostview',
                            esc_html__("Featured",'aloshop')        => 'featured',
                            esc_html__("New Arrivals",'aloshop')    => 'newarrival',
                            esc_html__("Most Review",'aloshop')     => 'mostreview',
                            esc_html__("On Sale",'aloshop')         => 'onsale',
                            ),
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-1','home-12'),
                            )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Product type",'aloshop'),
                        "param_name" => "type_home7",
                        "value" => array(
                            esc_html__("Bestsell",'aloshop')        => 'bestsell',
                            esc_html__("Most View",'aloshop')       => 'mostview',
                            esc_html__("Featured",'aloshop')        => 'featured',
                            esc_html__("New Arrivals",'aloshop')    => 'newarrival',
                            esc_html__("Most Review",'aloshop')     => 'mostreview',
                            esc_html__("On Sale",'aloshop')         => 'onsale',
                            ),
                        'edit_field_class'=>'vc_col-sm-6 vc_column',
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-7','home-19','home-8','home-2','home-2-left','home-2-adv','home-9','home-9-2','home-10','home-11'),
                            )
                    ),
                    array(
                        'type'        => 'checkbox',
                        'holder'      => 'div',
                        'heading'     => esc_html__( 'Product Tags', 'aloshop' ),
                        'param_name'  => 'tags',
                        'value'       => sv_list_taxonomy('product_tag',false),
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-7','home-19','home-8','home-9','home-2','home-2-left','home-2-adv','home-9-2'),
                            )
                    ),
                    array(
                        "type" => "add_brand",
                        "heading" => esc_html__("Product Brand",'aloshop'),
                        "param_name" => "brands",
                        "group" => esc_html__("Brands",'aloshop'),
                    ),
                    array(
                        "type" => "add_advantage",
                        "heading" => esc_html__("Product Adv",'aloshop'),
                        "param_name" => "advs",
                        "group" => esc_html__("Adv Content",'aloshop'),
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-2-adv','home-12'),
                            )
                    ),
                    array(
                        "type" => "textarea_html",
                        "heading" => esc_html__("Content Adv",'aloshop'),
                        "param_name" => "content",
                        'dependency'  => array(
                            'element'   => 'style',
                            'value'   => array('home-10'),
                            )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Extra Class",'aloshop'),
                        "param_name" => "el_class",
                    ),
                )
            ));
        }
    }
    add_action( 'wp_ajax_load_more_product_category', 'sv_load_more_product_category' );
    add_action( 'wp_ajax_nopriv_load_more_product_category', 'sv_load_more_product_category' );
    if(!function_exists('sv_load_more_product_category')){
        function sv_load_more_product_category() {
            $number         = $_POST['number'];
            $order_by       = $_POST['orderby'];
            $order          = $_POST['order'];
            $product_type   = $_POST['product_type'];
            $cat            = $_POST['cat'];
            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => $order_by,
                'order'             => $order,
            );
            if(!empty($cat)) {
                $args['tax_query'][]=array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $cat
                );
            }
            if(!empty($product_type)){
                switch ($product_type) {
                    case 'mostview':
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = 'post_views';
                        break;

                    case 'bestsell':
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                        break;

                    case 'onsale':
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
                        break;

                    case 'featured':
                        $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        break;

                    case 'mostreview':
                        $args['meta_key'] = '_wc_average_rating';
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_query'] = WC()->query->get_meta_query();
                        $args['tax_query'][] = WC()->query->get_tax_query();
                        break;

                    case 'newest':
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                    
                    default:
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                }
            }
            $query = new WP_Query($args);
            // var_dump($args);
            $html = '';
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                        $html .=    '<div class="item">
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
            echo balanceTags($html);
            wp_reset_postdata();
        }
    }
    //Home 3
    add_action( 'wp_ajax_load_more_product_category_home3', 'sv_load_more_product_category_home3' );
    add_action( 'wp_ajax_nopriv_load_more_product_category_home3', 'sv_load_more_product_category_home3' );
    if(!function_exists('sv_load_more_product_category_home3')){
        function sv_load_more_product_category_home3() {
            $number         = $_POST['number'];
            $order_by       = $_POST['orderby'];
            $order          = $_POST['order'];
            $product_type   = $_POST['product_type'];
            $cat            = $_POST['cat'];
            $pre            = $_POST['pre'];
            $tab_active     = $_POST['tab_active'];
            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => $order_by,
                'order'             => $order,
            );
            if(!empty($cat)) {
                $args['tax_query'][]=array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $cat
                );
            }        
            $new_class = $best_class = '';
            if($tab_active == 'best1-'.$pre) $best_class = 'active';
            $html =     '<div class="tab-content">';
            $html .=        '<div role="tabpanel" class="tab-pane fade in '.$best_class.'" id="best1-'.$pre.'">
                                <div class="popular-cat-slider slider-home3">
                                    <div class="wrap-item">';
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $query = new WP_Query($args);
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    $html .=            '<div class="item">
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
            $html .=                '</div>
                                </div>
                            </div>';
            if($tab_active == 'new1-'.$pre) $new_class = 'active';
            $html .=        '<div role="tabpanel" class="tab-pane '.$new_class.'" id="new1-'.$pre.'">
                                <div class="popular-cat-slider slider-home3">
                                    <div class="wrap-item">';
            unset($args['meta_key']);
            $args['orderby'] = 'date';
            $query = new WP_Query($args);
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    $html .=            '<div class="item">
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
            $html .=                '</div>
                                </div>
                            </div>';
            $html .=    '</div>';
            echo balanceTags($html);
            wp_reset_postdata();
        }
    }
    //Home 8
    add_action( 'wp_ajax_load_more_product_category_home8', 'sv_load_more_product_category_home8' );
    add_action( 'wp_ajax_nopriv_load_more_product_category_home8', 'sv_load_more_product_category_home8' );
    if(!function_exists('sv_load_more_product_category_home8')){
        function sv_load_more_product_category_home8() {
            $number         = $_POST['number'];
            $order_by       = $_POST['orderby'];
            $order          = $_POST['order'];
            $product_type   = $_POST['product_type'];
            $cat            = $_POST['cat'];
            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => $order_by,
                'order'             => $order,
            );
            if(!empty($cat)) {
                $args['tax_query'][]=array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $cat
                );
            }
            if(!empty($product_type)){
                switch ($product_type) {
                    case 'mostview':
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = 'post_views';
                        break;

                    case 'bestsell':
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                        break;

                    case 'onsale':
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
                        break;

                    case 'featured':
                        $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        break;

                    case 'mostreview':
                        $args['meta_key'] = '_wc_average_rating';
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_query'] = WC()->query->get_meta_query();
                        $args['tax_query'][] = WC()->query->get_tax_query();
                        break;

                    case 'newarrival':
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                        
                    default:
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                }
            }
            $query = new WP_Query($args);
            $html = '';
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    $html .=    '<div class="item-cat-parent">
                                    '.sv_product_thumb_hover3(array(300,360)).'
                                    <div class="product-info">
                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        '.sv_get_product_price().'
                                    </div>
                                </div>';
                }
            }
            echo balanceTags($html);
            wp_reset_postdata();
        }
    }
    //Home 9
    add_action( 'wp_ajax_load_more_product_category_home9', 'sv_load_more_product_category_home9' );
    add_action( 'wp_ajax_nopriv_load_more_product_category_home9', 'sv_load_more_product_category_home9' );
    if(!function_exists('sv_load_more_product_category_home9')){
        function sv_load_more_product_category_home9() {
            $number         = $_POST['number'];
            $order_by       = $_POST['orderby'];
            $order          = $_POST['order'];
            $product_type   = $_POST['product_type'];
            $cat            = $_POST['cat'];
            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => $order_by,
                'order'             => $order,
            );
            if(!empty($cat)) {
                $args['tax_query'][]=array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $cat
                );
            }
            if(!empty($product_type)){
                switch ($product_type) {
                    case 'mostview':
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = 'post_views';
                        break;

                    case 'bestsell':
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                        break;

                    case 'onsale':
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
                        break;

                    case 'featured':
                        $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        break;

                    case 'mostreview':
                        $args['meta_key'] = '_wc_average_rating';
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_query'] = WC()->query->get_meta_query();
                        $args['tax_query'][] = WC()->query->get_tax_query();
                        break;

                    case 'newarrival':
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                        
                    default:
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                }
            }
            $query = new WP_Query($args);
            $html = '';
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    $html .=    '<div class="item-product9">
                                    '.sv_product_thumb_hover3(array(300,360)).'
                                    <div class="product-info">
                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        '.sv_get_product_price().'
                                    </div>
                                </div>';
                }
            }
            echo balanceTags($html);
            wp_reset_postdata();
        }
    }
    //Home 10
    add_action( 'wp_ajax_load_more_product_category_home10', 'sv_load_more_product_category_home10' );
    add_action( 'wp_ajax_nopriv_load_more_product_category_home10', 'sv_load_more_product_category_home10' );
    if(!function_exists('sv_load_more_product_category_home10')){
        function sv_load_more_product_category_home10() {
            $number         = $_POST['number'];
            $order_by       = $_POST['orderby'];
            $order          = $_POST['order'];
            $product_type   = $_POST['product_type'];
            $cat            = $_POST['cat'];
            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => $order_by,
                'order'             => $order,
            );
            if(!empty($cat)) {
                $args['tax_query'][]=array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $cat
                );
            }
            if(!empty($product_type)){
                switch ($product_type) {
                    case 'mostview':
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = 'post_views';
                        break;

                    case 'bestsell':
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                        break;

                    case 'onsale':
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
                        break;

                    case 'featured':
                        $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        break;

                    case 'mostreview':
                        $args['meta_key'] = '_wc_average_rating';
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_query'] = WC()->query->get_meta_query();
                        $args['tax_query'][] = WC()->query->get_tax_query();
                        break;

                    case 'newarrival':
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                        
                    default:
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                }
            }
            $query = new WP_Query($args);
            $html = '';
            $count = 1;$block_left = $block_right = '';
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    if($count % 2 == 1){
                        $block_left .=  '<div class="item-large-cat-hover">
                                            <div class="large-cat-info">
                                                '.sv_get_saleoff_html('home2').'
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                            </div>
                                            <div class="large-cat-thumb">
                                                '.sv_product_thumb_hover3(array(300,360)).'
                                            </div>
                                        </div>';
                    }
                    else{
                        $block_right .= '<div class="item-small-cat-hover">
                                            <div class="small-cat-thumb">
                                                '.sv_product_thumb_hover3(array(300,360)).'
                                            </div>
                                            <div class="small-cat-info">
                                                <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                '.sv_get_product_price().'
                                            </div>
                                        </div>';
                    }
                    $count++;
                }
            }
            $html .=            '<div class="large-cat-hover">
                                    '.$block_left.'
                                </div>
                                <div class="small-cat-hover">
                                    '.$block_right.'
                                </div>';
            echo balanceTags($html);
            wp_reset_postdata();
        }
    }
    //Home 11
    add_action( 'wp_ajax_load_more_product_category_home11', 'sv_load_more_product_category_home11' );
    add_action( 'wp_ajax_nopriv_load_more_product_category_home11', 'sv_load_more_product_category_home11' );
    if(!function_exists('sv_load_more_product_category_home11')){
        function sv_load_more_product_category_home11() {
            $number         = $_POST['number'];
            $order_by       = $_POST['orderby'];
            $order          = $_POST['order'];
            $product_type   = $_POST['product_type'];
            $cat            = $_POST['cat'];
            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => $order_by,
                'order'             => $order,
            );
            if(!empty($cat)) {
                $args['tax_query'][]=array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $cat
                );
            }
            if(!empty($product_type)){
                switch ($product_type) {
                    case 'mostview':
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = 'post_views';
                        break;

                    case 'bestsell':
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                        break;

                    case 'onsale':
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
                        break;

                    case 'featured':
                        $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        break;

                    case 'mostreview':
                        $args['meta_key'] = '_wc_average_rating';
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_query'] = WC()->query->get_meta_query();
                        $args['tax_query'][] = WC()->query->get_tax_query();
                        break;

                    case 'newarrival':
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                        
                    default:
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                }
            }
            $query = new WP_Query($args);
            $html = '';
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    $html .=        '<div class="item">
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
            echo balanceTags($html);
            wp_reset_postdata();
        }
    }
    //Home 12
    add_action( 'wp_ajax_load_more_product_category_home12', 'sv_load_more_product_category_home12' );
    add_action( 'wp_ajax_nopriv_load_more_product_category_home12', 'sv_load_more_product_category_home12' );
    if(!function_exists('sv_load_more_product_category_home12')){
        function sv_load_more_product_category_home12() {
            $number         = $_POST['number'];
            $order_by       = $_POST['orderby'];
            $order          = $_POST['order'];
            $product_type   = $_POST['product_type'];
            $cat            = $_POST['cat'];
            $args = array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => $order_by,
                'order'             => $order,
            );
            if(!empty($cat)) {
                $args['tax_query'][]=array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $cat
                );
            }
            if(!empty($product_type)){
                switch ($product_type) {
                    case 'mostview':
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_key'] = 'post_views';
                        break;

                    case 'bestsell':
                        $args['meta_key'] = 'total_sales';
                        $args['orderby'] = 'meta_value_num';
                        break;

                    case 'onsale':
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
                        break;

                    case 'featured':
                        $args['tax_query'][] = array(
                                                'taxonomy' => 'product_visibility',
                                                'field'    => 'name',
                                                'terms'    => 'featured',
                                                'operator' => 'IN',
                                            );
                        break;

                    case 'mostreview':
                        $args['meta_key'] = '_wc_average_rating';
                        $args['orderby'] = 'meta_value_num';
                        $args['meta_query'] = WC()->query->get_meta_query();
                        $args['tax_query'][] = WC()->query->get_tax_query();
                        break;

                    case 'newarrival':
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                        
                    default:
                        $args['order'] = 'DESC';
                        $args['orderby'] = 'date';
                        break;
                }
            }
            $query = new WP_Query($args);
            $html = '';
            $count = 1;
            $count_query = $query->post_count;
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    if($count % 2 == 1) $html .=    '<div class="item">';
                    $html .=        '<div class="item-category-featured-product">
                                        '.sv_product_thumb_hover(array(300,360)).'
                                        <div class="product-info">
                                            <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            '.sv_get_product_price().'
                                        </div>
                                        '.sv_get_saleoff_html().'
                                    </div>';
                    if($count % 2 == 0 || $count == $count_query) $html .=    '</div>';
                    $count++;
                }
            }
            echo balanceTags($html);
            wp_reset_postdata();
        }
    }
}