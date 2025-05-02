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

	$content = '';
	foreach( $items as $time => $item ){
		$content .= <<< EOF
			<!-- wp:paragraph -->
			<p>{$item['content']} <a href="{$item['link']}" target="_blank">#</a></p>
			<!-- /wp:paragraph -->
			EOF;
	}

	return $content;
}

function build_daily_digest_post( DateTime $date, $all_items = array() ) {
	$all_items = parse_pleroma_atom( RSS_URL );
	$date_string = $date->format( 'Y-m-d' );

	return array(
		'post_name' => 'from_akkoma_' . $date_string,
		'post_title' => 'From akkoma ' . $date_string,
		'post_content' => build_main_content( $date, $all_items ),
		'post_status' => 'published',
	);
}

