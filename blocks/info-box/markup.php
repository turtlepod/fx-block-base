<?php
/**
 * Example block markup
 */

// Set defaults.
$attributes = wp_parse_args(
	$args['attributes'] ?? [],
	[
		'className' => '',
		'text'      => '',
	]
);
?>

<div class="fxbb-infobox-block <?php echo esc_attr( $attributes['className'] ); ?>">
	<p><?php echo wp_kses_post( $attributes['text'] ); ?></p>
</div>
