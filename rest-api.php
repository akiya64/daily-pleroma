<?php
/**
 * Rest API end point.
 *
 * @package daily-pleroma
 */

add_action(
	'rest_api_init',
	function () {
		$get_yesterday_entry = function() {
			$settings        = get_option( 'daily_pleroma_settings' );

			if( ! $settings ){
				return new WP_Error(
					'RSS の URL が設定されていません。',
					'RSS の URL が設定されていません。',
					array( 'status' => 500 )
				);
			}

			$all_items  = parse_pleroma_atom( $settings['rss_url'] );
			$yesterday  = new DateTime( '-1 day', wp_timezone() );
			$entries    = slice_items( $all_items, $yesterday );
			$entries    = array_map(
				fn( $k, $v ) => array( 'date' => $k, ...$v ),
				array_keys( $entries ), array_values( $entries )
			);

			return rest_ensure_response( $entries );
		};

		register_rest_route( 'daily-pleroma/v1', '/fetch-rss', array(
			'methods'  => WP_REST_Server::READABLE,
			'callback' => $get_yesterday_entry,
		) );
	}
);
