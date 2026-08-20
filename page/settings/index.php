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
					$loading_message = __( 'Loading', 'daily-pleroma' );
				?>
					<div class="wrap" id="daily-pleroma-settings"><?php echo $loading_message; ?></div>
				<?php
			}
		);
	},
	99
);

add_action(
	'admin_enqueue_scripts',
	function( $admin_page ){
		if ( 'settings_page_daily_pleroma' !== $admin_page ) {
			return;
		}

		$asset_file = plugin_dir_path( __FILE__ ) . 'index.bundle.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'daily-pleroma-settings',
			plugins_url( 'index.bundle.js', __FILE__ ),
			$asset['dependencies'],
			$asset['version'],
			array(
				'in_footer' => true,
			)
		);

		wp_enqueue_style( 'wp-components' );

		wp_enqueue_style(
			'daily-pleroma-settings-style',
			plugins_url( 'index.css', __FILE__ ),
			array_filter(
				$asset['dependencies'],
				fn ( $style ) => wp_style_is( $style, 'registered' )
			),
			$asset['version'],
		);
	}
);
