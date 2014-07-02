/**
 * 
 */
$(document).ready(function(){
	
	var initialize = function initialize() {
		var lat = $('#latitude').val();
		var lng = $('#longitude').val();
	    var input = document.getElementById('txb_address');
	    new google.maps.places.Autocomplete(input);
	    var myLatlng = new google.maps.LatLng(lat,lng);
	    var mapOptions = {
	      zoom: 12,
	      center: myLatlng
	    }
	    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	    var marker = new google.maps.Marker({
	        position: myLatlng,
	        map: map
	    });
	}
	var geocoder = new google.maps.Geocoder();
	
	google.maps.event.addDomListener(window, 'load', initialize);
	
	var clientId = $(location).attr('href').split("/")[4];
	
	$(function() {
		$('#project_startDate').datepicker({minDate: 0, dateFormat: 'yy-mm-dd'});
		$('#project_endDate').datepicker({minDate: 0, dateFormat: 'yy-mm-dd'});
		$( "#accordion" ).accordion({
			collapsible: true
		});
		$( "#usersAvailable, #userAssigned" ).sortable({
		      connectWith: ".connectedSortable"
		    }).disableSelection();
	});
	
	$('#btn_addProject').on('click', function(){
		$('#newProject_dialog').dialog({
			title: 'Create new project',
			height: 'auto',
			width: 'auto',
			draggable: false,
			resizable: false,
			modal : true
		});
	});
	
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
	
	$('#newProject_dialog').bootstrapValidator({
		message: 'This value is not valid',
		submitHandler: function(validator, form, submitButton) {
			var usersAssigned = [];
			$('#userAssigned li').each(function(){
				usersAssigned.push($(this).attr('rel'));
			});
			var startDate = null;
			if($('#project_startDate').val() == ""){
				startDate = new Date();
				startDate= (startDate.getFullYear() + '-' + (startDate.getMonth()+1) + '-' + startDate.getDate());
			}
			var data = {
				name: $('#project_name').val(),
				description: $('#project_description').val(),
				startDate: startDate,
				endDate: $('#project_endDate').val(),
				url: $('#project_url').val(),
				note: $('#project_note').val(),
				projectLeader: $('#project_leader').val(),
				usersAssigned: usersAssigned,
				clientId: clientId
			};
			console.log(data);
			$.ajax({
				type: "POST",
				url: "/projects/add/",
				data: data,
				success: function(response){
				location.reload();
				}
			});
		},
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        live: 'enabled',
        fields: {
        	project_name: {
                validators: {
                    notEmpty: {
                        message: 'The project\'s name is required and cannot be empty'
                    },
                    regexp: {
                    	regexp: /^[a-zèéòì\s]+$/i,
                    	message: 'The project\'s name can consist of alphabetical characters and spaces only'
                    }
                }
            },
            project_url: {
            	validators: {
            		uri: {
                        message: 'The url address is not valid'
                    }
            	}
            }
        }
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
