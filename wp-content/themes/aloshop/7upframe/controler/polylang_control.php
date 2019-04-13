<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 13/08/15
 * Time: 10:20 AM
 */
if(defined( 'POLYLANG_VERSION' ) && !defined('ICL_SITEPRESS_VERSION')){
    if (!function_exists('sv_copy_default_theme_option_polylang')){
        function sv_copy_default_theme_option_polylang($option_name){
            global $polylang;
            if(is_object($polylang)){
                $languages = $polylang->model->get_languages_list();
                $options = get_option($option_name);
                if(is_array($languages) && !empty($languages))
                {
                    foreach ($languages as $lang) {
                        $lang_option = get_option($option_name.'_'.$lang->slug);
                        if($lang_option==''){
                            update_option($option_name.'_'.$lang->slug,$options);
                        }
                    }
                }
            }
        }
    }    
    add_action('sv_copy_theme_option_polylang','sv_copy_default_theme_option_polylang',10,1);
    do_action('sv_copy_theme_option_polylang', 'option_tree' );
    if (!function_exists('sv_get_option_by_lang')){
        add_filter('ot_options_id','sv_get_option_by_lang_poly',10,1);
        function sv_get_option_by_lang_poly($option){
            if(function_exists('pll_current_language')){
            $current_lang = pll_current_language();
                if(!empty($current_lang)) return $option_key = $option.'_'.$current_lang;
                else return $option;
            }
        }
    }
}
?>