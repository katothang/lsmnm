<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_social_box'))
{
    function sv_vc_social_box($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'social'     => '',
            'user'       => '',
            'twitter_id' => '',
            'title'      => '',
            'photos'     => '',
            'token'         => '',
            'size_index'    => '0',
        ),$attr));
        ob_start();
        switch ($social) {
            case 'instagram':
                $html .=    '<div class="box-social box-instagram">
                                <h2 class="title-social-box">'.$title.'</h2>
                                <div class="list-item-instagram">';
                if ($user != ''){
                    $media_array = s7upf_scrape_instagram($user, $photos, $token, $size_index);
                    if(!empty($media_array)){
                        foreach ($media_array as $item) {
                            if(isset($item['link']) && isset($item['thumbnail_src'])){
                                $html .= '<a href="'. esc_url( $item['link'] ) .'"><img src="'. esc_url($item['thumbnail_src']) .'" alt=""/></a>';
                            }
                        }              
                    }
                }
                $html .=        '</div>
                            </div>';
                break;

            case 'twitter':?>
                <div class="box-social box-twitter">
                    <h2 class="title-social-box"><?php echo balanceTags($title);?></h2>
                    <a class="twitter-timeline" href="<?php echo esc_url('https://twitter.com/'.$user)?>" data-widget-id="<?php echo esc_attr($twitter_id)?>"><?php esc_html("Tweets by","aloshop")."@".$user?></a>
                    <script>
                        !function(d,s,id){
                            var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                            if(!d.getElementById(id)){
                                js=d.createElement(s);
                                js.id=id;
                                js.src=p+"://platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js,fjs);
                            }
                        }(document,"script","twitter-wjs");
                    </script>
                </div>
                <?php
                break;
            
            default:?>
                <div class="box-social box-facebook">
                    <h2 class="title-social-box"><?php echo balanceTags($title);?></h2>
                    <div id="fb-root"></div>
                        <script>
                            (function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=691387590945471";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));
                        </script>
                        <div class="fb-page"
                            data-href="https://www.facebook.com/<?php echo esc_attr($user)?>"
                            data-tabs="timeline" 
                            data-width="370" 
                            data-height="490" 
                            data-small-header="true" 
                            data-adapt-container-width="true" 
                            data-hide-cover="false" 
                            data-show-facepile="false">
                        </div>
                </div>
                <?php 
                break;
        }
        $html .=    ob_get_clean();
        return $html;
    }
}

stp_reg_shortcode('sv_social_box','sv_vc_social_box');

vc_map( array(
    "name"      => esc_html__("SV Social Box", 'aloshop'),
    "base"      => "sv_social_box",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type"          => "dropdown",
            "holder"        => "div",
            "heading"       => esc_html__("Social",'aloshop'),
            "param_name"    => "social",
            "value"         => array(
                esc_html__("FaceBook",'aloshop')        => 'facebook',
                esc_html__("Twitter",'aloshop')         => 'twitter',
                esc_html__("Instagram",'aloshop')       => 'instagram',
                )
        ),
        array(
            "type"          => "textfield",
            "holder"        => "div",
            "heading"       => esc_html__("Title",'aloshop'),
            "param_name"    => "title",
        ),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("User",'aloshop'),
            "param_name"    => "user",
        ),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("Token",'haustiere'),
            "param_name"    => "token",
            'dependency'    => array(
                'element'       => 'social',
                'value'         => array('instagram'),
            ),
            "description"   => esc_html__("Enter token to view more 12 of photos. Create token your account at: https://outofthesandbox.com/pages/instagram-access-token",'haustiere'),
        ),
        
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Image custom size",'7upframework'),
            "param_name"    => "size_index",
            "value"         => array(
                esc_html__("Small",'7upframework')          => '0',
                esc_html__("Medium",'7upframework')         => '1',
                esc_html__("Large",'7upframework')          => '2',
                ),
            'dependency'    => array(
                'element'       => 'social',
                'value'         => array('instagram'),
            ),
            'description'   => esc_html__( 'Choose instagram image size to display', '7upframework' ),
        ),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("Twitter Widget ID",'aloshop'),
            "param_name"    => "twitter_id",
            'description'   => esc_html__( 'Create widget here https://twitter.com/settings/widgets/new', 'aloshop' ),
            'dependency'    => array(
                'element'       => 'social',
                'value'         => 'twitter',
            )
        ),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("Number",'aloshop'),
            "param_name"    => "photos",
            'dependency'    => array(
                'element'       => 'social',
                'value'         => 'instagram',
            )
        )
    )
));