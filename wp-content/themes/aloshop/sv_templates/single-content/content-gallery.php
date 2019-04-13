<?php
$data = '';
$gallery = get_post_meta(get_the_ID(), 'format_gallery', true);
if (!empty($gallery)){
    $array = explode(',', $gallery);
    if(is_array($array) && !empty($array)){
        
        $data .= '<div class="post-gallery"><div class="gallery-slider">';
        foreach ($array as $key => $item) {
            $thumbnail_url = wp_get_attachment_url($item);
            $data .='<div class="image-slider">';
            $data .= '<img src="' . esc_url($thumbnail_url) . '" alt="image-slider">';           
            $data .= '</div>';
        }
        $data .='</div></div>';
    }
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