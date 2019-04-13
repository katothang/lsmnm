<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 31/08/15
 * Time: 10:00 AM
 */
/************************************Main Carousel*************************************/
if(!function_exists('sv_vc_slide_carousel'))
{
    function sv_vc_slide_carousel($attr, $content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'item'      => '1',
            'speed'     => '',
            'itemres'   => '',
            'nav_slider'=> 'nav-hidden',
            'animation' => '',
            'custom_css' => '',
        ),$attr));
        if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
            $html .=    '<div class="wrap-slider '.$nav_slider.'">';
            $html .=        '<div class="wrap-item sv-slider '.$css_class.'" data-item="'.$item.'" data-speed="'.$speed.'" data-itemres="'.$itemres.'" data-animation="'.$animation.'" data-nav="'.$nav_slider.'">';
            $html .=            wpb_js_remove_wpautop($content, false);
            $html .=        '</div>';
            $html .=    '</div>';
        return $html;
    }
}
stp_reg_shortcode('slide_carousel','sv_vc_slide_carousel');
vc_map(
    array(
        'name'     => esc_html__( 'Carousel Slider', 'aloshop' ),
        'base'     => 'slide_carousel',
        'category' => esc_html__( '7Up-theme', 'aloshop' ),
        'icon'     => 'icon-st',
        'as_parent' => array( 'only' => 'vc_column_text,slide_banner_item,sv_manufacture_item,sv_icon_content_item,sv_category_product_item,slide_testimonial_item' ),
        'content_element' => true,
        'js_view' => 'VcColumnView',
        'params'   => array(                       
            array(
                'heading'     => esc_html__( 'Item slider display', 'aloshop' ),
                'type'        => 'textfield',
                'description' => esc_html__( 'Enter number of item. Default is 1.', 'aloshop' ),
                'param_name'  => 'item',
            ),
            array(
                'heading'     => esc_html__( 'Speed', 'aloshop' ),
                'type'        => 'textfield',
                'description' => esc_html__( 'Enter time slider go to next item. Unit (ms). Example 5000. If empty this field autoPlay is false.', 'aloshop' ),
                'param_name'  => 'speed',
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Navigation style', 'aloshop' ),
                'param_name'  => 'nav_slider',
                'value'       => array(
                    esc_html__( 'Hidden', 'aloshop' )   => 'nav-hidden',
                    esc_html__( 'Default', 'aloshop' )   => 'default',
                    esc_html__( 'Banner home 3', 'aloshop' )   => 'slider-home3',
                    esc_html__( 'Default Pagination', 'aloshop' )   => 'gift-icon-slider',
                    esc_html__( 'Navigation small top right', 'aloshop' )   => 'slider-home4',
                    esc_html__( 'Navigation home 5', 'aloshop' )   => 'banner-slider5',
                    esc_html__( 'Pagination home 5', 'aloshop' )   => 'slide-adds',
                    esc_html__( 'Navigation home 8', 'aloshop' )   => 'banner-slider8',
                    esc_html__( 'Navigation home 9', 'aloshop' )   => 'banner-slider8 banner-slider9',
                    esc_html__( 'Pagination Outlet', 'aloshop' )   => 'outlet-slider',
                    esc_html__( 'Navigation home 10', 'aloshop' )   => 'banner-slider10',
                    esc_html__( 'Default ontop', 'aloshop' )   => 'nav-ontop',
                    esc_html__( 'Navigation home 21', 'aloshop' )   => 'banner-slider banner-slider21 slider-home3 bg-slider',
                    esc_html__( 'Pagination home 24', 'aloshop' )   => 'banner-slider24',
                    )
            ),
            array(
                'heading'     => esc_html__( 'Custom Item', 'aloshop' ),
                'type'        => 'textfield',
                'description' => esc_html__( 'Enter custom item for each window 360px,480px,768px,992px. Default is auto. Example: "2,3,4,5"', 'aloshop' ),
                'param_name'  => 'itemres',
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Animation', 'aloshop' ),
                'param_name'  => 'animation',
                'value'       => array(
                    esc_html__( 'None', 'aloshop' )        => '',
                    esc_html__( 'Fade', 'aloshop' )        => 'fade',
                    esc_html__( 'BackSlide', 'aloshop' )   => 'backSlide',
                    esc_html__( 'GoDown', 'aloshop' )      => 'goDown',
                    esc_html__( 'FadeUp', 'aloshop' )      => 'fadeUp',
                    )
            ),
            array(
                "type"          => "css_editor",
                "heading"       => esc_html__("Custom Block",'aloshop'),
                "param_name"    => "custom_css",
                'group'         => esc_html__('Advanced','aloshop')
            )
        )
    )
);

/*******************************************END MAIN*****************************************/


/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_slide_banner_item'))
{
    function sv_vc_slide_banner_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'     => '',
            'image'     => '',
            'link'      => '',
            'color'     => 'bg-blue',
        ),$attr));
        if(!empty($image)){
            switch ($style) {
                case 'home-24':
                    $html .=    '<div class="item-slider">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'home-21':
                    $html .=    '<div class="item-slider">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info text-center">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'home10':
                    $html .=    '<div class="item-banner10">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info">
                                        <div class="container">
                                            <div class="banner-content-text">
                                                <div class="inner-content-text">
                                                    '.wpb_js_remove_wpautop($content, true).'
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    break;

                case 'outlet':
                    $html .=    '<div class="item">
                                    <div class="outlet-slider-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="outlet-slider-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'home9':
                    $html .=    '<div class="item-banner9">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info '.$color.'">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'home8':
                    $html .=    '<div class="item-banner8">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'home8-2':
                    $html .=    '<div class="item-banner8">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info center-text">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'home6':
                    $html .=    '<div class="item-banner7">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'sidebar-home5':
                    $html .=    '<div class="item">
                                    <div class="item-widget-adv">
                                        <div class="adv-widget-thumb">
                                            <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                        </div>
                                        <div class="adv-widget-info">
                                            '.wpb_js_remove_wpautop($content, true).'
                                        </div>
                                    </div>
                                </div>';
                    break;
                    
                case 'home5':
                    $html .=    '<div class="item-banner5">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'home4':
                    $html .=    '<div class="item-banner4">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;

                case 'home4-rotate':
                    $html .=    '<div class="item-banner4">
                                    <div class="banner-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <div class="banner-info rotate-text">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;
                
                case 'header-image':
                    $html .=    '<div class="item-shop-slider">
                                    <div class="shop-slider-thumb">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>';
                    if(!empty($content)){
                        $html .=    '<div class="shop-slider-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                        </div>';
                    }
                    $html .=    '</div>';
                    break;

                default:
                    $html .=    '<div class="item-thenew">
                                    <div class="thumb-slider">
                                        <a href="'.esc_url($link).'" class="link-thumb-slider">
                                            '.wp_get_attachment_image($image,'full').'
                                        </a>
                                    </div>
                                    <div class="thenew-info">
                                        '.wpb_js_remove_wpautop($content, true).'
                                    </div>
                                </div>';
                    break;
            }            
        }
        return $html;
    }
}
stp_reg_shortcode('slide_banner_item','sv_vc_slide_banner_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Banner Item', 'aloshop' ),
        'base'     => 'slide_banner_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'aloshop' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Default', 'aloshop' ) => '',
                    esc_html__( 'Header image', 'aloshop' ) => 'header-image',
                    esc_html__( 'Home 4 Rotate text', 'aloshop' ) => 'home4-rotate',
                    esc_html__( 'Home 4', 'aloshop' ) => 'home4',
                    esc_html__( 'Home 5', 'aloshop' ) => 'home5',
                    esc_html__( 'Sidebar home 5', 'aloshop' ) => 'sidebar-home5',
                    esc_html__( 'Home 6', 'aloshop' ) => 'home6',
                    esc_html__( 'Home 8', 'aloshop' ) => 'home8',
                    esc_html__( 'Home 8 (Center)', 'aloshop' ) => 'home8-2',
                    esc_html__( 'Home 9', 'aloshop' ) => 'home9',
                    esc_html__( 'Home 10', 'aloshop' ) => 'home10',
                    esc_html__( 'Outlet', 'aloshop' ) => 'outlet',
                    esc_html__( 'Home 21', 'aloshop' ) => 'home-21',
                    esc_html__( 'Home 24', 'aloshop' ) => 'home-24',
                    )
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Color', 'aloshop' ),
                'param_name'  => 'color',
                'value'       => array(
                    esc_html__( 'Green', 'aloshop' ) => 'bg-blue',
                    esc_html__( 'Brown', 'aloshop' ) => 'bg-brown',
                    esc_html__( 'Blue', 'aloshop' ) => 'bg-violet',
                    ),
                'dependency'  => array(
                        'element'   => 'style',
                        'value'   => 'home9',
                        )
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image', 'aloshop' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link Banner', 'aloshop' ),
                'param_name'  => 'link',
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'aloshop'),
                "param_name" => "content",
            ),
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_manufacture_item'))
{
    function sv_vc_manufacture_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'image'     => '',
            'link'      => '',
        ),$attr));
        if(!empty($image)){                
            $html .=    '<div class="item-manufacture">
                            <div class="zoom-image-thumb"><a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a></div>
                        </div>';
        }
        return $html;
    }
}
stp_reg_shortcode('sv_manufacture_item','sv_vc_manufacture_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Manufacture Item', 'aloshop' ),
        'base'     => 'sv_manufacture_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(            
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image', 'aloshop' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link', 'aloshop' ),
                'param_name'  => 'link',
            ),
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_icon_content_item'))
{
    function sv_vc_icon_content_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'icon'     => '',
        ),$attr));               
        $html .=    '<div class="item-gift-icon">
                        <span><i class="fa '.$icon.'"></i></span>
                        '.wpb_js_remove_wpautop($content, true).'
                    </div>';
        return $html;
    }
}
stp_reg_shortcode('sv_icon_content_item','sv_vc_icon_content_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Icon Content Item', 'aloshop' ),
        'base'     => 'sv_icon_content_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Icon', 'aloshop' ),
                'param_name'  => 'icon',                
                'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker'
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'aloshop'),
                "param_name" => "content",
            ),
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_category_product_item'))
{
    function sv_vc_category_product_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'cat'       => '',
            'image'     => ''
        ),$attr));
        $term = get_term_by( 'slug',$cat, 'product_cat' );
        if(!empty($term) && is_object($term)){
            $term_link = get_term_link( $term->term_id, 'product_cat' );  
            $html .=    '<div class="item-pop-cat">
                            <div class="zoom-image-thumb">
                                <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                            </div>
                            <h2 class="pop-cat-title">'.$term->name.'</h2>
                        </div>';
        }
        return $html;
    }
}
stp_reg_shortcode('sv_category_product_item','sv_vc_category_product_item');
// Banner item
$check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_admin_category_product_item',10,100 );
if ( ! function_exists( 'sv_admin_category_product_item' ) ) {
    function sv_admin_category_product_item(){
        vc_map(
            array(
                'name'     => esc_html__( 'Product Category Item', 'aloshop' ),
                'base'     => 'sv_category_product_item',
                'icon'     => 'icon-st',
                'content_element' => true,
                'as_child' => array('only' => 'slide_carousel'),
                'params'   => array(
                    array(
                        'type'        => 'dropdown',
                        'holder'      => 'div',
                        'heading'     => esc_html__( 'Product Category', 'aloshop' ),
                        'param_name'  => 'cat',
                        'value'       => sv_list_taxonomy('product_cat',true),
                    ),            
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Product image",'aloshop'),
                        "param_name" => "image",
                    ),
                )
            )
        );
    }
}

/**************************************END ITEM************************************/

/**************************************BEGIN ITEM************************************/
//Testimonial Frontend
if(!function_exists('sv_vc_slide_testimonial_item'))
{
    function sv_vc_slide_testimonial_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'     => 'style-1',
            'image'     => '',
            'name'      => '',
            'position'  => '',
            'link'      => '#',
        ),$attr));
        if(!empty($image)){
            if($style == 'style-2'){
                $html .=    '<div class="item">
                                <div class="item-customer-saying">
                                    <div class="thumb-customer-saying">
                                        <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,array(70,70)).'</a>
                                    </div>
                                    <div class="info-customer-saying">
                                        '.wpb_js_remove_wpautop($content, true).'
                                        <h3><a href="'.esc_url($link).'">'.$name.'</a></h3>
                                        <span>'.$position.'</span>
                                    </div>
                                </div>
                            </div>';
            }
            else{
                $html .=    '<div class="item">
                                <div class="testimo-item">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="testimo-content-left">
                                                '.wp_get_attachment_image($image,array(570,390),0,array('class'=>'testimo-thumb')).'
                                                <div class="info-testimo-author">
                                                    <a href="'.esc_url($link).'" class="testimo-avatar">
                                                        '.wp_get_attachment_image($image,array(150,150)).'
                                                    </a>
                                                    <h3 class="testimo-name"><a href="'.esc_url($link).'">'.$name.'</a></h3>
                                                    <p class="testimo-job">'.$position.'</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="testimo-content-right">
                                                '.wpb_js_remove_wpautop($content, true).'
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
            }
        }
        return $html;
    }
}
stp_reg_shortcode('slide_testimonial_item','sv_vc_slide_testimonial_item');

// Testimonial item
vc_map(
    array(
        'name'     => esc_html__( 'Testimonial Item', 'aloshop' ),
        'base'     => 'slide_testimonial_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'aloshop' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Style 1', 'aloshop' )   => 'style-1',
                    esc_html__( 'Style 2', 'aloshop' )   => 'style-2',
                    )
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Avatar', 'aloshop' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Name', 'aloshop' ),
                'param_name'  => 'name',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Position', 'aloshop' ),
                'param_name'  => 'position',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link Detail', 'aloshop' ),
                'param_name'  => 'link',
            ),
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'aloshop'),
                "param_name" => "content",
            ),
        )
    )
);

/**************************************END ITEM************************************/

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Slide_Carousel extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Slide_Banner_Item extends WPBakeryShortCode {}
    class WPBakeryShortCode_Sv_Manufacture_Item extends WPBakeryShortCode {}
    class WPBakeryShortCode_Sv_Icon_Content_Item extends WPBakeryShortCode {}
    class WPBakeryShortCode_Sv_Category_Product_Item extends WPBakeryShortCode {}
    class WPBakeryShortCode_Slide_Testimonial_Item extends WPBakeryShortCode {}
}