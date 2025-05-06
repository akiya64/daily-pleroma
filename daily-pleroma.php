<?php
/**
 * Plugin Name: daily-pleroma
 * Description: from pleroma / akkoma instance via RSS feed.
 * Version:     0.0.1
 * Author: Akiya
 * Author URI:  https://autumunsky.jp/
 * TextDomain:  daily-pleroma
 *
 * @package:     daily-pleroma
 */

require_once __DIR__ . '/build-post.php';
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/parser.php';
require_once __DIR__ . '/scheduler.php';
require_once __DIR__ . '/setting-page.php';
