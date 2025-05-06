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
