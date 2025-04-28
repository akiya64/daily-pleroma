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
					<h2>via RSS feed settings</h2>
						<?php parse_pleroma_atom( 'https://autumnsky.jp/users/akiya/feed.atom' );
						?>
					<h2>Upload actor.json</h2>
				<?php
			}
		);
	},
	99
);
