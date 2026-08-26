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

			ksort( $all_items );

			$first = min( array_keys( $all_items ) );
			$since = new DateTime( $first, wp_timezone() );

			$last = max( array_keys( $all_items ) );
			$until = new DateTime( $last, wp_timezone() );

			$interval = DateInterval::createFromDateString( '1 day' );
			$period = new DatePeriod( $since, $interval, $until );

			$count = 0;

			foreach( $period as $current ){
				$estimated_publish_day = $current->modify( '+1 day' );
				if( exists_digest_post( $estimated_publish_day ) ) {
					continue;
				}

				$post_arr = build_daily_digest_post( $current, $all_items );

				if( ! $post_arr ){
					continue;
				}

				$post_arr["post_date"] = $estimated_publish_day->format( 'Y-m-d' ) . ' 02:00:00';

				if( wp_insert_post( $post_arr ) ){
					$count++;
				}
			}

			$day = $since->format('Y-m-d') . ' - ' . $until->format('Y-m-d');

			if( $count === 0 ){
				return rest_ensure_response( $day . ' この期間で投稿できるダイジェストはありませんでした' );
			} else {
				return rest_ensure_response( $day . ': ' . $count . '件を投稿しました。' );

			}
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
