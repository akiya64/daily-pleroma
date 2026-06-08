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
			'options-general.php',
			'Daily Pleroma',
			'Daily Pleroma',
			'manage_options',
			'daily_pleroma',
			function(){
				?>
					<div class="wrap" id="daily-pleroma-settings">Loading</div>
				<?php
			}
		);
	},
	99
);

add_action(
	'admin_enqueue_scripts',
	function( $admin_page ){
		if ( 'tools_page_daily_pleroma' !== $admin_page ) {
			return;
		}

		$asset_file = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'daily-pleroma-settings',
			plugins_url( 'build/index.js', __FILE__ ),
			$asset['dependencies'],
			$asset['version'],
			array(
				'in_footer' => true,
			)
		);
	}
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
