//tracks the current page in view/visible
var currPg = "pg-home";
var o = {
    //stores array of candidates found as a result of search
    candidates : {},
};

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

    //bind carriage return to search on search box
    $('#search-box').keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
           search();
           e.preventDefault();
        }//end of if key 13    
    });
    //bind click of search icon to search method
    $('#search-icon > a').click(function(){
        search();
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

search = function() {

            var queryStr = $('#search-box').val();
            //can convert into ORM style later. e.g. candidate.search
            var searchJSON = {
               fields : ["filename", "title", "url", "key", "date", "keywords", "content-type"],
               query : {
                  term : {
                     _all : queryStr
                  }
               },
               highlight : {
                    pre_tags : ['** '],
                    post_tags : [' **'],
                    fields : {
                        file : { term_vector : "with_positions_offsets", 
                                fragment_size : 150 }
                    }
               }
            };
        // --- Not a good place to put constants
        var ES_ENDPOINT = "http://54.251.251.101:9200/";
        var ES_INDEX = "rdb-test/";
        var ES_TYPE = "candidate/";

         $.ajax({
                    type: "POST",
                    url: ES_ENDPOINT+ES_INDEX+ES_TYPE+"_search",
                    data: JSON.stringify(searchJSON),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(data) {
                            var msg = "";
                            if(tmpl) {
                                var func = tmpl('template-search-results');
                                msg = data['hits']['total'] + " person" +
                                ((parseInt(data['hits']['total']) === 1)? "" : "s") +
                                " found in " + data['took'] + " milli seconds";
                                //hold the search results
                                o['candidates'] = data['hits']['hits'];
                                var result = func({
                                    candidates: o['candidates'],
                                });
                                //TBD - better error handling. results
                                //var may not be in well formed HTML
                                $('#search-results').html("");
                                $('<div>' + result + '</div>').appendTo('#search-results');
                            }
                            else {
                                console.log('Error: Templating not available. Cannot paint results.');
                                msg = "Something has gone wrong. Sorry!";
                            }
                            $("div#search-hlp > blockquote").html(msg);
                    },
                    error: function(request, status, error) {
                        //handle error better
                        console.log('Oops we are so sorry, something seems to have gone wrong');
                    }
                });

} //end of search

