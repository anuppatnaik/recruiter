//tracks the current page in view/visible
var currPg = "pg-home";

//fires on creation of DOM. all element (img) may not have been loaded
$(function () { 
    'use strict';

    $('#fileupload').fileupload({
		url: '/lib/s3/'
    });
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload('option', {
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
    	// Enable iframe cross-domain access via redirect option:
        'redirect': window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        ),
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(pdf|doc|docx)$/i,
        dropZone: $('#pg-upload'),
        pasteZone: null,
        limitConcurrentUploads:3,

    });

	//bind events	
	//left menu click events to change view on click
	$('ul.nav#top-menu > li > a').click(function(){ 
		//function to switch view between pages
		//remove highlighting of all links in nav
		$('ul.nav > li').removeClass("active");
		//add highlighting to the link clicked
		$(this).parent().addClass("active");
		//hide the old page
		$('#' + currPg).hide();
		currPg = "pg-" + $(this).attr("href").substring(1);
		//show the clicked page
		$('#' + currPg).show();
	}); //end of switch view fn
    $('#hide-search-hlp').click(function(){
        $('#search-hlp').hide();
        return false;
    });

}); //end of document ready

getAllFiles = function() {

//get all files    
$.ajax({
    // Uncomment the following to send cross-domain cookies:
    //xhrFields: {withCredentials: true},
    url: $('#fileupload').fileupload('option', 'url'),
    dataType: 'json',
    context: $('#fileupload')[0]
    }).done(function (result) {
	$(this).fileupload('option', 'done')
    	.call(this, null, {result: result});
   	});

}

//util function. TBD - place in a util file
getGoogleViewerLink = function(url) {
	var baseUrl = " http://docs.google.com/viewer";
	return baseUrl + "?url=" + encodeURIComponent(url);
}//end of getGoogleViewerLink
