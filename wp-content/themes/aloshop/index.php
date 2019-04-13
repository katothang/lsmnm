<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package 7up-framework
 */

get_header();?>
    <?php sv_display_breadcrumb();?>
<div id="main-content" class="content-page">
    <div class="container">
        <div class="row">
            <?php sv_output_sidebar('left')?>
            <div class="<?php echo esc_attr(sv_get_main_class()); ?>">
            	<div class="blog-list-post">
                    <?php 
                        if(have_posts()):
                            while (have_posts()) :the_post();
        						get_template_part('sv_templates/blog-content/content');
        				    endwhile;
                            wp_reset_postdata();
        				    sv_paging_nav();
                        else :
                            get_template_part( 'sv_templates/blog-content/content', 'none' );
        				endif;
                    ?>
                </div>
            </div>
            <?php sv_output_sidebar('right')?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
