/**
 * WordPress dependencies
 */
const {
	i18n: { __ },
	element: { Fragment },
	blockEditor: { RichText, useBlockProps },
} = wp;

/**
 * Block Edit Component
 */
const BlockEdit = ({
	attributes: { text },
	setAttributes,
}) => {
	const blockProps = useBlockProps({ className: 'fxbb-infobox-block' });

	return (
		<Fragment>
			<div {...blockProps}>
				<RichText
					className="fxbb-infobox-block__description"
					tagName="p"
					placeholder={__('Description here…', 'fxbb')}
					keepPlaceholderOnFocus="true"
					value={text}
					onChange={(text) => setAttributes({ text })}
				/>
			</div>
		</Fragment>
	);
};

export default BlockEdit;
