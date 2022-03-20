<?php
/**
 * Gutenberg Blocks setup
 *
 * @package FxBlockBase
 */

namespace FxBlockBase\Blocks;

/**
 * Blocks Setup
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'enqueue_block_editor_assets', $n( 'blocks_editor_scripts' ) );
	add_action( 'init', $n( 'register_blocks' ) );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\setup' );

/**
 * Blocks Editor Scripts and Styles.
 */
function blocks_editor_scripts() {
	wp_enqueue_script(
		'cta-complete',
		FXBB_URI . 'blocks/cta-complete/editor.min.js',
		[
			'wp-element',
			'wp-blocks',
			'wp-components',
			'wp-editor',
		],
		FXBB_VERSION,
		true
	);
}

/**
 * Register Blocks
 */
function register_blocks() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	require_once FXBB_BLOCK_DIR . '/cta-complete/register.php';
}
