<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 31/08/15
 * Time: 10:00 AM
 */
/************************************Main Carousel*************************************/
if(!function_exists('sv_vc_service_wrap'))
{
    function sv_vc_service_wrap($attr, $content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'style'      => '',
        ),$attr));
                $html .=    '<div class="list-service-box inner-list-service">
                                <div class="row">';
                $html .=            wpb_js_remove_wpautop($content, false);
                $html .=        '</div>';
                $html .=        '<a href="#" class="close-service-box"><i class="fa fa-times"></i></a>
                            </div>';
        return $html;
    }
}
stp_reg_shortcode('service_wrap','sv_vc_service_wrap');
vc_map(
    array(
        'name'     => esc_html__( 'Service Wrap', 'aloshop' ),
        'base'     => 'service_wrap',
        'category' => esc_html__( '7Up-theme', 'aloshop' ),
        'icon'     => 'icon-st',
        'as_parent' => array( 'only' => 'service_item' ),
        'content_element' => true,
        'js_view' => 'VcColumnView',
        'params'   => array(
            
        )
    )
);

/*******************************************END MAIN*****************************************/


/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('sv_vc_service_item'))
{
    function sv_vc_service_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'     => '',
            'des'       => '',
            'image'     => '',
            'link'      => '',
        ),$attr));
        $html .=    '<div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="service-box">
                            <div class="service-thumb">
                                <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                            </div>
                            <div class="service-info">
                                <h2><a href="'.esc_url($link).'">'.$title.'</a></h2>
                                <p>'.$des.'</p>
                            </div>
                        </div>
                    </div>';
        return $html;
    }
}
stp_reg_shortcode('service_item','sv_vc_service_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Service Item', 'aloshop' ),
        'base'     => 'service_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'slide_carousel'),
        'params'   => array(
            array(
                'type'        => 'textfield',
                'holder'      => 'div',
                'heading'     => esc_html__( 'Title', 'aloshop' ),
                'param_name'  => 'title',
            ),
            array(
                'type'        => 'textfield',
                'holder'      => 'div',
                'heading'     => esc_html__( 'Description', 'aloshop' ),
                'param_name'  => 'des',
            ),
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
if(!function_exists('sv_vc_service'))
{
    function sv_vc_service($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'     => 'item-service3',
            'title'     => '',
            'des'       => '',
            'image'     => '',
            'icon'     => '',
            'link'      => '',
        ),$attr));
        switch ($style) {
            case 'home-23':
                $html .=    '<div class="service-box service-box23">
                                <div class="service-thumb">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="service-info">
                                    <h2><a href="'.esc_url($link).'">'.$title.'</a></h2>
                                    <p>'.$des.'</p>
                                </div>
                            </div>';
                break;

            case 'home-11':
                $html .=    '<div class="item-privacy-shipping">
                                <ul>
                                    <li><i class="fa '.$icon.'"></i></li>
                                    <li>
                                        <h2>'.$title.'</h2>
                                        <span>'.$des.'</span>
                                    </li>
                                </ul>
                            </div>';
                break;

            case 'item-service2':
                $html .=    '<div class="item-service2">
                                <div class="service-thumb2">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>  
                                <div class="service-info2">
                                    <h2>'.$title.'</h2>
                                    <span>'.$des.'</span>
                                </div>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="item-service3">
                                <div class="item-service-thum3">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full').'</a>
                                </div>
                                <div class="item-service-info3">
                                    <h2><a href="'.esc_url($link).'">'.$title.'</a></h2>
                                    <p>'.$des.'</p>
                                </div>
                            </div>';
                break;
        }        
        return $html;
    }
}
stp_reg_shortcode('sv_service','sv_vc_service');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'SV Service image', 'aloshop' ),
        'base'     => 'sv_service',
        'icon'     => 'icon-st',
        "category"  => '7Up-theme',
        'params'   => array(
            array(
                "type"          => "dropdown",
                "holder"        => "div",
                "heading"       => esc_html__("Style",'aloshop'),
                "param_name"    => "style",
                "value"         => array(
                    esc_html__("Style 1",'aloshop')        => 'item-service3',
                    esc_html__("Style 2",'aloshop')         => 'item-service2',
                    esc_html__("Style 3",'aloshop')         => 'home-11',
                    esc_html__("Style 4(Home 23)",'aloshop')         => 'home-23',
                    )
            ),
            array(
                'type'        => 'textfield',
                'holder'      => 'div',
                'heading'     => esc_html__( 'Title', 'aloshop' ),
                'param_name'  => 'title',
            ),
            array(
                'type'        => 'textfield',
                'holder'      => 'div',
                'heading'     => esc_html__( 'Description', 'aloshop' ),
                'param_name'  => 'des',
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image', 'aloshop' ),
                'param_name'  => 'image',
                'dependency'  => array(
                    'element'   => 'style',
                    'value'   => array('item-service3','item-service2','home-23'),
                    )
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Icon', 'aloshop' ),
                'param_name'  => 'icon',
                'edit_field_class'=>'vc_col-sm-12 vc_column sv_iconpicker',
                'dependency'  => array(
                    'element'   => 'style',
                    'value'   => 'home-11',
                    )
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link', 'aloshop' ),
                'param_name'  => 'link',
                'dependency'  => array(
                    'element'   => 'style',
                    'value'   => array('item-service3','item-service2','home-23'),
                    )
            ),
        )
    )
);
/**************************************BEGIN ITEM************************************/

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Service_Wrap extends WPBakeryShortCodesContainer {
    }
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Service_Item extends WPBakeryShortCode {}
}