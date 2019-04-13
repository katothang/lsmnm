<?php
$data = $st_link_post= $s_class = '';
global $post;
$sv_image_blog = get_post_meta(get_the_ID(), 'format_image', true);
if(!empty($sv_image_blog)){
    $data .='<div class="zoom-image-thumb">
                <img alt="'.$post->post_name.'" title="'.$post->post_name.'" class="blog-image" src="' . esc_url($sv_image_blog) . '"/>
            </div>';
}
else{
    if (has_post_thumbnail()) {
        $data .=    '<div class="zoom-image-thumb">
                        '.get_the_post_thumbnail(get_the_ID(),'full').'                
                    </div>';
    }
}
?>
<div class="single-post-leading">
    <?php if(!empty($data)) echo balanceTags($data);?>
    <h2><?php the_title()?></h2>
    <?php sv_display_metabox('single');?>
</div>
<div class="single-post-content">
    <?php the_content(); ?>
</div>