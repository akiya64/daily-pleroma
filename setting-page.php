<?php
/**
 * Menu page for settings and fetch test.
 *
 * @package daily-pleroma.php
 */

add_action(
	'admin_menu',
	function(){
		add_submenu_page(
			'tools.php',
			'Daily Pleroma',
			'Setting Daily Pleroma',
			'manage_options',
			'sub_daily_pleroma',
			function(){
				$url = get_option( 'rss_url', '');
				$post_est = get_option( 'est_daily_post', '' );
				$selected_cat = get_option( 'digest_cat', 0 );
				$selected_user = get_option( 'digest_author', 0 );
				?>
				<h1>Daily Pleroma</h1>
					<h2>RSS feed settings</h2>
						<form method="post">
							<label>RSS URL: <input type="text" name="rss-url" value="<?php echo esc_html( $url ); ?>"></label><br>
							<label>投稿時刻: <input type="time" name="post-est" value="<?php echo esc_html( $post_est ); ?>"></label><br>
							<label>カテゴリー: <?php wp_dropdown_categories( array( 'hide_empty' => true, 'selected' => $selected_cat ) ); ?></label><br>
							<label>投稿者: <?php wp_dropdown_users( array( 'selected' => $selected_user ) ); ?></label><br>
							<input type="submit" value="保存">
						</form>
						<?php if( $url ) : ?>
							<form method="post">
								<input type="hidden" name="fetch-test" value="test">
								<input type="submit" value="RSS読み取りテスト">
							</form>
						<?php endif; ?>
					<h2>Upload actor.json</h2>
				<?php
					if( isset( $_POST['fetch-test'] ) && 'test' === $_POST['fetch-test'] ){

						$yesterday = new DateTime( '-1 day', wp_timezone() );
						$all_items = parse_pleroma_atom( $url );

						var_dump( build_daily_digest_post( $yesterday, $all_items ) );
					}

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
		);
	},
	99
);

function insert_yesterday_digest(){
	$yesterday = new DateTime( '-1 day', wp_timezone() );

	if( is_digest_posted( $yesterday ) ) return;

	$all_items = parse_pleroma_atom( get_option( 'rss_url') );
	wp_insert_post( build_daily_digest_post( $yesterday, $all_items ) );
};

add_action( 'insert_yesterday_digest_hook', 'insert_yesterday_digest' );

function add_daily_digest_schedule( int $est ){

	$next = wp_get_scheduled_event( 'insert_yesterday_digest_hook' );

	if( $next ){
		// 時刻変更.
		$next_date = date( "H:i", $next->timestamp );
		$est_date = date( "H:i", $est );

		if( $next_date !== $est_date ){
			wp_reschedule_event( $est, 'daily', 'insert_yesterday_digest_hook' );
		}

	} else {
		// 新規登録.
		wp_schedule_event( $est, 'daily', 'insert_yesterday_digest_hook' );
	}
}

function is_digest_posted( DateTime $date ){
	$posts = get_posts( array(
		'category' => get_option( 'digest_cat' ),
		'date_query' => array(array (
			'year' => $date->format('Y'),
			'month' => $date->format('m'),
			'day' => $date->format('d'),
		)))
	);
	return $posts ? false : true;
}
