/**
 * WordPress dependencies
 */
const {
	i18n: { __ },
	blocks: { registerBlockType },
	blockEditor: { RichText },
	domReady,
} = wp;

/**
 * Internal dependencies
 */
import edit from './edit';
import block from './block.json';

/* Uncomment for CSS overrides in the admin */
// import './index.css';

/**
 * Register block
 */
domReady(function () {
	registerBlockType(block.name, {
		title: __('CTA - Complete', 'gutenberg-lessons'),
		description: __('Complete version of the CTA block', 'gutenberg-lessons'),
		edit,
		save: () => null,
	});
});
