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
						<label>RSS URL</label>
						<input type="text" name="feed_url" id="feed-url"/>
						<button>テスト</button>
						<?php 
							echo test_build_yesterday_digest();
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

	return build_post_main_content( $yesterday, $all_items );
}
