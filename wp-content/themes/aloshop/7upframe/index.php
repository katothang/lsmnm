<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */

if(!defined('ABSPATH')) return;
get_template_part('7upframe/function/function');
get_template_part('7upframe/config/config');
sv_load_files('class');
sv_load_files('controler');
if(class_exists('Vc_Manager') && class_exists('PluginCore')){
	sv_load_files('element');
} 
sv_load_files('widget');