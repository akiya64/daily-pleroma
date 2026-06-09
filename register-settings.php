<?php
/**
 * Register settings
 *
 * @package daily-pleroma
 */

add_action(
	'admin_init',
	function () {
		$default = array(
			'rss_url' => 'https://example.com/feed.atom',
			'digest_author' => 1,
			'digest_category' => 1,
			'est_daily_post' => '00:00'
		);

		$schema = array(
			'type' => 'object',
			'properties' => array(
				'rss_url' => array(
					'type' => 'string'
				),
				'digest_author' => array(
					'type' => 'integer'
				),
				'digest_category' => array(
					'type' =>  'integer'
				),
				'est_daily_post' => array(
					'type' => 'string'
				),
			)
		);

		register_setting(
			'daily_pleroma',
			'daily_pleroma_settings',
			array(
				'type'         => 'object',
				'default'      => $default,
				'show_in_rest' => $schema
			)
		);

		if ( get_option( 'rss_url' ) ) {
			$old_settings = array(
				'rss_url'         => get_option( 'rss_url' ),
				'digest_author'   => get_option( 'digest_author' ),
				'digest_category' => get_option( 'digest_category' ),
				'est_daily_post'  => get_option( 'est_daily_post' )
			);

			update_option( 'daily_pleroma_settings', $old_settings );

		}
	},
);


