const {
	blocks: {
		getBlockVariations,
		unregisterBlockVariation,
		unregisterBlockStyle,
		unregisterBlockType,
	},
	domReady,
} = wp;

domReady(() => {
	// Unregister Variations
	const allowedEmbedBlocks = ['youtube'];
	getBlockVariations('core/embed').forEach(function (blockVariation) {
		if (allowedEmbedBlocks.indexOf(blockVariation.name) === -1) {
			unregisterBlockVariation('core/embed', blockVariation.name);
		}
	});
	unregisterBlockVariation('core/group', 'group-row');

	// Unregister Styles
	unregisterBlockStyle('core/image', 'rounded');

	// Unregister Blocks
	unregisterBlockType( 'core/verse' );
	unregisterBlockType( 'core/pullquote' );
	unregisterBlockType( 'core/audio' );
	unregisterBlockType( 'core/video' );
	unregisterBlockType( 'core/file' );
	// Widget
	unregisterBlockType( 'core/archives' );
	unregisterBlockType( 'core/calendar' );
	unregisterBlockType( 'core/rss' );
	unregisterBlockType( 'core/search' );
	unregisterBlockType( 'core/social-links' );
	unregisterBlockType( 'core/social-link' );
	unregisterBlockType( 'core/tag-cloud' );
	unregisterBlockType( 'core/latest-posts' );
	unregisterBlockType( 'core/latest-comments' );
	unregisterBlockType( 'core/categories' );
	unregisterBlockType( 'core/page-list' );
	// Theme
	unregisterBlockType( 'core/navigation' );
	unregisterBlockType( 'core/site-logo' );
	unregisterBlockType( 'core/site-title' );
	unregisterBlockType( 'core/site-tagline' );
	unregisterBlockType( 'core/query' );
	unregisterBlockType( 'core/post-title' );
	unregisterBlockType( 'core/post-excerpt' );
	unregisterBlockType( 'core/post-featured-image' );
	unregisterBlockType( 'core/post-date' );
	unregisterBlockType( 'core/post-author' );
	unregisterBlockType( 'core/post-content' );
	unregisterBlockType( 'core/post-terms' );
	unregisterBlockType( 'core/post-navigation-link' );
	unregisterBlockType( 'core/loginout' );
	unregisterBlockType( 'core/post-comments' );
	unregisterBlockType( 'core/term-description' );
	unregisterBlockType( 'core/query-title' );
});
