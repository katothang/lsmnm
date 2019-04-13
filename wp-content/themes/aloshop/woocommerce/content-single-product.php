<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="content-product-detail">
		<?php 
		$product_style = sv_get_value_by_id('product_style');
		switch ($product_style) {
			case 'style2':
				$col = '9';
				$col_sm = '8';
				if(sv_check_sidebar()) $col = $col_sm = '12';
				echo 	'<div class="detail-fullwidth">
							<div class="row">
								<div class="col-md-'.$col.' col-sm-'.$col_sm.' col-xs-12">';
									sv_product_main_detai();
				echo 			'</div>';				
								sv_get_more_info_product();
				echo 		'</div>
						</div>';
				break;
			
			default:
				sv_product_main_detai();
				break;
		}
		?>		
	</div>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />
	<?php 
		$tabs = apply_filters( 'woocommerce_product_tabs', array() );
		// do_action( 'woocommerce_after_single_product_summary' );
	?>
	<!-- TAB PRODUCT -->
	<div class="tab-detail">
		<div class="title-tab-detail">
			<ul role="tablist">
				<?php 
					$num=0;
					foreach ( $tabs as $key => $tab ) : 
					$num++;
				?>
					<li class="<?php if($num==1){echo 'active';}?>" role="presentation">
						<a href="<?php echo esc_url( '#sv-'.$key ); ?>" aria-controls="sv-<?php echo esc_attr( $key ); ?>" role="tab" data-toggle="tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
					</li>
						
				<?php endforeach; ?>			
				<li role="presentation"><a href="<?php echo esc_url("#tags")?>" aria-controls="tags" role="tab" data-toggle="tab"><?php esc_html_e("Tags","aloshop")?></a></li>
			</ul>
		</div>
		<!-- Tab panes -->
		<div class="content-tab-detail">
			<div class="tab-content">
				<?php 
					$num=0;
					foreach ( $tabs as $key => $tab ) : 
					$num++;
				?>
					<div role="tabpanel" class="tab-pane <?php if($num==1){echo 'active';}?>" id="sv-<?php echo esc_attr( $key ); ?>">
						<div class="inner-content-tab-detail clearfix">
							<?php call_user_func( $tab['callback'], $key, $tab ); ?>
						</div>
					</div>
				<?php endforeach; ?>				
				<div role="tabpanel" class="tab-pane" id="tags">
					<div class="inner-content-tab-detail clearfix">
						<h2><?php esc_html_e("Tags","aloshop")?></h2>
						<?php 
							global $product,$post;
							$tag_count = sizeof( get_the_terms( get_the_ID(), 'product_tag' ) );
							echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( '', '', count( $product->get_tag_ids() ), 'aloshop' ) . ' ', '</span>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	sv_single_upsell_product();
	sv_single_relate_product();
	sv_single_lastest_product();
	?>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
