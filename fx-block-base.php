<?php
/**
 * Plugin Name: f(x) Block Base
 * Plugin URI: http://genbumedia.com/plugins/fx-updater/
 * Description: Block Starter Plugin with Examples
 * Version: 1.0.0
 * Author: David Chandra Purnama
 * Author URI: http://turtlepod.xyz/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
**/

// Plugin Constants.
define( 'FXBB_VERSION', '1.0.1' );
define( 'FXBB_PATH', plugin_dir_path(__FILE__) );
define( 'FXBB_URI', plugin_dir_url( __FILE__ ) );
define( 'FXBB_INC', FXBB_PATH . 'includes/' );
define( 'FXBB_BLOCK_DIR', FXBB_PATH . 'blocks/' );

// Load blocks.
require_once FXBB_BLOCK_DIR . 'blocks.php';
