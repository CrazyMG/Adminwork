$(document).ready(function(){

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
});