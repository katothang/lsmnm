<?php
/**
 * Product Loop End
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */
global $wp_query;
$number = '12';
if(isset($_GET['number'])){
    $number = $_GET['number'];
}
?>
	</ul>
	<div class="sort-pagi-bar">
		<?php if(!is_cart() && !is_single()):?>
			<div class="product-order">
				<?php woocommerce_catalog_ordering()?>
			</div>
			<div class="product-per-page">
				<a href="#" class="per-page-toggle"><?php esc_html_e("show","aloshop")?> <span><?php echo esc_attr($number)?></span></a>
				<ul class="per-page-list">
                    <li><a data-number="<?php echo '6'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','6'))?>"><?php esc_html_e("6","aloshop")?></a></li>
                    <li><a data-number="<?php echo '9'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','9'))?>"><?php esc_html_e("9","aloshop")?></a></li>
                    <li><a data-number="<?php echo '12'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','12'))?>"><?php esc_html_e("12","aloshop")?></a></li>
                    <li><a data-number="<?php echo '18'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','18'))?>"><?php esc_html_e("18","aloshop")?></a></li>
                    <li><a data-number="<?php echo '24'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','24'))?>"><?php esc_html_e("24","aloshop")?></a></li>
                    <li><a data-number="<?php echo '48'?>" class="load-shop-ajax" href="<?php echo esc_url(sv_get_key_url('number','48'))?>"><?php esc_html_e("48","aloshop")?></a></li>
                </ul>
			</div>
		<?php endif;?>
		<?php if($wp_query->max_num_pages > 1){?>
		<div class="product-pagi-nav">
			<?php
				echo paginate_links( array(
					'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
					'format'       => '',
					'add_args'     => '',
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'total'        => $wp_query->max_num_pages,
					'prev_text'    => '<span class="lnr lnr-chevron-left"></span>',
					'next_text'    => '<span class="lnr lnr-chevron-right"></span>',
					'type'         => 'plain',
					'end_size'     => 2,
					'mid_size'     => 1
				) );
			?>
		</div>
		<?php }?>
	</div>
</div>