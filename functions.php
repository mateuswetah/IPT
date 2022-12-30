<?php
/**
 * Theme Name: IPT
 * Description: Tema do Instituto de Pesquisas Tecnológicas
 * Author: wetah
 * Template: blocksy
 * Text Domain: ipt
 */

if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}

/** Child Theme version */
const IPT_VERSION = '0.10.11';

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style('blocksy-child-style', get_stylesheet_uri());
});

/* This makes the section collapses begin collapsed by default */
add_filter('tainacan-get-metadata-section-as-html-before-name--index-0', function($before, $item_metadatum) {
	return str_replace('<input checked="checked"', '<input ', $before);
}, 12, 2);

add_shortcode( 'tainacan-total-items', function($attributes) {

	$args = shortcode_atts(array(
        // default values
        'group_taxonomy_id' => '39939',
        'conjunto_term_id' => '113'

    ), $attributes);

	$group_taxonomy_id = $args['group_taxonomy_id'];//'279';//
	$conjunto_term_id = $args['conjunto_term_id'];//'523';//'21';//

	$collections_post_types = \Tainacan\Repositories\Repository::get_collections_db_identifiers();

	$conjunto_posts_args = array(
		'post_type' => $collections_post_types,
		'posts_per_page' => -1,
		'tax_query' => array(
		  array(
			'taxonomy' => 'tnc_tax_' . $group_taxonomy_id,
			'field'    => 'term_id',
			'terms'    => array($conjunto_term_id)
		  ),
		),
	);
	$wp_query = new WP_Query($conjunto_posts_args);
	$conjunto_posts_count = $wp_query->found_posts;

	$total_items = 0;

	foreach( $collections_post_types as $collection_post_type ) {
		$total_items_for_collection = wp_count_posts($collection_post_type);
		$total_items += (int) $total_items_for_collection->publish;
	}

	return '<span class="tainacan-total-items-shortcode">' . ($total_items - $conjunto_posts_count) . '</span>';
});

add_action('blocksy:header:before', function() {
	echo '><section class="govsp-topo">
	<link rel="stylesheet" type="text/css" href="https://saopaulo.sp.gov.br/barra-govsp/css/topo-basico-sp.min.css">
	<link rel="stylesheet" type="text/css" href="https://saopaulo.sp.gov.br/barra-govsp/css/contraste.css">
		<div id="govsp-topbarGlobal" class="blu-e">
				<div id="topbarGlobal">
					<div id="topbarLink" class="govsp-black">
					<div class="govsp-portal">
						<a href="https://www.saopaulo.sp.gov.br/">saopaulo.sp.gov.br</a>
					</div>
				</div>
				<nav class="govsp-navbar govsp-navbar-expand-lg">
						<a class="govsp-link" href="http://www.cidadao.sp.gov.br" target="_blank">Cidadão SP</a>
						<a class="govsp-social" href="https://www.facebook.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/facebook.png" alt="Facebook Governo de SÃ£o Paulo"></a>
						<a class="govsp-social" href="https://www.twitter.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/twitter.png" alt="Twitter Governo de SÃ£o Paulo"></a>
						<a class="govsp-social" href="https://www.instagram.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/insta.png" alt="Instagram Governo de SÃ£o Paulo"></a>
						<a class="govsp-social" href="https://www.flickr.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/flickr.png" alt="Flickr Governo de SÃ£o Paulo"></a>
						<a class="govsp-social" href="https://www.youtube.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/youtube.png" alt="Youtube Governo de SÃ£o Paulo"></a>
						<a class="govsp-social" href="https://www.issuu.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/issuu.png" alt="Issuu Governo de SÃ£o Paulo"></a>
						<a class="govsp-social" href="https://www.linkedin.com/company/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/linkedin.png" alt="Linkedin Governo de SÃ£o Paulo"></a>
						<p class="govsp-social">/governosp</p>
						<a class="govsp-acessibilidade" href="javascript:mudaTamanho(`body`, 1);"><img class="govsp-acessibilidade" src="https://saopaulo.sp.gov.br/barra-govsp/img/big-font.png" alt="Aumentar Fonte"></a>
						<a class="govsp-acessibilidade" href="javascript:mudaTamanho(`body`, -1);"><img class="govsp-acessibilidade" src="https://saopaulo.sp.gov.br/barra-govsp/img/small-font.png" alt="Diminuir Fonte"></a>
						<a class="govsp-acessibilidade" href="#" id="altocontraste" accesskey="3" onclick="window.toggleContrast()" onkeydown="window.toggleContrast()"><img class="govsp-acessibilidade" src="https://saopaulo.sp.gov.br/barra-govsp/img/contrast.png" alt="Contraste"></a>
						<a class="govsp-acessibilidade" href="https://www.saopaulo.sp.gov.br/fale-conosco/comunicar-erros/" title="Comunicar Erros" target="_blank"><img class="govsp-acessibilidade" src="https://saopaulo.sp.gov.br/barra-govsp/img/error-report.png"></a>
				</nav>
			</div>
			<div class="govsp-kebab">
					<figure></figure>
					<figure class="govsp-middle"></figure>
					<p class="govsp-cross"></p>
					<figure></figure>
					<ul class="govsp-dropdown" id="govsp-kebab">
						<li><a class="govsp-link" href="http://www.cidadao.sp.gov.br" target="_blank">Cidadão SP</a>
						</li><li><a class="govsp-social" href="https://www.facebook.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/facebook.png" alt="Facebook Governo de SÃ£o Paulo"></a></li>
						<li><a class="govsp-social" href="https://www.twitter.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/twitter.png" alt="Twitter Governo de SÃ£o Paulo"></a></li>
						<li><a class="govsp-social" href="https://www.instagram.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/insta.png" alt="Instagram Governo de SÃ£o Paulo"></a></li>
						<li><a class="govsp-social" href="https://www.flickr.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/flickr.png" alt="Flickr Governo de SÃ£o Paulo"></a></li>
						<li><a class="govsp-social" href="https://www.youtube.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/youtube.png" alt="Youtube Governo de SÃ£o Paulo"></a></li>
						<li><a class="govsp-social" href="https://www.issuu.com/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/issuu.png" alt="Issuu Governo de SÃ£o Paulo"></a></li>
						<li><a class="govsp-social" href="https://www.linkedin.com/company/governosp/" target="_blank"><img class="govsp-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/linkedin.png" alt="Linkedin Governo de SÃ£o Paulo"></a></li>
						<li></li><p class="govsp-social">/governosp</p>
					</ul>
			</div>
		</div>
		<script src="https://saopaulo.sp.gov.br/barra-govsp/js/script-topo.js"></script>
		<script src="https://saopaulo.sp.gov.br/barra-govsp/js/script-contrast.js"></script>
		<script src="https://saopaulo.sp.gov.br/barra-govsp/js/script-tamanho-fonte.js"></script>
		<script src="https://saopaulo.sp.gov.br/barra-govsp/js/script-scroll.js"></script>
	</section>';
});

add_filter( 'map_meta_cap', 'tainacan_ipt_map_unfiltered_html', 99, 4 );
function tainacan_ipt_map_unfiltered_html( $caps, $cap, $user_id, $args ) {
	$user = get_userdata( $user_id );

	if ( in_array( $user->roles[0], array('administrator', 'editor', 'author') ) && ( 'unfiltered_html' == $cap ) ) :
		$caps = array( $cap );
	endif;

	return $caps;
}