<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(defined('ICL_LANGUAGE_CODE') || class_exists('Polylang')){
    if(!function_exists('sv_vc_language_selector'))
    {
        function sv_vc_language_selector($attr)
        {
            $html = $lang_sub = $lang_active = '';
            extract(shortcode_atts(array(
                'style'             => 'aloshop-style',
                'style_home'        => '',
                'flag'              => 'yes',
                'border_left'       => '',
                'border_right'      => '',
            ),$attr));
            switch ($style) {
                case 'poly-style':
                    if(function_exists('pll_the_languages')){
                        ob_start();
                        $html .=    '<div class="polylang-selector">';
                        pll_the_languages(array('dropdown'=>1,'show_flags'=>1));
                        $html .=    ob_get_clean();
                        $html .=    '</div>';
                    }
                    break;

                case 'wpml-style':
                    ob_start();
                    do_action('wpml_add_language_selector');
                    $html .=    ob_get_clean();
                    break;
                
                default:
                    if(defined('ICL_SITEPRESS_VERSION')){
                        $wpml_lang = icl_get_languages('skip_missing=0&orderby=custom');            
                        foreach ($wpml_lang as $lang) {
                            if($lang['active']){
                                $l_class = 'active';
                                $lang_active .=     '<a class="language-selected" href="'.esc_url($lang['country_flag_url']).'">';
                                if($flag == 'yes') $lang_active .=     '<img alt="flag" src="'.esc_url($lang['country_flag_url']).'">';
                                $lang_active .=         $lang['native_name'];
                                $lang_active .=     '</a>';
                            }
                            else $l_class = '';
                            $lang_sub .=                '<li class="'.$l_class.'">
                                                            <a href="'.esc_url($lang['url']).'">';
                            if($flag == 'yes') $lang_sub .=     '<img alt="flag" src="'.esc_url($lang['country_flag_url']).'">';
                            $lang_sub .=                        $lang['native_name'];
                            $lang_sub .=                    '</a>
                                                        </li>';
                        }
                        $html .=            '<ul class="'.$style_home.' top-info '.$border_left.' '.$border_right.'">';
                        $html .=                '<li class="top-language has-child">'.$lang_active.'
                                                    <ul class="sub-menu-top">';
                        $html .=                        $lang_sub;
                        $html .=                    '</ul>
                                                </li>';
                        $html .=            '</ul>';
                    }
                    else{
                        if(class_exists('Polylang')){
                            global $polylang;
                            $languages = $polylang->model->get_languages_list();
                            $current_lang = pll_current_language();
                            foreach ($languages as $lang) {
                                if($lang->slug == $current_lang){
                                    $l_class = 'active';
                                    $lang_active .=     '<a class="language-selected" href="'.esc_url($lang->home_url).'">';
                                    if($flag == 'yes') $lang_active .=     '<img alt="flag" src="'.esc_url($lang->flag_url).'">';
                                    $lang_active .=         $lang->name;
                                    $lang_active .=     '</a>';
                                }
                                else $l_class = '';
                                $lang_sub .=                '<li class="'.$l_class.'">
                                                                <a href="'.esc_url($lang->home_url).'">';
                                if($flag == 'yes') $lang_sub .=     '<img alt="flag" src="'.esc_url($lang->flag_url).'">';
                                $lang_sub .=                        $lang->name;
                                $lang_sub .=                    '</a>
                                                            </li>';
                            }
                            $html .=            '<ul class="'.$style_home.' top-info '.$border_left.' '.$border_right.'">';
                            $html .=                '<li class="top-language has-child">'.$lang_active.'
                                                        <ul class="sub-menu-top">';
                            $html .=                        $lang_sub;
                            $html .=                    '</ul>
                                                    </li>';
                            $html .=            '</ul>';  
                        }
                    }
                    break;
            }            
            return $html;
        }
    }

    stp_reg_shortcode('sv_language_selector','sv_vc_language_selector');

    vc_map( array(
        "name"      => esc_html__("SV Language Selector", 'aloshop'),
        "base"      => "sv_language_selector",
        "icon"      => "icon-st",
        "category"  => '7Up-theme',
        "params"    => array(
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Type",'aloshop'),
                "param_name" => "style",
                "value"     => array(
                    esc_html__("Aloshop style",'aloshop')       => 'aloshop-style',
                    esc_html__("Wpml style",'aloshop')          => 'wpml-style',
                    esc_html__("Polylang style",'aloshop')          => 'poly-style',
                    )
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Style",'aloshop'),
                "param_name" => "style_home",
                "value"     => array(
                    esc_html__("Home",'aloshop')     => '',
                    esc_html__("Home 2",'aloshop')     => 'top-info-left',
                    esc_html__("Home 3",'aloshop')     => 'top-info3',
                    esc_html__("Home 7",'aloshop')     => 'top-info7',
                    esc_html__("Home 9",'aloshop')     => 'top-info9',
                    ),
                "dependency"     => array(
                    "element"       => "style",
                    "value"         => "aloshop-style",
                    )
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Show Flag",'aloshop'),
                "param_name" => "flag",
                "value"     => array(
                    esc_html__("Yes",'aloshop')     => 'yes',
                    esc_html__("No",'aloshop')     => 'no',
                    ),
                "dependency"     => array(
                    "element"       => "style",
                    "value"         => "aloshop-style",
                    )
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Border Left",'aloshop'),
                "param_name" => "border_left",
                "value"     => array(
                    esc_html__("No",'aloshop')     => '',
                    esc_html__("Yes",'aloshop')     => 'show-border-left',
                    ),
                "dependency"     => array(
                    "element"       => "style",
                    "value"         => "aloshop-style",
                    )
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Border Right",'aloshop'),
                "param_name" => "border_right",
                "value"     => array(
                    esc_html__("No",'aloshop')     => '',
                    esc_html__("Yes",'aloshop')     => 'show-border-right',
                    ),
                "dependency"     => array(
                    "element"       => "style",
                    "value"         => "aloshop-style",
                    )
            )
        )
    ));
}