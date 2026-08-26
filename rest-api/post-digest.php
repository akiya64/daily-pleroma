<?php
/**
 * Rest API end point.
 *
 * @package daily-pleroma
 */

add_action(
	'rest_api_init',
	function () {
		$post = function() {
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

			return post_digest_entire_period( $all_items );

		};


		register_rest_route( 'daily-pleroma/v1', '/post-digest', array(
			'methods'  => WP_REST_Server::CREATABLE,
			'callback' => $post,
			'permission_callback' => function() {
				return current_user_can( 'edit_posts' );
			}
		) );
	}
);
