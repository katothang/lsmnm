<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!function_exists('sv_set_theme_config')){
    function sv_set_theme_config(){
        global $sv_dir,$sv_config;
        /**************************************** BEGIN ****************************************/
        $sv_dir = get_template_directory_uri() . '/7upframe';
        $sv_config = array();
        $sv_config['dir'] = $sv_dir;
        $sv_config['css_url'] = $sv_dir . '/assets/css/';
        $sv_config['js_url'] = $sv_dir . '/assets/js/';
        $sv_config['nav_menu'] = array(
            'primary' => esc_html__( 'Primary Navigation', 'aloshop' ),
        );
        $sv_config['mega_menu'] = '1';
        $sv_config['sidebars']=array(
            array(
                'name'              => esc_html__( 'Blog Sidebar', 'aloshop' ),
                'id'                => 'blog-sidebar',
                'description'       => esc_html__( 'Widgets in this area will be shown on all blog page.', 'aloshop'),
                'before_title'      => '<h3 class="widget-title">',
                'after_title'       => '</h3>',
                'before_widget'     => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                'after_widget'      => '</div>',
            )
        );
        $sv_config['import_config'] = array(
                'homepage_default'          => 'Home',
                'blogpage_default'          => 'Blog',
                'menu_locations'            => array("Main Menu" => "primary"),
                'set_woocommerce_page'      => 1
            );
        $sv_config['import_theme_option'] = 'YTozOTp7czoxNDoic3ZfaGVhZGVyX3BhZ2UiO3M6MjoiMTUiO3M6MTQ6InN2X2Zvb3Rlcl9wYWdlIjtzOjI6IjE3IjtzOjExOiJzdl80MDRfcGFnZSI7czowOiIiO3M6MTU6InNob3dfc2Nyb2xsX3RvcCI7czozOiJvZmYiO3M6MTA6ImVuYWJsZV9ydGwiO3M6Mzoib2ZmIjtzOjE3OiJzdl9zaG93X2JyZWFkcnVtYiI7czozOiJvZmYiO3M6MTY6InN2X2JnX2JyZWFkY3J1bWIiO3M6MDoiIjtzOjEwOiJtYWluX2NvbG9yIjtzOjA6IiI7czoxMToibWFpbl9jb2xvcjIiO3M6MDoiIjtzOjEwOiJjdXN0b21fY3NzIjtzOjA6IiI7czo0OiJsb2dvIjtzOjczOiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9hbG9zaG9wL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE2LzA0L2xvZ28ucG5nIjtzOjc6ImZhdmljb24iO3M6NzI6Imh0dHA6Ly83dXB0aGVtZS5jb20vd29yZHByZXNzL2Fsb3Nob3Avd3AtY29udGVudC91cGxvYWRzLzIwMTYvMDQvN3VwLmpwZyI7czoxMzoic3ZfbWVudV9maXhlZCI7czozOiJvZmYiO3M6MTM6InN2X21lbnVfY29sb3IiO3M6MDoiIjtzOjE5OiJzdl9tZW51X2NvbG9yX2hvdmVyIjtzOjA6IiI7czoyMDoic3ZfbWVudV9jb2xvcl9hY3RpdmUiO3M6MDoiIjtzOjI0OiJzdl9zaWRlYmFyX3Bvc2l0aW9uX2Jsb2ciO3M6NDoibGVmdCI7czoxNToic3Zfc2lkZWJhcl9ibG9nIjtzOjEyOiJibG9nLXNpZGViYXIiO3M6MjQ6InN2X3NpZGViYXJfcG9zaXRpb25fcGFnZSI7czoyOiJubyI7czoxNToic3Zfc2lkZWJhcl9wYWdlIjtzOjA6IiI7czozMjoic3Zfc2lkZWJhcl9wb3NpdGlvbl9wYWdlX2FyY2hpdmUiO3M6NDoibGVmdCI7czoyMzoic3Zfc2lkZWJhcl9wYWdlX2FyY2hpdmUiO3M6MTI6ImJsb2ctc2lkZWJhciI7czoyNDoic3Zfc2lkZWJhcl9wb3NpdGlvbl9wb3N0IjtzOjQ6ImxlZnQiO3M6MTU6InN2X3NpZGViYXJfcG9zdCI7czoxMjoiYmxvZy1zaWRlYmFyIjtzOjE0OiJzdl9hZGRfc2lkZWJhciI7YToyOntpOjA7YToyOntzOjU6InRpdGxlIjtzOjE5OiJXb29jb21tZXJjZSBzaWRlYmFyIjtzOjIwOiJ3aWRnZXRfdGl0bGVfaGVhZGluZyI7czoyOiJoMyI7fWk6MTthOjI6e3M6NToidGl0bGUiO3M6MTQ6IlNpbmdsZSBTaWRlYmFyIjtzOjIwOiJ3aWRnZXRfdGl0bGVfaGVhZGluZyI7czoyOiJoMyI7fX1zOjEyOiJnb29nbGVfZm9udHMiO2E6MTp7aTowO2E6MTp7czo2OiJmYW1pbHkiO3M6MDoiIjt9fXM6MjM6InN2X3NpZGViYXJfcG9zaXRpb25fd29vIjtzOjQ6ImxlZnQiO3M6MTQ6InN2X3NpZGViYXJfd29vIjtzOjE5OiJ3b29jb21tZXJjZS1zaWRlYmFyIjtzOjMwOiJzdl9zaWRlYmFyX3Bvc2l0aW9uX3dvb19kZXRhaWwiO3M6NDoibGVmdCI7czoyMToic3Zfc2lkZWJhcl93b29fZGV0YWlsIjtzOjE0OiJzaW5nbGUtc2lkZWJhciI7czoxMToic2hvd19oZWFkZXIiO3M6Mjoib24iO3M6MTg6InNob3dfaGVhZGVyX3NpbmdsZSI7czozOiJvZmYiO3M6MTE6ImhlYWRlcl9kYXRhIjthOjM6e2k6MDthOjU6e3M6NToidGl0bGUiO3M6MTc6Impld2VscnktYnJhY2VsZXRzIjtzOjU6ImltYWdlIjtzOjcyOiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9hbG9zaG9wL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE2LzA0L2JuMS5qcGciO3M6NDoibGluayI7czoxOiIjIjtzOjQ6ImluZm8iO3M6MTM6ImV4dGEgMzUlIG9mZiAiO3M6NToibGFiZWwiO3M6ODoic2hvcCBub3ciO31pOjE7YTo1OntzOjU6InRpdGxlIjtzOjE0OiJOZXcgdGVjaG5vbG9neSI7czo1OiJpbWFnZSI7czo3MjoiaHR0cDovLzd1cHRoZW1lLmNvbS93b3JkcHJlc3MvYWxvc2hvcC93cC1jb250ZW50L3VwbG9hZHMvMjAxNi8wNC9ibjMuanBnIjtzOjQ6ImxpbmsiO3M6MToiIyI7czo0OiJpbmZvIjtzOjEyOiJFeHRhIDM0JSBvZmYiO3M6NToibGFiZWwiO3M6ODoiU2hvcCBub3ciO31pOjI7YTo1OntzOjU6InRpdGxlIjtzOjExOiJOZXcgRmFzaGlvbiI7czo1OiJpbWFnZSI7czo3MjoiaHR0cDovLzd1cHRoZW1lLmNvbS93b3JkcHJlc3MvYWxvc2hvcC93cC1jb250ZW50L3VwbG9hZHMvMjAxNi8wNC9ibjIuanBnIjtzOjQ6ImxpbmsiO3M6MToiIyI7czo0OiJpbmZvIjtzOjEyOiJTYWxlIG9mZiA0NSUiO3M6NToibGFiZWwiO3M6ODoiU2hvcCBub3ciO319czoxNToid29vX3Nob3BfY29sdW1uIjtzOjE6IjMiO3M6MTM6InByb2R1Y3Rfc3R5bGUiO3M6Njoic3R5bGUxIjtzOjE1OiJhdHRyaWJ1dGVfc3R5bGUiO3M6NzoiZGVmYXVsdCI7czoxNzoic2hvd19wcm9kdWN0X2RhdGEiO3M6Mjoib24iO3M6MTg6InRpdGxlX3Byb2R1Y3RfZGF0YSI7czoyMjoiQUxPU0hPUCAtIEhPVyBJVCBXT1JLUyI7czoxMjoicHJvZHVjdF9kYXRhIjthOjU6e2k6MDthOjM6e3M6NToidGl0bGUiO3M6MTc6IlF1aWNrIEJ1eWVyIEd1aWRlIjtzOjU6ImltYWdlIjtzOjcyOiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9hbG9zaG9wL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE2LzA0L2R0MS5wbmciO3M6NDoibGluayI7czoxOiIjIjt9aToxO2E6Mzp7czo1OiJ0aXRsZSI7czoxNToiVHJhZGUgQXNzdXJhbmNlIjtzOjU6ImltYWdlIjtzOjcyOiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9hbG9zaG9wL3dwLWNvbnRlbnQvdXBsb2Fkcy8yMDE2LzA0L2R0Mi5wbmciO3M6NDoibGluayI7czoxOiIjIjt9aToyO2E6Mzp7czo1OiJ0aXRsZSI7czoxNzoiU2FmZXR5ICYgU2VjdXJpdHkiO3M6NToiaW1hZ2UiO3M6NzI6Imh0dHA6Ly83dXB0aGVtZS5jb20vd29yZHByZXNzL2Fsb3Nob3Avd3AtY29udGVudC91cGxvYWRzLzIwMTYvMDQvZHQzLnBuZyI7czo0OiJsaW5rIjtzOjE6IiMiO31pOjM7YTozOntzOjU6InRpdGxlIjtzOjEyOiJZb3VyIEFjY291bnQiO3M6NToiaW1hZ2UiO3M6NzI6Imh0dHA6Ly83dXB0aGVtZS5jb20vd29yZHByZXNzL2Fsb3Nob3Avd3AtY29udGVudC91cGxvYWRzLzIwMTYvMDQvZHQ0LnBuZyI7czo0OiJsaW5rIjtzOjE6IiMiO31pOjQ7YTozOntzOjU6InRpdGxlIjtzOjE3OiJDb250YWN0IFN1cHBsaWVycyI7czo1OiJpbWFnZSI7czo3MjoiaHR0cDovLzd1cHRoZW1lLmNvbS93b3JkcHJlc3MvYWxvc2hvcC93cC1jb250ZW50L3VwbG9hZHMvMjAxNi8wNC9kdDUucG5nIjtzOjQ6ImxpbmsiO3M6MToiIyI7fX19';
        $sv_config['import_widget'] = '{"blog-sidebar":{"categories-2":{"title":"","count":1,"hierarchical":0,"dropdown":0},"sv_post_tab_widget-2":{"title":"","number":"5"},"text-2":{"title":"FAQS","text":"<ul class=\"list-post-faq\">\r\n\t\t\t\t\t\t\t\t\t<li class=\"active\">\r\n\t\t\t\t\t\t\t\t\t\t<h3>Flyout Content Area 1<\/h3>\r\n\t\t\t\t\t\t\t\t\t\t<p>Porem ipsum dolor sit amet, ctetur adip isicing elit, sed do eiusmod tempor incid idunt ut labore et dolore magna<\/p>\r\n\t\t\t\t\t\t\t\t\t<\/li>\r\n\t\t\t\t\t\t\t\t\t<li>\r\n\t\t\t\t\t\t\t\t\t\t<h3>Flyout Content Area 2<\/h3>\r\n\t\t\t\t\t\t\t\t\t\t<p>Porem ipsum dolor sit amet, ctetur adip isicing elit, sed do eiusmod tempor incid idunt ut labore et dolore magna<\/p>\r\n\t\t\t\t\t\t\t\t\t<\/li>\r\n\t\t\t\t\t\t\t\t\t<li>\r\n\t\t\t\t\t\t\t\t\t\t<h3>Flyout Content Area 3<\/h3>\r\n\t\t\t\t\t\t\t\t\t\t<p>Porem ipsum dolor sit amet, ctetur adip isicing elit, sed do eiusmod tempor incid idunt ut labore et dolore magna<\/p>\r\n\t\t\t\t\t\t\t\t\t<\/li>\r\n\t\t\t\t\t\t\t\t\t<li>\r\n\t\t\t\t\t\t\t\t\t\t<h3>Flyout Content Area 4<\/h3>\r\n\t\t\t\t\t\t\t\t\t\t<p>Porem ipsum dolor sit amet, ctetur adip isicing elit, sed do eiusmod tempor incid idunt ut labore et dolore magna<\/p>\r\n\t\t\t\t\t\t\t\t\t<\/li>\r\n\t\t\t\t\t\t\t\t\t<li>\r\n\t\t\t\t\t\t\t\t\t\t<h3>Flyout Content Area 5<\/h3>\r\n\t\t\t\t\t\t\t\t\t\t<p>Porem ipsum dolor sit amet, ctetur adip isicing elit, sed do eiusmod tempor incid idunt ut labore et dolore magna<\/p>\r\n\t\t\t\t\t\t\t\t\t<\/li>\r\n\t\t\t\t\t\t\t\t<\/ul>","filter":false},"sv_advantage_widget-2":{"title":"<span>Week<\/span><strong>big sale<\/strong>","advs":{"1":{"title":"New Collection","des":"<span>from<\/span> 40% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl2.jpg"},"2":{"title":"Quality usinesswear ","des":"<span>from<\/span> 30% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl1.jpg"},"3":{"title":"Hanbags Style 2016","des":"<span>from<\/span> 20% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl3.jpg"}}}},"woocommerce-sidebar":{"sv_product_fillter-2":{"title":"","category":["electronis","fashion","food","furniture","sports"],"price":"yes","attribute":["brand","color","size"]},"text-3":{"title":"","text":"<div class=\"widget-vote\">\r\n<h2 class=\"widget-title\">COMMUNITY POLL<\/h2>\r\n<p>What is your favorite color<\/p>\r\n<ul>\r\n<li><a href=\"#\">Green<\/a><\/li>\r\n<li><a href=\"#\" >Red<\/a><\/li>\r\n<li><a href=\"#\">Black<\/a><\/li>\r\n<li><a href=\"#\">Magenta<\/a><\/li>\r\n<\/ul>\t\t\t\t\t\t\t\t<button>Vote<\/button>\r\n<\/div>","filter":false},"sv_advantage_widget-3":{"title":"<span>Week<\/span><strong>big sale<\/strong>","advs":{"1":{"title":"New Collection","des":"<span>from<\/span> 40% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl2.jpg"},"2":{"title":"Quality usinesswear ","des":"<span>from<\/span> 30% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl1.jpg"},"3":{"title":"Hanbags Style 2016","des":"<span>from<\/span> 20% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl3.jpg"}}}},"single-sidebar":{"sv_relate_products-2":{"title":"Recent Product","number":"5","product_type":""},"sv_advantage_widget-4":{"title":"<span>Week<\/span><strong>big sale<\/strong>","advs":{"1":{"title":"New Collection","des":"<span>from<\/span> 40% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl1.jpg"},"2":{"title":"Quality usinesswear ","des":"<span>from<\/span> 30% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl2.jpg"},"3":{"title":"Hanbags Style 2016","des":"<span>from<\/span> 20% off","link":"#","image":"http:\/\/7uptheme.com\/wordpress\/aloshop\/wp-content\/uploads\/2016\/04\/sl3.jpg"}}}}}';
        $sv_config['import_category'] = '{"accessories":{"thumbnail":"557","parent":"electronis"},"android":{"thumbnail":"875","parent":"electronis"},"bags":{"thumbnail":"889","parent":"fashion"},"basketball":{"thumbnail":"886","parent":"sports"},"bathtime-goods":{"thumbnail":"1018","parent":"furniture"},"beer":{"thumbnail":"880","parent":"food"},"blankets":{"thumbnail":"1020","parent":"furniture"},"boxing":{"thumbnail":"885","parent":"sports"},"cake":{"thumbnail":"883","parent":"food"},"computers":{"thumbnail":"556","parent":"electronis"},"cream":{"thumbnail":"882","parent":"food"},"dresses":{"thumbnail":"891","parent":"fashion"},"drink":{"thumbnail":"884","parent":"food"},"earrings":{"thumbnail":"877","parent":"jewelry"},"electronis":{"thumbnail":"747","parent":""},"face":{"thumbnail":"876","parent":"jewelry"},"fashion":{"thumbnail":"746","parent":""},"fast-food":{"thumbnail":"885","parent":"food"},"food":{"thumbnail":"748","parent":""},"football":{"thumbnail":"889","parent":"sports"},"fresh-fruit":{"thumbnail":"881","parent":"food"},"furniture":{"thumbnail":"745","parent":""},"glasses":{"thumbnail":"888","parent":"fashion"},"golf-clothes":{"thumbnail":"888","parent":"sports"},"iphone":{"thumbnail":"876","parent":"electronis"},"jewelry":{"thumbnail":"744","parent":""},"mobiles-tablets":{"thumbnail":"555","parent":"electronis"},"necklaces-pendants":{"thumbnail":"875","parent":"jewelry"},"palettes":{"thumbnail":"557","parent":"jewelry"},"pants":{"thumbnail":"887","parent":"fashion"},"rings":{"thumbnail":"556","parent":"jewelry"},"shoes":{"thumbnail":"890","parent":"fashion"},"shower-curtains":{"thumbnail":"1018","parent":"furniture"},"ski-wear":{"thumbnail":"890","parent":"sports"},"smartwatch":{"thumbnail":"877","parent":"electronis"},"sectional-sofa":{"thumbnail":"1017","parent":"furniture"},"sports":{"thumbnail":"","parent":""},"step-stools":{"thumbnail":"1016","parent":"furniture"},"swimming-suit":{"thumbnail":"887","parent":"sports"},"t-shirt":{"thumbnail":"886","parent":"fashion"},"coffee-table":{"thumbnail":"1015","parent":"furniture"},"tools":{"thumbnail":"555","parent":"jewelry"}}';
        
        /**************************************** PLUGINS ****************************************/

        $sv_config['require-plugin'] = array(    
            array(
                'name'               => 'Option Tree', // The plugin name.
                'slug'               => 'option-tree', // The plugin slug (typically the folder name).
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            ),
            array(
                'name'      => 'Contact Form 7',
                'slug'      => 'contact-form-7',
                'required'  => true,
            ),
            array(
                'name'      => 'Visual Composer',
                'slug'      => 'js_composer',
                'required'  => true,
                'source'    =>get_template_directory_uri().'/plugins/js_composer.zip'
            ),
            array(
                'name'      => '7up Core',
                'slug'      => '7up-core',
                'required'  => true,
                'source'    =>get_template_directory_uri().'/plugins/7up-core.zip'
            ),
            array(
                'name'      => 'WooCommerce',
                'slug'      => 'woocommerce',
                'required'  => true,
            ),
            array(
                'name'      => 'MailChimp for WordPress Lite',
                'slug'      => 'mailchimp-for-wp',
                'required'  => true,
            ),    
            array(
                'name'      => 'Yith Woocommerce Compare',
                'slug'      => 'yith-woocommerce-compare',
                'required'  => true,
            ),
            array(
                'name'      => 'Yith Woocommerce Wishlist',
                'slug'      => 'yith-woocommerce-wishlist',
                'required'  => true,
            )
        );

        /**************************************** THEME OPTION ****************************************/

        $sv_config['theme-option'] = array(
            'sections' => array(
                array(
                    'id' => 'option_general',
                    'title' => '<i class="fa fa-cog"></i>'.esc_html__(' General Settings', 'aloshop')
                ),
                array(
                    'id' => 'option_logo',
                    'title' => '<i class="fa fa-image"></i>'.esc_html__(' Logo Settings', 'aloshop')
                ),
                array(
                    'id' => 'option_menu',
                    'title' => '<i class="fa fa-align-justify"></i>'.esc_html__(' Menu Settings', 'aloshop')
                ),
                array(
                    'id' => 'option_layout',
                    'title' => '<i class="fa fa-columns"></i>'.esc_html__(' Layout Settings', 'aloshop')
                ),
                array(
                    'id' => 'option_typography',
                    'title' => '<i class="fa fa-font"></i>'.esc_html__(' Typography', 'aloshop')
                )
            ),
            'settings' => array(
                 /*----------------Begin General --------------------*/
                array(
                    'id'          => 'sv_header_page',
                    'label'       => esc_html__( 'Header Page', 'aloshop' ),
                    'desc'        => esc_html__( 'Include page to Header. You also select this value in edit page/post area to set header for only that page/post.', 'aloshop' ),
                    'type'        => 'select',
                    'section'     => 'option_general',
                    'choices'     => sv_list_header_page()
                ),
                array(
                    'id'          => 'sv_footer_page',
                    'label'       => esc_html__( 'Footer Page', 'aloshop' ),
                    'desc'        => esc_html__( 'Include page to Footer. You also select this value in edit page/post area to set footer for only that page/post.', 'aloshop' ),
                    'type'        => 'page-select',
                    'section'     => 'option_general'
                ),
                array(
                    'id'          => 'sv_404_page',
                    'label'       => esc_html__( '404 Page', 'aloshop' ),
                    'desc'        => esc_html__( 'Include page to 404 page', 'aloshop' ),
                    'type'        => 'page-select',
                    'section'     => 'option_general'
                ),
                array(
                    'id' => 'show_scroll_top',
                    'label' => esc_html__('Show Scroll Top', 'aloshop'),
                    'desc' => esc_html__('This allow you to show or hide Scroll top button', 'aloshop'),
                    'type' => 'on-off',
                    'section' => 'option_general',
                    'std' => 'off'
                ),
                array(
                    'id' => 'sv_show_breadrumb',
                    'label' => esc_html__('Show BreadCrumb', 'aloshop'),
                    'desc' => esc_html__('This allow you to show or hide BreadCrumb', 'aloshop'),
                    'type' => 'on-off',
                    'section' => 'option_general',
                    'std' => 'off'
                ),
                array(
                    'id'          => 'sv_bg_breadcrumb',
                    'label'       => esc_html__('Background Breadcrumb','aloshop'),
                    'type'        => 'background',
                    'section'     => 'option_general',
                    'condition'   => 'sv_show_breadrumb:is(on)',
                ),
                array(
                    'id'          => 'body_background',
                    'label'       => esc_html__('Body Background color','aloshop'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_general',
                ),
                array(
                    'id'          => 'main_color',
                    'label'       => esc_html__('Main color','aloshop'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_general',
                ),
                array(
                    'id'          => 'main_color2',
                    'label'       => esc_html__('Main color 2','aloshop'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_general',
                ),
                array(
                    'id'          => 'custom_css',
                    'label'       => esc_html__('Custom CSS','aloshop'),
                    'type'        => 'textarea-simple',
                    'section'     => 'option_general',
                ),
                /*----------------End General ----------------------*/

                /*----------------Begin Logo --------------------*/
                array(
                    'id' => 'logo',
                    'label' => esc_html__('Logo', 'aloshop'),
                    'desc' => esc_html__('This allow you to change logo. You also change this value in edit SV Logo element in header page for only that page.', 'aloshop'),
                    'type' => 'upload',
                    'section' => 'option_logo',
                ),                        
                array(
                    'id' => 'favicon',
                    'label' => esc_html__('Favicon', 'aloshop'),
                    'desc' => esc_html__('This allow you to change favicon of your website', 'aloshop'),
                    'type' => 'upload',
                    'section' => 'option_logo'
                ),
                /*----------------End Logo ----------------------*/

                /*----------------Begin Menu --------------------*/
                array(
                    'id'          => 'sv_menu_fixed',
                    'label'       => esc_html__('Menu Fixed','aloshop'),
                    'desc'        => 'Menu change to fixed when scroll',
                    'type'        => 'on-off',
                    'section'     => 'option_menu',
                    'std'         => 'off',
                ),
                array(
                    'id'          => 'sv_menu_fixed_mobile',
                    'label'       => esc_html__('Menu Fixed on mobile','aloshop'),
                    'desc'        => 'Active Menu fixed on mobile',
                    'type'        => 'on-off',
                    'section'     => 'option_menu',
                    'std'         => 'off',
                    'condition'   => 'sv_menu_fixed:is(on)',
                ),
                array(
                    'id'          => 'sv_menu_color',
                    'label'       => esc_html__('Menu style','aloshop'),
                    'type'        => 'typography',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 'sv_menu_color_hover',
                    'label'       => esc_html__('Hover color','aloshop'),
                    'desc'        => esc_html__('Choose color','aloshop'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 'sv_menu_color_active',
                    'label'       => esc_html__('Background hover color','aloshop'),
                    'desc'        => esc_html__('Choose color','aloshop'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 'sv_menu_color2',
                    'label'       => esc_html__('Menu sub style','aloshop'),
                    'type'        => 'typography',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 'sv_menu_color_hover2',
                    'label'       => esc_html__('Hover sub color','aloshop'),
                    'desc'        => esc_html__('Choose color','aloshop'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 'sv_menu_color_active2',
                    'label'       => esc_html__('Background hover sub color','aloshop'),
                    'desc'        => esc_html__('Choose color','aloshop'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_menu',
                ),
                /*----------------End Menu ----------------------*/
                

                /*----------------Begin Layout --------------------*/
                array(
                    'id'          => 'sv_sidebar_position_blog',
                    'label'       => esc_html__('Sidebar Blog','aloshop'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','aloshop'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','aloshop'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','aloshop'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','aloshop'),
                        )
                    )
                ),
                array(
                    'id'          => 'sv_sidebar_blog',
                    'label'       => esc_html__('Sidebar select display in blog','aloshop'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 'sv_sidebar_position_blog:not(no)',
                ),
                /****end blog****/
                array(
                    'id'          => 'sv_sidebar_position_page',
                    'label'       => esc_html__('Sidebar Page','aloshop'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Choose sidebar position. You also select this value in edit page area to set sidebar position for only that page.','aloshop'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','aloshop'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','aloshop'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','aloshop'),
                        )
                    )
                ),
                array(
                    'id'          => 'sv_sidebar_page',
                    'label'       => esc_html__('Sidebar select display in page','aloshop'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 'sv_sidebar_position_page:not(no)',
                ),
                /****end page****/
                array(
                    'id'          => 'sv_sidebar_position_page_archive',
                    'label'       => esc_html__('Sidebar Position on Page Archives:','aloshop'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','aloshop'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','aloshop'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','aloshop'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','aloshop'),
                        )
                    )
                ),
                array(
                    'id'          => 'sv_sidebar_page_archive',
                    'label'       => esc_html__('Sidebar select display in page Archives','aloshop'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 'sv_sidebar_position_page_archive:not(no)',
                ),
                // END
                array(
                    'id'          => 'sv_sidebar_position_post',
                    'label'       => esc_html__('Sidebar Single Post','aloshop'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','aloshop'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','aloshop'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','aloshop'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','aloshop'),
                        )
                    )
                ),
                array(
                    'id'          => 'sv_sidebar_post',
                    'label'       => esc_html__('Sidebar select display in single post','aloshop'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 'sv_sidebar_position_post:not(no)',
                ),
                array(
                    'id'          => 'sv_add_sidebar',
                    'label'       => esc_html__('Add SideBar','aloshop'),
                    'type'        => 'list-item',
                    'section'     => 'option_layout',
                    'std'         => '',
                    'settings'    => array( 
                        array(
                            'id'          => 'widget_title_heading',
                            'label'       => esc_html__('Choose heading title widget','aloshop'),
                            'type'        => 'select',
                            'std'        => 'h3',
                            'choices'     => array(
                                array(
                                    'value'=>'h1',
                                    'label'=>esc_html__('H1','aloshop'),
                                ),
                                array(
                                    'value'=>'h2',
                                    'label'=>esc_html__('H2','aloshop'),
                                ),
                                array(
                                    'value'=>'h3',
                                    'label'=>esc_html__('H3','aloshop'),
                                ),
                                array(
                                    'value'=>'h4',
                                    'label'=>esc_html__('H4','aloshop'),
                                ),
                                array(
                                    'value'=>'h5',
                                    'label'=>esc_html__('H5','aloshop'),
                                ),
                                array(
                                    'value'=>'h6',
                                    'label'=>esc_html__('H6','aloshop'),
                                ),
                            )
                        ),
                    ),
                ),
                /*----------------End Layout ----------------------*/

                /*----------------Begin Blog ----------------------*/       
                

                /*----------------End BLOG----------------------*/

                /*----------------Begin Typography ----------------------*/
                array(
                    'id'          => 'sv_custom_typography',
                    'label'       => esc_html__('Add Settings','aloshop'),
                    'type'        => 'list-item',
                    'section'     => 'option_typography',
                    'std'         => '',
                    'settings'    => array(
                        array(
                            'id'          => 'typo_area',
                            'label'       => esc_html__('Choose Area to style','aloshop'),
                            'type'        => 'select',
                            'std'        => 'main',
                            'choices'     => array(
                                array(
                                    'value'=>'header',
                                    'label'=>esc_html__('Header','aloshop'),
                                ),
                                array(
                                    'value'=>'main',
                                    'label'=>esc_html__('Main Content','aloshop'),
                                ),
                                array(
                                    'value'=>'widget',
                                    'label'=>esc_html__('Widget','aloshop'),
                                ),
                                array(
                                    'value'=>'footer',
                                    'label'=>esc_html__('Footer','aloshop'),
                                ),
                            )
                        ),
                        array(
                            'id'          => 'typo_heading',
                            'label'       => esc_html__('Choose heading Area','aloshop'),
                            'type'        => 'select',
                            'std'        => 'h3',
                            'choices'     => array(
                                array(
                                    'value'=>'h1',
                                    'label'=>esc_html__('H1','aloshop'),
                                ),
                                array(
                                    'value'=>'h2',
                                    'label'=>esc_html__('H2','aloshop'),
                                ),
                                array(
                                    'value'=>'h3',
                                    'label'=>esc_html__('H3','aloshop'),
                                ),
                                array(
                                    'value'=>'h4',
                                    'label'=>esc_html__('H4','aloshop'),
                                ),
                                array(
                                    'value'=>'h5',
                                    'label'=>esc_html__('H5','aloshop'),
                                ),
                                array(
                                    'value'=>'h6',
                                    'label'=>esc_html__('H6','aloshop'),
                                ),
                                array(
                                    'value'=>'a',
                                    'label'=>esc_html__('a','aloshop'),
                                ),
                                array(
                                    'value'=>'p',
                                    'label'=>esc_html__('p','aloshop'),
                                ),
                            )
                        ),
                        array(
                            'id'          => 'typography_style',
                            'label'       => esc_html__('Add Style','aloshop'),
                            'type'        => 'typography',
                            'section'     => 'option_typography',
                        ),
                    ),
                ),        
                array(
                    'id'          => 'google_fonts',
                    'label'       => esc_html__('Add Google Fonts','aloshop'),
                    'type'        => 'google-fonts',
                    'section'     => 'option_typography',
                ),
                /*----------------End Typography ----------------------*/
            )
        );
        if(class_exists( 'WooCommerce' )){
            array_push($sv_config['theme-option']['sections'], array(
                                                        'id' => 'option_woo',
                                                        'title' => '<i class="fa fa-shopping-cart"></i>'.esc_html__(' Shop Settings', 'aloshop')
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'before_append_woo',
                                                        'label'       => esc_html__('Append content before Woocommerce page','aloshop'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        // 'choices'     => s7upf_list_post_type('s7upf_mega_item'),
                                                        'desc'        => esc_html__('Choose a mega page content append to before main content of woocommerce page.','aloshop'),
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_sidebar_position_woo',
                                                        'label'       => esc_html__('Sidebar Position WooCommerce page','aloshop'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        'desc'=>esc_html__('Left, or Right, or Center','aloshop'),
                                                        'choices'     => array(
                                                            array(
                                                                'value'=>'no',
                                                                'label'=>esc_html__('No Sidebar','aloshop'),
                                                            ),
                                                            array(
                                                                'value'=>'left',
                                                                'label'=>esc_html__('Left','aloshop'),
                                                            ),
                                                            array(
                                                                'value'=>'right',
                                                                'label'=>esc_html__('Right','aloshop'),
                                                            )
                                                        )
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_sidebar_woo',
                                                        'label'       => esc_html__('Sidebar select WooCommerce page','aloshop'),
                                                        'type'        => 'sidebar-select',
                                                        'section'     => 'option_woo',
                                                        'condition'   => 'sv_sidebar_position_woo:not(no)',
                                                        'desc'        => esc_html__('Choose one style of sidebar for WooCommerce page','aloshop'),

                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_sidebar_position_woo_detail',
                                                        'label'       => esc_html__('Sidebar Position WooCommerce Detail','aloshop'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        'desc'=>esc_html__('Left, or Right, or Center','aloshop'),
                                                        'choices'     => array(
                                                            array(
                                                                'value'=>'no',
                                                                'label'=>esc_html__('No Sidebar','aloshop'),
                                                            ),
                                                            array(
                                                                'value'=>'left',
                                                                'label'=>esc_html__('Left','aloshop'),
                                                            ),
                                                            array(
                                                                'value'=>'right',
                                                                'label'=>esc_html__('Right','aloshop'),
                                                            )
                                                        )
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_sidebar_woo_detail',
                                                        'label'       => esc_html__('Sidebar select detail product','aloshop'),
                                                        'type'        => 'sidebar-select',
                                                        'section'     => 'option_woo',
                                                        'condition'   => 'sv_sidebar_position_woo:not(no)',
                                                        'desc'        => esc_html__('Choose one style of sidebar for WooCommerce page','aloshop'),

                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_header',
                                                        'label'       => esc_html__('Show header shop','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_woo',
                                                        'std'         => 'on'
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'shop_ajax',
                                                        'label'       => esc_html__('Shop ajax','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_woo',
                                                        'std'         => 'off'
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_header_single',
                                                        'label'       => esc_html__('Show header Detail Product','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_woo',
                                                        'std'         => 'off'
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'header_data',
                                                        'label'       => esc_html__('Header Slider','aloshop'),
                                                        'type'        => 'list-item',
                                                        'section'     => 'option_woo',
                                                        'condition'   => 'show_header:is(on),show_header_single:is(on)',
                                                        'operator'    => 'or',
                                                        'settings'    => array(
                                                            array(
                                                                'id' => 'image',
                                                                'label' => esc_html__('Image', 'aloshop'),
                                                                'type' => 'upload',
                                                            ),
                                                            array(
                                                                'id' => 'link',
                                                                'label' => esc_html__('Link', 'aloshop'),
                                                                'type' => 'text',
                                                            ),
                                                            array(
                                                                'id' => 'info',
                                                                'label' => esc_html__('Text Extra', 'aloshop'),
                                                                'type' => 'text',
                                                            ),
                                                            array(
                                                                'id' => 'label',
                                                                'label' => esc_html__('Label Button', 'aloshop'),
                                                                'type' => 'text',
                                                            ),
                                                        )));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_list_cat',
                                                        'label'       => esc_html__('Show List Category','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_woo',
                                                        'std'         => 'on'
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'list_cat_number',
                                                        'label'       => esc_html__('List Category Number','aloshop'),
                                                        'type'        => 'text',
                                                        'section'     => 'option_woo',
                                                        'condition'   => 'show_list_cat:is(on)',
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'woo_shop_number',
                                                        'label'       => esc_html__('Product Number','aloshop'),
                                                        'type'        => 'text',
                                                        'section'     => 'option_woo',
                                                        'desc'        => esc_html__('Enter number product to display per page. Default is 12.','bigc')
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'woo_shop_column',
                                                        'label'       => esc_html__('Choose shop column','aloshop'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        'choices'     => array(                                                    
                                                            array(
                                                                'value'=> 1,
                                                                'label'=> 1,
                                                            ),
                                                            array(
                                                                'value'=> 2,
                                                                'label'=> 2,
                                                            ),
                                                            array(
                                                                'value'=> 3,
                                                                'label'=> 3,
                                                            ),
                                                            array(
                                                                'value'=> 4,
                                                                'label'=> 4,
                                                            ),
                                                            array(
                                                                'value'=> 5,
                                                                'label'=> 5,
                                                            ),
                                                            array(
                                                                'value'=> 6,
                                                                'label'=> 6,
                                                            ),
                                                            array(
                                                                'value'=> 7,
                                                                'label'=> 7,
                                                            ),
                                                            array(
                                                                'value'=> 8,
                                                                'label'=> 8,
                                                            ),
                                                        )
                                                    ));
            array_push($sv_config['theme-option']['sections'], array(
                                                        'id' => 'option_product',
                                                        'title' => '<i class="fa fa-th-large"></i>'.esc_html__(' Product Settings', 'aloshop')
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'main_thumb_hover',
                                                        'label'       => esc_html__('Product main thumb hover','aloshop'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_product',
                                                        'choices'     => array(
                                                            array(
                                                                'value'=> '',
                                                                'label'=> esc_html__("Special", 'aloshop'),
                                                            ),
                                                            array(
                                                                'value'=> 'scale',
                                                                'label'=> esc_html__("Normal", 'aloshop'),
                                                            ),
                                                        )
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'product_thumb_click',
                                                        'label'       => esc_html__('Disable product thumbnail click','aloshop'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_product',
                                                        'choices'     => array(
                                                            array(
                                                                'value'=> '',
                                                                'label'=> esc_html__("-- Select --", 'aloshop'),
                                                            ),
                                                            array(
                                                                'value'=> 'all-device',
                                                                'label'=> esc_html__("All Devices", 'aloshop'),
                                                            ),
                                                            array(
                                                                'value'=> 'on-mobile',
                                                                'label'=> esc_html__("On Mobile", 'aloshop'),
                                                            ),
                                                        )
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'product_style',
                                                        'label'       => esc_html__('Product Style','aloshop'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_product',
                                                        'choices'     => array(
                                                            array(
                                                                'value'=> 'style1',
                                                                'label'=> esc_html__("Style 1", 'aloshop'),
                                                            ),
                                                            array(
                                                                'value'=> 'style2',
                                                                'label'=> esc_html__("Style 2", 'aloshop'),
                                                            ),
                                                        )
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'attribute_style',
                                                        'label'       => esc_html__('Product Attribute Style','aloshop'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_product',
                                                        'choices'     => array(                                                    
                                                            array(
                                                                'value'=> 'default',
                                                                'label'=> esc_html__("Default", 'aloshop'),
                                                            ),
                                                            array(
                                                                'value'=> 'special',
                                                                'label'=> esc_html__("Special", 'aloshop'),
                                                            ),
                                                        )
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_product_excerpt',
                                                        'label'       => esc_html__('Show product excerpt','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_product',
                                                        'std'         => 'off',
                                                        'description' => esc_html__('Show/hide product excerpt in detail product page','aloshop'),
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_product_data',
                                                        'label'       => esc_html__('Show product data','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_product',
                                                        'std'         => 'on',
                                                        'description' => esc_html__('Only show with product style 2','aloshop'),
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'title_product_data',
                                                        'label'       => esc_html__('Product more Title','aloshop'),
                                                        'type'        => 'text',
                                                        'section'     => 'option_product',
                                                        'condition'   => 'show_product_data:is(on),',
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'product_data',
                                                        'label'       => esc_html__('Product more data','aloshop'),
                                                        'type'        => 'list-item',
                                                        'section'     => 'option_product',
                                                        'condition'   => 'show_product_data:is(on),',
                                                        'settings'    => array(
                                                            array(
                                                                'id' => 'image',
                                                                'label' => esc_html__('Image', 'aloshop'),
                                                                'type' => 'upload',
                                                            ),
                                                            array(
                                                                'id' => 'link',
                                                                'label' => esc_html__('Link', 'aloshop'),
                                                                'type' => 'text',
                                                            ),
                                                        )));
            
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_single_number',
                                                        'label'       => esc_html__('Show Single Products Number','aloshop'),
                                                        'type'        => 'text',
                                                        'section'     => 'option_product',
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_single_upsell',
                                                        'label'       => esc_html__('Show Single Upsell Products','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_product',
                                                        'std'         => 'on'
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_single_relate',
                                                        'label'       => esc_html__('Show Single Relate Products','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_product',
                                                        'std'         => 'off'
                                                    ));
            array_push($sv_config['theme-option']['settings'],array(
                                                        'id'          => 'show_single_lastest',
                                                        'label'       => esc_html__('Show Single Lastest Products','aloshop'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_product',
                                                        'std'         => 'off'
                                                    ));
            array_push($sv_config['theme-option']['sections'], array(
                                                                'id' => 'option_catelog',
                                                                'title' => '<i class="fa fa-shopping-cart"></i>'.esc_html__(' WooCommerce Catalog', 'aloshop')
                                                            ));
            array_push($sv_config['theme-option']['settings'],array(
                                                                'id'          => 'woo_catelog',
                                                                'label'       => esc_html__('Enable WooCommerce Catalog Mode','aloshop'),
                                                                'type'        => 'on-off',
                                                                'section'     => 'option_catelog',
                                                                'std'         => 'off'
                                                            ));
            array_push($sv_config['theme-option']['settings'],array(
                                                                'id'          => 'hide_detail',
                                                                'label'       => esc_html__('Hide "Add to cart" button in product detail page','aloshop'),
                                                                'type'        => 'on-off',
                                                                'section'     => 'option_catelog',
                                                                'condition'   => 'woo_catelog:is(on)',
                                                                'std'         => 'off'
                                                            ));
            array_push($sv_config['theme-option']['settings'],array(
                                                                'id'          => 'hide_other_page',
                                                                'label'       => esc_html__('Hide "Add to cart" button in other shop pages','aloshop'),
                                                                'type'        => 'on-off',
                                                                'section'     => 'option_catelog',
                                                                'condition'   => 'woo_catelog:is(on)',
                                                                'std'         => 'off',
                                                            ));
            array_push($sv_config['theme-option']['settings'],array(
                                                                'id'          => 'hide_admin',
                                                                'label'       => esc_html__('Enable Catalog Mode also for administrators','aloshop'),
                                                                'type'        => 'on-off',
                                                                'section'     => 'option_catelog',
                                                                'condition'   => 'woo_catelog:is(on)',
                                                                'std'         => 'off',
                                                            ));
            array_push($sv_config['theme-option']['settings'],array(
                                                                'id'          => 'hide_price',
                                                                'label'       => esc_html__('Hide Price','aloshop'),
                                                                'type'        => 'on-off',
                                                                'section'     => 'option_catelog',
                                                                'condition'   => 'woo_catelog:is(on)',
                                                                'std'         => 'off',
                                                            ));
            array_push($sv_config['theme-option']['settings'],array(
                                                                'id'          => 'hide_shop',
                                                                'label'       => esc_html__('Disable shop','aloshop'),
                                                                'type'        => 'on-off',
                                                                'section'     => 'option_catelog',
                                                                'condition'   => 'woo_catelog:is(on)',
                                                                'std'         => 'off',
                                                                'desc'        => esc_html__('Hide and disable "Cart" page, "Checkout" page and all "Add to Cart" buttons','aloshop')
                                                            ));
        }
    }
}
sv_set_theme_config();
