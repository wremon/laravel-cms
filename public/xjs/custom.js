jQuery( document ).ready( function(){
	"use strict";

	jQuery('a[data-effect="toggle"]').on('click', function(){
		jQuery('tr.' + jQuery(this).attr('data-target')).addClass('opened').slideToggle();
	});

	jQuery("input#file-upload").change(function(){
		readURL(this);
	});


} );

function readURL(input) {
	"use strict";

	if (input.files && input.files[0]) {
		var reader = new FileReader();

		
		reader.onload = function (e) {
			jQuery('#upload-image-preview').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}



function handleFileSelect(evt) {
	var attachments = evt.target.files; // FileList object

	// Loop through the FileList and render image attachments as thumbnails.
	for (var i = 0, f; f = attachments[i]; i++) {

		// Only process image attachments.
		// if (!f.type.match('image.*')) {
		// //continue;
		// }

		var reader = new FileReader();

		// Closure to capture the file information.
		reader.onload = (function(attachment) {
		return function(e) {

			// Render thumbnail.
			var span = document.createElement('span');
			if (attachment.type.match('image')){
				span.innerHTML = ['<div class="thumb"><img class="img-polaroid image" src="', e.target.result,
								'" title="', escape(attachment.name), '"/>',
								'<strong class="file-name">', escape(attachment.name), '</strong></div>'].join('');
			}else{
				span.innerHTML = ['<div class="thumb"><i class="icon icon-file"></i>',
								'<strong class="file-name">', escape(attachment.name), '</strong></div>'].join('');

			}
			document.getElementById('attachments-list').insertBefore(span, null);
		};
		})(f);

		// Read in the image file as a data URL.
		reader.readAsDataURL(f);
	}
}

document.getElementById('multiple-file-upload').addEventListener('change', handleFileSelect, false);