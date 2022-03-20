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

<div class="fxbb-alertbox-block <?php echo esc_attr( $attributes['className'] ); ?>">
	<?php echo wp_kses_post( wpautop( $attributes['text'], true ) ); ?>
</div>
