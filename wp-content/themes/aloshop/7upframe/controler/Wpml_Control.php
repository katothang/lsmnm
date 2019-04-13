<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 13/08/15
 * Time: 10:20 AM
 */

if(!function_exists('s7upf_get_list_languages')){
    function s7upf_get_list_languages(){
        $languages = array();
        if(function_exists('qtranxf_getSortedLanguages')) $languages = qtranxf_getSortedLanguages();
        if(defined( 'POLYLANG_VERSION' )){
            global $polylang;
            $languages = array();
            $poly_languages = $polylang->model->get_languages_list();
            foreach ($poly_languages as $lang) {
                $languages[] = $lang->slug;
            }
        }
        if(defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE')){
            global $sitepress;
            $languages = array();
            $wpml_lang = icl_get_languages('skip_missing=0&orderby=custom');
            foreach ($wpml_lang as $lang) {
                $languages[] = $lang['language_code'];
            }
        }
        return $languages;
    }
}
if(!function_exists('s7upf_get_current_language')){
    function s7upf_get_current_language(){
        $lang_code = '';
        if(function_exists('qtranxf_getSortedLanguages')){
            global $q_config;
            $lang_code = $q_config['language'];
        }
        if(defined( 'POLYLANG_VERSION' ))$lang_code = pll_current_language();
        if(defined('ICL_SITEPRESS_VERSION') && defined('ICL_LANGUAGE_CODE')) $lang_code = ICL_LANGUAGE_CODE;
        return $lang_code;
    }
}
if(defined('QTX_VERSION')){
    add_filter('s7upf_get_page_content','s7upf_get_page_content');
    if(!function_exists('s7upf_get_page_content')){
        function s7upf_get_page_content($content){
            if(function_exists('qtranxf_useCurrentLanguageIfNotFoundShowAvailable')) return qtranxf_useCurrentLanguageIfNotFoundShowAvailable($content);
            else return $content;
        }
    }
}
if(defined('ICL_SITEPRESS_VERSION') || defined('QTX_VERSION') || defined('POLYLANG_VERSION')){
    if (!function_exists('s7upf_copy_default_theme_option')){
        function s7upf_copy_default_theme_option($option_name){
            global $sitepress;
            $options = get_option($option_name);
            $languages = s7upf_get_list_languages();
            if(is_array($languages) && !empty($languages)){
                foreach ($languages as $lang) {
                    $lang_option = get_option($option_name.'_'.$lang);
                    if($lang_option==''){
                        update_option($option_name.'_'.$lang,$options);
                    }
                }
            }    
        }
    }    
    add_action('s7upf_copy_theme_option','s7upf_copy_default_theme_option',10,1);
    do_action('s7upf_copy_theme_option', 'option_tree' );
    if (!function_exists('s7upf_get_option_by_lang')){
        add_filter('ot_options_id','s7upf_get_option_by_lang',10,1);
        function s7upf_get_option_by_lang($option){
            $lang_code = s7upf_get_current_language();
            return $option_key = $option.'_'.$lang_code;
        }
    }
}
?>