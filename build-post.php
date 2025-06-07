<?php
/**
 * Insert post
 *
 * @package daily-pleroma
 */

function build_main_content( DateTime $date, $all_items = array() ){

	$items = array_filter( $all_items, function( $k ) use ( $date ){
		return str_contains( $k, $date->format( 'Y-m-d' ) );
	}, ARRAY_FILTER_USE_KEY );

	ksort( $items );

	$content = '';
	foreach( $items as $item ){
		$content .= <<< EOF
			<!-- wp:paragraph -->
			<p>{$item['content']} <a href="{$item['link']}" target="_blank">#</a></p>
			<!-- /wp:paragraph -->
			EOF;
	}

	return $content;
}

function build_daily_digest_post( DateTime $date, $all_items = array() ) {
	$all_items = parse_pleroma_atom( get_option( 'rss_url' ) );
	$date_string = $date->format( 'Y-m-d' );

	$main_content = build_main_content( $date, $all_items );

	if( $main_content ){
		return array(
			'post_name' => 'from_akkoma_' . $date_string,
			'post_title' => 'From akkoma ' . $date_string,
			'post_content' => $main_content,
			'post_status' => 'publish',
			'post_author' => get_option( 'digest_author' ) ?? '',
			'post_category' => array( get_option( 'digest_category' ) ?? '' ),
		);
	} else {
		return;
	}
}
