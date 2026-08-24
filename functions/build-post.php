<?php
/**
 * Insert post
 *
 * @package daily-pleroma
 */

function build_daily_digest_post( DateTime $date, $all_items = array() ) {
	if( ! $all_items ){
		return;
	}

	$items = slice_items( $all_items, $date );

	if( ! $items ){
		return;
	}

	$main_content = '';
	foreach( $items as $item ){
		$main_content .= <<< EOF
			<!-- wp:paragraph -->
			<p>{$item['content']} <a href="{$item['url']}" target="_blank">#</a></p>
			<!-- /wp:paragraph -->
			EOF;
	}

	$settings = get_option( 'daily_pleroma_settings' );
	$date_string = $date->format( 'Y-m-d' );

	return array(
		'post_name' => 'from_akkoma_' . $date_string,
		'post_title' => 'From akkoma ' . $date_string,
		'post_content' => $main_content,
		'post_status' => 'publish',
		'post_author' => $settings['digest_author'] ?? '',
		'post_category' => array( $settings['digest_category'] ),
	);
}
