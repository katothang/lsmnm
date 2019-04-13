<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_process_bar'))
{
    function sv_vc_process_bar($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         => 'circle-process',
            'title'         => '100',
            'value'         => '100',
            'color1'        => '#e5e5e5',
            'color2'        => '#ffd21e',
            'value_color'   => '',
            'value_size'    => '30',
            'bg_color'      => '',
            'radius'        => '150',
            'width'         => '3',
            'height'        => '5',
            'border_radius' => '0',
            'align'         => '',
        ),$attr));
        wp_enqueue_script('pieChart');
        wp_enqueue_script('circles');
        $el_class = $css_string = $bg_class = $c_class1 = $c_class2 = $css_string2 = $line_class = $line_class2 = '';
        if(!empty($value_color)) $css_string .= 'color:'.$value_color.';';
        if(!empty($bg_color)) $bg_class = SV_Assets::build_css('background:'.$bg_color.';');
        if(!empty($value_size)) $css_string .= 'font-size:'.$value_size.'px !important;';
        if(!empty($css_string)) $el_class = SV_Assets::build_css($css_string);
        if(!empty($color1)) $c_class1 = SV_Assets::build_css('background-color: '.$color1.';fill: '.$color1.';');
        if(!empty($color2)) $c_class2 = SV_Assets::build_css('background-color: '.$color2.';fill: '.$color2.';');
        if(!empty($height)) $css_string2 .= 'height:'.$height.'px;';
        $css_string2 .= 'border-radius:'.$border_radius.'px;';
        if(!empty($color1)) $css_string2 .= 'background:'.$color1.' !important;';
        if(!empty($css_string2)) $line_class = SV_Assets::build_css($css_string2);
        if(!empty($color2)) $line_class2 = SV_Assets::build_css('background:'.$color2.' !important;');
        $num = uniqid();
        switch ($style) {
            case 'line-title':
                $html .=    '<div class="item-progressbar processbar-title '.$align.'">
                                <div class="process-intro clearfix"><label class="pull-left">'.$title.'</label> <span class="pull-right">'.$value.'%</span></div>
                                <div class="hidden"></div>
                                <div class="line-progressbar '.$line_class.'" id="'.$num.'" data-value="'.$value.'" data-class="'.$line_class2.'"></div>
                            </div>';
                break;

            case 'line-process':
            $html .=    '<div class="item-progressbar '.$align.'">
                            <label class="'.$el_class.'">100%</label>
                            <div class="line-progressbar '.$line_class.'" id="'.$num.'" data-value="'.$value.'" data-class="'.$line_class2.'"></div>
                        </div>';
            break;

            case 'pie-chart':
            $value2 = 100 - (int)$value;
                $html .=    '<div class="sv-pie-chart" id="'.$num.'" data-color1="'.$c_class1.'" data-color2="'.$c_class2.'">
                                <input type="hidden" class="pieChart" value="'.$value.'">
                                <input type="hidden" class="pieChart" value="'.$value2.'">
                            </div>
                            <div id="target_'.$num.'" class="pie-chart"></div>';
                break;
            
            default:
                
        $html .= '<div class="'.$style.' '.$bg_class.'" id="chart-'.$num.'" data-color1="'.$color1.'" data-color2="'.$color2.'" data-value="'.$value.'" data-radius="'.$radius.'" data-width="'.$width.'" data-class="'.$el_class.'"></div>';
                break;
        }
        return $html;
    }
}

stp_reg_shortcode('sv_process_bar','sv_vc_process_bar');

vc_map( array(
    "name"      => esc_html__("SV Process Bar", 'aloshop'),
    "base"      => "sv_process_bar",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "holder" => "div",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Circle",'aloshop')  => 'circle-process',
                esc_html__("Pie Chart",'aloshop')  => 'pie-chart',
                esc_html__("Line",'aloshop')  => 'line-process',
                esc_html__("Line title",'aloshop')  => 'line-title',
                )
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Title",'aloshop'),
            "param_name" => "title",
            "dependency"    => array(
                "element"   => 'style',
                "value"   => 'line-title',
                )
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => esc_html__("Value",'aloshop'),
            "param_name" => "value",
            'description' => esc_html__( 'Enter number 1~100. Default is 100', 'aloshop' ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Radius",'aloshop'),
            "param_name" => "radius",
            'description' => esc_html__( 'Enter number. Default is 150', 'aloshop' ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Width",'aloshop'),
            "param_name" => "width",
            'description' => esc_html__( 'Enter number. Default is 3', 'aloshop' ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Color 1",'aloshop'),
            "param_name" => "color1",
            'description' => esc_html__( 'Default is #e5e5e5', 'aloshop' ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Color 2",'aloshop'),
            "param_name" => "color2",
            'description' => esc_html__( 'Default is #ffd21e', 'aloshop' ),
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Value Color",'aloshop'),
            "param_name" => "value_color",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Value Size",'aloshop'),
            "param_name" => "value_size",
            'description' => esc_html__( 'Default is 30. Unit(px)', 'aloshop' ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Height",'aloshop'),
            "param_name" => "height",
            'description' => esc_html__( 'Default is 5. Unit(px)', 'aloshop' ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Border Radius",'aloshop'),
            "param_name" => "height",
            'description' => esc_html__( 'Default is 0. Unit(px)', 'aloshop' ),
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Align",'aloshop'),
            "param_name" => "align",
            "value"     => array(
                esc_html__("Default",'aloshop')    => '',
                esc_html__("Pull left",'aloshop')    => 'pull-left',
                esc_html__("Pull right",'aloshop')    => 'pull-right',
                )
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background Color",'aloshop'),
            "param_name" => "bg_color",
        ),
    )
));