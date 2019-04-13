<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;
?>
<?php
	$type = 'grid';
    if(isset($_GET['type'])){
        $type = $_GET['type'];
    }
?>
<?php if($type == 'list'){?>
	<li>
		<div class="item-product">
			<div class="row">
				<?php
				$sku = get_post_meta(get_the_ID(),'_sku',true);
				$stock = get_post_meta(get_the_ID(),'_stock_status',true);
				echo 	'<div class="col-md-4 col-sm-4 col-xs-12">
							'.sv_product_thumb_hover_only().'
						</div>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="product-info">
								<h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
								'.sv_get_product_price().'
								'.sv_get_rating_html().'
								<div class="product-code">
									<label>'.esc_html("Item Code","aloshop").': </label> <span>#'.$sku.'</span>
								</div>
								<div class="product-stock">
									<label>'.esc_html("Availability","aloshop").': </label> <span>'.$stock.'</span>
								</div>
								'.sv_product_links('list-view').'
							</div>
							<p class="product-desc">'.get_the_excerpt().'</p>
						</div>';
				?>
			</div>
		</div>
	</li>
<?php }
	else{
		$b_col = 12;$col = 4;$size = array(268,322);
		$col_option = $woocommerce_loop['columns'];
		if(!empty($col_option)) $col = $b_col/(int)$col_option;
		if($col_option == 2) $size = array(268*1.5,322*1.5);
		if($col_option == 1) $size = 'full';
		global $count_product;
		if($count_product % $col_option == 1) $break_class = 'break-item';
		else $break_class = '';
		$li_class = 'col-md-'.$col.' col-sm-6 col-xs-12 '.$break_class;
		if($col_option == 5 || $col_option == 7 || $col_option == 8){
			$li_class = 'custom-item-col item-'.$count_product.' custom-item-col-'.$col_option.' '.$break_class;
		}
	?>
	<li class="<?php echo esc_attr($li_class)?>">
		<?php 
			// $test = new YITH_YWRAQ_Frontend();
			// $test->print_button();
			echo 	'<div class="item-product">
						'.sv_product_thumb_hover($size).'
						<div class="product-info">
							<h3 class="title-product"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
							'.sv_get_product_price().'
							'.sv_get_rating_html().'
						</div>
						'.sv_get_saleoff_html().'
					</div>'
		?>
	</li>
	<?php $count_product++;
	if($count_product > $col_option) $count_product = 1;
	?>
<?php }?>