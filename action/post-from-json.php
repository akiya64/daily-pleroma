<?php
/**
 * Menu page for settings and fetch test.
 *
 * @package daily-pleroma
 */


function insert_post_from_json() {
	if ( 'POST' !== $_SERVER['REQUEST_METHOD']
		|| ! isset( $_FILES['outbox-json'] ) ) {
			return;
	}

	if( 'application/json' !== $_FILES['outbox-json']['type'] ){
		echo '<p>Error, upload file is not json.</p>';
		return;
	}

	$outbox = file_get_contents( $_FILES['outbox-json']['tmp_name'] );
	$all_item = parse_outbox_json( $outbox );
}
