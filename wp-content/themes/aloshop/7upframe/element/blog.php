<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 29/02/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_blog'))
{
    function sv_vc_blog($attr)
    {
        $html = $class_nav = '';
        extract(shortcode_atts(array(
            'style'      => 'blog-list-post',
            'number'     => '',
            'order'      => '',
            'order_by'   => '',
            'cats'       => '',
        ),$attr));
        if($style == 'masonry-list-post'){
            wp_enqueue_script('masonry');
            $class_nav = 'masonry-paginav';
        }
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $args=array(
            'post_type'         => 'post',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
            'paged'             => $paged,
        );
        if($order_by == 'post_views'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'post_views';
        }
        if($order_by == 'time_update'){
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'time_update';
        }
        if($order_by == '_post_like_count'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_post_like_count';
        }
        if(!empty($cats)) {
            $custom_list = explode(",",$cats);
            $args['tax_query'][]=array(
                'taxonomy'=>'category',
                'field'=>'slug',
                'terms'=> $custom_list
            );
        }
        $query = new WP_Query($args);
        $count = 1;
        $count_query = $query->post_count;
        $html .=    '<div class="'.$style.'">';
        ob_start();
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                get_template_part( 'sv_templates/blog-content/'.$style );
            }
        }
        $html .=    ob_get_clean();
        if($style == 'masonry-list-post') $html .=    '</div></div>';
        $big = 999999999;
        $html .=    '<div class="post-paginav '.$class_nav.'">';
        $html .=        paginate_links( array(
                            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'format'       => '&page=%#%',
                            'current'      => max( 1, $paged ),
                            'total'        => $query->max_num_pages,
                            'prev_text' => '<i class="fa fa-angle-double-left"></i> '.esc_html__( 'Prev', 'aloshop' ),
                            'next_text' => esc_html__( 'Next', 'aloshop' ).' <i class="fa fa-angle-double-right"></i>',
                            'end_size'     => 2,
                            'mid_size'     => 1
                        ) );
        if($style != 'masonry-list-post') $html .=    '</div></div>';
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_blog','sv_vc_blog');

vc_map( array(
    "name"      => esc_html__("SV Blog", 'aloshop'),
    "base"      => "sv_blog",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Number post",'aloshop'),
            "param_name" => "number",
            'description'   => esc_html__( 'Number of post display in this element. Default is 10.', 'aloshop' ),
        ),
        array(
            "type"          => "dropdown",
            "holder"        => "div",
            "heading"       => esc_html__("Style Post",'aloshop'),
            "param_name"    => "style",
            "value"         => array(
                esc_html__("List","aloshop")        => 'blog-list-post',
                esc_html__("Masonry","aloshop")     => 'masonry-list-post',
                ),
            'description'   => esc_html__( 'Choose style to display.', 'aloshop' ),
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Order",'aloshop'),
            "param_name"    => "order",
            "value"         => array(
                esc_html__('Desc','aloshop') => 'DESC',
                esc_html__('Asc','aloshop')  => 'ASC',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Order By",'aloshop'),
            "param_name"    => "order_by",
            "value"         => sv_get_order_list(),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),        
        array(
            'holder'     => 'div',
            'heading'     => esc_html__( 'Categories', 'aloshop' ),
            'type'        => 'checkbox',
            'param_name'  => 'cats',
            'value'       => sv_list_taxonomy('category',false)
        ),
    )
));