/**
 * WordPress dependencies
 */
const {
	i18n: { __ },
	element: { Fragment },
	blockEditor: { RichText, useBlockProps, InspectorControls },
	components: { TextareaControl, PanelBody, PanelRow },
} = wp;
const ServerSideRender = wp.serverSideRender || wp.components.ServerSideRender;

/**
 * Block Edit Component
 */
const BlockEdit = ({
	attributes,
	attributes: { text },
	setAttributes,
}) => {
	const blockProps = useBlockProps();

	return (
		<Fragment>
			<div {...blockProps}>
				<ServerSideRender
					block="fxbb/alert-box"
					attributes={ attributes }
				/>
			</div>
			<InspectorControls>
				<PanelBody
					title={__('Block Settings', 'fxbb')}
					initialOpen={ true }
				>
					<PanelRow>
						<TextareaControl
							label={__('Alert text', 'fxbb')}
							help={__('Add your alert text here.', 'fxbb')}
							placeholder={__('Add alert here...', 'fxbb')}
							value={ text }
							onChange={ ( text ) => setAttributes( { text } ) }
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
		</Fragment>
	);
};

export default BlockEdit;
