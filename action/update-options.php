<?php
/**
 * Menu page for settings and fetch test.
 *
 * @package daily-pleroma
 */

function update_daily_pleroma_settings(){

	if( isset( $_POST['rss-url'] ) && $_POST['rss-url'] ){
		update_option( 'rss_url', $_POST['rss-url'] );
	}
	if( isset( $_POST['user'] ) && intval( $_POST['user'] ) ){
		update_option( 'digest_author', $_POST['user'] );
	}
	if( isset( $_POST['cat'] ) && intval( $_POST['cat'] ) ){
		update_option( 'digest_category', $_POST['cat'] );
	}
	if( isset( $_POST['post-est'] ) ){
		update_option( 'est_daily_post', $_POST['post-est'] );

		$date = date_create_from_format( 'H:i', $_POST['post-est'], wp_timezone() );
		$date->setTimezone( new DateTimeZone('UTC'));
		add_daily_digest_schedule( $date->getTimestamp() );
	}
}
