<?php
/*
 * Template Name: Visual Template
 *
 *
 * */

get_header();
?>
    <div id="main-content" class="vc-template">
        <div class="container">
            <div class="row">
                <?php sv_output_sidebar('left')?>
                <div class="<?php echo esc_attr(sv_get_main_class()); ?>">
                    <?php while ( have_posts() ) : the_post();?>
                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php the_content(); ?>
                            <?php
                                wp_link_pages( array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'aloshop' ),
                                    'after'  => '</div>',
                                ) );
                            ?>
                        </div>
                        <?php
                        if ( comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                    endwhile; ?>
                </div>
                <?php sv_output_sidebar('right')?>
            </div>

        </div>

    </div>
<?php
get_footer();