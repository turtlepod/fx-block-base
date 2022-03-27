<?php
/**
 * Gutenberg Blocks setup
 *
 * @package FxBlockBase
 */

namespace FxBlockBase\Blocks;

// Constants.
define( __NAMESPACE__ . '\PATH', plugin_dir_path(__FILE__) );
define( __NAMESPACE__ . '\URI', plugin_dir_url(__FILE__) );
define( __NAMESPACE__ . '\DIST_PATH', PATH . 'dist/' );
define( __NAMESPACE__ . '\DIST_URI', URI . 'dist/' );

/**
 * Configuration
 *
 * @return array
 */
function config() {
	$config = [
		'prefix'           => 'fx_block',
		'categories'       => [
			[
				'slug'  => 'fxbb',
				'title' => 'f(x) Blocks',
				'icon'  => 'edit',
			],
		],
		'pattern_category' => [
			'slug'  => 'fxbp',
			'title' => 'f(x) Blocks',
		],
	];
	return $config;
}

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

	// Block Patterns.
	add_action( 'after_setup_theme', function() {
		remove_theme_support( 'core-block-patterns' );
	} );
	add_action( 'init', $n( 'register_block_patterns' ) );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\setup' );

/**
 * Load block editor scripts.
 */
function block_editor_assets() {
	$prefix         = config()['prefix'];
	$editor_scripts = DIST_PATH . 'editor.js';
	if ( file_exists( $editor_scripts) ) {
		wp_enqueue_script(
			"{$prefix}_editor_js",
			DIST_URI . 'editor.js',
			[
				'wp-i18n',
				'wp-blocks',
				'wp-components',
				'wp-data',
				'wp-editor',
				'wp-element',
				'wp-url',
				'wp-edit-post',
				'wp-dom-ready',
				'wp-api-fetch',
			],
			filemtime( $editor_scripts ),
			true
		);
	}
	$editor_style = DIST_PATH . 'editor-style.css';
	if ( file_exists( $editor_style) ) {
		wp_enqueue_style(
			"{$prefix}_editor_style_css",
			DIST_URI . 'editor-style.css',
			[],
			filemtime( $editor_style )
		);
	}
}

/**
 * Load block scripts for editor and front-end.
 */
function block_assets() {
	$prefix = config()['prefix'];
	$style  = DIST_PATH . 'style.css';
	if ( file_exists( $style) ) {
		wp_enqueue_style(
			"{$prefix}_css",
			DIST_URI . 'style.css',
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
	$config = config();

	foreach ( $config['categories'] as $category ) {
		$categories = array_merge(
			$categories,
			[
				[
					'slug'  => $category['slug'],
					'title' => $category['title'],
					'icon'  => $category['icon'],
				],
			]
		);
	}
	return $categories;
}

/**
 * Register Custom Blocks
 */
function register_custom_blocks() {
	$prefix = config()['prefix'];
	$dirs   = glob( PATH . 'custom-blocks/*', GLOB_ONLYDIR );
	foreach ( $dirs as $dir ) {
		$block  = basename( $dir );
		$json   = trailingslashit( $dir ) . 'block.json';
		$markup = trailingslashit( $dir ) . 'markup.php';
		$script = trailingslashit( $dir ) . 'block.js';
		$style  = trailingslashit( $dir ) . 'style.css';
		$editor = trailingslashit( $dir ) . 'editor-style.css';
		if ( file_exists( $json ) && file_exists( $markup ) && file_exists( $script ) ) {
			$args = [
				'editor_script'   => "{$prefix}_{$block}_editor_script",
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
				$args['style'] = "{$prefix}_{$block}_style";
			}
			if ( file_exists( $editor ) ) {
				$args['editor_style'] = "{$prefix}_{$block}_editor_style";
			}
			register_block_type( $dir, $args );
		}
	}
}

/**
 * Custom Blocks Editor Scripts and Styles.
 */
function custom_blocks_scripts() {
	$prefix = config()['prefix'];
	$dirs   = glob( PATH . 'custom-blocks/*', GLOB_ONLYDIR );
	foreach ( $dirs as $dir ) {
		$block = basename( $dir );

		// Block script.
		$script = DIST_PATH . 'custom-blocks/' . $block . '/block.js';
		if ( file_exists( $script ) ) {
			wp_register_script(
				"{$prefix}_{$block}_editor_script",
				DIST_URI . 'custom-blocks/' . $block . '/block.js',
				[
					'wp-i18n',
					'wp-blocks',
					'wp-components',
					'wp-data',
					'wp-editor',
					'wp-element',
					'wp-url',
					'wp-edit-post',
					'wp-dom-ready',
					'wp-api-fetch',
				],
				filemtime( $script ),
				true
			);
		}

		// Block style.
		$style = trailingslashit( $dir ) . 'style.css';
		if ( file_exists( $style ) ) {
			wp_register_style(
				"{$prefix}_{$block}_style",
				DIST_URI . 'custom-blocks/' . $block . '/style.css',
				[],
				filemtime( $style )
			);
		}

		// Editor style.
		$editor_style = trailingslashit( $dir ) . 'editor-style.css';
		if ( file_exists( $editor_style ) ) {
			wp_register_style(
				"{$prefix}_{$block}_editor_style",
				DIST_URI . 'custom-blocks/' . $block . '/editor-style.css',
				[],
				filemtime( $editor_style )
			);
		}
	}
}

/**
 * Register Block Patterns
 */
function register_block_patterns() {
	$config         = config();
	$category_slug  = $config['pattern_category']['slug'];
	$category_title = $config['pattern_category']['title'];

	// Register pattern category.
	register_block_pattern_category(
		$category_slug,
		[
			'label' => $category_title,
		]
	);

	// Register patterns.
	$files    = glob( PATH . 'block-patterns/*.html' );
	$patterns = [];

	foreach ( $files as $file_path ) {
		if ( ! file_exists( $file_path ) ) {
			continue;
		}

		ob_start();
		include $file_path;
		$content = ob_get_clean();
		$content = str_replace( '{URI}/', URI, $content );
		$name    = basename( $file_path, '.html' );

		register_block_pattern(
			$category_slug . '/' . sanitize_title( $name ),
			[
				'title'      => $name,
				'categories' => [ $category_slug ],
				'content'    => $content,
			]
		);
	}
}
