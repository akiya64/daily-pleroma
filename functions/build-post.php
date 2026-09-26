<?php
/**
 * Insert post
 *
 * @package daily-pleroma
 */

function build_daily_digest_post( DateTime|DateTimeImmutable $date, $all_items = array() ) {
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
			<p>{$item['content']} <a href="{$item['link']}" target="_blank">#</a></p>
			<!-- /wp:paragraph -->
			EOF;
	}

	$settings = get_option( 'daily_pleroma_settings' );

	[ $hour, $min ] = explode( ":", $settings['est_daily_post'] );
	$estimated_publish = $date->modify( '+1 day' )->setTime( $hour, $min );

	return array(
		'post_name'     => 'from_akkoma_' . $date->format( 'Y-m-d' ),
		'post_title'    => 'From akkoma ' . $date->format( 'Y-m-d' ),
		'post_content'  => $main_content,
		'post_status'   => 'publish',
		'post_author'   => $settings['digest_author'] ?? '',
		'post_category' => array( $settings['digest_category'] ),
		'post_date'     => $estimated_publish->format( 'Y-m-d H:i:s' )
	);
}
