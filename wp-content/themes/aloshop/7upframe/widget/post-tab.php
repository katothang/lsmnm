<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('SV_Post_Tab_Widget'))
{
    class SV_Post_Tab_Widget extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            register_widget( 'SV_Post_Tab_Widget' );
        }

        function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('Post Tab Widget','aloshop'),
                array( 'description' => esc_html__( 'Get post tab slider', 'aloshop' ), ));

            $this->default=array(
                'title'     => '',
                'number'     => '',
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
                'post_type'         => 'post',
                'posts_per_page'    => $number,
            );
            $html =    '<div class="widget-post-tab">
                            <div class="title-post-tab">
                                <ul>
                                    <li class="active"><a data-toggle="tab" href="'.esc_url('#popular').'" aria-expanded="true">'.esc_html__("Popular","aloshop").'</a></li>
                                    <li class=""><a data-toggle="tab" href="'.esc_url('#recent').'" aria-expanded="false">'.esc_html__("Recent","aloshop").'</a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div id="popular" class="tab-pane fade active in" role="tabpanel">
                                    <ul class="list-post-tab">';
            $args_post['orderby'] = 'meta_value_num';
            $args_post['meta_key'] = 'post_views';
            $query = new WP_Query($args_post);
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    $html .=            '<li>
                                            <div class="zoom-image-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(100,67)).'</a>
                                            </div>
                                            <div class="post-tab-info">
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <span>'.get_the_time('F d Y').'</span>
                                            </div>
                                        </li>';
                }
            }
            $html .=                '</ul>
                                </div>
                                <div id="recent" class="tab-pane fade" role="tabpanel">
                                    <ul class="list-post-tab">';
            $args_post['orderby'] = 'date';
            unset($args_post['meta_key']);
            $query = new WP_Query($args_post);
            if($query->have_posts()) {
                while($query->have_posts()) {
                    $query->the_post();
                    $html .=            '<li>
                                            <div class="zoom-image-thumb">
                                                <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(100,67)).'</a>
                                            </div>
                                            <div class="post-tab-info">
                                                <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                <span>'.get_the_time('F d Y').'</span>
                                            </div>
                                        </li>';
                }
            }
            $html .=                '</ul>
                                </div>
                            </div>
                        </div>';
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
        <?php
        }
    }

    SV_Post_Tab_Widget::_init();

}
