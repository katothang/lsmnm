<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
if(!function_exists('sv_vc_select_category'))
{
    function sv_vc_select_category($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         => 'default',
            'cat'           => '',
            'image'         => '',
            'label'         => '',
            'text_link'     => '',
        ),$attr));
        $term = get_term_by( 'slug',$cat, 'product_cat' );
        if(!empty($term) && is_object($term)){
            $term_link = get_term_link( $term->term_id, 'product_cat' );
            switch ($style) {
                case 'home-5':
                    $html .=    '<div class="popcat-box">
                                    '.wp_get_attachment_image($image,'full').'
                                    <h3><a href="'.esc_url($term_link).'">'.$term->name.'</a></h3>
                                </div>';
                    break;
                
                default:
                    $html .=    '<div class="item-lower-price">
                                    <h2><a href="'.esc_url($term_link).'">'.$term->name.'</a></h2>
                                    <div class="lower-price-info">
                                        '.$label.'
                                    </div>
                                    <div class="zoom-image-thumb">
                                        <a href="'.esc_url($term_link).'">'.wp_get_attachment_image($image,'full').'</a>
                                    </div>
                                    <h3><a href="'.esc_url($term_link).'">'.$text_link.'</a></h3>
                                    <a href="'.esc_url($term_link).'" class="viewall">'.esc_html__("VIEW ALL","aloshop").'</a>
                                </div>';
                    break;
            }            
        }
        return $html;
    }
}

stp_reg_shortcode('sv_select_category','sv_vc_select_category');
$check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_admin_select_category',10,100 );
if ( ! function_exists( 'sv_admin_select_category' ) ) {
    function sv_admin_select_category(){
        vc_map( array(
            "name"      => esc_html__("SV Select Product Category", 'aloshop'),
            "base"      => "sv_select_category",
            "icon"      => "icon-st",
            "category"  => '7Up-theme',
            "params"    => array(
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__( 'Style', 'aloshop' ),
                    'param_name'  => 'style',
                    'value'       => array(
                        esc_html__( 'Default', 'aloshop' )    => 'default',
                        esc_html__( 'Home 5', 'aloshop' )     => 'home-5',
                        ),
                ),
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
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Label",'aloshop'),
                    "param_name" => "label",
                    "dependency"    => array(
                        "element"   => 'style',
                        "value"   => 'default',
                        )
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__("Text link",'aloshop'),
                    "param_name" => "text_link",
                    "dependency"    => array(
                        "element"   => 'style',
                        "value"   => 'default',
                        )
                )
            )
        ));
    }
}
}