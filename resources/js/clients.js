$(document).ready(function(){

	var initialize = function initialize() {
	    var input = document.getElementById('txb_address');
	    new google.maps.places.Autocomplete(input);
	}
	var geocoder = new google.maps.Geocoder();
	google.maps.event.addDomListener(window, 'load', initialize);
	
	$('#newClient_dialog').bootstrapValidator({
		message: 'This value is not valid',
		submitHandler: function(validator, form, submitButton) {
			if($('#txb_address').val()){
				geocoder.geocode({
					'address' : $('#txb_address').val()
				},function(results,status) {
					if (status == google.maps.GeocoderStatus.OK) {
						latitude = results[0].geometry.location.lat();
						longitude = results[0].geometry.location.lng();
						var data = {
								name: $('#txb_name').val(),
								email: $('#txb_email').val(),
								description: $('#tarea_description').val(),
								address: $('#txb_address').val(),
								latitude: latitude,
								longitude: longitude,
								phone: $('#txb_phone').val(),
								fax: $('#txb_fax').val(),
								website: $('#txb_website').val()
							};
						console.log(data);
						$.ajax({
							type: "POST",
							url: "/clients/add/",
							data: data,
							success: function(response){
								console.log(response);
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
        	name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required and cannot be empty'
                    },
                    regexp: {
                    	regexp: /^[a-zè.éòì\s]+$/i,
                    	message: 'The name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            website: {
                validators: {
                	uri: {
                        message: 'The website address is not valid'
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
	
	/**
	 * Handling of the button "Create User".
	 */
	$('#btn_newClient').on('click', function(){
		$('#newClient_dialog').dialog({
			title: 'Create new user',
			height: 'auto',
			width: 'auto',
			draggable: false,
			resizable: false,
			modal : true
		});
	});
});