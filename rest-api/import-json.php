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
			if ( ! isset( $_FILES['outbox-json'] ) ) {
				return new WP_Error(
					'jsonファイルをアップロードして下さい',
					'jsonファイルをアップロードして下さい',
					array( 'status' => 406 )
				);
			}

			if( 'application/json' !== $_FILES['outbox-json']['type'] ){
				return new WP_Error(
					'ファイルが json 形式ではありません',
					'ファイルが json 形式ではありません',
					array( 'status' => 406 )
				);
			}

			$outbox = file_get_contents( $_FILES['outbox-json']['tmp_name'] );
			$all_item = parse_outbox_json( $outbox );

			if( count( $all_item ) === 0 ){
				return new WP_Error(
					'JSON ファイルに有効なエントリーが含まれていません',
					'JSON ファイルに有効なエントリーが含まれていません',
					array( 'status' => 406 )
				);
			}

			ksort( $all_item );

			$first = min( array_keys( $all_item ) );
			$since = new DateTime( $first, wp_timezone() );

			$last = max( array_keys( $all_item ) );
			$until = new DateTime( $last, wp_timezone() );

			$interval = DateInterval::createFromDateString( '1 day' );
			$period = new DatePeriod( $since, $interval, $until );

			$count = 0;

			foreach( $period as $current ){
				$estimated_publish_day = $current->modify( '+1 day' );
				if( exists_digest_post( $estimated_publish_day ) ) {
					continue;
				}

				$post_arr = build_daily_digest_post( $current, $all_item );

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

		register_rest_route( 'daily-pleroma/v1', '/import-json', array(
			'methods'  => WP_REST_Server::CREATABLE,
			'callback' => $import,
			'permission_callback' => function() {
				return current_user_can( 'edit_posts' );
			}
		) );
	}
);
