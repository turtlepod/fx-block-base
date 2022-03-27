const {
	blocks: { registerBlockVariation },
	domReady,
} = wp;

const TEMPLATE = [
	['core/column', {}, [
		['core/heading', { level: 3, textAlign: 'center', content: 'Product A' }],
		['core/list', {}],
		['core/buttons', { layout: { type: 'flex', justifyContent: 'center'}}, [
			['core/button', {}],
		]],
	]],
	['core/column', {}, [
		['core/heading', { level: 3, textAlign: 'center', content: 'Product B' }],
		['core/list', {}],
		['core/buttons', { layout: { type: 'flex', justifyContent: 'center'}}, [
			['core/button', {}],
		]],
	]],
	['core/column', {}, [
		['core/heading', { level: 3, textAlign: 'center', content: 'Product C' }],
		['core/list', {}],
		['core/buttons', { layout: { type: 'flex', justifyContent: 'center'}}, [
			['core/button', {}],
		]],
	]],
];

domReady(() => {
	registerBlockVariation('core/columns', {
		name: 'pricing-table',
		title: 'Pricing Table',
		icon: 'money-alt',
		scope: 'inserter',
		attributes: { className: 'fx-pricing-table', example: undefined },
		isActive: ( blockAttributes, variationAttributes ) => blockAttributes.className === variationAttributes.className,
		innerBlocks: TEMPLATE,
	});
});
