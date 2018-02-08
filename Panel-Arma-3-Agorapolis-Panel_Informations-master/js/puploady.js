/*
	pUploady by orugari
	http://puploady.orugari.fr
	License: ttp://puploady.orugari.fr/license.php
	v1.1.0
*/

(function($) {

    $.fn.puploady = function(options) {
		
        var settings = $.extend({
            file         : 'upload.php',
            callback     : true
        }, options);

$(this).on('submit', function(event){
	event.preventDefault();
	$(this).after('<div id="blackback"><progress id="thebar" value="0"></progress> <span id="pup_cancel"><img src="images/cancel.png" alt="cancel" /></a></div>');
	
	var form = $(this);
    var formdata = false;
    var formAction = form.attr('action');
    
    	 
	$("#blackback").css({
      "background-color": "rgba(0,0,0,0.7)",
      "width": "100%",
      "height": "100%",
      "position": "fixed",
      "text-align": "center",
      "top": "0",
      "left": "0",
      "display": "none"
    });
    $("#thebar").css({
      "width": "30%",
      "z-index": "100",
      "margin-top": "20%"
    });
    $("#pup_cancel img").css({
      "cursor": "pointer",
      "vertical-align": "middle",
      "padding-bottom": "2px"
    });
    $('#blackback').fadeIn();
    
    if (window.FormData){
        formdata = new FormData(form[0]);
    }
     var theax = $.ajax({
            xhr: function() {
			myXhr = $.ajaxSettings.xhr();
			if(myXhr.upload){
			myXhr.upload.addEventListener('progress',progressDisplay, false);
			}
			return myXhr;
			},
        url         : settings.file,
        data        : formdata ? formdata : form.serialize(),
        cache       : false,
        contentType : false,
        processData : false,
        type        : 'POST',
        success     : function(data, textStatus, jqXHR){

			if ( settings.callback ) {
				$('#blackback').fadeOut(function(){ alert(data);});
			}
           else
			{
	            $('#blackback').fadeOut();
			}  
        }
    });
    
    $("#pup_cancel").click(function() {
        theax.abort();
        $('#blackback').fadeOut();
        
    })
     
function progressDisplay(e){
	if(e.lengthComputable){
		$('#thebar').attr({value:e.loaded,max:e.total});
	}
	}
});

}

}(jQuery));


