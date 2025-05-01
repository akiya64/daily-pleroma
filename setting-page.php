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

function test_build_yesterday_digest() {
	$all_items = parse_pleroma_atom( 'https://autumnsky.jp/users/akiya/feed.atom' );
	$yesterday = new DateTime( '-1 day' );

	return build_main_content( $yesterday, $all_items );
}
