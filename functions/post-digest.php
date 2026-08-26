<?php

function post_digest_entire_period( array $all_items ){

	ksort( $all_items );

	$first = min( array_keys( $all_items ) );
	$since = new DateTime( $first, wp_timezone() );

	$last = max( array_keys( $all_items ) );
	$until = new DateTime( $last, wp_timezone() );

	$interval = DateInterval::createFromDateString( '1 day' );
	$period = new DatePeriod( $since, $interval, $until );

	$count = 0;

	foreach( $period as $current ){
		$current = DateTimeImmutable::createFromMutable( $current );
		$estimated_publish_day = $current->modify( '+1 day' );
		if( exists_digest_post( $estimated_publish_day ) ) {
			continue;
		}

		$post_arr = build_daily_digest_post( $current, $all_items );

		if( ! $post_arr ){
			continue;
		}

		$post_arr["post_date"] = $estimated_publish_day->format( 'Y-m-d' ) . ' 02:00:00';

		error_log(print_r($post_arr,true));
		//if( wp_insert_post( $post_arr ) ){
		//	$count++;
		//}
	}

	$day = $since->format('Y-m-d') . ' - ' . $until->format('Y-m-d');

	if( $count === 0 ){
		return rest_ensure_response( $day . ' この期間で投稿できるダイジェストはありませんでした' );
	} else {
		return rest_ensure_response( $day . ': ' . $count . '件を投稿しました。' );
	}
};
