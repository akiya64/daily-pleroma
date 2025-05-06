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
					receiver_post_method();
				?>
				<h1>Daily Pleroma</h1>
					<h2>RSS feed settings</h2>
						<?php render_setting_form(); ?>
				<?php
			}
		);
	},
	99
);

function render_setting_form(){

	$url = get_option( 'rss_url', '');
	$post_est = get_option( 'est_daily_post', '' );
	$selected_cat = get_option( 'digest_cat', 0 );
	$selected_user = get_option( 'digest_author', 0 );
	?>
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
		<?php endif;
}

function receiver_post_method(){

	if( isset( $_POST['fetch-test'] ) && 'test' === $_POST['fetch-test'] ){

		$yesterday = new DateTime( '-1 day', wp_timezone() );
		$all_items = parse_pleroma_atom( get_option( 'rss_url' ) );

		var_dump( $yesterday );
		var_dump( build_daily_digest_post( $yesterday, $all_items ) );

		var_dump( exists_digest_post( $yesterday ) );
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
