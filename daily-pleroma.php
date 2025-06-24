<?php
/**
 * Plugin Name: Daily pleroma
 * Description: Post daily digest from pleroma / akkoma instance via RSS feed.
 * Version:     0.0.1
 * Author: Akiya
 * Author URI:  https://code.autumunsky.jp/akiya/
 * TextDomain:  daily-pleroma
 *
 * @package:     daily-pleroma
 */

require_once __DIR__ . '/action/update-options.php';
require_once __DIR__ . '/action/test-settings.php';
require_once __DIR__ . '/page/tools.php';

require_once __DIR__ . '/build-post.php';
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/parser.php';
require_once __DIR__ . '/scheduler.php';
