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

get_header(); ?>
    <?php sv_display_breadcrumb();?>
<div id="main-content" class="content-page st-default">
    <?php do_action('sv_before_main_content')?>
    <div class="container">
        <div class="row">
            <div class="tp-blog-page">
                <?php sv_output_sidebar('left')?>
                <div class="<?php echo esc_attr(sv_get_main_class()); ?>">                    
                    <?php the_archive_title('<h2 class="title-archive-page">','</h2>'); ?>
                    <?php if(have_posts()):?>    
                        <?php while (have_posts()) :the_post();?>
                            
                            <?php get_template_part('sv_templates/blog-content/content',get_post_format())?>
                        
                        <?php endwhile;?>
                        <?php wp_reset_postdata();?>

                        <?php sv_paging_nav();?>

                    <?php else : ?>
                        <?php get_template_part( 'sv_templates/blog-content/content', 'none' ); ?>
                    <?php endif;?>
                </div>
                <?php sv_output_sidebar('right')?>
            </div>
        </div>
    </div>
    <?php do_action('sv_affter_main_content')?>
</div>
<?php get_footer(); ?>
