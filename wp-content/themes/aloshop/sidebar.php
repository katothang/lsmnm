<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package 7up-framework
 */
?>
<?php
$sidebar = sv_get_sidebar();
if ( is_active_sidebar( $sidebar['id']) && $sidebar['position'] != 'no' ):?>
	<div class="col-md-3 col-sm-4 col-xs-12">
		<div class="sidebar-left sidebar-post">
	    	<?php dynamic_sidebar($sidebar['id']); ?>
		</div>
	</div>
<?php endif;?>