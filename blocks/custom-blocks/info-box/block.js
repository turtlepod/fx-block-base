/**
 * WordPress dependencies
 */
const {
	blocks: { registerBlockType, registerBlockStyle },
	domReady,
} = wp;

/**
 * Internal dependencies
 */
import edit from './edit';
import block from './block.json';

/**
 * Register block
 */
domReady(function () {
	registerBlockType(block.name, {
		title: block.title,
		description: block.description,
		edit,
		save: () => null,
	});
	registerBlockStyle(block.name, {
		name: 'round-corner',
		label: 'Round corner',
	});
});
