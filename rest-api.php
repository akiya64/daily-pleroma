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

			if( ! $settings || ! $settings['rss_url'] ){
				return new WP_Error(
					'RSS の URL が設定されていません。',
					'RSS の URL が設定されていません。',
					array( 'status' => 500 )
				);
			}

			$all_items  = parse_pleroma_atom( $settings['rss_url'] );

			if( ! $all_items ){
				return new WP_Error(
					'RSS が読み込めませんでした。',
					'RSS が読み込めませんでした。',
					array( 'status' => 500 )
				);
			}

			$days_ago = -1;
			do {
				$yesterday  = new DateTime( $days_ago . 'day', wp_timezone() );
				$entries    = slice_items( $all_items, $yesterday );
				--$days_ago;

			} while ( ! $entries );

			$entries = array_map(
				fn( $k, $v ) => array(
					'date'    => $k,
					'content' => wp_kses_post( $v['content'] ),
					'url'     => esc_url( $v['link'] )
				),
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
