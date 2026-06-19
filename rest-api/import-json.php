<?php
/**
 * Rest API end point.
 *
 * @package daily-pleroma
 */

add_action(
	'rest_api_init',
	function () {
		$import = function() {
			error_log("import-json endpoint");
			if ( ! isset( $_FILES['outbox-json'] ) ) {
				return;
			}

			error_log(print_r($_FILES,true));

			if( 'application/json' !== $_FILES['outbox-json']['type'] ){
				echo '<p>Error, upload file is not json.</p>';
				return;
			}

			$outbox = file_get_contents( $_FILES['outbox-json']['tmp_name'] );
			$all_item = parse_outbox_json( $outbox );

			ksort( $all_item );

			$first = min( array_keys( $all_item ) );
			$since = new DateTime( $first, wp_timezone() );

			$last = max( array_keys( $all_item ) );
			$until = new DateTime( $last, wp_timezone() );

			$interval = DateInterval::createFromDateString( '1 day' );
			$period = new DatePeriod( $since, $interval, $until );

			foreach( $period as $current ){
				$estimated_publish_day = $current->modify( '+1 day' );
				if( exists_digest_post( $estimated_publish_day ) ) {
					continue;
				}

				$post_arr = build_daily_digest_post( $current, $all_item );
				$post_arr["post_date"] = $estimated_publish_day->format( 'Y-m-d' ) . ' 02:00:00';
				wp_insert_post( $post_arr );
			}


			echo '<p>Done insert post from outbox.json</p>';
		};

		register_rest_route( 'daily-pleroma/v1', '/import-json', array(
			'methods'  => WP_REST_Server::CREATABLE,
			'callback' => $import,
		) );
	}
);
