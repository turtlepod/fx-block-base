<?php
/**
 * Example block markup
 */

// Set defaults.
$attributes = wp_parse_args(
	$args['attributes'] ?? [],
	[
		'text' => '',
	]
);
?>

<div class="fxbb-alertbox-block <?php echo esc_attr( isset( $attributes['className'] ) ? $attributes['className'] : '' ); ?>">
	<?php echo wp_kses_post( wpautop( $attributes['text'], true ) ); ?>
</div>
