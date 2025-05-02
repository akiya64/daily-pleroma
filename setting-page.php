<?php
/**
 * Menu page for settings and fetch test.
 *
 * @package daily-pleroma.php
 */

define( 'RSS_URL', 'https://autumnsky.jp/users/akiya/feed.atom' );

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
							<input type="text" name="rss-url" value="<?php echo RSS_URL; ?>">
							<input type="submit" value="保存">
				</form>
				<hr>
						<form method="post">
							<input type="hidden" name="fetch-test" value="test">
							<input type="submit" value="RSS読み取りテスト">
						</form>
						<?php
							if( isset( $_POST['fetch-test'] ) && 'test' === $_POST['fetch-test'] ){
								echo build_yesterday_digest();
							}
						?>
					<h2>Upload actor.json</h2>
				<?php
			}
		);
	},
	99
);

add_action( 'insert_yesterday_digest', function(){
	error_log('scheduled insert');
	wp_insert_post( array(
		'post_title' => 'From akkoma',
		'post_content' => build_yesterday_digest()
	) );
});

wp_schedule_event( strtotime("now"), 'hourly', 'insert_yesterday_digest' );
