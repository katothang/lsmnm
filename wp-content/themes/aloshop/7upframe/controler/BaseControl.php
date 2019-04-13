<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!defined('ABSPATH')) return;

if(!class_exists('SV_BaseController'))
{
    class SV_BaseController
    {
        static function _init()
        {
            //Default Framwork Hooked

            add_filter( 'wp_title', array(__CLASS__,'_wp_title'), 10, 2 );
            add_action( 'wp', array(__CLASS__,'_setup_author') );
            add_action( 'after_setup_theme', array(__CLASS__,'_after_setup_theme') );
            add_action('widgets_init',array(__CLASS__,'_add_sidebars'));

            add_action('wp_enqueue_scripts',array(__CLASS__,'_add_scripts'));

            //Custom hooked
            add_filter('sv_get_sidebar',array(__CLASS__,'_blog_filter_sidebar'));
            
            add_action('wp_head',array(__CLASS__,'_show_custom_css'),100);

            add_action('admin_enqueue_scripts',array(__CLASS__,'_add_admin_scripts'));
            add_action('admin_footer',array(__CLASS__,'_init_admin_scripts'));

            add_filter( 'style_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
            add_filter( 'script_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );

            add_filter( 'user_contactmethods', array(__CLASS__,'_add_author_profile'), 10, 1);

            add_filter('body_class', array(__CLASS__,'sv_body_classes'));
            
            if(class_exists("woocommerce") && !is_admin()){
                add_action( 'pre_get_posts', array(__CLASS__,'_product_widget_filter'),100);
                add_action('woocommerce_product_query', array(__CLASS__, '_woocommerce_product_query'), 20);
            }

            // add_action( 'register_form', array(__CLASS__,'_show_extra_register_fields' ));
            // Check the form for errors
            add_action( 'register_post', array(__CLASS__,'_check_extra_register_fields'), 10, 3 );

            add_action( 'user_register', array(__CLASS__,'_register_extra_fields'), 100 );

            // Search sku
            add_filter('posts_join', array(__CLASS__,'s7upf_product_search_join' ));
            add_filter( 'posts_where', array(__CLASS__,'s7upf_product_search_where' ));

            // Before/After append settings
            $terms = array('product_cat','product_tag');
            foreach ($terms as $term_name) {
                add_action($term_name.'_add_form_fields', array(__CLASS__,'s7upf_product_cat_metabox_add'), 10, 1);
                add_action($term_name.'_edit_form_fields', array(__CLASS__,'s7upf_product_cat_metabox_edit'), 10, 1);    
                add_action('created_'.$term_name, array(__CLASS__,'s7upf_product_save_category_metadata'), 10, 1);    
                add_action('edited_'.$term_name, array(__CLASS__,'s7upf_product_save_category_metadata'), 10, 1);
            }
            // Before/After append display
            add_action('content_append_before', array(__CLASS__,'s7upf_append_content_before'), 10);
        }

        static function s7upf_product_cat_metabox_add($tag) { 
            ?>
            <div class="form-field">
                <label><?php esc_html_e('Append Content Before','7upframework'); ?></label>
                <div class="wrap-metabox-field">
                    <select name="before_append" id="before_append">
                        <?php
                        $mega_pages = s7upf_list_post_type('s7upf_mega_item',false);
                        foreach ($mega_pages as $key => $value) {
                            echo '<option value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        <?php }
        static function s7upf_product_cat_metabox_edit($tag) { ?>
            <tr class="form-field">
                <th scope="row" valign="top">
                    <label><?php esc_html_e('Append Content Before','7upframework'); ?></label>
                </th>
                <td>            
                    <div class="wrap-metabox-field">
                        <select name="before_append" id="before_append">
                            <?php
                            $page = get_term_meta($tag->term_id, 'before_append', true);
                            $mega_pages = s7upf_list_post_type('s7upf_mega_item',false);
                            foreach ($mega_pages as $key => $value) {
                                $selected = selected($key,$page,false);
                                echo '<option '.$selected.' value="'.esc_attr($key).'">'.esc_html($value).'</option>';
                            }
                            ?>
                        </select>
                    </div>            
                </td>
            </tr>
        <?php 
        }
        static function s7upf_product_save_category_metadata($term_id){
            if (isset($_POST['before_append'])) update_term_meta( $term_id, 'before_append', $_POST['before_append']);
        }

        static function s7upf_append_content_before(){        
            $woo_id = sv_get_option('before_append_woo');
            $post_id = sv_get_option('before_append_post');
            if(sv_is_woocommerce_page()) $page_id = $woo_id;
            elseif(is_home() || is_archive() || is_search() || is_singular('post')) $page_id = $post_id;
            else $page_id = sv_get_option('before_append_page'); 
            $id = s7upf_get_current_id();
            $meta_id = get_post_meta($id,'before_append',true);
            if(!empty($meta_id)) $page_id = $meta_id;
            if(function_exists('is_shop')) $is_shop = is_shop();
            else $is_shop = false;           
            if(is_archive() && !$is_shop){
                global $wp_query;
                $term = $wp_query->get_queried_object();
                if(isset($term->term_id)) $cat_id = get_term_meta($term->term_id, 'before_append', true);
                else $cat_id = '';
                if(!empty($cat_id)) $page_id = $cat_id;
            }
            if(!empty($page_id)) echo '<div class="content-append-before">'.SV_Template::get_vc_pagecontent($page_id).'</div>';
        }

        static function _add_scripts()
        {
            $css_url = get_template_directory_uri() . '/assets/css/';
            $js_url = get_template_directory_uri() . '/assets/js/';
            /*
             * Javascript
             * */
            if ( is_singular() && comments_open()){
            wp_enqueue_script( 'comment-reply' );
            }
            //Register JS
            wp_register_script( 'bootstrap',$js_url.'lib/bootstrap.min.js',array('jquery'),null,true);
            wp_register_script( 'google-map', "//maps.google.com/maps/api/js?key=AIzaSyBX2IiEBg-0lQKQQ6wk6sWRGQnWI7iogf0", array('jquery'), null, true );
            wp_register_script( 'jquery-fancybox',$js_url.'/lib/jquery.fancybox.js',array('jquery'),null,true);
            wp_register_script( 'jquery-ui',$js_url.'/lib/jquery-ui.js',array('jquery'),null,true);
            wp_register_script( 'owl-carousel',$js_url.'/lib/owl.carousel.js',array('jquery'),null,true);
            wp_register_script( 'timeCircles',$js_url.'/lib/TimeCircles.js',array('jquery'),null,true);
            wp_register_script( 'masonry',$js_url.'/lib/masonry.pkgd.min.js',array('jquery'),null,true);
            wp_register_script( 'jcarousellite',$js_url.'/lib/jquery.jcarousellite.js',array('jquery'),null,true);
            wp_register_script( 'elevatezoom',$js_url.'/lib/jquery.elevatezoom.js',array('jquery'),null,true);
            wp_register_script( 'modernizr-custom',$js_url.'/lib/modernizr.custom.js',array('jquery'),null,true);
            wp_register_script( 'hoverdir',$js_url.'/lib/jquery.hoverdir.js',array('jquery'),null,true);
            wp_register_script( 'themepunch-revolution',$js_url.'/lib/jquery.themepunch.revolution.min.js',array('jquery'),null,true);
            wp_register_script( 'themepunch-plugins',$js_url.'/lib/jquery.themepunch.plugins.min.js',array('jquery'),null,true);
            wp_register_script( 'bxslider',$js_url.'/lib/jquery.bxslider.min.js',array('jquery'),null,true);
            wp_register_script( 'mCustomScrollbar',$js_url.'/lib/jquery.mCustomScrollbar.concat.min.js',array('jquery'),null,true);
            wp_register_script( 'pieChart',$js_url.'lib/PieChart.js',array('jquery'),null,true);
            wp_register_script( 'circles',$js_url.'lib/circles.js',array('jquery'),null,true);
            wp_register_script( 'sv-script-map',$js_url.'map.js',array('jquery'),null,true);
            wp_register_script( 'sv-script',$js_url.'script.js',array('jquery'),null,true);
            //ENQUEUE JS
            if(class_exists("woocommerce")){
                global $woocommerce;
                wp_enqueue_script( 'wc-add-to-cart-variation', $woocommerce->plugin_url() . '/assets/js/frontend/add-to-cart-variation.min.js', array('jquery'), '1.6', true );
            }
            wp_enqueue_script('bootstrap');
            wp_enqueue_script('jquery-fancybox');
            wp_enqueue_script('jquery-ui');
            wp_enqueue_script('owl-carousel');
            wp_enqueue_script('jcarousellite');
            wp_enqueue_script('elevatezoom');
            wp_enqueue_script('mCustomScrollbar');
            wp_enqueue_script('sv-script');
            wp_enqueue_script( 'sv-ajax', $js_url.'ajax.js', array( 'jquery' ),null,true);
            wp_localize_script( 'sv-ajax', 'ajax_process', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
            

            // CSS
            wp_enqueue_style('open-sans-css','https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' );
            wp_enqueue_style('bootstrap',$css_url.'lib/bootstrap.min.css');
            wp_enqueue_style('font-awesome',$css_url.'lib/font-awesome.min.css');
            wp_enqueue_style('font-linearicons',$css_url.'lib/font-linearicons.css');
            wp_enqueue_style('bootstrap-theme',$css_url.'lib/bootstrap-theme.css');
            wp_enqueue_style('jquery-fancybox',$css_url.'lib/jquery.fancybox.css');
            wp_enqueue_style('jquery-ui',$css_url.'lib/jquery-ui.css');
            wp_enqueue_style('owl-carousel',$css_url.'lib/owl.carousel.css');
            wp_enqueue_style('owl-transitions',$css_url.'lib/owl.transitions.css');
            wp_enqueue_style('piechart',$css_url.'lib/PieChart.css');
            wp_enqueue_style('owl-theme',$css_url.'lib/owl.theme.css');
            wp_enqueue_style('mCustomScrollbar',$css_url.'lib/jquery.mCustomScrollbar.css');
            wp_enqueue_style('sv-settings',$css_url.'lib/settings.css');
            wp_enqueue_style('sv-theme-unitest',$css_url.'theme-unitest.css');            
            wp_enqueue_style('sv-default',$css_url.'lib/theme.css');
            wp_enqueue_style('sv-theme-style',$css_url.'custom-style.css');
            wp_enqueue_style('sv-responsive',$css_url.'lib/responsive.css');
            wp_enqueue_style('sv-responsive-fix',$css_url.'lib/responsive-fix.css');
            wp_enqueue_style('sv-theme-default',get_stylesheet_uri());

        }


        static function _show_custom_css()
        {
            $style=SV_Template::load_view('custom_css');?>

            <style id="sv_cutom_css">
                <?php print ($style);?>
            </style>

            <?php echo "\n";

        }

        static function _blog_filter_sidebar($sidebar)
        {
            if((!is_front_page() && is_home()) || (is_front_page() && is_home())){
                $pos=sv_get_option('sv_sidebar_position_blog');
                $sidebar_id=sv_get_option('sv_sidebar_blog');
            }
            else{
                if(is_single()){
                    $pos = sv_get_option('sv_sidebar_position_post');
                    $sidebar_id = sv_get_option('sv_sidebar_post');
                }
                else{
                    $pos = sv_get_option('sv_sidebar_position_page');
                    $sidebar_id = sv_get_option('sv_sidebar_page');
                }        
            }
            if(class_exists( 'WooCommerce' )){
                if(sv_is_woocommerce_page()){
                    $pos = sv_get_option('sv_sidebar_position_woo');
                    $sidebar_id = sv_get_option('sv_sidebar_woo');
                    if(is_single()){
                        $pos = sv_get_option('sv_sidebar_position_woo_detail');
                        $sidebar_id = sv_get_option('sv_sidebar_woo_detail');
                    }
                }
            }
            if(is_archive() && !sv_is_woocommerce_page()){
                $pos = sv_get_option('sv_sidebar_position_page_archive');
                $sidebar_id = sv_get_option('sv_sidebar_page_archive');
            }
            else{
                if(!is_home()){
                    $id = get_the_ID();
                    if(is_404()) $id = sv_get_option('sv_404_page');
                    if(is_front_page()) $id = (int)get_option('page_on_front');
                    if(is_archive() || is_search()) $id = 0;
                    if (class_exists('woocommerce')) {
                        if(is_shop()) $id = (int)get_option('woocommerce_shop_page_id');
                        if(is_cart()) $id = (int)get_option('woocommerce_cart_page_id');
                        if(is_checkout()) $id = (int)get_option('woocommerce_checkout_page_id');
                        if(is_account_page()) $id = (int)get_option('woocommerce_myaccount_page_id');
                    }
                    $sidebar_pos = get_post_meta($id,'sv_sidebar_position',true);
                    $id_side_post = get_post_meta($id,'sv_select_sidebar',true);
                    if(!empty($sidebar_pos)){
                        $pos = $sidebar_pos;
                        if(!empty($id_side_post)) $sidebar_id = $id_side_post;
                    }
                }
            }
            if(is_search()) {
                $sidebar_id = 'blog-sidebar';
                $pos = 'left';
                if(sv_is_woocommerce_page()){
                    $pos = 'left';
                    if(is_active_sidebar('woocommerce-sidebar')) $sidebar_id = 'woocommerce-sidebar';
                }
            }
            if($sidebar_id){
                $sidebar['id']=$sidebar_id;
            }

            if($pos){
                $sidebar['position']=$pos;
            }

            return $sidebar;
        }
        
        
        // -----------------------------------------------------
        // Default Hooked, Do not edit

        /**
         * Hook setup theme
         *
         *
         * */

        static function _after_setup_theme()
        {
            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on stframework, use a find and replace
             * to change LANGUAGE to the name of your theme in all the template files
             */

            // This theme uses wp_nav_menu() in one location.
            global $sv_config;
            $menus= $sv_config['nav_menu'];
            if(is_array($menus) and !empty($menus) )
            {
                register_nav_menus($menus);
            }


            add_theme_support( "title-tag" );
            add_theme_support('automatic-feed-links');
            add_theme_support('post-thumbnails');
            add_theme_support('html5',array(
                'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
            ));
            add_theme_support('post-formats',array(
                'image', 'video', 'gallery','audio','quote'
            ));
            add_theme_support('custom-header');
            add_theme_support('custom-background');
            add_theme_support('woocommerce');
        }

        /**
         * Add default sidebar to website
         *
         *
         * */
        static function _add_sidebars()
        {
            // From config file
            global $sv_config;
            $sidebars = $sv_config['sidebars'];
            if(is_array($sidebars) and !empty($sidebars) )
            {
                foreach($sidebars as $value){
                    register_sidebar($value);
                }
            }
            $add_sidebars = sv_get_option('sv_add_sidebar');
            if(is_array($add_sidebars) and !empty($add_sidebars) )
            {
                foreach($add_sidebars as $sidebar){
                    if(!empty($sidebar['title'])){
                        $id = strtolower(str_replace(' ', '-', $sidebar['title']));
                        $custom_add_sidebar = array(
                                'name' => $sidebar['title'],
                                'id' => $id,
                                'description' => esc_html__( 'SideBar created by add sidebar in theme options.', 'aloshop'),
                                'before_title' => '<'.$sidebar['widget_title_heading'].' class="widget-title">',
                                'after_title' => '</'.$sidebar['widget_title_heading'].'>',
                                'before_widget' => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                                'after_widget'  => '</div>',
                            );
                        register_sidebar($custom_add_sidebar);
                        unset($custom_add_sidebar);
                    }
                }
            }

        }


        /**
         * Set up author data
         *
         * */
        static function _setup_author() {
            global $wp_query;

            if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
                $GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
            }
        }


        /**
         * Hook to wp_title
         *
         * */
        static function _wp_title($title,$sep)
        {
            return $title;
        }
        
        static function  _init_admin_scripts()
        {
            ?>
            <script>
                jQuery(document).ready(function($){
                    $('.sv_iconpicker').iconpicker();


                    //This for VC Elements
                    $(document).on('click','div.sv_iconpicker input[type=text]',function(){

                        if(!$(this).hasClass('st_icp_inited'))
                        {
                            $(this).iconpicker({
                                'container':'body'
                            });

                            $(this).addClass('st_icp_inited').data('iconpicker').show();
                        }
                    });
                    $(document).on('click','input.sv_iconpicker',function(){

                        if(!$(this).hasClass('st_icp_inited'))
                        {
                            $(this).iconpicker({
                                'container':'body'
                            });
                            $(this).parent().parent().attr('style','overflow:inherit !important');
                            $(this).addClass('st_icp_inited').data('iconpicker').show();
                        }
                    });
                });

            </script>

            <?php
        }

        static function _add_admin_scripts()
        {
            $admin_url = get_template_directory_uri().'/assets/admin/';
            wp_enqueue_media();
            wp_enqueue_script( 'sv-admin-js', $admin_url . '/js/admin.js', array( 'jquery' ),null,true );
            wp_enqueue_script('st-iconpicker',$admin_url.'/js/fontawesome-iconpicker.js',array('jquery'),null,true);
            add_editor_style();
            wp_enqueue_style( 'st-fontawesome',$admin_url.'css/font-awesome.css');
            wp_enqueue_style( 'st-custom-admin',$admin_url.'css/custom.css');
            wp_enqueue_style( 'st-iconpicker',$admin_url.'css/fontawesome-iconpicker.min.css');
        }

        static function _remove_enqueue_ver($src)    {
            if (strpos($src, '?ver='))
                $src = remove_query_arg('ver', $src);
            return $src;
        }

        static function _add_author_profile( $contactmethods ) {       
            $contactmethods['author_position'] = esc_html__('Position','aloshop');   
            return $contactmethods;
        }
        static function _woocommerce_product_query($query){
            if($query->get( 'post_type' ) == 'product'){
                $query->set('post__not_in', '');
            } 
        }
        static function _product_widget_filter($query) {
            global $wp_query,$wpdb;
            if(is_object($query)){
                if($query->get( 'post_type' ) == 'product') $query->set( 'post_status ', 'publish');
                if( $query->is_main_query() and
                    ( ( $query->get( 'post_type' ) == 'product' or $query->get( 'product_cat' ) )
                    or
                    $query->is_page() && 'page' == get_option( 'show_on_front' ) && $query->get('page_id') == wc_get_page_id('shop')
                    or is_product_taxonomy() )
                ) {
                    $attr_taxquery = array();
                    if( isset( $_REQUEST['number'])) $query->set( 'posts_per_page',$_REQUEST['number']);
                    $attribute_taxonomies = $wpdb->get_results( "
                        SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies" );
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
                    if(isset($_REQUEST['thuong_hieu'])){
                        $term = $_REQUEST['thuong_hieu'];
                        $term = explode(',', $term);
                        $attr_taxquery[] =  array(
                                                'taxonomy'      => 'thuong_hieu',
                                                'terms'         => $term,
                                                'field'         => 'slug',
                                                'operator'      => 'IN'
                                            );
                    }
                    if(isset($_REQUEST['xuat_xu'])){
                        $term = $_REQUEST['xuat_xu'];
                        $term = explode(',', $term);
                        $attr_taxquery[] =  array(
                                                'taxonomy'      => 'xuat_xu',
                                                'terms'         => $term,
                                                'field'         => 'slug',
                                                'operator'      => 'IN'
                                            );
                    }
                    $current_meta = $query->get( 'meta_query');
                    if ( !is_admin() && !empty($attr_taxquery)){                        
                        $attr_taxquery['relation'] =  'AND';
                        $query->set( 'tax_query', $attr_taxquery);
                        return;
                    }
                    if(is_search()){
                        $sku = $_REQUEST['s'];
                        $product_id = s7upf_get_product_by_sku($sku);
                        if($product_id){
                            $query->set( 'p', $product_id);
                            $query->set( 's', '');
                        }
                    }
                }
            }
        }

        static function _show_extra_register_fields(){
            echo '<p>
                    <label for="repeat_password">'.esc_html__("Repeat password","aloshop").'<br/>
                    <input id="repeat_password" class="input" type="password" tabindex="40" size="25" value="" name="repeat_password" />
                    </label>
                </p>';
        }
        // Check the form for errors
        static function _check_extra_register_fields($login, $email, $errors) {
            if ( $_POST['password'] !== $_POST['repeat_password'] ) {
                $errors->add( 'passwords_not_matched', "<strong>".esc_html__("ERROR","aloshop")."</strong>: ".esc_html__("Passwords must match","aloshop")."" );
            }
            if ( strlen( $_POST['password'] ) < 8 ) {
                $errors->add( 'password_too_short', "<strong>".esc_html__("ERROR","aloshop")."</strong>: ".esc_html__("Passwords must be at least eight characters long","aloshop")."" );
            }
        }
        
        static function _register_extra_fields( $user_id ){
            $userdata = array();
            $userdata['ID'] = $user_id;
            if(isset($_POST['password'])){
                if ( $_POST['password'] !== '' ) {
                    $userdata['user_pass'] = $_POST['password'];
                }
                $new_user_id = wp_update_user( $userdata );
            }
        }
        static function sv_body_classes($classes) {
            $thumb_click = sv_get_option('product_thumb_click');
            $shop_ajax = sv_get_value_by_id('shop_ajax');
            if($shop_ajax == 'on') $classes[] = 'shop-ajax-enable';
            if(is_rtl()) $classes[] = 'rtl-enable';
            $theme_info = wp_get_theme();
            $classes[] = 'theme-ver-'.$theme_info['Version'];
            $classes[] = 'thumb-click-'.$thumb_click;
            return $classes;
        }

        static function s7upf_product_search_join( $join ) {
            if( is_admin() || ! is_search() || ! is_woocommerce() ) {
                return $join;
            }
         
            global $wpdb;
         
            $join .= " LEFT JOIN {$wpdb->postmeta} post_meta ON {$wpdb->posts}.ID = post_meta.post_id ";
         
            return $join;
        }
        static function s7upf_product_search_where( $where ) {
            if( is_admin() || ! is_search() || ! is_woocommerce() ) {
                return $where;
            }
         
            global $wpdb;
         
            $where = preg_replace("/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
                "({$wpdb->posts}.post_title LIKE $1) OR (post_meta.meta_key = '_sku' AND post_meta.meta_value LIKE $1)", $where );
         
            return $where;
        }
    }

    SV_BaseController::_init();
}
