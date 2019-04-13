<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Register post type
 *
 *
 * */

if(!function_exists('stp_reg_post_type'))
{
    function stp_reg_post_type($post_type, $args)
    {
        register_post_type($post_type, $args);
    }
}
/**
 * Register post type
 *
 *
 * */

if(!function_exists('stp_reg_taxonomy'))
{
    function stp_reg_taxonomy($taxonomy, $object_type, $args )
    {
        register_taxonomy($taxonomy, $object_type, $args );
    }
}
/**
 * Add shortcode
 *
 *
 * */

if(!function_exists('stp_reg_shortcode'))
{
    function stp_reg_shortcode($tag , $func )
    {
        add_shortcode($tag , $func );
    }
}
if(!function_exists('sv_shortcode_param'))
{
    function sv_shortcode_param( $name, $form_field_callback, $script_url = null ){
        add_shortcode_param( $name, $form_field_callback, $script_url = null );
    }
}
if(!function_exists('s7upf_instagram_api_curl_connect')){
    function s7upf_instagram_api_curl_connect( $api_url ){
        $content = file_get_contents($api_url);
        return json_decode( $content ); // decode and return
    }
}
if(!function_exists('s7upf_scrape_instagram'))
{
function s7upf_scrape_instagram($username, $slice = 9 , $token = '',$size_index= 0) {
    // $key = '3225616123.d90570a.92f2ff44795d4458926300c08c408ea6';
    $username = strtolower($username);
    $instagram = array();
    if($username) {
        $remote = wp_remote_get('https://instagram.com/'.trim($username));
        if (is_wp_error($remote))
        return new WP_Error('site_down', __('Unable to communicate with Instagram.', STP_TEXTDOMAIN));
        if ( 200 != wp_remote_retrieve_response_code( $remote ) )
        return new WP_Error('invalid_response', __('Instagram did not return a 200.', STP_TEXTDOMAIN));
        $shards = explode('window._sharedData = ', $remote['body']);
        $insta_json = explode(';</script>', $shards[1]);
        $insta_array = json_decode($insta_json[0], TRUE);
        if (!$insta_array)
        return new WP_Error('bad_json', __('Instagram has returned invalid data.', STP_TEXTDOMAIN));
        if(!empty($token)){
            $user_id = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['id'];
            $api = "https://api.instagram.com/v1/users/".$user_id."/media/recent?access_token=".$token;
            $all_data = array();
            $i = 1;
            $max_page = (int)($slice/20) + 1;
            while ($api !== NULL && $i <= $max_page) {                
                $data = s7upf_instagram_api_curl_connect($api);
                if(isset($data->data)) $all_data = array_merge($all_data,$data->data);
                if(isset($data->pagination->next_url)) $api = $data->pagination->next_url;
                else $api = NULL;
                $i++;
            }
            $i = 1;
            foreach ($all_data as $value) {
                switch ($size_index) {
                    case '1':
                        $thumbnail_src = $value->images->low_resolution->url;
                        break;

                    case '2':
                        $thumbnail_src = $value->images->low_resolution->url;
                        break;

                    case '3':
                        $thumbnail_src = $value->images->standard_resolution->url;
                        break;
                    
                    default:
                        $thumbnail_src = $value->images->thumbnail->url;
                        break;
                }
                $instagram[] = array(
                    'link' => $value->link,
                    'thumbnail_src' => $thumbnail_src,
                );
                if($i == $slice) break;
                $i++;
            }
        }
        else{
            if(isset($insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'])){
                $images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
                foreach ($images as $image) {               
                    $instagram[] = array(
                        'link' => 'https://instagram.com/p/'.$image['node']['shortcode'],
                        'thumbnail_src' => $image['node']['thumbnail_resources'][$size_index]['src'],
                    );
                }
            }
        }
        set_transient('instagram-media-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS*2));
    }
    return array_slice($instagram, 0, $slice);
    }
}
if(!function_exists('sv_images_only'))
{
    function sv_images_only($media_item) {
        if ($media_item['type'] == 'image')
        return true;
        return false;
    }
}
if(!function_exists('sv_get_current_url'))
{
    function sv_get_current_url() {
        $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        return $url;
    }
}
