const {
	blocks: { registerBlockStyle },
	domReady,
} = wp;

function registerImageStyles() {
	registerBlockStyle('core/image', {
		name: 'slightly-rounded',
		label: 'Slightly Rounded',
	});
}

domReady(() => {
	registerImageStyles();
});
