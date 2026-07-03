<?php
/**
 * Helper functions
 *
 * @package daily-pleroma
 */

function exists_digest_post( DateTime $date ){
	$posts = get_posts( array(
		'category' => get_option( 'digest_cat' ),
		'date_query' => array(array (
			'year' => $date->format('Y'),
			'month' => $date->format('m'),
			'day' => $date->format('d'),
		)))
	);

	return $posts ? true : false;
}

function slice_items( array $all_items, DateTime $date, ){
	if( ! $all_items ){
		return;
	}

	ksort( $all_items );

	$items = array_filter( $all_items, function( $k ) use ( $date ){
		return str_contains( $k, $date->format( 'Y-m-d' ) );
	}, ARRAY_FILTER_USE_KEY );

	ksort( $items );

	return $items;
}
