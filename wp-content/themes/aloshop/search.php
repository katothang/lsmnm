<?php
/**
 * The template for displaying search results pages.
 *
 * @package 7up-framework
 */

get_header(); ?>
    <?php sv_display_breadcrumb();?>
	<div id="main-content" class="main-wrapper tp-blog-page content-page">
	    <div class="container">
	        <div class="row">
		        <?php sv_output_sidebar('left')?>
		        <div class="<?php echo esc_attr(sv_get_main_class()); ?>">
		        	<h2 class="title-shop-page"><?php printf( esc_html__( 'Search Results for: %s', 'aloshop' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
					<?php if ( have_posts() ) : ?>						

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part('sv_templates/blog-content/content');
							?>
							
						<?php endwhile; ?>
						<?php sv_paging_nav();?><!-- Display navigation-->
					<?php else : ?>

						<h2><?php esc_html_e("No post for key search.","aloshop")?></h2>

					<?php endif; ?>
				</div>
	            <?php sv_output_sidebar('right')?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
