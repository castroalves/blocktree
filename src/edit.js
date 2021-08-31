/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";
import {
	TextControl,
	CheckboxControl,
	BaseControl,
	Placeholder,
	Panel,
	PanelBody,
	PanelRow,
} from "@wordpress/components";
import { Fragment } from "@wordpress/element";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import {
	useBlockProps,
	ColorPalette,
	InspectorControls,
} from "@wordpress/block-editor";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const onChangeBgColor = (hexColor) => {
		setAttributes({ linkBgColor: hexColor });
	};

	const onChangeTextColor = (hexColor) => {
		setAttributes({ linkTextColor: hexColor });
	};

	return (
		<div {...useBlockProps()}>
			<Fragment>
				<InspectorControls key="setting">
					<Panel>
						<PanelBody title={__("Color", "blocktree")} initialOpen={true}>
							<PanelRow>
								<BaseControl label={__("Background Color", "blocktree")}>
									<ColorPalette onChange={onChangeBgColor} />
								</BaseControl>
							</PanelRow>
							<PanelRow>
								<BaseControl label={__("Text Color", "blocktree")}>
									<ColorPalette onChange={onChangeTextColor} />
								</BaseControl>
							</PanelRow>
						</PanelBody>
					</Panel>
				</InspectorControls>
			</Fragment>
			<Placeholder
				style={{
					backgroundColor: attributes.linkBgColor,
					color: attributes.linkTextColor,
				}}
			>
				<div
					style={{
						display: "flex",
						flexDirection: "column",
					}}
				>
					<TextControl
						label={__("Link Title", "blocktree")}
						value={attributes.linkTitle}
						onChange={(val) => setAttributes({ linkTitle: val })}
					/>
					<TextControl
						label={__("Link URL", "blocktree")}
						value={attributes.linkUrl}
						onChange={(val) => setAttributes({ linkUrl: val })}
					/>
					<CheckboxControl
						label={__("Open in a new tab")}
						value={attributes.linkTarget}
						onChange={(val) => setAttributes({ linkTarget: val })}
					/>
				</div>
			</Placeholder>
		</div>
	);
}
