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

	$conjunto_posts_args = array(
		'post_type' => 'any',
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

	$collections_post_types = \Tainacan\Repositories\Repository::get_collections_db_identifiers();
	$total_items = 0;

	foreach( $collections_post_types as $collection_post_type ) {
		$total_items_for_collection = wp_count_posts($collection_post_type);
		$total_items += (int) $total_items_for_collection->publish;
	}

	return '<span class="tainacan-total-items-shortcode">' . ($total_items - $conjunto_posts_count) . '</span>';
});