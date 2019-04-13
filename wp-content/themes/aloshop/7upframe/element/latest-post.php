<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 15/12/15
 * Time: 10:00 AM
 */

if(!function_exists('sv_vc_lastest_post5'))
{
    function sv_vc_lastest_post5($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'     => '',
            'nav'       => '',
            'title'     => '',
            'number'    => '5',
            'order'     => 'DESC',
            'link'      => '',
            'sub'       => '',
        ),$attr));
        $args = array(
            'post_type'         => 'post',
            'posts_per_page'    => $number,
            'orderby'           => 'post_date',
            'order'             => $order,
        );
        $query = new WP_Query($args);
        $count_query = $query->post_count;        
        switch ($style) {
            case 'home-21':
                $html .=    '<div class="latest-new21">
                                <div class="title-news21">';
                if(!empty($title)) $html .=    '<h2>'.esc_html($title).'</h2>';
                if(!empty($link)) $html .=    '<a class="viewall3" href="'.esc_url($link).'">'.esc_html__("View All","aloshop").'</a>';
                $html .=        '</div>
                                <div class="news-slider21">
                                    <div class="wrap-item">';
                if($query->have_posts()){
                    while($query->have_posts()){
                        $query->the_post();
                        $format = get_post_format();
                        switch ($format) {
                            case 'video':
                                $post_icon = '<i class="fa fa-video-camera"></i>';
                                break;

                            case 'audio':
                                $post_icon = '<i class="fa fa-volume-up"></i>';
                                break;

                            case 'quote':
                                $post_icon = '<i class="fa fa-quote-left"></i>';
                                break;
                            
                            default:
                                $post_icon = '<i class="fa fa-picture-o"></i>';
                                break;
                        }
                        $html .=    '<div class="item-post-masonry">
                                        <div class="blog-post-thumb">
                                            <div class="post-info-extra">
                                                <div class="post-date"><strong>'.get_the_date('d').'</strong><span>'.get_the_date('M, Y').'</span></div>
                                                <div class="post-format">'.$post_icon.'</div>
                                            </div>
                                            <div class="zoom-image-thumb">
                                                <a href="'. esc_url(get_the_permalink()) .'">'.get_the_post_thumbnail(get_the_ID(),array(370,247)).'</a>                
                                            </div>
                                        </div>
                                        <div class="blog-post-info">
                                            <h3 class="post-title"><a href="'. esc_url(get_the_permalink()) .'">'.get_the_title().'</a></h3>
                                            <ul class="post-date-author">
                                                <li>'.esc_html__("By:","aloshop").' <a href="'.esc_url(get_author_posts_url(get_the_author_meta("ID"))).'">'.get_the_author().'</a></li>
                                                <li><a href="'.esc_url(get_comments_link()).'">'.get_comments_number().' '.esc_html__("Comments","aloshop").'</a></li>
                                            </ul>
                                            <p class="desc">'.sv_substr(get_the_excerpt(),0,80).'</p>
                                            <a class="post-readmore" href="'. esc_url(get_the_permalink()) .'">'.esc_html__("Read More","aloshop").'</a>
                                        </div>
                                    </div>';
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;

            case 'home-2':
                $html .=    '<div class="box-bottom-home2 box-from-blog">
                                <h2>'.$title.'</h2>
                                <div class="from-blog-slider slider-home2 '.$nav.'">
                                    <div class="wrap-item">';
                if($query->have_posts()){
                    while($query->have_posts()){
                        $query->the_post();
                        $excerpt_text = sv_substr(get_the_excerpt(),0,70);
                        $html .=        '<div class="item">
                                            <div class="wrap-from-blog">
                                                <div class="from-blog-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(300,300)).'</a>
                                                </div>
                                                <div class="from-blog-info">
                                                    <h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                                    <p>'.$excerpt_text.'</p>
                                                </div>
                                            </div>
                                            <div class="from-blog-more">
                                                <ul>
                                                    <li><i class="fa fa-calendar-o"></i> '.get_the_date('d F Y').'</li>
                                                    <li><i class="fa fa-comment-o"></i> '.get_comments_number().'</li>
                                                </ul>
                                                <a href="'.esc_url(get_the_permalink()).'" class="readmore"><i class="fa fa-long-arrow-right"></i></a>
                                            </div>
                                        </div>';
                    }
                }
                $html .=            '</div>
                                </div>';
                if(!empty($link)) $html .=  '<a href="'.esc_url($link).'" class="viewall">'.esc_html__("View All","aloshop").'</a>';
                $html .=    '</div>';
                break;

            case 'home-6':
                $html .=    '<div class="from-blog6">
                                <h2><span>'.$title.'</span></h2>
                                <div class="fromblog-slider slider-home6">
                                    <div class="wrap-item">';
                if($query->have_posts()){
                    while($query->have_posts()){
                        $query->the_post();
                        $excerpt_text = sv_substr(get_the_excerpt(),0,200);
                        $html .=    '<div class="item-from-blog clearfix">
                                        <div class="zoom-image-thumb">
                                            <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(300,300)).'</a>
                                        </div>
                                        <div class="from-blog-info">
                                            <h3 class="post-title"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
                                            <ul class="post-date-author">
                                                <li>'.esc_html__("By","aloshop").': <a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></li>
                                                <li><a href="'.esc_url( get_comments_link() ).'">'.get_comments_number().' '.esc_html__("Comment","aloshop").'</a></li>
                                            </ul>
                                            <p class="post-desc">'.$excerpt_text.'</p>
                                        </div>
                                    </div>';
                    }
                }
                $html .=            '</div>
                                </div>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="latest-new5">
                                <div class="special-slider-header">
                                    <h2 class="title-special">'.$title.'</h2>
                                </div>
                                <div class="from-blog-slider slider-home5">
                                    <div class="wrap-item">';
                if($query->have_posts()){
                    while($query->have_posts()){
                        $query->the_post();
                        $html .=        '<div class="item-blog5">
                                            <div class="wrap-from-blog">
                                                <div class="from-blog-thumb">
                                                    <a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(100,100)).'</a>
                                                </div>
                                                <div class="from-blog-info">
                                                    <p>'.get_the_title().'</p>
                                                </div>
                                            </div>
                                            <div class="from-blog-more">
                                                <ul>
                                                    <li><i class="fa fa-calendar-o"></i> '.get_the_date('d F Y').'</li>
                                                    <li><i class="fa fa-comment-o"></i> '.get_comments_number().'</li>
                                                </ul>
                                            </div>
                                            <a href="'.esc_url(get_the_permalink()).'" class="readmore">'.esc_html__("Read more","aloshop").'</a>
                                        </div>';
                    }
                }
                $html .=            '</div>
                                </div>';
                if(!empty($link)) $html .=  '<a href="'.esc_url($link).'" class="viewall5"><i class="fa fa-long-arrow-right"></i></a>';
                $html .=    '</div>';
                break;
        }
       
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_lastest_post5','sv_vc_lastest_post5');

vc_map( array(
    "name"      => esc_html__("SV Latest Post", 'aloshop'),
    "base"      => "sv_lastest_post5",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Style",'aloshop'),
            "param_name" => "style",
            "value"     => array(
                esc_html__("Default",'aloshop')   => '',
                esc_html__("Home 2",'aloshop')   => 'home-2',
                esc_html__("Home 6",'aloshop')   => 'home-6',
                esc_html__("Home 21",'aloshop')   => 'home-21',
                )
        ),        
        array(
            "type" => "dropdown",
            "heading" => esc_html__("Navigation",'aloshop'),
            "param_name" => "nav",
            "value"     => array(
                esc_html__("Circle",'aloshop')      => '',
                esc_html__("Square",'aloshop')      => 'rect-arrow',
                ),
            "dependency"    => array(
                "element"   => 'style',
                "value"   => 'home-2',
                )
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Title', 'aloshop' ),
            'param_name'  => 'title',            
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Number post', 'aloshop' ),
            'param_name'  => 'number',            
        ),
        array(
            'heading'     => esc_html__( 'Order', 'aloshop' ),
            'type'        => 'dropdown',
            'param_name'  => 'order',
            'value' => array(                   
                esc_html__('Desc','aloshop')  => 'DESC',
                esc_html__('Asc','aloshop')  => 'ASC',
            ),
            'description' => esc_html__( 'Select Order Type ', 'aloshop' ),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Link View', 'aloshop' ),
            'param_name'  => 'link',            
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Get Excerpt character', 'aloshop' ),
            'param_name'  => 'sub',            
        ),
    )
));