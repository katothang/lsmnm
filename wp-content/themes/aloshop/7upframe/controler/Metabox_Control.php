<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */

add_action('admin_init', 'sv_custom_meta_boxes');
if(!function_exists('sv_custom_meta_boxes')){
    function sv_custom_meta_boxes(){
        //Format content
        $format_metabox = array(
            'id' => 'block_format_content',
            'title' => esc_html__('Format Settings', 'aloshop'),
            'desc' => '',
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(                
                array(
                    'id' => 'format_image',
                    'label' => esc_html__('Upload Image', 'aloshop'),
                    'type' => 'upload',
                ),
                array(
                    'id' => 'format_gallery',
                    'label' => esc_html__('Add Gallery', 'aloshop'),
                    'type' => 'Gallery',
                ),
                array(
                    'id' => 'format_media',
                    'label' => esc_html__('Link Media', 'aloshop'),
                    'type' => 'text',
                )
            ),
        );
        // SideBar
    	$sidebar_metabox_default = array(
            'id'        => 'sv_sidebar_option',
            'title'     => 'Advanced Settings',
            'desc'      => '',
            'pages'     => array( 'page','post','product'),
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(
                array(
                    'id'          => 'sv_sidebar_position',
                    'label'       => esc_html__('Sidebar position ','aloshop'),
                    'type'        => 'select',
                    'std' => '',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','aloshop'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('No Sidebar','aloshop'),
                            'value'=>'no'
                        ),
                        array(
                            'label'=>esc_html__('Left sidebar','aloshop'),
                            'value'=>'left'
                        ),
                        array(
                            'label'=>esc_html__('Right sidebar','aloshop'),
                            'value'=>'right'
                        ),
                    ),

                ),
                array(
                    'id'        =>'sv_select_sidebar',
                    'label'     =>esc_html__('Selects sidebar','aloshop'),
                    'type'      =>'sidebar-select',
                    'condition' => 'sv_sidebar_position:not(no),sv_sidebar_position:not()',
                ),
                array(
                    'id'          => 'sv_show_breadrumb',
                    'label'       => esc_html__('Show Breadcrumb','aloshop'),
                    'type'        => 'select',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','aloshop'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('Yes','aloshop'),
                            'value'=>'yes'
                        ),
                        array(
                            'label'=>esc_html__('No','aloshop'),
                            'value'=>'no'
                        ),
                    ),

                ),
                array(
                    'id'          => 'sv_menu_fixed',
                    'label'       => esc_html__('Menu Fixed','aloshop'),
                    'desc'        => 'Menu change to fixed when scroll',
                    'type'        => 'select',
                    'choices'     => array(
                        array(
                            'label' =>  esc_html__('--Select--','aloshop'),
                            'value' =>  '',
                        ),
                        array(
                            'label' =>  esc_html__('Yes','aloshop'),
                            'value' =>  'on'
                        ),
                        array(
                            'label' =>  esc_html__('No','aloshop'),
                            'value' =>  'off'
                        ),
                    ),
                ),
                array(
                    'id'          => 'sv_header_page',
                    'label'       => esc_html__('Choose page header','aloshop'),
                    'type'        => 'select',
                    'choices'     => sv_list_header_page()
                ),
                array(
                    'id'          => 'sv_footer_page',
                    'label'       => esc_html__('Choose page footer','aloshop'),
                    'type'        => 'page-select'
                )
            )
        );
        $product_trendding = array(
            'id' => 'product_trendding',
            'title' => esc_html__('Product Type', 'aloshop'),
            'desc' => '',
            'pages' => array('product'),
            'context' => 'side',
            'priority' => 'high',
            'fields' => array(                
                array(
                    'id'    => 'trending_product',
                    'label' => esc_html__('Product Trendding', 'aloshop'),
                    'type'        => 'on-off',
                    'std'         => 'off'
                ),
            ),
        );
        $product_metabox = array(
            'id' => 'block_product_thumb_hover',
            'title' => esc_html__('Product hover image', 'aloshop'),
            'desc' => '',
            'pages' => array('product'),
            'context' => 'side',
            'priority' => 'low',
            'fields' => array(                
                array(
                    'id'    => 'product_thumb_hover',
                    'label' => esc_html__('Product hover image', 'aloshop'),
                    'type'  => 'upload',
                ),
                array(
                    'id'    => 'deals_time',
                    'label' => esc_html__('Deals time', 'aloshop'),
                    'type'  => 'text',
                    'desc' => esc_html__('Enter deals time format housr:min. 00:00 ~ 23:59.', 'aloshop'),
                ),
                array(
                    'id'          => 'product_style',
                    'label'       => esc_html__('Product Style','aloshop'),
                    'type'        => 'select',
                    'choices'     => array(
                        array(
                            'value'=> '',
                            'label'=> esc_html__("-- Select --", 'aloshop'),
                        ),
                        array(
                            'value'=> 'style1',
                            'label'=> esc_html__("Style 1", 'aloshop'),
                        ),
                        array(
                            'value'=> 'style2',
                            'label'=> esc_html__("Style 2", 'aloshop'),
                        ),
                    )
                ),
                array(
                    'id'          => 'attribute_style',
                    'label'       => esc_html__('Attributes Style','aloshop'),
                    'type'        => 'select',
                    'choices'     => array(  
                        array(
                            'value'=> '',
                            'label'=> esc_html__("-- Select --", 'aloshop'),
                        ),                                                  
                        array(
                            'value'=> 'default',
                            'label'=> esc_html__("Default", 'aloshop'),
                        ),
                        array(
                            'value'=> 'special',
                            'label'=> esc_html__("Special", 'aloshop'),
                        ),
                    )
                ),
            ),
        );
        //Show page title
        $show_page_title = array(
            'id' => 'page_title_setting',
            'title' => esc_html__('Title page setting', 'aloshop'),
            'pages' => array('page'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'show_title_page',
                    'label' => esc_html__('Show title', 'aloshop'),
                    'type' => 'on-off',
                    'std'   => 'on',
                ),
                array(
                    'id' => 'show_scroll_top',
                    'label' => esc_html__('Show Scroll top', 'aloshop'),
                    'type' => 'on-off',
                    'std' => 'off',
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
                    'id' => 'shop_ajax',
                    'label' => esc_html__('Shop Ajax', 'aloshop'),
                    'type' => 'select',
                    'std'   => '',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','aloshop'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('On','aloshop'),
                            'value'=>'on'
                        ),
                        array(
                            'label'=>esc_html__('Off','aloshop'),
                            'value'=>'off'
                        ),
                    ),
                )
            ),
        );
        $product_data = array(
            'id' => 'product_data',
            'title' => esc_html__('Product Settings', 'aloshop'),
            'desc' => '',
            'pages' => array('product'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => array(                
                array(
                    'id'          => 's7upf_product_tab_data',
                    'label'       => esc_html__('Add Custom Tab','7upframework'),
                    'type'        => 'list-item',
                    'settings'    => array(
                        array(
                            'id' => 'tab_content',
                            'label' => esc_html__('Content', '7upframework'),
                            'type' => 'textarea',
                        ),
                        array(
                            'id'            => 'priority',
                            'label'         => esc_html__('Priority (Default 40)', '7upframework'),
                            'type'          => 'numeric-slider',
                            'min_max_step'  => '1,50,1',
                            'std'           => '40',
                            'desc'          => esc_html__('Choose priority value to re-order custom tab position.','7upframework'),
                        ),
                    )
                ),
            ),
        );
        if (function_exists('ot_register_meta_box')){
            ot_register_meta_box($format_metabox);
            ot_register_meta_box($sidebar_metabox_default);
            ot_register_meta_box($product_trendding);
            ot_register_meta_box($product_metabox);
            ot_register_meta_box($product_data);
            ot_register_meta_box($show_page_title);
        }
    }
}
?>