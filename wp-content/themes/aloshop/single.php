<?php
/**
 * The template for displaying all single posts.
 *
 * @package 7up-framework
 */
?>
<?php get_header();?>
    <?php sv_display_breadcrumb();?>
    <div id="main-content"  class="content-page">
        <div class="container">
            <div class="row">
                <?php sv_output_sidebar('left')?>
                <div class="<?php echo esc_attr(sv_get_main_class());?>">
                    <div class="main-single-post">
                        <?php
                        while ( have_posts() ) : the_post();
                            sv_set_post_view();
                            /*
                            * Include the post format-specific template for the content. If you want to
                            * use this in a child theme, then include a file called called content-___.php
                            * (where ___ is the post format) and that will be used instead.
                            */
                            get_template_part( 'sv_templates/single-content/content',get_post_format() );
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'aloshop' ),
                                'after'  => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                            ) );
                            ?>
                            <?php echo balanceTags(sv_single_box())?>
                            <?php sv_author_box();?>
                            <?php sv_single_related_post();?>
                            <?php if ( comments_open() || get_comments_number() ) comments_template();?>
                            <?php
                                $previous_post = get_previous_post();
                                $next_post = get_next_post();
                            ?>
                            <div class="single-post-control clearfix">
                                <?php if(!empty( $previous_post )):?>
                                <a href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>" class="pull-left prev-post"><span class="lnr lnr-chevron-left"></span><?php esc_html_e("Prev","aloshop")?></a>
                                <?php endif;?>
                                <?php if(!empty( $next_post )):?>
                                    <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>" class="pull-right next-post"><?php esc_html_e("Next","aloshop")?><span class="lnr lnr-chevron-right"></span></a>
                                <?php endif;?>
                            </div>                        
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php sv_output_sidebar('right')?>
            </div>
        </div>
    </div>
<?php get_footer();?>