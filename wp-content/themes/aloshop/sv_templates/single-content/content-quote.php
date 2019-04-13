<?php
$data = $st_link_post= $s_class = '';
global $post;
if (has_post_thumbnail()) {
    $data .= '<div class="zoom-image-thumb">
                '.get_the_post_thumbnail(get_the_ID(),'full').'                
            </div>';
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