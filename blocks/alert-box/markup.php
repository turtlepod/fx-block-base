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
	<p class="fxbb-alertbox-block__description">
		<?php echo wp_kses_post( $attributes['text'] ); ?>
	</p>
</div>
