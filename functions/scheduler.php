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

add_action(
	'update_option_daily_pleroma_settings',
	function( $_old, $new){
		$next = wp_get_scheduled_event( 'insert_yesterday_digest_hook' );

		if( $next ){
			wp_unschedule_hook( 'insert_yesterday_digest_hook' );
		}

		$est = date_create_from_format( 'H:i', $new['est_daily_post'], wp_timezone() );
		$est->setTimezone( new DateTimeZone('UTC'));

		$now = new DateTime( 'now' );
		$now->setTimezone( new DateTimeZone('UTC'));

		if( $est < $now ){
			$est->modify( '+1 day' );
		}

		wp_schedule_event( $est->getTimestamp(), 'daily', 'insert_yesterday_digest_hook' );
	},
	10,
	3
);

add_action(
	'deactivate_daily-pleroma/daily-pleroma.php',
	function(){
		wp_unschedule_hook( 'insert_yesterday_digest_hook' );
	}
);
