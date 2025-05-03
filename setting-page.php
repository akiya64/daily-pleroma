<?php
/**
 * Menu page for settings and fetch test.
 *
 * @package daily-pleroma.php
 */

define( 'RSS_URL', 'https://autumnsky.jp/users/akiya/feed.atom' );
define( 'EST', '02:00' );

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
				?>
				<h1>Daily Pleroma</h1>
					<h2>RSS feed settings</h2>
						<form method="post">
							<label>RSS URL: <input type="text" name="rss-url" value="<?php echo RSS_URL; ?>"></label><br>
							<label>投稿時刻: <input type="time" name="est-time" value=""></label><br>
							<label>カテゴリー: <?php wp_dropdown_categories( array( 'hide_empty' => true ) ); ?></label><br>
							<label>投稿者: <?php wp_dropdown_users(); ?></label><br>
							<input type="submit" value="保存">
						</form>
						<form method="post">
							<input type="hidden" name="fetch-test" value="test">
							<input type="submit" value="RSS読み取りテスト">
						</form>
					<h2>Upload actor.json</h2>
				<?php
					if( isset( $_POST['fetch-test'] ) && 'test' === $_POST['fetch-test'] ){

						$yesterday = new DateTime( '-1 day' );
						$all_items = parse_pleroma_atom( RSS_URL );

						var_dump( build_daily_digest_post( $yesterday, $all_items ) );
					}

					if( isset( $_POST['user'] ) && intval( $_POST['user'] ) ){
						update_option( 'digest_author', $_POST['user'] );
					}
					if( isset( $_POST['cat'] ) && intval( $_POST['cat'] ) ){
						update_option( 'digest_category', $_POST['cat'] );
					}
			}
		);
	},
	99
);

function insert_yesterday_digest(){
	$yesterday = new DateTime( '-1 day' );
	$all_items = parse_pleroma_atom( RSS_URL );
	wp_insert_post( build_daily_digest_post( $yesterday, $all_items ) );
};

add_action( 'insert_yesterday_digest_hook', 'insert_yesterday_digest' );

if( ! wp_next_scheduled( 'insert_yesterday_digest' ) ){
	wp_schedule_event( strtotime("now"), 'hourly', 'insert_yesterday_digest_hook' );
}
