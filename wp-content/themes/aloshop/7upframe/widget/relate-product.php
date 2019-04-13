<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('SV_Relate_products'))
{
    class SV_Relate_products extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            register_widget( 'SV_Relate_products' );
        }

        function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('SV Products','aloshop'),
                array( 'description' => esc_html__( 'Get products widget', 'aloshop' ), ));

            $this->default=array(
                'title'     => '',
                'number'     => '',
                'product_type'     => '',
            );
        }

        function widget( $args, $instance ) {
            // Widget output
            echo balancetags($args['before_widget']);
            if ( ! empty( $instance['title'] ) ) {
               echo balancetags($args['before_title']) . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
            }
            $instance = wp_parse_args($instance,$this->default);
            extract($instance);
            $args_post=array(
                'post_type'         => 'product',
                'posts_per_page'    => $number,
                'orderby'           => 'date'
            );
            if($product_type == 'trendding'){
                $args_post['meta_query'][] = array(
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
                $args_post['meta_key'] = 'post_views';
                $args_post['orderby'] = 'meta_value_num';
            }
            if($product_type == 'bestsell'){
                $args_post['meta_key'] = 'total_sales';
                $args_post['orderby'] = 'meta_value_num';
            }
            if($product_type=='onsale'){
                $args_post['meta_query']['relation']= 'OR';
                $args_post['meta_query'][]=array(
                    'key'   => '_sale_price',
                    'value' => 0,
                    'compare' => '>',                
                    'type'          => 'numeric'
                );
                $args_post['meta_query'][]=array(
                    'key'   => '_min_variation_sale_price',
                    'value' => 0,
                    'compare' => '>',                
                    'type'          => 'numeric'
                );
            }
            if($product_type == 'featured'){
                $args_post['tax_query'][] = array(
                                            'taxonomy' => 'product_visibility',
                                            'field'    => 'name',
                                            'terms'    => 'featured',
                                            'operator' => 'IN',
                                        );
            }
            $query = new WP_Query($args_post);
            $html =    '';
            if($query->have_posts()) {
                $html .=    '<ul class="list-product-related">';
                while($query->have_posts()) {
                    $query->the_post();
                    global $product;
                    $html .=    '<li class="clearfix">
                                    <div class="product-related-thumb">
                                        <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(103,123)).'</a>
                                    </div>
                                    <div class="product-related-info">
                                        <h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                        '.sv_get_product_price().'
                                        '.sv_get_rating_html().'
                                    </div>
                                </li>';
                }                
                $html .=    '</ul>';
            }
            wp_reset_postdata();
            echo balancetags($html);
            echo balancetags($args['after_widget']);
        }

        function update( $new_instance, $old_instance ) {

            // Save widget options
            $instance=array();
            $instance=wp_parse_args($instance,$this->default);
            $new_instance=wp_parse_args($new_instance,$instance);

            return $new_instance;
        }

        function form( $instance ) {
            // Output admin widget options form

            $instance=wp_parse_args($instance,$this->default);
            extract($instance);
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:' ,'aloshop'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number', 'aloshop'); ?>: </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('product_type')); ?>"><?php esc_html_e('Product Type', 'aloshop'); ?>: </label>
                <select id="<?php echo esc_attr($this->get_field_id( 'product_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'product_type' )); ?>">
                    <option value="" <?php if($product_type == '') echo'selected="selected"';?>><?php esc_html_e('Recent Product','aloshop');?></option>
                    <option value="featured" <?php if($product_type == 'featured') echo'selected="selected"';?>><?php esc_html_e('Featured Product','aloshop');?></option>
                    <option value="trending" <?php if($product_type == 'trending') echo'selected="selected"';?>><?php esc_html_e('Trending Product','aloshop');?></option>
                    <option value="onsale" <?php if($product_type == 'onsale') echo'selected="selected"';?>><?php esc_html_e('Sale Product','aloshop');?></option>
                    <option value="bestsell" <?php if($product_type == 'bestsell') echo'selected="selected"';?>><?php esc_html_e('Bestsell Product','aloshop');?></option>
                    <option value="toprate" <?php if($product_type == 'toprate') echo'selected="selected"';?>><?php esc_html_e('Top rate Product','aloshop');?></option>
                    <option value="mostview" <?php if($product_type == 'mostview') echo'selected="selected"';?>><?php esc_html_e('Most view Product','aloshop');?></option>
                </select>
            </p>
        <?php
        }
    }

    SV_Relate_products::_init();

}
