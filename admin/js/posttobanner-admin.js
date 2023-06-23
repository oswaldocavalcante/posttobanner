(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function ($) {
		// on upload button click
		$('body').on('click', '.rudr-upload', function (event) {
			event.preventDefault(); // prevent default link click and page refresh

			const button = $(this)
			const imageId = button.next().next().val();

			const customUploader = wp.media({
				title: 'Selecionar logotipo', // modal window title
				library: {
					// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
					type: 'image'
				},
				button: {
					text: 'Inserir logotipo' // button label text
				},
				multiple: false
			}).on('select', function () { // it also has "open" and "close" events
				const attachment = customUploader.state().get('selection').first().toJSON();
				button.removeClass('button').html('<img src="' + attachment.url + '">'); // add image instead of "Upload Image"
				button.next().show(); // show "Remove image" link
				button.next().next().val(attachment.id); // Populate the hidden field with image ID
			})

			// already selected images
			customUploader.on('open', function () {

				if (imageId) {
					const selection = customUploader.state().get('selection')
					attachment = wp.media.attachment(imageId);
					attachment.fetch();
					selection.add(attachment ? [attachment] : []);
				}

			})

			customUploader.open()

		});
		// on remove button click
		$('body').on('click', '.rudr-remove', function (event) {
			event.preventDefault();
			const button = $(this);
			button.next().val(''); // emptying the hidden field
			button.hide().prev().addClass('button').html('Enviar imagem'); // replace the image with text
		});
	});
	

})( jQuery );
