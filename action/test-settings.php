<?php
/**
 * Test fetch and put var_dump
 *
 * @package daily-pleroma
 */

function test_settings(){
	if( isset( $_POST['fetch-test'] ) && 'test' === $_POST['fetch-test'] ){

		$yesterday = new DateTime( '-1 day', wp_timezone() );
		$all_items = parse_pleroma_atom( get_option( 'rss_url' ) );

		var_dump( $yesterday );
		var_dump( build_daily_digest_post( $yesterday, $all_items ) );

		var_dump( exists_digest_post( $yesterday ) );
	}
}
