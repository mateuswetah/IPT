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
const IPT_VERSION = '0.10.5';

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style('blocksy-child-style', get_stylesheet_uri());
});

/* This makes the section collapses begin collapsed by default */
add_filter('tainacan-get-metadata-section-as-html-before-name--index-0', function($before, $item_metadatum) {
	return str_replace('<input checked="checked"', '<input ', $before);
}, 12, 2);

add_shortcode( 'tainacan-total-items', function() {

	$group_taxonomy_id = '39939';//'279';//
	$conjunto_term_id = '523';//'21';//

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
	echo '<section class="govsph-topo"> 

		<link rel="stylesheet" type="text/css" href="https://saopaulo.sp.gov.br/barra-govsp/css/cabecalho-secretarias.css">
		<link rel="stylesheet" type="text/css" href="https://saopaulo.sp.gov.br/barra-govsp/css/contraste.css">
			
		<div id="govsph-topbarGlobal" class="blu-e">
				
				<div id="topbarGlobal">
						<ul class="govsph-links-governo">              
								<li class="govsph-link-portal"><a class="govsph-links-governo" href="http://www.saopaulo.sp.gov.br" target="_blank">saopaulo.sp.gov.br</a></li>
								<li><a class="govsph-links-governo" href="http://www.cidadao.sp.gov.br" target="_blank">Cidadão SP</a></li>
							</ul>
						<div id="govsph-redes-sociais">
								
								<ul class="govsph-links-redes-sociais">              
										<li><a class="govsph-social" href="https://www.facebook.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/facebook.png" alt="Facebook Governo de São Paulo"></a></li>
										<li><a class="govsph-social" href="https://www.twitter.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/twitter.png" alt="Facebook Governo de São Paulo"></a></li>
										<li><a class="govsph-social" href="https://www.instagram.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/insta.png" alt="Facebook Governo de São Paulo"></a></li>
										<li><a class="govsph-social" href="https://www.flickr.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/flickr.png" alt="Facebook Governo de São Paulo"></a></li>
										<li><a class="govsph-social" href="https://www.youtube.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/youtube.png" alt="Facebook Governo de São Paulo"></a></li>
										<li><a class="govsph-social" href="https://www.issuu.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/issuu.png" alt="Facebook Governo de São Paulo"></a></li>
										<li><a class="govsph-social" href="https://www.linkedin.com/company/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/linkedin.png" alt="Facebook Governo de São Paulo"></a></li>
										<li><p class="govsph-social">/governosp</p></li>
										<a class="govsp-acessibilidade" href="javascript:mudaTamanho(`body`, 1);"><img class="govsp-acessibilidade" src="https://saopaulo.sp.gov.br/barra-govsp/img/big-font.png" alt="Aumentar Fonte"></a>
										<a class="govsp-acessibilidade" href="javascript:mudaTamanho(`body`, -1);"><img class="govsp-acessibilidade" src="https://saopaulo.sp.gov.br/barra-govsp/img/small-font.png" alt="Diminuir Fonte"></a>
										<a class="govsp-acessibilidade" href="#" id="altocontraste" accesskey="3" onclick="window.toggleContrast()" onkeydown="window.toggleContrast()"><img class="govsp-acessibilidade" src="https://saopaulo.sp.gov.br/barra-govsp/img/contrast.png" alt="Contraste"></a>
										<a class="govsp-acessibilidade" href="https://www.saopaulo.sp.gov.br/fale-conosco/comunicar-erros/" title="Comunicar Erros" target="_blank"><img class="govsp-acessibilidade" src="https://saopaulo.sp.gov.br/barra-govsp/img/error-report.png"></a>
									</ul>
							</div>
									
				<div id="topbarLink" class="govsph-blue">
					
					<div class="govsph-portal">
						<!-- Insira na Tag abaixo o Nome da Secretaria-->
						<p class="govsph-pasta">Desenvolvimento Econômico</p>
						
					</div> 
				</div>
				<div class="govsph-logo"></div> 
			</div>
			<div class="govsph-kebab">
					<figure></figure>
					<figure class="govsph-middle"></figure>
					<p class="govsph-cross"></p>
					<figure></figure>
					<ul class="govsph-dropdown" id="govsp-kebab">
						<ul class="govsph-links-esq">
						<li class="govsph-link-portal"><a class="govsph-links-governo" href="http://www.saopaulo.sp.gov.br" target="_blank">saopaulo.sp.gov.br</a></li>
						<li><a class="govsph-links-governo" href="http://www.cidadao.sp.gov.br" target="_blank">Cidadão SP</a></li>
						</ul>              
						<li><a class="govsph-social" href="https://www.facebook.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/facebook.png" alt="Facebook Governo de São Paulo"></a></li>
						<li><a class="govsph-social" href="https://www.twitter.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/twitter.png" alt="Facebook Governo de São Paulo"></a></li>
						<li><a class="govsph-social" href="https://www.instagram.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/insta.png" alt="Facebook Governo de São Paulo"></a></li>
						<li><a class="govsph-social" href="https://www.flickr.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/flickr.png" alt="Facebook Governo de São Paulo"></a></li>
						<li><a class="govsph-social" href="https://www.youtube.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/youtube.png" alt="Facebook Governo de São Paulo"></a></li>
						<li><a class="govsph-social" href="https://www.issuu.com/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/issuu.png" alt="Facebook Governo de São Paulo"></a></li>
						<li><a class="govsph-social" href="https://www.linkedin.com/company/governosp/" target="_blank"><img class="govsph-icon-social" src="https://saopaulo.sp.gov.br/barra-govsp/img/linkedin.png" alt="Facebook Governo de São Paulo"></a></li>
						<li><p class="govsph-social">/governosp</p></li>
					</ul> 
			</div>
		</div>
		<script src="https://saopaulo.sp.gov.br/barra-govsp/js/script-cabecalho.js"></script>
		<script src="https://saopaulo.sp.gov.br/barra-govsp/js/script-contrast.js"></script>
		<script src="https://saopaulo.sp.gov.br/barra-govsp/js/script-tamanho-fonte.js"></script>
		<script src="https://saopaulo.sp.gov.br/barra-govsp/js/script-scroll.js"></script>
	</section>';
});

