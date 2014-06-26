$(document).ready(function(){

	$('#newClient_dialog').bootstrapValidator({
		message: 'This value is not valid',
		submitHandler: function(validator, form, submitButton) {
			var data = {
					name: $('#txb_name').val(),
					description: $('#tarea_description').val(),
					website: $('#txb_website').val()
				};
			$.ajax({
				type: "POST",
				url: "/clients/add/",
				data: data,
				success: function(response){
					console.log(response);
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
        	name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required and cannot be empty'
                    },
                    regexp: {
                    	regexp: /^[a-zèéòì\s]+$/i,
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