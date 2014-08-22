jQuery( document ).ready( function(){
	"use strict";

	jQuery('a[href="#"]').on('click', function(e){
		e.preventDefault();
	});

	jQuery('a[data-effect="toggle"]').on('click', function(){
		jQuery('tr.' + jQuery(this).attr('data-target')).addClass('opened').toggleClass('hide');
	});

	jQuery("input#file-upload").change(function(){
		readURL(this);
	});


	jQuery("button").click(function(event) {
		event.preventDefault();
	});


	jQuery('textarea.editor').each(function(){
		CKEDITOR.replace(jQuery(this).attr('id'));
	});

	if ( jQuery.isFunction(jQuery.fn.colorpicker) ) {
		jQuery('.color-picker').colorpicker();
	};


	//console.log($('#multiple-file-upload').offset().top);


	jQuery('.save-menu').on('click', function(){
		var menu = getChildMenus('1');
		var request = jQuery.ajax({
			headers: {'X-CSRF-Token': csrf},
			url: dashboardUrl+'/menu/'+menuId+'/items',
			type: "POST",
			data: {'menu-items' : menu},
			dataType: "json",
			complete: function(a){
				console.log(a);
				console.log(menu);
				jQuery('#alert-container').html(showAlert('success', 'Menu saved'));
			}
		}); //------
	});

	jQuery('body').on('click', '.menu .item-title', function(){
		jQuery(this).parent('.item-header').siblings('.item-body').slideToggle();
	});

	jQuery('.new-menu').on('click', function(){
		jQuery('ul[data-id="1"]').append('<li class="full-width"><div class=""><div class="box box-info collapsed-box"><div class="box-header"><h3 class="box-title handle ui-sortable-handle">'+menuTitle+'</h3><div class="pull-right box-tools"><a class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></a></div></div><div class="box-body pad" style="display: none;"><div class="form-group row"><div class="col-md-4"><label for="text">'+fieldText+'</label></div><div class="col-md-8"><input class="form-control" name="text[]" type="text"></div></div><div class="form-group row"><div class="col-md-4"><label for="link">'+fieldLink+'</label></div><div class="col-md-8"><input class="form-control" name="link[]" type="text"></div></div><div class="form-group row"><div class="col-md-4"><label for="class">'+fieldClass+'</label></div><div class="col-md-8"><input class="form-control" name="class[]" type="text"></div></div><div class="row"><div class="form-group col-md-6"><div class="row"><div class="col-md-4"><label for="rel">'+fieldRel+'</label></div><div class="col-md-8"><input class="form-control" name="rel[]" type="text"></div></div></div><div class="form-group col-md-6"><div class="row"><div class="col-md-4"><label for="target">'+fieldTarget+'</label></div><div class="col-md-8">'+fieldTargetElement+'</div></div></div></div></div></div></div></li>');
	});

	/*jQuery('li.menu').mouseenter(function() {
		if (jQuery(this).find('> .submenu').has('li')){
			jQuery(this).find('> .submenu').slideDown();
			alert('asd');
		}
	}).mouseleave(function(){
		if (jQuery(this).find('> .submenu > li').length == 0){
			jQuery(this).find('> .submenu').slideUp();
		}
	});*/

	/*jQuery('li.menu').on({
		mouseenter: function(){
			// console.log(jQuery(this).find('> .submenu').children('li.menu').length);
			if (jQuery(this).find('> .submenu').has('li.menu')){
				jQuery(this).find('> .submenu').slideDown();
			}
		},
		mouseleave: function(){
			if (jQuery(this).find('> .submenu > li').length == 1){
				jQuery(this).find('> .submenu').slideUp();
			}
		}
	});*/

});

function getChildMenus(selector){
	var menu = [];
	jQuery('ul[data-id="'+selector+'"]>li').each(function(){
		var item = 
		{
			'text' 		: jQuery(this).find('input[name="text[]"]').val(),
			'link' 		: jQuery(this).find('input[name="link[]"]').val(),
			'class' 	: jQuery(this).find('input[name="class[]"]').val(),
			'rel'		: jQuery(this).find('input[name="rel[]"]').val(),
			'target' 	: jQuery(this).find('select[name="target[]"] option:selected').val(),
			'submenu' 	: getChildMenus(jQuery(this).children('ul.submenu').attr('data-id'))
		};
		
		menu.push(item);
	});

	return menu;
}


/*
|--------------------------------------------------------------------------
| Alert
|--------------------------------------------------------------------------
|
| 
|
*/
function showAlert(type, message){
	"use strict";
	return '<div class="alert alert-'+type+' alert-dismissable"><i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+message+'</div>';
}



/*
|--------------------------------------------------------------------------
| Dialog
|--------------------------------------------------------------------------
|
| 
|
*/
jQuery( document ).ready( function(){
	"use strict";

	// Trash post item
	jQuery('a.trash-post-item').on('click', function(){
		var id = jQuery(this).attr('data-id');
		showDialog('#dialog-trash-post', function(){
			var request = jQuery.ajax({
				headers: {'X-CSRF-Token': csrf},
				url: dashboardUrl+'/content/trash',
				type: "POST",
				data: {'post-id' : id},
				dataType: "json",
				complete: function(){
					jQuery('#row-'+id).addClass('text-danger').fadeOut(1000, function(){
						jQuery('#alert-container').html(showAlert('info', 'Post has been moved to trash'));
					});
				}
			});
			jQuery( this ).dialog( "close" );
		});
	});


	// Restore post item
	jQuery('a.restore-post-item').on('click', function(){
		var id = jQuery(this).attr('data-id');
		showDialog('#dialog-restore-post', function(){
			var request = jQuery.ajax({
				headers: {'X-CSRF-Token': csrf},
				url: dashboardUrl+'/content/restore',
				type: "POST",
				data: {'post-id' : id},
				dataType: "json",
				complete: function(){
					jQuery('#row-'+id).addClass('text-danger').fadeOut(1000, function(){
						jQuery('#alert-container').html(showAlert('success', 'Post has been restored'));
					});
				}
			});
			jQuery( this ).dialog( "close" );
		});
	});


	// Permanently delete post item
	jQuery('a.delete-post-item').on('click', function(){
		var id = jQuery(this).attr('data-id');
		showDialog('#dialog-delete-post', function(){
			var request = jQuery.ajax({
				headers: {'X-CSRF-Token': csrf},
				url: dashboardUrl+'/content/delete',
				type: "POST",
				data: {'post-id' : id},
				dataType: "json",
				complete: function(){
					jQuery('#row-'+id).addClass('text-danger').fadeOut(1000, function(){
						jQuery('#alert-container').html(showAlert('info', 'Post has been deleted'));
					});
				}
			});
			jQuery( this ).dialog( "close" );
		});
	});


	// Post type
	jQuery('a.delete-post-type').on('click', function(){
		var id = jQuery(this).attr('data-id');
		showDialog('#dialog-delete-post-type', function(){
			var request = jQuery.ajax({
				headers: {'X-CSRF-Token': csrf},
				url: dashboardUrl+'/settings/post-types/delete',
				type: "POST",
				data: {'post-type' : id},
				dataType: "json",
				complete: function(){
					jQuery('#row-'+id).addClass('text-danger').fadeOut(1000, function(){
						jQuery('#alert-container').html(showAlert('info', 'Post type has been deleted'));
					});
				}
			});
			request.fail(function( jqXHR, textStatus ) {
				console.log(jqXHR);
			});
			jQuery( this ).dialog( "close" );
		});
	});


	// Meta field
	jQuery('a.delete-meta-field').on('click', function(){
		var id = jQuery(this).attr('data-id');
		showDialog('#dialog-delete-post-meta', function(){
			var request = jQuery.ajax({
				headers: {'X-CSRF-Token': csrf},
				url: dashboardUrl+'/settings/post-types/'+postType+'/meta-fields/delete',
				type: "POST",
				data: {'meta-field' : id},
				dataType: "json",
				complete: function(){
					jQuery('#row-'+id).addClass('text-danger').fadeOut(1000, function(){
						jQuery('#alert-container').html(showAlert('info', 'Post type has been deleted'));
					});
				}
			});
			jQuery( this ).dialog( "close" );
		});
	});
});


function showDialog(element, callback){
	"use strict";

	return jQuery(element).dialog({
		resizable: false,
		height: 200,
		modal: true,
		buttons: {
			"Yes": callback,
			Cancel: function() {
				jQuery( this ).dialog( "close" );
			}
		}
	});
}


/*
|--------------------------------------------------------------------------
| Sortable
|--------------------------------------------------------------------------
|
| 
|
*/
jQuery( document ).ready( function(){
	"use strict";

	jQuery('.sortable').sortable({
		handle: '.handle',
		revert: true
	});

	
	jQuery('.sortable-connect').sortable({
		handle: '.handle',
		connectWith: ".sortable-connect",
		items: "li:not(.unsortable)",
		cancel: ".unsortable",
		tolerance: "intersect",
		revert: true,
		start: function() {
			jQuery('.unsortable').animate({
				'height' : 10
			});
		},
		stop: function() {
			jQuery('.unsortable').animate({
				'height' : 0
			});
		}
	});	

	// Menu
	jQuery('a[data-sortable="menus"]').on('click', function(){
		updateSortable(jQuery(this), dashboardUrl+'/menu/reorder');
	});

	// Meta fields
	jQuery('a[data-sortable="post-types"]').on('click', function(){
		updateSortable(jQuery(this), dashboardUrl+'/settings/post-types/reorder');
	});

	// Meta fields
	jQuery('a[data-sortable="fields"]').on('click', function(){
		updateSortable(jQuery(this), dashboardUrl+'/settings/post-types/'+postType+'/meta-fields/reorder');
	});
});


function updateSortable(sortable, url){
	"use strict";

	var target 	= jQuery(sortable).attr('data-sortable'),
		keys 	= [];
	jQuery('[data-sortable-id="'+target+'"]').children().each(function(){
		keys.push(jQuery(this).attr('data-id'));
	});

	var request = jQuery.ajax({
		headers: {'X-CSRF-Token': csrf},
		url: url,
		type: "POST",
		data: {'keys' : keys},
		dataType: "json",
		complete: function(){
			jQuery('#alert-container').html(showAlert('info', 'Order has been saved'));
		}
	});

	request.fail(function( jqXHR, textStatus ) {
		console.log(jqXHR);
	});
}



/*
|--------------------------------------------------------------------------
| Forms
|--------------------------------------------------------------------------
|
| 
|
*/
jQuery( document ).ready( function(){
	"use strict";


	// Post type
	jQuery(document.body).on('click', '.edit-menu', function(){
		var key = jQuery(this).attr('data-id');

		formEdit(
			window.location.pathname+'/edit',
			{'key' : key},
			function(result){
				jQuery('input[name="_id"]').remove();
				jQuery('#form-menu').append('<input name="_id" type="hidden" value="'+result.id+'">');
				jQuery('#form-menu [name="name"]').val(result.name);
				jQuery('#form-menu [name="location"]').val(result.location);
			}
		);
	});


	// Post type
	jQuery(document.body).on('click', '.edit-post-type', function(){
		var key = jQuery(this).attr('data-id');

		formEdit(
			window.location.pathname+'/edit',
			{'key' : key},
			function(result){
				jQuery('#form-post-type').append('<input name="_id" type="hidden" value="'+result.id+'">');
				jQuery('#form-post-type [name="name"]').val(result.name);
				jQuery('#form-post-type [name="slug"]').val(result.slug);
			}
		);
	});


	// Meta field
	jQuery(document.body).on('click', '.edit-meta-field', function(){
		var key = jQuery(this).attr('data-id');

		formEdit(
			window.location.pathname+'/edit',
			{'key' : key, 'post-type' : postType},
			function(result){
				jQuery('#form-meta-field').append('<input name="_id" type="hidden" value="'+result.id+'">');
				jQuery('#form-meta-field [name="text"]').val(result.text);
				jQuery('#form-meta-field [name="type"]').val(result.type);
				jQuery('#form-meta-field [name="description"]').val(result.description);
			}
		);
	});

});


function formEdit(url, data, successCallback){
	var request = jQuery.ajax({
		headers: {'X-CSRF-Token': csrf},
		url: url,
		type: "POST",
		data: data,
		dataType: "json",
		success: successCallback
	});

	request.fail(function( jqXHR, textStatus ) {
		console.log(jqXHR);
	});
}



// ------------------------------------------------------

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
	document.getElementById('attachments-list').innerHTML = "";

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
				span.innerHTML = ['<div class="thumb col-md-3"><img class="img-polaroid image" src="', e.target.result,
								'" title="', escape(attachment.name), '">',
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

//document.getElementById('multiple-file-upload').addEventListener('change', handleFileSelect, false);