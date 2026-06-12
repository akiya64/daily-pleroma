<?php
/**
 * Insert post
 *
 * @package daily-pleroma
 */

function build_daily_digest_post( DateTime $date, $all_items = array() ) {
	if( ! $all_items ){
		$all_items = parse_pleroma_atom( get_option( 'rss_url' ) );
	}

	$items = slice_items( $date, $all_items );

	if( ! $items ){
		return;
	}

	$main_content = '';
	foreach( $items as $item ){
		$main_content .= <<< EOF
			<!-- wp:paragraph -->
			<p>{$item['content']} <a href="{$item['link']}" target="_blank">#</a></p>
			<!-- /wp:paragraph -->
			EOF;
	}

	$date_string = $date->format( 'Y-m-d' );

	return array(
		'post_name' => 'from_akkoma_' . $date_string,
		'post_title' => 'From akkoma ' . $date_string,
		'post_content' => $main_content,
		'post_status' => 'publish',
		'post_author' => get_option( 'digest_author' ) ?? '',
		'post_category' => array( get_option( 'digest_category' ) ?? '' ),
	);
}
