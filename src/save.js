/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
export default function save() {
	return (
		<div { ...useBlockProps.save() }>
		<div id="cpj_contact_form_error_response_block"></div>
<div id="contact-form-block">
	<div className="contact-form-row">
		<label htmlFor="contact-form-name" className="contact-form-label">
			{'Name:'}
		</label>
		<div className="contact-form-input">
			<input type="text" name="contact-form-name" id="contact-form-name" />
		</div>
	</div>
	<div className="contact-form-row">
		<label htmlFor="contact-form-email" className="contact-form-label">
			{'E-mail:'}
		</label>
		<div className="contact-form-input">
			<input type="text" name="contact-form-email" id="contact-form-email" />
		</div>
	</div>
	<div className="contact-form-row">
		<label htmlFor="contact-form-phone" className="contact-form-label">
			{'Phone:'}
		</label>
		<div className="contact-form-input">
			<input type="text" name="contact-form-phone" id="contact-form-phone" />
		</div>
	</div>
	<div className="contact-form-row">
		<label htmlFor="contact-form-pref-method" className="contact-form-label-pcm">
			Preferred Contact Method:
		</label>
		<div className="contact-from-input">
			<select name="contact-form-pref-method" id="contact-form-pref-method" className="">
				<option value="Call">Call</option>
				<option value="Text">Text</option>
				<option selected="yes" value="E-mail">E-mail</option>
			</select>
		</div>
	</div>
	<div className="contact-form-row">
			<div>
			<label htmlFor="contact-form-message" className="contact-form-label-message">
				Message:
			</label>
			</div>
			<div>
				<textarea name="contact-form-message" id="contact-form-message"></textarea>
			</div>
	</div>
	<div className="contact-form-row">
		<div className="cpj-contact-form-submit-btn-block">
			<button id="cpj-contact-form-send-btn1" style={{ textAlign: 'center' }} >
			Send</button>
		</div>
	</div>
</div>


</div>
	);
}
