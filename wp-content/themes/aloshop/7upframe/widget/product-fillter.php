<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 24/12/15
 * Time: 10:20 AM
 */
if(!class_exists('SV_Product_Fillter') && class_exists("woocommerce"))
{
    class SV_Product_Fillter extends WP_Widget {


        protected $default=array();

        static function _init()
        {
            add_action( 'widgets_init', array(__CLASS__,'_add_widget') );
        }

        static function _add_widget()
        {
            register_widget( 'SV_Product_Fillter' );
        }

        function __construct() {
            // Instantiate the parent object
            parent::__construct( false, esc_html__('Product Fillter','aloshop'),
                array( 'description' => esc_html__( 'Fillter product shop page', 'aloshop' ), ));

            $this->default=array(
                'title' => '',
                'category' => array(),
                'price'    => '',
                'price_min'    => '',
                'price_max'    => '',
                'attribute' => array(),
            );
        }



        function widget( $args, $instance ) {
            // Widget output
            if(!is_single()){
                echo balancetags($args['before_widget']);
                if ( ! empty( $instance['title'] ) ) {
                   echo balancetags($args['before_title']) . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
                }

                $instance=wp_parse_args($instance,$this->default);
                extract($instance);
                if(is_object($category)) $category = json_decode(json_encode($category), true);
                if(is_object($attribute)) $attribute = json_decode(json_encode($attribute), true);
                echo    '<div class="sidebar-shop">
                            <div class="widget widget-filter">';
                if(is_array($category) && !empty($category)){
                    echo        '<div class="box-filter category-filter">
                                    <h2 class="widget-title">'.esc_html__("CATEGORY","aloshop").'</h2>
                                    <ul>';                
                        $cat_current = '';
                        if(isset($_GET['product_cat'])) $cat_current = $_GET['product_cat'];
                        if($cat_current != '') $cat_current = explode(',', $cat_current);
                        else $cat_current = array();
                        foreach ($category as $cat_slug) {
                            $cat = get_term_by('slug',$cat_slug,'product_cat');
                            if(is_object($cat)){
                                if(in_array($cat->slug, $cat_current)) $active = 'active';
                                else $active = '';
                                echo        '<li><a data-cat='.esc_attr($cat->slug).' href="'.esc_url(sv_get_filter_url('product_cat',$cat->slug)).'" class="load-shop-ajax '.$active.'"> '.$cat->name.' ('.$cat->count.')</a></li>';
                            }
                        }
                    echo            '</ul>
                                </div>';
                }
                if($price == 'yes'){
                    global $wpdb,$wp;
                    $price_arange = sv_get_price_arange();
                    if(empty($price_min)) $min = $price_arange['min'];
                    else $min = $price_min;
                    if(empty($price_max)) $max = $price_arange['max'];
                    else $max = $price_max;
                    if(isset($_GET['product_cat'])) $cat_input_html = '<input class="product-cat-filter" type="hidden" name="product_cat" value="'.$_GET['product_cat'].'">';
                    else $cat_input_html = '';
                    if(isset($_GET['min_price'])) $current_min = $_GET['min_price'];
                    else $current_min = $min;
                    if(isset($_GET['max_price'])) $current_max = $_GET['max_price'];
                    else $current_max = $max;
                    if ( '' == get_option( 'permalink_structure' ) ) {
                        $form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', esc_url(home_url( '/' )).$wp->request ) );
                    } else {
                        $form_action = preg_replace( '%\/page/[0-9]+%', '', esc_url(home_url( '/' )).trailingslashit( $wp->request ) );
                    }
                    $input_attr_html = '';
                    foreach ($attribute as $key => $attr) {
                        if(isset($_GET['pa_'.$attr])){
                            $input_attr_html .= '<input class=" product-attr product-attr-'.$attr.'" type="hidden" name="pa_'.$attr.'" value="'.$_GET['pa_'.$attr].'">';
                        }
                    }
                    echo    '<div class="box-filter price-filter">
                                <h2 class="widget-title">'.esc_html__("price","aloshop").'</h2>
                                <div class="inner-price-filter">
                                    <div class="range-filter">
                                        <form method="get" action="'.esc_url( $form_action ).'">
                                            <label>'.get_woocommerce_currency_symbol().'</label>
                                            <div id="amount"></div>
                                            '.$cat_input_html.'
                                            <input class="price-min-filter" type="hidden" name="min_price" value="'.$current_min.'">
                                            <input class="price-max-filter" type="hidden" name="max_price" value="'.$current_max.'">
                                            '.$input_attr_html.'
                                            <button class="btn-filter">'.esc_html__("Filter","aloshop").'</button>
                                            <div id="slider-range" data-min="'.$min.'" data-max="'.$max.'" data-current_min="'.$current_min.'" data-current_max="'.$current_max.'"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                }
                if(is_array($attribute) && !empty($attribute)){
                    foreach ($attribute as $key => $attr) {
                        $terms = get_terms("pa_".$attr);
                        $term_current = '';
                        if(isset($_GET['pa_'.$attr])) $term_current = $_GET['pa_'.$attr];
                        if($term_current != '') $term_current = explode(',', $term_current);
                        else $term_current = array();
                        if($attr == 'color'){                        
                            echo    '<div class="box-filter '.$attr.'-filter">
                                        <h2 class="widget-title">'. wc_attribute_label( $attr ).'</h2>
                                        <div class="list-'.$attr.'-filter">';
                            if(is_array($terms)){
                                foreach ($terms as $term) {
                                    if(is_object($term)){
                                        if(in_array($term->slug, $term_current)) $active = 'active';
                                        else $active = '';
                                        echo '<a data-attribute="pa_'.esc_attr($attr).'" data-term="'.esc_attr($term->slug).'" class="load-shop-ajax '.$active.' color-'.$term->slug.'" href="'.esc_url(sv_get_filter_url('pa_'.$attr,$term->slug)).'"></a>';
                                    }
                                }
                            }
                            echo        '</div>
                                    </div>';
                        }
                        else{
                            echo    '<div class="box-filter '.$attr.'-filter">
                                        <h2 class="widget-title">'. wc_attribute_label( $attr ).'</h2>
                                        <div class="list-'.$attr.'-filter">
                                            <ul>';
                            if(is_array($terms)){
                                foreach ($terms as $term) {
                                    if(is_object($term)){
                                        if(in_array($term->slug, $term_current)) $active = 'active';
                                        else $active = '';
                                        echo    '<li><a data-attribute="pa_'.esc_attr($attr).'" data-term="'.esc_attr($term->slug).'" class="load-shop-ajax '.$active.'" href="'.esc_url(sv_get_filter_url('pa_'.$attr,$term->slug)).'">'.$term->name.' <span>('.$term->count.')</span></a></li>';
                                    }
                                }
                            }
                            echo            '</ul>
                                        </div>
                                    </div>';
                        }
                    }
                }
                echo        '</div>
                        </div>';           
                echo balancetags($args['after_widget']);
            }
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
            if(is_object($category)) $category = json_decode(json_encode($category), true);
            if(is_object($attribute)) $attribute = json_decode(json_encode($attribute), true);
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:' ,'aloshop'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <p>
                <label><?php esc_html_e( 'Categories:' ,'aloshop'); ?></label></br>
                <?php 
                $cats = get_terms('product_cat');
                if(is_array($cats) && !empty($cats)){
                    foreach ($cats as $cat) {
                        if(in_array($cat->slug, $category)) $checked = 'checked="checked"';
                        else $checked = '';
                        echo '<input '.$checked.' id="'.esc_attr($this->get_field_id( 'category' )).'" type="checkbox" name="'.esc_attr($this->get_field_name( 'category' )).'[]" value="'.$cat->slug.'"><span>'.$cat->name.'</span>';
                    }
                }
                else echo esc_html__("No any category.","aloshop");
                ?>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'price' )); ?>"><?php esc_html_e( 'Filter Price:' ,'aloshop'); ?></label>

                <select id="<?php echo esc_attr($this->get_field_id( 'price' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'price' )); ?>">
                    <option <?php selected('yes',$price) ?> value="yes"><?php esc_html_e("Yes","aloshop")?></option>
                    <option <?php selected('no',$price) ?> value="no"><?php esc_html_e("No","aloshop")?></option>

                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'price_min' )); ?>"><?php esc_html_e( 'Default min price:' ,'aloshop'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'price_min' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'price_min' )); ?>" type="text" value="<?php echo esc_attr( $price_min ); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'price_max' )); ?>"><?php esc_html_e( 'Default max price:' ,'aloshop'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'price_max' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'price_max' )); ?>" type="text" value="<?php echo esc_attr( $price_max ); ?>">
            </p>
            <p>
                <label><?php esc_html_e( 'Attribute:' ,'aloshop'); ?></label></br>
                <?php 
                global $wpdb;
                $attribute_taxonomies = $wpdb->get_results( "
                    SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies" );
                if(!empty($attribute_taxonomies)){
                    foreach($attribute_taxonomies as $attr){
                        if(in_array($attr->attribute_name, $attribute)) $checked = 'checked="checked"';
                        else $checked = '';
                        echo '<input '.$checked.' id="'.esc_attr($this->get_field_id( 'attribute' )).'" type="checkbox" name="'.esc_attr($this->get_field_name( 'attribute' )).'[]" value="'.$attr->attribute_name.'"><span>'.$attr->attribute_label.'</span>';
                    }
                }
                else echo esc_html__("No any attribute.","aloshop");
                ?>
            </p>
        <?php
        }
    }

    SV_Product_Fillter::_init();

}