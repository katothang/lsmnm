<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>
    <?php sv_display_breadcrumb();?>
	<div id="primary" class="content-area">
		<div class="container">
			<main id="main" class="site-main" role="main">
				<?php
				$page_id = sv_get_option('sv_404_page');
				if(!empty($page_id)) {
				    echo 	'<div class="custom-404-page">
				            	<div class="container">';
				    echo        	SV_Template::get_vc_pagecontent($page_id);
				    echo    	'</div>
				          	</div>';
				}
				else{ ?>
				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'aloshop' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'aloshop' ); ?></p>

						<?php get_search_form(); ?>
					</div><!-- .page-content -->
				</section><!-- .error-404 -->
				<?php }?>
			</main><!-- .site-main -->
		</div>
	</div><!-- .content-area -->

<?php get_footer(); ?>
