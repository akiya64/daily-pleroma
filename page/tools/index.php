<?php
/**
 * Menu page for import outbox.json
 *
 * @package daily-pleroma
 */

add_action(
	'admin_menu',
	function(){
		add_submenu_page(
			'tools.php',
			'Import outbox',
			'Import outbox',
			'manage_options',
			'import_outbox',
			function(){
					$loading_message = __( 'Loading', 'daily-pleroma' );
				?>
					<div class="wrap" id="daily-pleroma-import-outbox"><?php echo $loading_message; ?></div>
				<?php
			}
		);
	},
	99
);

add_action(
	'admin_enqueue_scripts',
	function( $admin_page ){
		if ( 'tools_page_import_outbox' !== $admin_page ) {
			return;
		}

		$asset_file = plugin_dir_path( __FILE__ ) . 'index.bundle.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		wp_enqueue_script(
			'daily-pleroma-import-outbox',
			plugins_url( 'index.bundle.js', __FILE__ ),
			$asset['dependencies'],
			$asset['version'],
			array(
				'in_footer' => true,
			)
		);
		wp_enqueue_style( 'wp-components' );
	}
);
