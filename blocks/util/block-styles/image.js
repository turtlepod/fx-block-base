const {
	blocks: { registerBlockStyle },
	domReady,
} = wp;

domReady(() => {
	registerBlockStyle('core/image', {
		name: 'slightly-rounded',
		label: 'Slightly Rounded',
	});
});
