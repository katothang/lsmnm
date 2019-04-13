<?php
/**
 * The template for displaying all single posts.
 *
 * @package 7up-framework
 */

get_header();
?>
    <?php sv_display_breadcrumb();?>
    <div id="main-content" class="content-page">
        <div class="container">
            <div class="row">
                <?php sv_output_sidebar('left')?>
                <div class="<?php echo esc_attr(sv_get_main_class()); ?>">
                    <?php
                    while ( have_posts() ) : the_post();

                        /*
                        * Include the post format-specific template for the content. If you want to
                        * use this in a child theme, then include a file called called content-___.php
                        * (where ___ is the post format) and that will be used instead.
                        */
                        ?>
                        	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-content">
                                    <?php if(get_post_meta(get_the_ID(),'show_title_page',true) != 'off'):?>
								        <h2 class="title-shop-page"><?php the_title()?></h2>
                                    <?php endif;?>
									<?php the_content(); ?>
									<?php
										wp_link_pages( array(
											'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'aloshop' ),
											'after'  => '</div>',
										) );
									?>
								</div><!-- .entry-content -->
							</div><!-- #post-## -->
                        <?php

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                        // End the loop.
                    endwhile; ?>
                    
                </div> 
                <?php sv_output_sidebar('right')?>
            </div>

        </div>

    </div>
<?php
get_footer();