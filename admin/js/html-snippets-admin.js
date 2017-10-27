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

jQuery(document).ready(function($) {
	 // Click the insert snippet button
	 $("#insert-snippet-button").click(function(){

		var snippetId = $("#snippet-listing").val();

		if (snippetId==0) {
			alert('Select a snippet from the dropdown before clicking the "Insert" button.');
		} else {

			var data = {
				action: 'load_snippet_content',
				snippet_id: snippetId
			};

			$.post(ajaxurl, data, function(response) {
				response = eval('(' + response + ')');

				if (response.result!='success') {
					alert("Unexpected error attempting to insert snippet: " + response.result);
				} else {
					var content = $("<div/>").html(response.content).text();  // HTML decode

				    if (jQuery("#wp-content-wrap").hasClass("tmce-active")){
						tinyMCE.activeEditor.focus();
				        var startinContent = tinyMCE.activeEditor.getContent();
						tinyMCE.activeEditor.setContent(tinyMCE.activeEditor.getContent() + content);
				    }else{
				        var startingContent = jQuery('.wp-editor-container textarea.wp-editor-area').html();
						jQuery('.wp-editor-container textarea.wp-editor-area').html( startingContent + content )
				    }

					//TODO: egf - only appends to the end, only adds if you select the text area first in Visual editor
				}
			});
		}
		return false;
	});
});

})( jQuery );
