<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */
global $wp_query;
?>
<?php
	$type = 'grid';
    if(isset($_GET['type'])){
        $type = $_GET['type'];
    }
    $number = sv_get_option('woo_shop_number',12);
	if(isset($_GET['number'])){
	    $number = $_GET['number'];
	}
    $column = sv_get_option('woo_shop_column',3);
    if(isset($_GET['column'])){
        $type = $_GET['column'];
    }
?>
<div class="shop-tab-product main-shop-load">
	<div class="shop-tab-title">
		<?php if(!is_cart() && !is_single()):?>
			<h2><?php woocommerce_page_title(); ?></h2>
		<?php endif;?>
		<ul class="shop-tab-select">
			<li class="<?php if($type == 'grid') echo 'active'?>"><a href="<?php echo esc_url(sv_get_key_url('type','grid'))?>" class="load-shop-ajax grid-tab <?php if($type == 'grid') echo 'active'?>"></a></li>
			<li class="<?php if($type == 'list') echo 'active'?>"><a href="<?php echo esc_url(sv_get_key_url('type','list'))?>" class="load-shop-ajax list-tab <?php if($type == 'list') echo 'active'?>"></a></li>
		</ul>
	</div>
	<ul class="product-content-list product-<?php echo esc_attr($type)?> clearfix" data-number="<?php echo esc_attr($number)?>" data-column="<?php echo esc_attr($column)?>" data-currency="<?php echo esc_attr(get_woocommerce_currency_symbol())?>">	