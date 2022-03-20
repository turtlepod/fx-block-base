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

	add_filter( 'block_categories_all', $n( 'blocks_categories' ), 10, 2 );
	add_action( 'init', $n( 'register_blocks' ) );
	add_action( 'enqueue_block_assets', $n( 'blocks_scripts' ) );
	add_action( 'wp_enqueue_scripts', $n( 'blocks_scripts' ) );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\setup' );

/**
 * Add Block Categories
 *
 * @param array                    $categories Registered categories.
 * @param \WP_Block_Editor_Context $block_editor_context The current block editor context.
 *
 * @return array Filtered categories.
 */
function blocks_categories( $categories, $block_editor_context ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug'  => 'fxbb',
				'title' => 'f(x) Block Base',
			),
		)
	);
}

/**
 * Register All Blocks
 */
function register_blocks() {
	$dirs = glob( plugin_dir_path(__FILE__) . '*', GLOB_ONLYDIR );
	foreach ( $dirs as $dir ) {
		$block  = basename( $dir );
		$json   = trailingslashit( $dir ) . 'block.json';
		$markup = trailingslashit( $dir ) . 'markup.php';
		$script = trailingslashit( $dir ) . 'index.js';
		$style  = trailingslashit( $dir ) . 'index.css';
		$editor = trailingslashit( $dir ) . 'editor.css';
		if ( file_exists( $json ) && file_exists( $markup ) && file_exists( $script ) ) {
			$args = [
				'editor_script'   => $block,
				'render_callback' => function( $attributes, $content, $block ) use ( $markup ) {
					ob_start();
					$args = [
						'attributes' => $attributes,
						'content'    => $content,
						'block'      => $block,
					];
					include $markup;
					return ob_get_clean();
				},
			];
			if ( file_exists( $style ) ) {
				$args['style'] = $block . '_style';
			}
			if ( file_exists( $editor ) ) {
				$args['editor_style'] = $block . '_editor_style';
			}
			register_block_type( $dir, $args );
		}
	}
}

/**
 * Blocks Editor Scripts and Styles.
 */
function blocks_scripts() {
	$dirs = glob( plugin_dir_path(__FILE__) . '*', GLOB_ONLYDIR );
	foreach ( $dirs as $dir ) {
		$block = basename( $dir );

		// Block script.
		$script = plugin_dir_path(__FILE__) . 'dist/' . $block . '.min.js';
		if ( file_exists( $script ) ) {
			wp_register_script(
				$block,
				plugin_dir_url( __FILE__ ) . 'dist/' . basename( $script ),
				[
					'wp-block-editor',
					'wp-blocks',
					'wp-components',
					'wp-dom-ready',
					'wp-element',
					'wp-i18n',
					'wp-polyfill',
				],
				filemtime( $script ),
				true
			);
		}

		// Block style.
		$style = trailingslashit( $dir ) . 'index.css';
		if ( file_exists( $style ) ) {
			wp_register_style(
				$block . '_style',
				plugin_dir_url( __FILE__ ) . $block . '/index.css',
				[],
				filemtime( $style )
			);
		}

		// Editor style.
		$editor_style = trailingslashit( $dir ) . 'editor.css';
		if ( file_exists( $editor_style ) ) {
			wp_register_style(
				$block . '_editor_style',
				plugin_dir_url( __FILE__ ) . $block . '/editor.css',
				[],
				filemtime( $editor_style )
			);
		}
	}
}
