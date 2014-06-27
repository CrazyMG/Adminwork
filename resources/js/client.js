/**
 * 
 */
$(document).ready(function(){
	
	var initialize = function initialize() {
	    var input = document.getElementById('txb_address');
	    new google.maps.places.Autocomplete(input);
	}
	var geocoder = new google.maps.Geocoder();
	google.maps.event.addDomListener(window, 'load', initialize);
	
	var clientId = $(location).attr('href').split("/")[4];
	
	$('#btn_addContact').on('click', function(){
		$('#newContact_dialog').dialog({
			title: 'Create new contact',
			height: 'auto',
			width: 'auto',
			draggable: false,
			resizable: false,
			modal : true
		});
	});
	
	$('#newContact_dialog').bootstrapValidator({
		message: 'This value is not valid',
		submitHandler: function(validator, form, submitButton) {
			var latitude = 0;
			var longitude = 0;
			if($('#txb_address').val()){
				geocoder.geocode({
					'address' : $('#txb_address').val()
				},function(results,status) {
					if (status == google.maps.GeocoderStatus.OK) {
						latitude = results[0].geometry.location.lat();
						longitude = results[0].geometry.location.lng();
						var data = {
								referent: $('#txb_referent').val(),
								email: $('#txb_email').val(),
								phone: $('#txb_phone').val(),
								fax: $('#txb_fax').val(),
								address: $('#txb_address').val(),
								latitude: latitude,
								longitude: longitude,
								clientId: clientId
							};
						$.ajax({
							type: "POST",
							url: "/client/contact/add/",
							data: data,
							success: function(response){
								location.reload();
							}
						});
					}
				});
			}
		},
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        live: 'enabled',
        fields: {
        	referent: {
                validators: {
                    notEmpty: {
                        message: 'The referent is required and cannot be empty'
                    },
                    regexp: {
                    	regexp: /^[a-zèéòì\s]+$/i,
                    	message: 'The referent can consist of alphabetical characters and spaces only'
                    }
                }
            },
            email: {
            	validators: {
            		emailAddress: {
                        message: 'The value is not a valid email address'
                    },
            		notEmpty: {
            			message: 'The email is required and cannot be empty'
            		}
            	}
            }
        }
	});
});
