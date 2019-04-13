<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 9/1/16
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_team'))
{
    function sv_vc_team($attr, $content = false)
    {
        $html = $social_html = '';
        extract(shortcode_atts(array(
            'style'          => 'style-1',
            'name'          => '',
            'position'      => '',
            'image'         => '',
            'des'           => '',
            'social'        => '',
            'title'         => '',
            'link'          => '',
        ),$attr));
        parse_str( urldecode( $social ), $data);
        if(is_array($data)){
            foreach ($data as $key => $value) {
                $url = '#';
                if(isset($value['url'])) $url = $value['url'];
                $social_html .= '<li><a href="'.esc_url($url).'"><i class="fa '.$value['social'].'"></i></a></li>';
            }
        }
        switch ($style) {
            case 'style-2':
                $html .=    '<div class="item-team-circle item-team-circle3">
                                <div class="team-circle-thumb">
                                    '.wp_get_attachment_image($image,array(270,270),0 ,array('class'=>'team-cirle-image')).'
                                    <div class="info-circle-thumb">
                                        <p class="desc">'.$des.'</p>
                                        <ul class="team-circle-social-network list-inline">
                                            '.$social_html.'
                                        </ul>
                                    </div>
                                </div>
                                <div class="team-circle-info">
                                    <h3><a href="'.esc_url($link).'">'.$name.'</a></h3>
                                    <span>'.$position.'</span>
                                </div>
                            </div>';
                break;

            case 'style-3':
                $html .=    '<div class="item-team-rectang">
                                <div class="team-rectang-thumb">
                                    '.wp_get_attachment_image($image,array(270,365)).'
                                </div>
                                <div class="team-circle-info">
                                    <h3><a href="'.esc_url($link).'">'.$name.'</a></h3>
                                    <span>'.$position.'</span>
                                    <ul class="team-circle-social-network list-inline">
                                        '.$social_html.'
                                    </ul>
                                </div>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="item-team-gallery">
                                <h3><a href="'.esc_url($link).'">'.$title.'</a></h3>
                                <a class="team-gallery-thumb fancybox" href="'.wp_get_attachment_image_url($image,'full').'" data-fancybox-group="gallery" title="'.$title.'">
                                    '.wp_get_attachment_image($image,'full').'
                                </a>
                                <span>'.esc_html__("by","aloshop").' '.$name.'</span>
                                <p class="desc">'.$des.'</p>
                                <ul class="team-social-network list-inline">
                                    '.$social_html.'
                                </ul>
                            </div>';
                break;
        }
        return $html;
    }
}

stp_reg_shortcode('sv_team','sv_vc_team');

vc_map( array(
    "name"      => esc_html__("SV Team", 'aloshop'),
    "base"      => "sv_team",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Style 1",'aloshop')   => 'style-1',
                esc_html__("Style 2",'aloshop')   => 'style-2',
                esc_html__("Style 3",'aloshop')   => 'style-3',
                )
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'aloshop'),
            "param_name" => "image",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Name",'aloshop'),
            "param_name" => "name",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Position",'aloshop'),
            "param_name" => "position",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Title",'aloshop'),
            "param_name" => "title",
        ),
        array(
            "type" => "textarea",
            "holder"    => 'div',
            "heading" => esc_html__("Description",'aloshop'),
            "param_name" => "des",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Team link",'aloshop'),
            "param_name" => "link",
        ),
        array(
            "type" => "add_social",
            "heading" => esc_html__("Social",'aloshop'),
            "param_name" => "social",
        ),
    )
));