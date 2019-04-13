<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
 
/******************************************Core Function******************************************/
//Get option
if(!function_exists('sv_get_option')){
	function sv_get_option($key,$default=NULL)
    {
        if(function_exists('ot_get_option'))
        {
            return ot_get_option($key,$default);
        }

        return $default;
    }
}
//Get current ID
if(!function_exists('s7upf_get_current_id')){   
    function s7upf_get_current_id(){
        $id = get_the_ID();
        if(is_front_page() && is_home()) $id = (int)get_option( 'page_on_front' );
        if(!is_front_page() && is_home()) $id = (int)get_option( 'page_for_posts' );
        if(is_archive() || is_search()) $id = 0;
        if (class_exists('woocommerce')) {
            if(is_shop()) $id = (int)get_option('woocommerce_shop_page_id');
            if(is_cart()) $id = (int)get_option('woocommerce_cart_page_id');
            if(is_checkout()) $id = (int)get_option('woocommerce_checkout_page_id');
            if(is_account_page()) $id = (int)get_option('woocommerce_myaccount_page_id');
        }
        return $id;
    }
}

//Get list post type
if(!function_exists('s7upf_list_post_type')){
    function s7upf_list_post_type($post_type = 'page',$type = true){
        global $post;
        $post_temp = $post;
        $page_list = array();
        if($type){
            $page_list[] = array(
                'value' => '',
                'label' => esc_html__('-- Choose One --','7upframework')
            );
        }
        else $page_list[] = esc_html__('-- Choose One --','7upframework');
        if(is_admin()){
            $pages = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
            if(is_array($pages)){
                foreach ($pages as $page) {
                    if($type){
                        $page_list[] = array(
                            'value' => $page->ID,
                            'label' => $page->post_title,
                        );
                    }
                    else $page_list[$page->ID] = $page->post_title;
                }
            }
        }
        $post = $post_temp;
        return $page_list;
    }
}

//Autoload folder
if(!function_exists('sv_load_files')){
    function sv_load_files($folder)
    {
        //Auto load widget
        $files=glob(get_template_directory()."/"."7upframe/".$folder."/*.php");

        // Auto load all file
        if(!empty($files)){
            foreach ($files as $filename)
            {
                load_template($filename);
            }
        }

    }
}
//Favicon
if(!function_exists('sv_load_favicon') )
{
    function sv_load_favicon()
    {
        $value = sv_get_option('favicon');
        $favicon = (isset($value) && !empty($value))?$value:false;
        if($favicon)
            echo '<link rel="Shortcut Icon" href="' . esc_url( $favicon ) . '" type="image/x-icon" />' . "\n";
    }
}
if(!function_exists( 'wp_site_icon' ) ){
    add_action( 'wp_head','sv_load_favicon');
    add_action('login_head', 'sv_load_favicon');
    add_action('admin_head', 'sv_load_favicon');
}
//Add header style
if (!function_exists('sv_add_head_style')) {
    function sv_add_head_style($style) {
        $content ='<script type="text/javascript">
                    (function($) {
                        "use strict";
                        $("head").append('."'".'<style id="sv_add_footer_css">'.$style.'</style>'."'".');
                    })(jQuery);
                    </script>';
        return $content;
    }
}

//Get list header page
if(!function_exists('sv_list_header_page'))
{
    function sv_list_header_page($allpage = false)
    {
        global $post;
        $page_list = array();
        $page_list[] = array(
            'value' => '',
            'label' => esc_html__('-- Choose One --','aloshop')
        );
        $args= array(
        'post_type' => 'page',
        'posts_per_page' => -1, 
        );
        $query = new WP_Query($args);
        if($query->have_posts()): while ($query->have_posts()):$query->the_post();
            if ($allpage || strpos($post->post_content, '[sv_logo') ||  strpos($post->post_content, '[sv_menu')) {
                $page_list[] = array(
                    'value' => $post->ID,
                    'label' => $post->post_title
                );
            }
            endwhile;
        endif;
        wp_reset_postdata();
        return $page_list;
    }
}
//Get all page
if(!function_exists('sv_list_all_page'))
{
    function sv_list_all_page($complete = false)
    {
        global $post;
        if(!$complete){
            $page_list = array(
                esc_html__('-- Choose One --','7upframework') => '',
                );
        }
        else $page_list = array();
        $pages = get_pages();
        foreach ($pages as $page) {
            if(!$complete) $page_list[$page->post_title] = $page->ID;
            else{
                $page_list[] = array(
                    'value' => $page->ID,
                    'label' => $page->post_title,
                );
            }
        }
        return $page_list;
    }
}
//Get list sidebar
if(!function_exists('sv_get_sidebar_ids'))
{
    function sv_get_sidebar_ids($for_optiontree=false)
    {
        global $wp_registered_sidebars;
        $r=array();
        $r[]=esc_html__('--Select--','aloshop');
        if(!empty($wp_registered_sidebars)){
            foreach($wp_registered_sidebars as $key=>$value)
            {

                if($for_optiontree){
                    $r[]=array(
                        'value'=>$value['id'],
                        'label'=>$value['name']
                    );
                }else{
                    $r[$value['id']]=$value['name'];
                }
            }
        }
        return $r;
    }
}

//Get order list
if(!function_exists('sv_get_order_list'))
{
    function sv_get_order_list($current=false,$extra=array(),$return='array')
    {
        $default = array(
            esc_html__('None','aloshop')               => '',
            esc_html__('Post ID','aloshop')            => 'ID',
            esc_html__('Author','aloshop')             => 'author',
            esc_html__('Post Title','aloshop')         => 'title',
            esc_html__('Post Name','aloshop')          => 'name',
            esc_html__('Post Date','aloshop')          => 'date',
            esc_html__('Last Modified Date','aloshop') => 'modified',
            esc_html__('Post Parent','aloshop')        => 'parent',
            esc_html__('Random','aloshop')             => 'rand',
            esc_html__('Comment Count','aloshop')      => 'comment_count',
            esc_html__('View Post','aloshop')          => 'post_views',
            esc_html__('Like Post','aloshop')          => '_post_like_count',
            esc_html__('Custom Modified Date','aloshop')=> 'time_update',            
        );

        if(!empty($extra) and is_array($extra))
        {
            $default=array_merge($default,$extra);
        }

        if($return=="array")
        {
            return $default;
        }elseif($return=='option')
        {
            $html='';
            if(!empty($default)){
                foreach($default as $key=>$value){
                    $selected=selected($key,$current,false);
                    $html.="<option {$selected} value='{$key}'>{$value}</option>";
                }
            }
            return $html;
        }
    }
}

// Get sidebar
if(!function_exists('sv_get_sidebar'))
{
    function sv_get_sidebar()
    {
        $default=array(
            'position'=>'right',
            'id'      =>'blog-sidebar'
        );

        return apply_filters('sv_get_sidebar',$default);
    }
}

//Fill css background
if(!function_exists('sv_fill_css_background'))
{
    function sv_fill_css_background($data)
    {
        $string = '';
        if(!empty($data['background-color'])) $string .= 'background-color:'.$data['background-color'].';'."\n";
        if(!empty($data['background-repeat'])) $string .= 'background-repeat:'.$data['background-repeat'].';'."\n";
        if(!empty($data['background-attachment'])) $string .= 'background-attachment:'.$data['background-attachment'].';'."\n";
        if(!empty($data['background-position'])) $string .= 'background-position:'.$data['background-position'].';'."\n";
        if(!empty($data['background-size'])) $string .= 'background-size:'.$data['background-size'].';'."\n";
        if(!empty($data['background-image'])) $string .= 'background-image:url("'.$data['background-image'].'");'."\n";
        if(!empty($string)) return SV_Assets::build_css($string);
        else return false;
    }
}

// Get list menu
if(!function_exists('sv_list_menu_name'))
{
    function sv_list_menu_name()
    {
        $menu_nav = wp_get_nav_menus();
        $menu_list = array('Default' => '');
        if(is_array($menu_nav) && !empty($menu_nav))
        {
            foreach($menu_nav as $item)
            { 
                if(is_object($item))
                {
                    $menu_list[$item->name] = $item->slug;
                }
            }
        }
        return $menu_list;
    }
}

//Display BreadCrumb
if(!function_exists('sv_display_breadcrumb'))
{
    function sv_display_breadcrumb()
    {
        $breadcrumb = sv_get_value_by_id('sv_show_breadrumb','off');
        if($breadcrumb == 'on' && !is_page_template( 'visual-template.php' )){ 
            $b_class = sv_fill_css_background(sv_get_option('sv_bg_breadcrumb'));
            ?>
            <div class="tp-breadcrumb <?php echo esc_attr($b_class)?>">
                <div class="container">                    
                    <div class="breadcrumb">
                    <?php 
                        if(sv_is_woocommerce_page()) woocommerce_breadcrumb();
                        else{
                            if(function_exists('bcn_display')) bcn_display();
                            else sv_breadcrumb();
                        }
                    ?>
                    </div>
                </div>
            </div>
        <?php }
    }
}

//Custom BreadCrumb
if(!function_exists('sv_breadcrumb'))
{
    function sv_breadcrumb() {
        global $post;
        if (!is_home() || (is_home() && !is_front_page())) {
            echo '<a href="';
            echo esc_url(home_url('/'));
            echo '">';
            echo esc_html__('Home','aloshop');
            echo '</a>'.' <span class="lnr lnr-chevron-right"></span> ';
            if(is_home() && !is_front_page()){
                echo '<span>'.esc_html__('Blog','aloshop').'</span>'; 
            }
            if (is_category() || is_single()) {
                the_category(' <span class="lnr lnr-chevron-right"></span> ');
                if (is_single()) {
                    echo ' <span class="lnr lnr-chevron-right"></span><span> ';
                    the_title();
                    echo '</span>';
                }
            } elseif (is_page()) {
                if($post->post_parent){
                    $anc = get_post_ancestors( get_the_ID() );
                    $title = get_the_title();
                    foreach ( $anc as $ancestor ) {
                        $output = '<a href="'.esc_url(get_permalink($ancestor)).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a> <span class="lnr lnr-chevron-right"></span><span> ';
                    }
                    echo balanceTags($output);
                    echo '<span> '.$title.'</span>';
                } else {
                    echo '<span> '.get_the_title().'</span>';
                }
            }
        }
        elseif (is_tag()) {single_tag_title();}
        elseif (is_day()) {echo"<span>".esc_html_e("Archive for ","aloshop"); the_time(get_option( 'date_format' )); echo'</span>';}
        elseif (is_month()) {echo"<span>".esc_html_e("Archive for ","aloshop"); echo get_the_time('F, Y'); echo'</span>';}
        elseif (is_year()) {echo"<span>".esc_html_e("Archive for ","aloshop"); echo getthe_time('Y'); echo'</span>';}
        elseif (is_author()) {echo"<span>".esc_html_e("Author Archive ","aloshop"); echo'</span>';}
        elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>".esc_html_e("Blog Archives","aloshop"); echo'</span>';}
        elseif (is_search()) {echo"<span>".esc_html_e("Search Results","aloshop"); echo'</span>';}
    }
}

//Get page value by ID
if(!function_exists('sv_get_value_by_id'))
{   
    function sv_get_value_by_id($key)
    {
        if(!empty($key)){
            $id = get_the_ID();
            if(is_front_page() && is_home()) $id = (int)get_option( 'page_on_front' );
            if(!is_front_page() && is_home()) $id = (int)get_option( 'page_for_posts' );
            if(is_archive() || is_search()) $id = 0;
            $value = get_post_meta($id,$key,true);
            if(empty($value)) $value = sv_get_option($key);
            return $value;
        }
        else return 'Missing a variable of this funtion';
    }
}

//Check woocommerce page
if (!function_exists('sv_is_woocommerce_page')) {
    function sv_is_woocommerce_page() {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                }
        }
        return false;
    }
}

//navigation
if(!function_exists('sv_paging_nav'))
{
    function sv_paging_nav()
    {
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links( array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $GLOBALS['wp_query']->max_num_pages,
            'current'  => $paged,
            'mid_size' => 1,
            'add_args' => array_map( 'urlencode', $query_args ),
            'prev_text' => '<i class="fa fa-angle-double-left"></i> '.esc_html__( 'Prev', 'aloshop' ),
            'next_text' => esc_html__( 'Next', 'aloshop' ).' <i class="fa fa-angle-double-right"></i>',
        ) );

        if ($links) : ?>
        <div class="post-paginav">
            <?php echo balanceTags($links); ?>
        </div>
        <?php endif;
    }
}

//Set post view
if(!function_exists('sv_set_post_view'))
{
    function sv_set_post_view($post_id=false)
    {
        if(!$post_id) $post_id=get_the_ID();

        $view=(int)get_post_meta($post_id,'post_views',true);
        $view++;
        update_post_meta($post_id,'post_views',$view);
    }
}

if(!function_exists('sv_get_post_view'))
{
    function sv_get_post_view($post_id=false)
    {
        if(!$post_id) $post_id=get_the_ID();

        return (int)get_post_meta($post_id,'post_views',true);
    }
}

//remove attr embed
if(!function_exists('sv_remove_w3c')){
    function sv_remove_w3c($embed_code){
        $embed_code=str_replace('webkitallowfullscreen','',$embed_code);
        $embed_code=str_replace('mozallowfullscreen','',$embed_code);
        $embed_code=str_replace('frameborder="0"','',$embed_code);
        $embed_code=str_replace('frameborder="no"','',$embed_code);
        $embed_code=str_replace('scrolling="no"','',$embed_code);
        $embed_code=str_replace('&','&amp;',$embed_code);
        return $embed_code;
    }
}

// MetaBox
if(!function_exists('sv_display_metabox'))
{
    function sv_display_metabox($type ='') {
        switch ($type) {
            case 'single':?>
                <ul class="post-date-author">
                    <li><?php echo get_the_date('F d Y')?></li>
                    <li><?php esc_html_e('By', 'aloshop');?>: <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>"><?php echo get_the_author(); ?></a></li>
                    <li><a href="<?php echo esc_url( get_comments_link() ); ?>">
                        <?php echo get_comments_number().' '; ?>
                        <?php 
                            if(get_comments_number()>1) esc_html_e('Comments', 'aloshop') ;
                            else esc_html_e('Comment', 'aloshop') ;
                        ?>
                    </a></li>
                </ul>
                <?php
                break;

            case 'v2':?>
                <ul class="post-date-author">
                    <li><?php esc_html_e('By', 'aloshop');?>: <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>"><?php echo get_the_author(); ?></a></li>
                    <li><a href="<?php echo esc_url( get_comments_link() ); ?>">
                        <?php echo get_comments_number().' '; ?>
                        <?php 
                            if(get_comments_number()>1) esc_html_e('Comments', 'aloshop') ;
                            else esc_html_e('Comment', 'aloshop') ;
                        ?>
                    </a></li>
                </ul>
                <?php
                break;

            default:?>
                <div class="post-tags-info pull-right">
                    <label><?php esc_html_e('By', 'aloshop');?>:</label>
                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>" class="post-author-link"><?php echo get_the_author(); ?></a>
                    <label><?php esc_html_e('In', 'aloshop');?>:</label>
                        <?php $cats = get_the_category_list(', ');?>
                        <?php if($cats) echo balanceTags($cats); else esc_html_e("No Category",'aloshop');?>
                    
                    <?php if(is_front_page() && is_home()):?>
                    <label><?php esc_html_e('In', 'aloshop');?>:</label>
                        <?php $tags = get_the_tag_list(' ',', ',' ');?>
                        <?php if($tags) echo balanceTags($tags); else esc_html_e("No Tag",'aloshop');?>
                    <?php endif;?>

                    <a href="<?php echo esc_url( get_comments_link() ); ?>" class="post-comment-link">
                        <?php echo get_comments_number().' '; ?>
                        <?php 
                            if(get_comments_number()>1) esc_html_e('Comments', 'aloshop') ;
                            else esc_html_e('Comment', 'aloshop') ;
                        ?>
                    </a>
                </div>
                <?php
                break;
        }
    ?>        
    <?php
    }
}
if(!function_exists('sv_get_header_default')){
    function sv_get_header_default(){
        ?>
        <div id="header" class="header-default">                
            <div class="header">
                <div class="container">
                    <div class="logo">
                        <a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr__("logo","aloshop");?>">
                            <?php $sv_logo=sv_get_option('logo');?>
                            <?php if($sv_logo!=''){
                                echo '<img src="' . esc_url($sv_logo) . '" alt="logo">';
                            }   else { echo '<h1>'.get_bloginfo('name', 'display').'</h1>'; }
                            ?>
                        </a>
                    </div>
                    <nav class="main-nav">
                        <?php if ( has_nav_menu( 'primary' ) ) {
                            wp_nav_menu( array(
                                    'theme_location' => 'primary',
                                    'container'=>false,
                                    'walker'=>new SV_Walker_Nav_Menu(),
                                 )
                            );
                        } ?>
                        <a href="#" class="toggle-mobile-menu"><span><?php esc_html_e("Menu","aloshop");?></span></a>
                    </nav>
                </div>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('sv_get_footer_default')){
    function sv_get_footer_default(){
        ?>
        <div id="footer" class="default-footer">
            <div class="container">
                <div class="footer-bottom">
                    <p class="copyright"><?php esc_html_e("Copyright &copy; by 7up. All Rights Reserved. Designed by","aloshop")?> <a href="#"><span><?php esc_html_e("7uptheme","aloshop")?></span>.<?php esc_html_e("com","aloshop")?></a>.</p>
                </div>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('sv_get_footer_visual')){
    function sv_get_footer_visual($page_id){
        ?>
        <div id="footer" class="footer-page">
            <div class="container">
                <?php echo SV_Template::get_vc_pagecontent($page_id);?>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('sv_get_header_visual')){
    function sv_get_header_visual($page_id){
        $menu_fixed = sv_get_value_by_id('sv_menu_fixed');
        $menu_fixed_mobile = sv_get_option('sv_menu_fixed_mobile');
        if($menu_fixed == 'on') $menu_fixed = 'menufixed';
        else $menu_fixed = '';
        if($menu_fixed_mobile == 'on') $menu_fixed .= ' fixed-mobile';
        ?>
        <div id="header" class="header-page <?php echo esc_attr($menu_fixed)?>">
            <div class="container">
                <?php echo SV_Template::get_vc_pagecontent($page_id);?>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('sv_get_main_class')){
    function sv_get_main_class(){
        $sidebar=sv_get_sidebar();
        $sidebar_pos=$sidebar['position'];
        $main_class = 'col-md-12';
        if($sidebar_pos != 'no') $main_class = 'col-md-9 col-sm-8 col-xs-12';
        return $main_class;
    }
}
if(!function_exists('sv_output_sidebar')){
    function sv_output_sidebar($position){
        $sidebar = sv_get_sidebar();
        $sidebar_pos = $sidebar['position'];
        if($sidebar_pos == $position) get_sidebar();
    }
}
if(!function_exists('sv_get_import_category')){
    function sv_get_import_category($taxonomy){
        $cats = get_terms($taxonomy);
        $data_json = '{';
        foreach ($cats as $key => $term) {
            $thumb_cat_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
            $term_pa = get_term_by( 'id',$term->parent, $taxonomy );
            if(isset($term_pa->slug)) $slug_pa = $term_pa->slug;
            else $slug_pa = '';
            if($key > 0) $data_json .= ',';
            $data_json .= '"'.$term->slug.'":{"thumbnail":"'.$thumb_cat_id.'","parent":"'.$slug_pa.'"}';
        }
        $data_json .= '}';
        echo balanceTags($data_json);
    }
}
if(!function_exists('sv_fix_import_category')){
    function sv_fix_import_category($taxonomy){
        global $sv_config;
        $data = $sv_config['import_category'];
        $data = json_decode($data,true);
        foreach ($data as $cat => $value) {
            $parent_id = 0;
            $term = get_term_by( 'slug',$cat, $taxonomy );
            $term_parent = get_term_by( 'slug', $value['parent'], $taxonomy );
            if(isset($term_parent->term_id)) $parent_id = $term_parent->term_id;
            if($parent_id) wp_update_term( $term->term_id, $taxonomy, array('parent'=> $parent_id) );
            if($value['thumbnail']){
                if($taxonomy == 'product_cat')  update_metadata( 'woocommerce_term', $term->term_id, 'thumbnail_id', $value['thumbnail']);
                else{
                    update_term_meta( $term->term_id, 'thumbnail_id', $value['thumbnail']);
                }
            }
        }
    }
}
/***************************************END Core Function***************************************/


/***************************************Add Theme Function***************************************/

//Compare URL
if(!function_exists('sv_compare_url')){
    function sv_compare_url($ajax = false,$id = false){
        if(class_exists('YITH_Woocompare')){
            if(!$id) $id = get_the_ID();
            $cp_link = str_replace('&', '&amp;',add_query_arg( array('action' => 'yith-woocompare-add-product','id' => $id )));
            $html = '<a href="'.esc_url($cp_link).'" class="product-compare compare compare-link" data-product_id="'.esc_attr($id).'"><i class="fa fa-toggle-on"></i></a>';
            return $html;
        }
    }
}
if(!function_exists('sv_product_thumb_hover')){
    function sv_product_thumb_hover($size = 'full',$product = false){        
        $img_hover = get_post_meta(get_the_ID(),'product_thumb_hover',true);
        if(!empty($img_hover)) $img_hover_html = sv_get_image_by_url($img_hover,$size,'second-thumb');
        else $img_hover_html = get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'second-thumb'));
        if(!$product) global $product;
        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i>%s</a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link' : '',
                                esc_attr( $product->get_type() ),                                
                                esc_html( $product->add_to_cart_text() )
                            ),
                        $product );
        $html_wl = '';
        if(class_exists('YITH_WCWL_Init')) $html_wl = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist product-wishlist" rel="nofollow" data-product-id="'.get_the_ID().'"><i class="fa fa-heart-o"></i></a>';
        $html = '<div class="product-thumb">
                    <a class="product-thumb-link" href="'.esc_url(get_the_permalink()).'">';
        $style_hover = sv_get_option('main_thumb_hover');
        if($style_hover == 'scale' || empty($img_hover)) $html .=        get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'normal-thumb'));
        else{
            $html .=        get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'first-thumb'));
            $html .=        $img_hover_html;
        }
        $html .=    '</a>
                    <div class="product-info-cart">
                        <div class="product-extra-link product">
                            '.$html_wl.'
                            '.sv_compare_url(true,$product->get_id()).'
                            <a data-product-id="'.get_the_id().'" href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link"><i class="fa fa-search"></i></a>
                        </div>
                        '.$button_html.'
                    </div>
                </div>';
        return $html;
    }
}
if(!function_exists('sv_product_thumb_hover3')){
    function sv_product_thumb_hover3($size = 'full'){
        $img_hover = get_post_meta(get_the_ID(),'product_thumb_hover',true);
        if(!empty($img_hover)) $img_hover_html = sv_get_image_by_url($img_hover,$size,'second-thumb');
        else $img_hover_html = get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'second-thumb'));
        global $product;
        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i>%s</a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link' : '',
                                esc_attr( $product->get_type() ),
                                esc_html( $product->add_to_cart_text() )
                            ),
                        $product );
        $html_wl = '';
        if(class_exists('YITH_WCWL_Init')) $html_wl = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist product-wishlist" rel="nofollow" data-product-id="'.get_the_ID().'"><i class="fa fa-heart-o"></i></a>';
        $html = '<div class="product-thumb">
                    <a class="product-thumb-link" href="'.esc_url(get_the_permalink()).'">';
        $style_hover = sv_get_option('main_thumb_hover');
        if($style_hover == 'scale' || empty($img_hover)) $html .=        get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'normal-thumb'));
        else{
            $html .=        get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'first-thumb'));
            $html .=        $img_hover_html;
        }
        $html .=    '</a>
                    <div class="product-info-cart">
                        <div class="product-extra-link product">
                            '.$html_wl.'
                            '.sv_compare_url(true).'
                            <a data-product-id="'.get_the_id().'" href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link"><i class="fa fa-search"></i></a>
                        </div>
                        '.$button_html.'
                    </div>
                </div>';
        return $html;
    }
}
if(!function_exists('sv_product_thumb_hover2')){
    function sv_product_thumb_hover2($size = 'full',$style = 'product-thumb3'){
        $img_hover = get_post_meta(get_the_ID(),'product_thumb_hover',true);
        if(!empty($img_hover)) $img_hover_html = sv_get_image_by_url($img_hover,$size,'second-thumb');
        else $img_hover_html = get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'second-thumb'));
        global $product;
        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i> %s</a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link' : '',
                                esc_attr( $product->get_type() ),
                                esc_html( $product->add_to_cart_text() )
                            ),
                        $product );
        $html_wl = '';
        if(class_exists('YITH_WCWL_Init')) $html_wl = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist product-wishlist" rel="nofollow" data-product-id="'.get_the_ID().'"><i class="fa fa-heart-o"></i></a>';
        $html = '<div class="product-thumb '.$style.'">
                    <a class="product-thumb-link" href="'.esc_url(get_the_permalink()).'">';
        $style_hover = sv_get_option('main_thumb_hover');
        if($style_hover == 'scale' || empty($img_hover)) $html .=        get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'normal-thumb'));
        else{
            $html .=        get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'first-thumb'));
            $html .=        $img_hover_html;
        }
        $html .=    '</a>
                    <div class="product-info-cart">
                        <div class="product-extra-link product">
                            '.$html_wl.'
                            '.sv_compare_url(true).'
                            <a data-product-id="'.get_the_id().'" href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link"><i class="fa fa-search"></i></a>
                        </div>
                        '.$button_html.'
                    </div>
                </div>';
        return $html;
    }
}
if(!function_exists('sv_product_links')){
    function sv_product_links($style = ''){        
        global $product;
        switch ($style) {
            case 'list-view':
                $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i><span>%s</span></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link' : '',
                                esc_attr( $product->get_type() ),
                                esc_html( $product->add_to_cart_text() )
                            ),
                        $product );
                break;
            
            default:
                $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link' : '',
                                esc_attr( $product->get_type() )
                            ),
                        $product );
                break;
        }        
        $html_wl = '';
        if(class_exists('YITH_WCWL_Init')) $html_wl = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist product-wishlist" rel="nofollow" data-product-id="'.get_the_ID().'"><i class="fa fa-heart-o"></i></a>';
        $html = '<div class="product-info-cart">
                    '.$button_html.'
                    <div class="product-extra-link product">
                        '.$html_wl.'
                        '.sv_compare_url(true).'
                        <a data-product-id="'.get_the_id().'" href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link"><i class="fa fa-search"></i></a>
                    </div>                    
                </div>';
        return $html;
    }
}
if(!function_exists('sv_product_links2')){
    function sv_product_links2($style = ''){        
        global $product;
        switch ($style) {
            case 'list-view':
                
                break;
            
            default:
                $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s"><i class="fa fa-shopping-basket"></i><span>%s</span></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button addcart-link' : '',
                                esc_attr( $product->get_type() ),
                                esc_html( $product->add_to_cart_text() )
                            ),
                        $product );
                break;
        }        
        $html_wl = '';
        if(class_exists('YITH_WCWL_Init')) $html_wl = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist product-wishlist" rel="nofollow" data-product-id="'.get_the_ID().'"><i class="fa fa-heart-o"></i></a>';
        $html = '<div class="product-info-cart">
                    <div class="product-extra-link product">
                        '.$html_wl.'
                        '.sv_compare_url(true).'
                        <a data-product-id="'.get_the_id().'" href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link"><i class="fa fa-search"></i></a>
                    </div>     
                    '.$button_html.'               
                </div>';
        return $html;
    }
}
if(!function_exists('sv_product_thumb_hover_only')){
    function sv_product_thumb_hover_only($size = 'full'){
        $img_hover = get_post_meta(get_the_ID(),'product_thumb_hover',true);
        if(!empty($img_hover)) $img_hover_html = sv_get_image_by_url($img_hover,$size,'second-thumb');
        else $img_hover_html = get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'second-thumb'));
        global $product;
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
        $html = '<div class="product-thumb">
                    <a class="product-thumb-link" href="'.esc_url(get_the_permalink()).'">';
        $style_hover = sv_get_option('main_thumb_hover');
        if($style_hover == 'scale' || empty($img_hover)) $html .=        get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'normal-thumb'));
        else{
            $html .=        get_the_post_thumbnail(get_the_ID(),$size,array('class'=>'first-thumb'));
            $html .=        $img_hover_html;
        }
        $html .=    '</a>                    
                    '.$button_html.'
                </div>';
        return $html;
    }
}

if(!function_exists('sv_product_thumb_hover_only2')){
    function sv_product_thumb_hover_only2($size = 'full'){
        global $product;
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
        $html = '<div class="product-thumb">
                    <a href="'.esc_url(get_the_permalink()).'">
                        '.get_the_post_thumbnail(get_the_ID(),$size).'
                    </a>
                    '.$button_html.'
                </div>';
        return $html;
    }
}

if(!function_exists('sv_get_rating_html')){
    function sv_get_rating_html($count = true,$style = ''){
        global $product;
        $html = '';
        $star = $product->get_average_rating();
        $review_count = $product->get_review_count();
        $width = $star / 5 * 100;
        // if($star){
            $html .=    '<div class="product-rating '.$style.'">
                            <div class="inner-rating" style="width:'.$width.'%;"></div>';
            if($count) $html .= '<span>('.$review_count.'s)</span>';
            $html .=    '</div>';
        // }
        return $html;
    }
}
if(!function_exists('sv_get_saleoff_html')){
    function sv_get_saleoff_html($style=''){
        global $product;
        $show_mode = sv_check_catelog_mode();
        $hide_price = sv_get_option('hide_price');
        $from = $product->get_regular_price();
        $to = $product->get_price();
        $percent = $html = '';
        if($from != $to && $from > 0){
            $percent = round(($from-$to)/$from*100).'%';
        }
        else{
            if($product->is_on_sale()) $percent = esc_html__("SALE","aloshop");
        }
        if(!empty($percent)){
            switch ($style) {
                case 'home24':
                    $html = '<span class="sale-label24">'.$percent.'</span>';
                    break;

                case 'home2':
                    $html = '<div class="cat-hover-percent">
                                <strong>'.$percent.'</strong>
                            </div>';
                    break;

                case 'home7':
                    $html = '<label class="persale">'.$percent.'</label>';
                    break;

                case 'home5':
                    $html = '<span class="percent-sale">- '.$percent.'</span>';
                    break;
                
                default:
                    $html = '<div class="percent-saleoff">
                                <span><label>'.$percent.'</label>'.esc_html__('OFF','aloshop').'</span>
                            </div>';
                    break;
            }            
        }
        if($show_mode == 'on' && $hide_price == 'on'){
            $html = '';
        }
        return $html;
    }
}
// get list taxonomy
if(!function_exists('sv_list_taxonomy'))
{
    function sv_list_taxonomy($taxonomy,$show_all = true)
    {
        if($show_all) $list = array('--Select--' => '');
        else $list = array();
        if(!isset($taxonomy) || empty($taxonomy)) $taxonomy = 'category';
        $tags = get_terms($taxonomy);
        if(is_array($tags) && !empty($tags)){
            foreach ($tags as $tag) {
                $list[$tag->name] = $tag->slug;
            }
        }
        return $list;
    }
}
if(!function_exists('sv_get_saledeals_html')){
    function sv_get_saledeals_html(){
        global $product;
        $from = $product->get_regular_price();
        $to = $product->get_price();
        $percent = $html = '';
        if($from != $to && $from > 0){
            $percent = round(($from-$to)/$from*100);
        }
        if(!empty($percent)){
            $html = '<label>'.$percent.'%</label>';
        }
        return $html;
    }
}
// Mini cart
if(!function_exists('sv_mini_cart')){
    function sv_mini_cart($echo = false){
        $html = '';
        if ( ! WC()->cart->is_empty() ){
            $count_item = 0; $html = '';
            $html .=  '<ul class="list-mini-cart-item">';                    
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $count_item++;
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                $product_quantity = woocommerce_quantity_input( array(
                    'input_name'  => "cart[{$cart_item_key}][qty]",
                    'input_value' => $cart_item['quantity'],
                    'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                    'min_value'   => '0'
                ), $_product, false );
                $thumb_html = '';
                if(has_post_thumbnail($product_id)) $thumb_html = $_product->get_image(array(70,70));
                $html .=    '<li class="item-info-cart" data-key="'.$cart_item_key.'">
                                <div class="mini-cart-edit">
                                    <a href="#" class="delete-mini-cart-item btn-remove"><i class="fa fa-trash-o"></i></a>
                                </div>
                                <div class="mini-cart-thumb">
                                    <a href="'.esc_url( $_product->get_permalink( $cart_item )).'">'.$thumb_html.'</a>
                                </div>
                                <div class="mini-cart-info">
                                    <h3><a href="'.esc_url( $_product->get_permalink( $cart_item )).'">'.$_product->get_title().'</a></h3>
                                    <div class="info-price">
                                        '.apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ).'
                                    </div>
                                    <div class="qty-product">
                                        <span class="qty-num">'.$cart_item['quantity'].'</span>
                                    </div>
                                </div>
                            </li>';
            }
            $html .=    '</ul><input id="count-cart-item" type="hidden" value="'.$count_item.'">';
            $html .=    '<div class="mini-cart-total cart-qty">
                            <label>'.esc_html__("TOTAL","aloshop").'</label>
                            <span class="total-price get-cart-price">'.WC()->cart->get_cart_total().'</span>
                        </div>
                        <div class="mini-cart-button">
                            <a href="'.wc_get_cart_url().'" class="mini-cart-view">'.esc_html__("View my cart","aloshop").'</a>
                            <a href="'.wc_get_checkout_url().'" class="mini-cart-checkout">'.esc_html__("Checkout","aloshop").'</a>
                        </div>';
        }
        // else $html .= '<ul class="info-list-cart"><li class="item-info-cart cart-empty"><h3>'.esc_html__("No product in cart","aloshop").'</h3></li></ul>';
        if($echo) echo balanceTags($html);
        else return $html;
    }
}
//product main detail
if(!function_exists('sv_product_main_detai')){
    function sv_product_main_detai($ajax = false){
        global $post, $product, $woocommerce;
        $excerpt_html = '';
        $check_show_ex = sv_get_option('show_product_excerpt');
        if($check_show_ex == 'on' && has_excerpt( get_the_ID() )) $excerpt_html = '<div class="desc">'.get_the_excerpt().'</div>';
        sv_set_post_view();        
        $show_mode = sv_check_catelog_mode();
        $product_style = sv_get_value_by_id('product_style');
        $thumb_id = array(get_post_thumbnail_id());
        $attachment_ids = $product->get_gallery_image_ids();
        $attachment_ids = array_merge($thumb_id,$attachment_ids);
        $attachment_ids = array_unique($attachment_ids);
        $ul_block = ''; $i = 1;
        $gallerys = '';
        foreach ( $attachment_ids as $attachment_id ) {
            $image_link = wp_get_attachment_url( $attachment_id );
            if($i == 1) $gallerys .= $image_link;
            else $gallerys .= ','.$image_link;
            if ( ! $image_link )
                continue;
            $image_title    = esc_attr( get_the_title( $attachment_id ) );
            $image_caption  = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
            $image       = wp_get_attachment_image( $attachment_id, 'full', 0, $attr = array(
                'title' => $image_title,
                'alt'   => $image_title
                ) );
            if($i == 1) $active = 'active';
            else $active = '';
            $ul_block .= '<li><a data-image_id="'.$attachment_id.'" href="#" class="'.$active.'">'.$image.'</a></li>';
            $i++;
        }
        $available_data = array();
        if( $product->is_type( 'variable' ) ) $available_data = $product->get_available_variations();        
        if(!empty($available_data)){
            foreach ($available_data as $available) {
                if(!empty($available['image_id']) && !in_array($available['image_id'],$attachment_ids)){
                    $attachment_ids[] = $available['image_id'];
                    $image2 = wp_get_attachment_image( $available['image_id'], 'full', 0, $attr = array(
                    'title' => $image_title,
                    'alt'   => $image_title
                    ) );
                    $gallerys .= ','.wp_get_attachment_image_url($available['image_id'],'full');
                    $ul_block .= '<li><a data-image_id="'.$available['image_id'].'" href="#">'.$image2.'</a></li>';
                    $i++;
                }
            }
        }
        $sku = get_post_meta(get_the_ID(),'_sku',true);
        $stock = $product->get_availability();
        if(is_array($stock)){
            if(!empty($stock['availability'])) $stock = $stock['availability'];
            else {
                if($stock['class'] == 'in-stock') $stock = esc_html__("In stock","aloshop");
                else $stock = esc_html__("Out of stock","aloshop");
            }
        }
        echo '<div class="main-detail main-'.$product_style.'">
            <div class="row">';
        switch ($product_style) {
            case 'style2':
                echo    '<div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="detail-gallery-fullwidth">
                                <div class="mid image-lightbox" data-gallery="'.$gallerys.'">
                                    '.sv_get_saleoff_html().'
                                    '.get_the_post_thumbnail(get_the_ID(),'full').'
                                    <p><i class="fa fa-search"></i> '.esc_html__("Mouse over to zoom in","aloshop").'</p>
                                </div>
                                <div class="carousel-fullwidth">
                                    <a href="#" class="vertical-control vertical-next"><i class="fa fa-angle-up"></i></a>
                                    <div class="carousel">
                                        <ul>
                                            '.$ul_block.'
                                        </ul>
                                    </div>
                                    <a href="#" class="vertical-control vertical-prev"><i class="fa fa-angle-down"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="detail-info detail-info-fullwidth">
                                <h2 class="title-detail">'.get_the_title().'</h2>
                                '.sv_get_rating_html(false).'
                                <div class="product-order">
                                    <span>'.get_post_meta(get_the_iD(),'total_sales',true).' '.esc_html__("Orders","aloshop").'</span>
                                </div>
                                '.$excerpt_html.'
                                <div class="product-code">
                                    <label>'.esc_html__("Item Code:","aloshop").' </label> <span>#'.$sku.'</span>
                                </div>';
                        if($show_mode != 'on'){
                echo        '<div class="product-stock">
                                <label>'. esc_html__("Availability","aloshop").': </label> <span>'.$stock.'</span>
                            </div>';
                        }
                echo        sv_get_product_price('detail').'
                                <div class="attr-info">';
                                    do_action( 'woocommerce_single_product_summary' );
                                    if($show_mode != 'on') woocommerce_template_single_add_to_cart();
                echo                balanceTags(sv_single_product_meta());
                echo            '</div>';
                            do_action( 'woocommerce_product_meta_end' );
                echo    '</div>
                        </div>';
                break;
            
            default:
                echo '<div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="detail-gallery">
                            <div class="mid image-lightbox" data-gallery="'.$gallerys.'">
                                '.sv_get_saleoff_html().'
                                '.get_the_post_thumbnail(get_the_ID(),'full').'
                                <p><i class="fa fa-search"></i> '.esc_html__("Mouse over to zoom in","aloshop").'</p>
                            </div>
                            <div class="carousel">
                                <ul>
                                    '.$ul_block.'
                                </ul>
                            </div>
                            <div class="gallery-control">
                                <a href="#" class="prev"><i class="fa fa-angle-left"></i></a>
                                <a href="#" class="next"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="detail-info">
                            <h2 class="title-detail">'.get_the_title().'</h2>
                            '.sv_get_rating_html(false).'
                            <div class="product-order">
                                <span>'.get_post_meta(get_the_iD(),'total_sales',true).' '.esc_html__("Orders","aloshop").'</span>
                            </div>
                            '.$excerpt_html.'
                            <div class="product-code">
                                <label>'. esc_html__("Item Code","aloshop").': </label> <span>#'.$sku.'</span>
                            </div>';
                        if($show_mode != 'on'){
                echo        '<div class="product-stock">
                                <label>'. esc_html__("Availability","aloshop").': </label> <span>'.$stock.'</span>
                            </div>';
                        }
                echo        sv_get_product_price('detail').'
                            <div class="attr-info">';
                                do_action( 'woocommerce_single_product_summary' );
                                if($show_mode != 'on') woocommerce_template_single_add_to_cart();
                echo            balanceTags(sv_single_product_meta());
                echo        '</div>';
                            do_action( 'woocommerce_product_meta_end' );
                echo    '</div>
                    </div>';
                break;
        }                
        echo    '</div>
            </div>';
    }
}
if(!function_exists('sv_single_box')){
    function sv_single_box(){
        global $post;
        $tags = get_the_tag_list(' ',', ',' ');
        if(empty($tags)) $tags = esc_html__("No Tags","aloshop");
        $html =     '<div class="tabs-share">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="single-post-tabs">
                                    <label>'.esc_html__("Tags:","aloshop").' </label>
                                    '.$tags.'
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="single-post-share">
                                    <label>'.esc_html__("Share","aloshop").'</label>
                                    <a href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'"><i class="fa fa-facebook"></i></a>
                                    <a href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'"><i class="fa fa-twitter"></i></a>
                                    <a href="'.esc_url('http://linkedin.com/shareArticle?mini=true&amp;url='.get_the_permalink().'&amp;title='.$post->post_name).'"><i class="fa fa-linkedin"></i></a>
                                    <a href="'.esc_url('http://pinterest.com/pin/create/button/?url='.get_the_permalink().'&amp;media='.wp_get_attachment_url(get_post_thumbnail_id())).'"><i class="fa fa-pinterest"></i></a>
                                    <a href="'.esc_url('https://plus.google.com/share?url='.get_the_permalink()).'"><i class="fa fa-google-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>';
        return $html;
    }
}
// Author Box function
if(!function_exists('sv_author_box')){
    function sv_author_box(){ 
        global $post;
        $des = get_the_author_meta('description');
        if(!empty($des)){
        ?>
            <div class="single-post-author">
                <div class="post-author-thumb">
                    <div class="zoom-image-thumb">
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <?php echo get_avatar(get_the_author_meta('email'),'50'); ?>
                    </a>
                    </div>
                </div>
                <div class="post-author-info">
                    <ul>
                        <li><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_the_author(); ?></a></li>
                        <?php
                        $position  = get_user_option( 'author_position', $post->post_author );
                        echo '<li>'.$position.'</li>'
                        ?>
                    </ul>
                    <?php echo get_the_author_meta('description'); ?>
                </div>
            </div>
        <?php
        }
    }
}
//Relate Box
if(!function_exists('sv_single_related_post')){
    function sv_single_related_post(){        
    ?>
        <div class="single-related-post">
            <h2 class="title"><?php esc_html_e("Relatest posts","aloshop")?></h2>
            <div class="single-related-post-slider">
                <div class="wrap-item">
                    <?php
                        $categories = get_the_category(get_the_ID());
                        $category_ids = array();
                        foreach($categories as $individual_category){
                            $category_ids[] = $individual_category->term_id;
                        }
                        $args=array(
                            'category__in' => $category_ids,
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page'=>6
                            );                                        
                        $query = new wp_query($args);
                        if( $query->have_posts() ) {
                            while ($query->have_posts()) {
                                $query->the_post();                                
                                echo    '<div class="item">
                                            <div class="item-single-related-post">
                                                <div class="zoom-image-thumb">
                                                    <a href="'. esc_url(get_the_permalink()) .'">'.get_the_post_thumbnail(get_the_ID(),array(370,247)).'</a>
                                                </div>
                                                <div class="single-related-post-info">
                                                    <h3><a href="'. esc_url(get_the_permalink()) .'">'.get_the_title().'</a></h3>
                                                    <ul class="post-date-author">
                                                        <li>'.get_the_date('M d Y').'</li>
                                                        <li>'.esc_html__("By","aloshop").': <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></li>
                                                    </ul>
                                                    <p>'.sv_substr(get_the_excerpt(),0,126).'</p>
                                                    <a href="'. esc_url(get_the_permalink()) .'" class="readmore">'.esc_html__("Read More","aloshop").'</a>
                                                    <a href="'.esc_url(get_comments_link()).'" class="related-comment"><i class="fa fa-comment-o"></i> '.get_comments_number().'</a>
                                                </div>
                                            </div>
                                        </div>';
                            }
                        }
                        wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
//get type url
if(!function_exists('sv_get_key_url')){
    function sv_get_key_url($key,$value){
        if(function_exists('sv_get_current_url')) $current_url = sv_get_current_url();
        else $current_url = get_the_permalink();
        if(isset($_GET[$key])){
            $current_url = str_replace('&'.$key.'='.$_GET[$key], '', $current_url);
            $current_url = str_replace('?'.$key.'='.$_GET[$key], '?', $current_url);
        }
        if(strpos($current_url,'?') > -1 ){
            $current_url .= '&amp;'.$key.'='.$value;
        }
        else {
            $current_url .= '?'.$key.'='.$value;
        }
        return $current_url;
    }
}
//get type url
if(!function_exists('sv_get_filter_url')){
    function sv_get_filter_url($key,$value){
        if(function_exists('sv_get_current_url')) $current_url = sv_get_current_url();
        else $current_url = get_the_permalink();
        if(isset($_GET[$key])){
            $current_val_string = $_GET[$key];
            if($current_val_string == $value){
                $current_url = str_replace('&'.$key.'='.$_GET[$key], '', $current_url);
                $current_url = str_replace('?'.$key.'='.$_GET[$key], '?', $current_url);
            }
            $current_val_key = explode(',', $current_val_string);
            $val_encode = str_replace(',', '%2C', $current_val_string);
            if(!empty($current_val_string)){
                if(!in_array($value, $current_val_key)) $current_val_key[] = $value;
                else{
                    $pos = array_search($value, $current_val_key);
                    unset($current_val_key[$pos]);
                }            
                $new_val_string = implode('%2C', $current_val_key);
                $current_url = str_replace($key.'='.$val_encode, $key.'='.$new_val_string, $current_url);
                if (strpos($current_url, '?') == false) $current_url = str_replace('&','?',$current_url);
            }
            else $current_url = str_replace($key.'=', $key.'='.$value, $current_url);     
        }
        else{
            if(strpos($current_url,'?') > -1 ){
                $current_url .= '&amp;'.$key.'='.$value;
            }
            else {
                $current_url .= '?'.$key.'='.$value;
            }
        }
        return $current_url;
    }
}
if(!function_exists('sv_header_slider_shop')){
    function sv_header_slider_shop(){
        $header_show = sv_get_value_by_id('show_header');
        $header_data = sv_get_value_by_id('header_data');
        if(is_single()) $header_show = sv_get_value_by_id('show_header_single');
        $html = '';
        if(($header_show == 'on' || $header_show == 'yes') && !empty($header_data) && sv_is_woocommerce_page()){            
        $html .=    '<div class="banner-shop-slider">
                        <div class="wrap-item">';
            foreach ($header_data as $header) {
                $html .=    '<div class="item">
                                <div class="item-shop-slider">
                                    <div class="shop-slider-thumb">
                                        <a href="'.esc_url($header['link']).'"><img src="'.esc_url($header['image']).'" alt=""></a>
                                    </div>
                                    <div class="shop-slider-info">
                                        <h3>'.$header['title'].'</h3>
                                        <h2>'.$header['info'].'</h2>';
                if(!empty($header['label'])) $html .=    '<a href="'.esc_url($header['link']).'" class="shop-now">'.$header['label'].'</a>';
                $html .=            '</div>
                                </div>
                            </div>';
            }        
        $html .=        '</div>
                    </div>';
        }
        echo balanceTags($html);
    }
}
if(!function_exists('sv_list_cat_shop')){
    function sv_list_cat_shop($number = 7){
        $html = '';
        $check_show = sv_get_option('show_list_cat');
        if($check_show != 'off'){
            $cat_number = sv_get_option('list_cat_number');
            if(!empty($cat_number)) $number = (int)$cat_number;
            $cats = get_terms('product_cat');
            if(is_array($cats) && !empty($cats) && !is_single()){
                $html .=    '<div class="list-shop-cat">
                                <ul>';
                $count = 1;
                foreach ($cats as $cat) {
                    if(!$cat->parent && $cat->count > 0){
                        $cat_link = get_term_link( $cat->term_id, 'product_cat' );
                        $html .=    '<li><a href="'.esc_url($cat_link).'">'.$cat->name.' <span>'.$cat->count.'</span></a></li>';
                        if($count >= $number) break;
                        $count++;
                    }
                }
                $html .=        '</ul>
                            </div>';
            }
        }
        return $html;
    }
}
if(!function_exists('sv_single_product_meta')){
    function sv_single_product_meta(){
        $html_wl = '';
        global $post;
        if(class_exists('YITH_WCWL_Init')) $html_wl = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist product-wishlist" rel="nofollow" data-product-id="'.get_the_ID().'"><i class="fa fa-heart-o"></i></a>';
        $html = '<div class="product-social-extra">
                    '.$html_wl.'
                    '.sv_compare_url(true).'
                    <a class="email-link" href="'.esc_url('mailto:'.get_option('admin_email')).'"><i class="fa fa-envelope"></i></a>
                    <a class="print-link" href="javascript:window.print()"><i class="fa fa-print"></i></a>
                    <a class="share-link" href="#"><i class="fa fa-share"></i></a>
                    <div class="single-product-share">
                        <a href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'"><i class="fa fa-facebook"></i></a>
                        <a href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'"><i class="fa fa-twitter"></i></a>
                        <a href="'.esc_url('http://linkedin.com/shareArticle?mini=true&amp;url='.get_the_permalink().'&amp;title='.$post->post_name).'"><i class="fa fa-linkedin"></i></a>
                        <a href="'.esc_url('http://pinterest.com/pin/create/button/?url='.get_the_permalink().'&amp;media='.wp_get_attachment_url(get_post_thumbnail_id())).'"><i class="fa fa-pinterest"></i></a>
                        <a href="'.esc_url('https://plus.google.com/share?url='.get_the_permalink()).'"><i class="fa fa-google-plus"></i></a>
                    </div>
                </div>';
        return $html;
    }
}
//Don't Show popup
if(!is_admin()){
    session_start();
}
if(!isset($_SESSION['dont_show_popup'])) $_SESSION['dont_show_popup'] = false;
add_action( 'wp_ajax_set_dont_show', 'sv_set_dont_show' );
add_action( 'wp_ajax_nopriv_set_dont_show', 'sv_set_dont_show' );
if(!function_exists('sv_set_dont_show')){
    function sv_set_dont_show() {
        $checked = $_POST['checked'];
        if($checked){
            session_start();  
            $_SESSION['dont_show_popup'] = $checked;
        }
        else{
            unset($_SESSION['dont_show_popup']); 
            session_destroy();
        }
    }
}
if(!function_exists('sv_product_filter_box')){
    function sv_product_filter_box($prices = '',$attributes = ''){
        $html = '<div class="box-product-filter">
                    <div class="list-box-filter clearfix">
                        <div class="item-box-filter">
                            <h2>'.esc_html__("Sort By","aloshop").'</h2>
                            <ul>
                                <li><a class="load-data-filter" data-product_type="" href="#">'.esc_html__("Default","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="trendding" href="#">'.esc_html__("Trendding","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="toprate" href="#">'.esc_html__("Toprate","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="mostview" href="#">'.esc_html__("Mostview","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="onsale" href="#">'.esc_html__("Onsale","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="featured" href="#">'.esc_html__("Featured","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="popularity" href="#">'.esc_html__("Popularity","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="rating" href="#">'.esc_html__("Average rating","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="price-asc" href="#">'.esc_html__("Price: Low to High","aloshop").'</a></li>
                                <li><a class="load-data-filter" data-product_type="price-desc" href="#">'.esc_html__("Price: High to Low","aloshop").'</a></li>
                            </ul>
                        </div>';

        $prices = explode(',', $prices);
        $price_arange = sv_get_price_arange();
        $hide_price = sv_get_option('hide_price');
        if(is_array($prices) && !empty($prices) && $hide_price != 'on' ){
            $html .=    '<div class="item-box-filter">
                            <h2>'.esc_html__("Price","aloshop").'</h2>
                            <ul>
                                <li><a class="load-data-filter" data-price="" href="#">'.esc_html__("All","aloshop").'</a></li>';
            foreach ($prices as $key => $price) {
                if($key == 0) $html .=    '<li><a class="load-data-filter" data-price="'.$price_arange['min'].','.$price.'" href="#">'.get_woocommerce_currency_symbol().$price_arange['min'].'.00 - '.get_woocommerce_currency_symbol().$price.'.00</a></li>';
                else{
                    $html .=    '<li><a class="load-data-filter" data-price="'.$prices[$key-1].','.$price.'" href="#">'.get_woocommerce_currency_symbol().$prices[$key-1].'.00 - '.get_woocommerce_currency_symbol().$price.'.00</a></li>';
                    if($key == count($prices)-1) $html .=    '<li><a class="load-data-filter" data-price="'.$prices[$key].','.$price_arange['max'].'" href="#">'.get_woocommerce_currency_symbol().$prices[$key].'.00+</a></li>';
                }
            }
            $html .=        '</ul>
                        </div>';
        }
        $attributes = explode(',', $attributes);
        if(is_array($attributes) && !empty($attributes)){
            foreach ($attributes as $key => $attr) {
                $terms = get_terms("pa_".$attr);
                $html .=    '<div class="item-box-filter">
                                <h2>'. wc_attribute_label( $attr ).'</h2>
                                <ul>';
                if(is_array($terms)){
                    foreach ($terms as $term) {
                        if(is_object($term)){
                            if($attr =='color') $html .=    '<li><span class="color-filter color-'.$term->slug.'"></span><a class="load-data-filter" data-attribute="pa_'.$attr.'" data-term="'.$term->slug.'" href="#">'.$term->name.' </a></li>';
                            else $html .=   '<li><a class="load-data-filter" data-attribute="pa_'.$attr.'" data-term="'.$term->slug.'"  href="#">'.$term->name.'</a></li>';
                        }
                    }
                }
                $html .=        '</ul>
                            </div>';
            }
        }
        $html .=    '<div class="item-box-filter box-tags-filter">
                            <h2>'.esc_html__("Tags","aloshop").'</h2>
                            <ul>';
        $tags = get_terms('product_tag');
        if(is_array($tags)){
            foreach ($tags as $term) {
               if(is_object($term)){
                $html .=    '<li><a class="load-data-filter" data-tag="'.$term->slug.'" href="#">'.$term->name.' </a></li>';
               } 
            }
        }
        $html .=            '</ul>
                        </div>
                    </div>
                </div>';
        return $html;
    }
}
if(!function_exists('sv_get_attr_product_list')){
    function sv_get_attr_product_list(){
        global $wpdb,$wp;
        $list = array();
        $attribute_taxonomies = $wpdb->get_results( "
            SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies" );
        if(!empty($attribute_taxonomies)){
            foreach($attribute_taxonomies as $attr){
                $list[$attr->attribute_label] = $attr->attribute_name;
            }
        }
        return $list;
    }
}
if(!function_exists('sv_get_price_arange')){
    function sv_get_price_arange(){
        global $wpdb, $wp_the_query;
        $args       = $wp_the_query->query_vars;
        // $tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
        // $meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();
        if ( ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms'    => array( $args['term'] ),
                'field'    => 'slug',
            );
        }
        $tax_query  = array();
        $meta_query  = array();
        foreach ( $meta_query as $key => $query ) {
            if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
                unset( $meta_query[ $key ] );
            }
        }

        $meta_query = new WP_Meta_Query( $meta_query );
        $tax_query  = new WP_Tax_Query( $tax_query );

        $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
        $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );
        $sql  = "SELECT min( CAST( price_meta.meta_value AS UNSIGNED ) ) as min_price, max( CAST( price_meta.meta_value AS UNSIGNED ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= "   WHERE {$wpdb->posts}.post_type = 'product'
                    AND {$wpdb->posts}.post_status = 'publish'
                    AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
                    AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $prices = $wpdb->get_row( $sql );
        $price = array();
        $price['min'] = floor( $prices->min_price );
        $price['max'] = ceil( $prices->max_price );
        return $price;
    }
}
if(!function_exists('sv_filter_price')){
    function sv_filter_price($min,$max,$filtered_posts = array()){
        global $wpdb;
        $matched_products = array( 0 );
        $matched_products_query = apply_filters( 'woocommerce_price_filter_results', $wpdb->get_results( $wpdb->prepare("
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta ON ID = post_id
            WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value BETWEEN %d AND %d
        ", '_price', $min, $max ), OBJECT_K ), $min, $max );

        if ( $matched_products_query ) {
            foreach ( $matched_products_query as $product ) {
                if ( $product->post_type == 'product' )
                    $matched_products[] = $product->ID;
                if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) )
                    $matched_products[] = $product->post_parent;
            }
        }

        // Filter the id's
        if ( sizeof( $filtered_posts ) == 0) {
            $filtered_posts = $matched_products;
        } else {
            $filtered_posts = array_intersect( $filtered_posts, $matched_products );
        }
        return $filtered_posts;
    }
}
if(!function_exists('sv_scroll_top')){
    function sv_scroll_top(){
        $scroll_top = sv_get_value_by_id('show_scroll_top');
        if($scroll_top == 'on'):?>
        <a class="back-to-top" href="#"><?php esc_html_e("Top","aloshop")?></a>
        <?php endif;
    }
}
if(!function_exists('sv_get_more_info_product')){
    function sv_get_more_info_product(){
        $show = sv_get_option('show_product_data');
        if($show == 'on' && !sv_check_sidebar()){
            $title = sv_get_option('title_product_data');
            $data = sv_get_option('product_data');
            $html = '';
            if(!empty($data)){
                $html .=    '<div class="col-md-3 col-sm-4 col-xs-12">
                                <div class="sidebar-detail">
                                    <h2>'.$title.'</h2>
                                    <ul>';
            foreach ($data as $value) {
                $html .=    '<li>
                                <div class="work-icon">
                                    <a href="'.esc_url($value['link']).'"><img src="'.esc_url($value['image']).'" alt=""></a>
                                </div>
                                <div class="work-info">
                                    <h3><a href="'.esc_url($value['link']).'">'.$value['title'].'</a></h3>
                                </div>
                            </li>';
            }
                $html .=            '</ul>
                                </div>
                            </div>';
            }
            echo balanceTags($html);
        }

    }
}
if(!function_exists('sv_check_sidebar')){
    function sv_check_sidebar(){
        $sidebar = sv_get_sidebar();
        if($sidebar['position'] == 'no') return false;
        else return true;
    }
}
if(!function_exists('sv_substr')){
    function sv_substr($string='',$start=0,$end=1){
        $output = '';
        if(!empty($string)){
            $string = strip_tags($string);
            if($end < strlen($string)){
                if($string[$end] != ' '){
                    for ($i=$end; $i < strlen($string) ; $i++) { 
                        if($string[$i] == ' ' || $string[$i] == '.' || $i == strlen($string)-1){
                            $end = $i;
                            break;
                        }
                    }
                }
            }
            $output = substr($string,$start,$end);
        }
        return $output;
    }
}
if(!function_exists('sv_check_catelog_mode')){
    function sv_check_catelog_mode(){
        $catelog_mode = sv_get_option('woo_catelog');
        $hide_other_page = sv_get_option('hide_other_page');
        $hide_detail = sv_get_option('hide_detail');
        $hide_admin = sv_get_option('hide_admin');
        $hide_shop = sv_get_option('hide_shop');
        $hide_price = sv_get_option('hide_price');
        $show_mode = 'off';
        if($catelog_mode == 'on'){
            if($hide_other_page == 'on' && !is_super_admin() && !is_shop() && !is_single()) $show_mode = 'on';
            if($hide_other_page == 'on' && $hide_admin == 'on' && is_super_admin() && !is_shop() && !is_single() ) $show_mode = 'on';
            if(is_shop()) {
                if($hide_shop == 'on' && !is_super_admin()) $show_mode = 'on';
                if($hide_shop == 'on' && $hide_admin == 'on' && is_super_admin()) $show_mode = 'on';
            }
            if(is_single()) {
                if($hide_detail == 'on' && !is_super_admin()) $show_mode = 'on';
                if($hide_detail == 'on' && $hide_admin == 'on' && is_super_admin()) $show_mode = 'on';
            }
        }
        return $show_mode;
    }
}
if(!function_exists('sv_get_product_price')){
    function sv_get_product_price($style = ''){
        global $product;
        $show_mode = sv_check_catelog_mode();
        $hide_price = sv_get_option('hide_price');
        switch ($style) {
            case 'detail':
                $html = '<div class="info-price info-price-detail">
                            <label>'.esc_html__("Price:","aloshop").'</label> '.$product->get_price_html().'
                        </div>';
                break;

            case 'sale':
                $html = '<div class="info-price-deal">
                            '.$product->get_price_html().'
                            '.sv_get_saledeals_html().'
                        </div>';
                break;
            
            default:
                $html = '<div class="info-price">
                            '.$product->get_price_html().'
                        </div>';
                break;
        }        
        if($show_mode == 'on' && $hide_price == 'on'){
            $html = '';
        }
        return $html;
    }
}
if(!function_exists('sv_single_upsell_product'))
{
    function sv_single_upsell_product()
    {
        $check_show = sv_get_value_by_id('show_single_upsell');
        $number = sv_get_value_by_id('show_single_number');
        if(!$number) $number = 6;
        if($check_show == 'on' || $check_show == 'yes'){
            global $product;
            $upsells = $product->get_upsell_ids();
            ?>  
            <div class="upsell-detail">
                <h2 class="title-default"><?php esc_html_e("UPSELL PRODUCTS","aloshop")?></h2>
                <div class="upsell-detail-slider">
                    <div class="wrap-item">
                    <?php
                        $meta_query = WC()->query->get_meta_query();
                        $args = array(
                            'post_type'           => 'product',
                            'ignore_sticky_posts' => 1,
                            'no_found_rows'       => 1,
                            'posts_per_page'      => $number,
                            'post__in'            => $upsells,
                            'post__not_in'        => array( $product->get_id() ),
                            'meta_query'          => $meta_query
                        );
                        $products = new WP_Query( $args );
                        if ( $products->have_posts() ) :
                            while ( $products->have_posts() ) : 
                                $products->the_post();                                  
                                global $product;
                                echo    '<div class="item">
                                            <div class="item-product">
                                                '.sv_product_thumb_hover(array(268,322)).'
                                                <div class="product-info">
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html().'
                                                </div>
                                            </div>
                                        </div>';
                    ?>
                    
                    <?php   endwhile;
                        endif;
                        wp_reset_postdata();
                    ?>
                    </div>
                </div>
            </div>
        <?php
        }
    }
}
if(!function_exists('sv_single_lastest_product'))
{
    function sv_single_lastest_product()
    {
        $check_show = sv_get_value_by_id('show_single_lastest');
        $number = sv_get_value_by_id('show_single_number');
        if(!$number) $number = 6;
        if($check_show == 'on' || $check_show == 'yes'){
            global $product;
            ?>
            <div class="upsell-detail">
                <h2 class="title-default"><?php esc_html_e("LASTEST PRODUCTS","aloshop")?></h2>
                <div class="upsell-detail-slider">
                    <div class="wrap-item">
                    <?php
                        $args = array(
                            'post_type'           => 'product',
                            'ignore_sticky_posts' => 1,
                            'posts_per_page'      => $number,
                            'post__not_in'        => array( $product->get_id() ),
                            'orderby'             => 'date'
                        );
                        $products = new WP_Query( $args );
                        if ( $products->have_posts() ) :
                            while ( $products->have_posts() ) : 
                                $products->the_post();                                  
                                global $product;
                                echo    '<div class="item">
                                            <div class="item-product">
                                                '.sv_product_thumb_hover(array(268,322)).'
                                                <div class="product-info">
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html().'
                                                </div>
                                            </div>
                                        </div>';
                    ?>
                    
                    <?php   endwhile;
                        endif;
                        wp_reset_postdata();
                    ?>
                    </div>
                </div>
            </div>
        <?php
        }
    }
}
if(!function_exists('sv_single_relate_product'))
{
    function sv_single_relate_product()
    {        
        global $product;
        $check_show = sv_get_value_by_id('show_single_relate');
        $number = sv_get_value_by_id('show_single_number');
        if(!$number) $number = 6;
        $related = wc_get_related_products($product->get_id(),$number);
        if($check_show == 'on' || $check_show == 'yes'){
            ?>
            <div class="upsell-detail">
                <h2 class="title-default"><?php esc_html_e("RELATED PRODUCTS","aloshop")?></h2>
                <div class="upsell-detail-slider">
                    <div class="wrap-item">
                    <?php
                        $args = array(
                            'post_type'           => 'product',
                            'ignore_sticky_posts'  => 1,
                            'no_found_rows'        => 1,
                            'posts_per_page'       => $number,
                            'post__in'             => $related,
                            'post__not_in'         => array( $product->get_id() )
                        );
                        $products = new WP_Query( $args );
                        if ( $products->have_posts() ) :
                            while ( $products->have_posts() ) : 
                                $products->the_post();                                  
                                global $product;
                                echo    '<div class="item">
                                            <div class="item-product">
                                                '.sv_product_thumb_hover(array(268,322)).'
                                                <div class="product-info">
                                                    <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    '.sv_get_product_price().'
                                                    '.sv_get_rating_html().'
                                                </div>
                                            </div>
                                        </div>';
                    ?>
                    
                    <?php   endwhile;
                        endif;
                        wp_reset_postdata();
                    ?>
                    </div>
                </div>
            </div>
        <?php
        }
    }
}
function sv_get_image_by_url($image_src,$size,$class=''){
    global $wpdb;
    $width = $height = '';
    if(is_array($size)){
        $width = $size[0];
        $height = $size[1];
    }
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    if($id) $html = wp_get_attachment_image($id,$size,0,array('class'=>$class));
    else $html = '<img width="'.esc_attr($width).'"  height="'.esc_attr($height).'" class="'.esc_attr($class).'" alt="" src="'.esc_url($image_src).'">';
    return $html;
}
if(!function_exists('s7upf_get_icon_params')){
    function s7upf_get_icon_params($key = '',$value = ''){
        $params = array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__( 'Icon library', 'aloshop' ),
                'value' => array(
                    esc_html__( 'Font Awesome', 'aloshop' ) => 'fontawesome',
                    esc_html__( 'Open Iconic', 'aloshop' ) => 'openiconic',
                    esc_html__( 'Typicons', 'aloshop' ) => 'typicons',
                    esc_html__( 'Entypo', 'aloshop' ) => 'entypo',
                    esc_html__( 'Linecons', 'aloshop' ) => 'linecons',
                    esc_html__( 'Mono Social', 'aloshop' ) => 'monosocial',
                ),
                'param_name' => 'type',
                'description' => esc_html__( 'Select icon library.', 'aloshop' ),
                'dependency' => array(
                    'element' => $key,
                    'value' => $value,
                    )
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'aloshop' ),
                'param_name' => 'icon_fontawesome',
                'value' => 'fa fa-adjust', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false,
                    // default true, display an "EMPTY" icon?
                    'iconsPerPage' => 4000,
                    // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'fontawesome',
                ),
                'description' => esc_html__( 'Select icon from library.', 'aloshop' ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'aloshop' ),
                'param_name' => 'icon_openiconic',
                'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'openiconic',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'openiconic',
                ),
                'description' => esc_html__( 'Select icon from library.', 'aloshop' ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'aloshop' ),
                'param_name' => 'icon_typicons',
                'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'typicons',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'typicons',
                ),
                'description' => esc_html__( 'Select icon from library.', 'aloshop' ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'aloshop' ),
                'param_name' => 'icon_entypo',
                'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'entypo',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'entypo',
                ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'aloshop' ),
                'param_name' => 'icon_linecons',
                'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'linecons',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'linecons',
                ),
                'description' => esc_html__( 'Select icon from library.', 'aloshop' ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'aloshop' ),
                'param_name' => 'icon_monosocial',
                'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
                'settings' => array(
                    'emptyIcon' => false, // default true, display an "EMPTY" icon?
                    'type' => 'monosocial',
                    'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                'dependency' => array(
                    'element' => 'type',
                    'value' => 'monosocial',
                ),
                'description' => esc_html__( 'Select icon from library.', 'aloshop' ),
            ),
        );
        return $params;
    }
}
if ( ! function_exists( 's7upf_catalog_ordering' ) ) {
    function s7upf_catalog_ordering($query,$set_orderby = '') {        
        $orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        if(!empty($set_orderby)) $orderby = $set_orderby;
        $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
            'menu_order' => __( 'Default sorting', 'aloshop' ),
            'popularity' => __( 'Sort by popularity', 'aloshop' ),
            'rating'     => __( 'Sort by average rating', 'aloshop' ),
            'date'       => __( 'Sort by newness', 'aloshop' ),
            'price'      => __( 'Sort by price: low to high', 'aloshop' ),
            'price-desc' => __( 'Sort by price: high to low', 'aloshop' )
        ) );

        if ( ! $show_default_orderby ) {
            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
            unset( $catalog_orderby_options['rating'] );
        }

        wc_get_template( 'loop/orderby.php', array( 'catalog_orderby_options' => $catalog_orderby_options, 'orderby' => $orderby, 'show_default_orderby' => $show_default_orderby ) );
    }
}
if(!function_exists('s7upf_get_product_by_sku')){
    function s7upf_get_product_by_sku( $sku ) {
        global $wpdb;

        $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );
        $post = get_post( $product_id );
        if ( $product_id ) return $post->post_parent;

        return null;
    }
}

/***************************************END Theme Function***************************************/
