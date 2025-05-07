<?php
/**
 * Set / Remove schedule for post daily digest.
 *
 * @package daily-pleroma
 */

function insert_yesterday_digest(){
	$yesterday = new DateTime( '-1 day', wp_timezone() );
	$today = new DateTime( 'now', wp_timezone() );
	if( exists_digest_post( $today ) ) return;

	$all_items = parse_pleroma_atom( get_option( 'rss_url') );
	wp_insert_post( build_daily_digest_post( $yesterday, $all_items ) );
};

add_action( 'insert_yesterday_digest_hook', 'insert_yesterday_digest' );

function add_daily_digest_schedule( int $est ){

	$next = wp_get_scheduled_event( 'insert_yesterday_digest_hook' );

	if( $next ){
		// 時刻変更.
		$next_date = date( "H:i", $next->timestamp );
		$est_date = date( "H:i", $est );

		if( $next_date !== $est_date ){
			wp_reschedule_event( $est, 'daily', 'insert_yesterday_digest_hook' );
		}

	} else {
		// 新規登録.
		wp_schedule_event( $est, 'daily', 'insert_yesterday_digest_hook' );
	}
}

add_action(
	'deactivate_daily-pleroma/daily-pleroma.php',
	function(){
		error_log('deactivate');
		$timestamp = wp_next_scheduled( 'insert_yesterday_digest_hook' );
		wp_unschedule_event( $timestamp, 'insert_yesterday_digest_hook' );
	}
);
