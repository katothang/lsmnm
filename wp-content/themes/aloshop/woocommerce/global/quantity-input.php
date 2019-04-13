<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<label><?php esc_html_e("Qty","aloshop")?>:</label>
<div class="quantity info-qty">
	<a class="qty-down" href="#"><i class="fa fa-minus"></i></a>
	<input type="text" step="<?php echo esc_attr( $step ); ?>" min="<?php echo esc_attr( $min_value ); ?>" max="<?php echo esc_attr( $max_value ); ?>" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'aloshop' ) ?>" class="input-text text qty qty-val" size="4" />
	<a class="qty-up" href="#"><i class="fa fa-plus"></i></a>
</div>