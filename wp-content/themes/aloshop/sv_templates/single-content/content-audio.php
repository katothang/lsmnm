<?php
$data = '';
if (get_post_meta(get_the_ID(), 'format_media', true)) {
    $media_url = get_post_meta(get_the_ID(), 'format_media', true);
    $data .= '<div class="audio">' . sv_remove_w3c(wp_oembed_get($media_url, array('height' => '176'))) . '</div>';
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