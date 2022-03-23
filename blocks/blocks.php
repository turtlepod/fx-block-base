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

	// Block Assets.
	add_action( 'enqueue_block_editor_assets', $n( 'block_editor_assets' ) );
	add_action( 'enqueue_block_assets', $n( 'block_assets' ) );

	// Custom Blocks.
	add_filter( 'block_categories_all', $n( 'blocks_categories' ), 10, 2 );
	add_action( 'init', $n( 'register_custom_blocks' ) );
	add_action( 'enqueue_block_assets', $n( 'custom_blocks_scripts' ) );
	add_action( 'wp_enqueue_scripts', $n( 'custom_blocks_scripts' ) );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\setup' );

/**
 * Load block editor scripts.
 */
function block_editor_assets() {
	$editor_scripts = plugin_dir_path(__FILE__) . '/dist/editor.min.js';
	if ( file_exists( $editor_scripts) ) {
		wp_enqueue_script(
			'fx_block_editor_js',
			plugin_dir_url( __FILE__ ) . 'dist/editor.min.js',
			[
				'wp-block-editor',
				'wp-blocks',
				'wp-components',
				'wp-dom-ready',
				'wp-element',
				'wp-i18n',
				'wp-polyfill',
			],
			filemtime( $editor_scripts ),
			true
		);
	}
	$editor_style = plugin_dir_path(__FILE__) . '/editor.css';
	if ( file_exists( $editor_style) ) {
		wp_enqueue_style(
			'fx_block_editor_css',
			plugin_dir_url( __FILE__ ) . '/editor.css',
			[],
			filemtime( $editor_style )
		);
	}
}

/**
 * Load block scripts.
 */
function block_assets() {
	$style = plugin_dir_path(__FILE__) . '/index.css';
	if ( file_exists( $style) ) {
		wp_enqueue_style(
			'fx_block_css',
			plugin_dir_url( __FILE__ ) . '/index.css',
			[],
			filemtime( $style )
		);
	}
}

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
 * Register Custom Blocks
 */
function register_custom_blocks() {
	$dirs = glob( plugin_dir_path(__FILE__) . 'custom-blocks/*', GLOB_ONLYDIR );
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
 * Custom Blocks Editor Scripts and Styles.
 */
function custom_blocks_scripts() {
	$dirs = glob( plugin_dir_path(__FILE__) . 'custom-blocks/*', GLOB_ONLYDIR );
	foreach ( $dirs as $dir ) {
		$block = basename( $dir );

		// Block script.
		$script = plugin_dir_path(__FILE__) . 'dist/custom-blocks/' . $block . '.min.js';
		if ( file_exists( $script ) ) {
			wp_register_script(
				$block,
				plugin_dir_url( __FILE__ ) . 'dist/custom-blocks/' . basename( $script ),
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
				plugin_dir_url( __FILE__ ) . 'custom-blocks/' . $block . '/index.css',
				[],
				filemtime( $style )
			);
		}

		// Editor style.
		$editor_style = trailingslashit( $dir ) . 'editor.css';
		if ( file_exists( $editor_style ) ) {
			wp_register_style(
				$block . '_editor_style',
				plugin_dir_url( __FILE__ ) . 'custom-blocks/' . $block . '/editor.css',
				[],
				filemtime( $editor_style )
			);
		}
	}
}

