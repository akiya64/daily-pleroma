<?php
/**
 * Menu page for settings and fetch test.
 *
 * @package daily-pleroma
 */

add_action(
	'admin_menu',
	function(){
		add_submenu_page(
			'tools.php',
			'Daily Pleroma',
			'Daily Pleroma',
			'manage_options',
			'daily_pleroma',
			function(){
				?>
				<h1>Daily Pleroma</h1>
					<h2>RSS feed settings</h2>
						<?php
							render_setting_form();
							test_settings();
						?>
					<h2>Upload json</h2>
						<form method="post" enctype="multipart/form-data">
							<input type="file" name="outbox-json">
							<input type="submit" value="アップロード">
						</form>
						<?php insert_post_from_json() ?>
				<?php
			}
		);
	},
	99
);

function render_setting_form(){

	$url = get_option( 'rss_url', '');
	$post_est = get_option( 'est_daily_post', '' );
	$selected_cat = get_option( 'digest_category', 0 );
	$selected_user = get_option( 'digest_author', 0 );
	?>
		<form method="post">
			<label>RSS URL: <input type="text" name="rss-url" value="<?php echo esc_html( $url ); ?>"></label><br>
			<label>投稿時刻: <input type="time" name="post-est" value="<?php echo esc_html( $post_est ); ?>"></label><br>
			<label>カテゴリー: <?php wp_dropdown_categories( array( 'hide_empty' => false, 'selected' => $selected_cat ) ); ?></label><br>
			<label>投稿者: <?php wp_dropdown_users( array( 'selected' => $selected_user ) ); ?></label><br>
			<input type="submit" value="保存">
		</form>
		<?php if( $url ) : ?>
			<form method="post">
				<input type="hidden" name="fetch-test" value="test">
				<input type="submit" value="RSS読み取りテスト">
			</form>
		<?php endif;
}
