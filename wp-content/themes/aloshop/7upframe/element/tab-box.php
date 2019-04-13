<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
 if ( ! function_exists( 'sv_latest_news' ) ) {
	function sv_latest_news( $atts, $shortcode_content = null ) {
		$html = '';
		extract( shortcode_atts(
			array(
				'number_post'  	=> '',
				'testimonial'  	=> '',
			), $atts ) );
		$pre = rand(0,100);
		$html .=	'<div class="latest-testimo-tab">
						<div class="latest-testimo-title popular-cat-tab-title">
							<ul class="title-tab3">
								<li class="active"><a href="'.esc_url('#latest-'.$pre).'" data-toggle="tab">'.esc_html__("latest news","aloshop").'</a></li>
								<li><a href="'.esc_url('#testimo-'.$pre).'" data-toggle="tab">'.esc_html__("testimonials","aloshop").'</a></li>
							</ul>
						</div>
						<div class="tab-content">';
		$html .=			'<div role="tabpanel" class="tab-pane fade in active" id="latest-'.$pre.'">
								<ul class="list-latest-new">';
		$args=array(
            'post_type'         => 'post',
            'posts_per_page'    => $number_post,
            'orderby'           => 'date',
            'order'             => 'DESC'
        );
        $query = new WP_Query($args);
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $html .= 	'<li class="clearfix">
								<div class="zoom-image-thumb">
									<a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),array(120,120)).'</a>
								</div>
								<div class="latest-post-info">
									<h3><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3>
									<ul class="comment-date-info">
										<li><i class="fa fa-calendar-o"></i> '.get_the_date('d F Y').'</li>
										<li><i class="fa fa-comment-o"></i> '.get_comments_number().'</li>
									</ul>
								</div>
							</li>';
            }
        }
		$html .=				'</ul>
							</div>';
		$html .=			'<div role="tabpanel" class="tab-pane fade in" id="testimo-'.$pre.'">
								<div class="tab-testimo-slider">
									<div class="wrap-item">';
		parse_str( urldecode( $testimonial ), $data);
        if(is_array($data)){
        	$i = 1;
            foreach ($data as $key => $value) {
                if($i % 2 == 1) $html .= 	'<div class="item">';
				$html .= 		'<div class="item-testimo3">
									<ul class="testimo-tab-info">
										<li>
											<div class="zoom-image-thumb">
												<a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a>
											</div>
										</li>
										<li>
											<div class="author-test-info">
												<h3><a href="'.esc_url($value['link']).'">'.$value['name'].'</a></h3>
												<span>'.$value['pos'].'</span>
											</div>
										</li>
									</ul>
									<p class="desc">'.$value['des'].'</p>
								</div>';
				if($i % 2 == 0 || $i == count($data)) $html .=	'</div>';
				$i++;
                '<li><a href="'.esc_url($value['link']).'">'.wp_get_attachment_image($value['image'],'full').'</a></li>';
            }
        }
		$html .=					'</div>
								</div>
							</div>';
		$html .=		'</div>
					</div>';
		wp_reset_postdata();
		return  $html;
	}
}
stp_reg_shortcode('latest_news','sv_latest_news');

vc_map(
	array(
		'name'     => esc_html__( 'SV Latest News Tab', 'aloshop' ),
		'base'     => 'latest_news',
		'category' => esc_html__( '7Up-theme', 'aloshop' ),
		'icon'     => 'icon-st',
		'params'   => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__("Number Post",'aloshop'),
				"param_name" => "number_post",
			),			
            array(
                "type" => "add_testimonial",
                "heading" => esc_html__("Testimonials",'aloshop'),
                "param_name" => "testimonial",
            ),
		)
	)
);