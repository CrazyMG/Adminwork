$(document).ready(function(){

	$('#newUser_dialog').bootstrapValidator({
		message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
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
            surname: {
                validators: {
                    notEmpty: {
                        message: 'The surname is required and cannot be empty'
                    },
                    regexp: {
                    	regexp: /^[a-zèéòì'\s]+$/i,
                    	message: 'The name can consist of alphabetical characters'
                    }
                }
            },
            pwd: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    different: {
                        field: 'name',
                        message: 'The password cannot be the same as name'
                    },
                    stringLength: {
                    	min: 8,
                        max: 20,
                        message: 'The password must be beetwen 8 and 20 characters'
                    }
                }
            },
            pwd2: {
            	validators: {
            		notEmpty: {
            			message: 'The confirm password is required and cannot be empty'
            		},
            		identical: {
                        field: 'pwd',
                        message: 'The password and its confirm are not the same'
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
            		},
            		remote: {
                        message: 'The email is not available',
                        url: '/src/ajaxManager.php',
                        data: {
                            type: 'email'
                        }
                    }
            	}
            }
        }
	});
	
	
	/**
	 * Handling of the button "Create User".
	 */
	$('#btn_newUser').on('click', function(){
		$('#newUser_dialog').dialog({
			title: 'Create new user',
			height: 'auto',
			width: 'auto',
			draggable: false,
			resizable: false,
			modal : true,
			buttons:{
				"Create": function(){
					var isActive = false;
					if($('#chk_isActiveUser').prop('checked')) isActive=1;
					var data = {
							name: $('#txb_name').val(),
							surname: $('#txb_surname').val(),
							password: $('#txb_pwd').val(),
							email: $('#txb_email').val(),
							thumbnail: $('#thumbnail').val(),
							role: $('#sel_role').val(),
							isActive: isActive
						};
					$.ajax({
						type: "POST",
						url: "/users/add/",
						data: data,
						success: function(response){
							console.log(response);
						}
					});
				},
				"Cancel": function(){
				}
			}
		});
	});
	
//	/**
//	 * Handling of the button "Edit".
//	 */
//	$('button[id^=btn_edit]').on('click', function(){
//		$('#editUser_dialog').dialog({
//			title: 'Create new user',
//			height: 'auto',
//			width: 'auto',
//			draggable: false,
//			resizable: false,
//			modal : true
//		});
//	});
});