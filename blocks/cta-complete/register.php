<?php
/**
 * Gutenberg Blocks setup
 *
 * @package FxBlockBase\Blocks\CTAComplete
 */

namespace FxBlockBase\Blocks\CTAComplete;

/**
 * Register the block
 */
function register() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	// Register the block.
	register_block_type(
		FXBB_BLOCK_DIR . 'cta-complete', // this is the directory where the block.json is found.
		[
			'render_callback' => $n( 'render_block_callback' ),
		]
	);
}
register();

/**
 * Render callback method for the block
 *
 * @param array  $attributes The blocks attributes
 * @param string $content    Data returned from InnerBlocks.Content
 * @param array  $block      Block information such as context.
 *
 * @return string The rendered block markup.
 */
function render_block_callback( $attributes, $content, $block ) {
	ob_start();
	$args = [
		'class_name' => 'wp-block-tenup-cta-complete',
		'attributes' => $attributes,
		'content'    => $content,
		'block'      => $block,
	];
	include FXBB_BLOCK_DIR . 'cta-complete/markup.php';
	return ob_get_clean();
}
