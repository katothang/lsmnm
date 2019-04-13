<?php
$data = '';
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
if (has_post_thumbnail()) {
    $data .=    '<div class="blog-post-thumb">
                    <div class="post-info-extra">
                        <div class="post-date"><strong>'.get_the_date('d').'</strong><span>'.get_the_date('M, Y').'</span></div>
                        <div class="post-format">'.$post_icon.'</div>
                    </div>
                    <div class="zoom-image-thumb">
                        <a href="'. esc_url(get_the_permalink()) .'">'.get_the_post_thumbnail(get_the_ID(),array(330,220)).'</a>                
                    </div>
                </div>';
}
?>
<div class="item-post-blog">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-ms-12">
            <?php if(!empty($data)) echo balanceTags($data);?>
        </div>
        <div class="col-md-6 col-sm-6 col-ms-12">
            <div class="blog-post-info">
                <h3 class="post-title"><a href="<?php echo esc_url(get_the_permalink());?>">
                    <?php the_title()?>
                </a></h3>
                <?php sv_display_metabox('v2');?>
                <p class="desc"><?php echo sv_substr(get_the_excerpt(),0,215);?></p>
                <a href="<?php echo esc_url(get_the_permalink());?>" class="post-readmore"><?php esc_html_e('Read More','aloshop')?></a>
            </div>
        </div>
    </div>
</div>