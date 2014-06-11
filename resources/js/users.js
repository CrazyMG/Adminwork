$(document).ready(function(){
	
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
					$.ajax({
						var data = {
								action : "createUser",
								name : $('#tbx_name').val(),
								surname : $('#tbx_surname').val(),
								password :$('#tbx_pwd_id').val(),
						}
					});
				},
				"Cancel": function(){
				}
			}
		});
	});
	
	$('#txb_name').on('blur', function(){
		$('#nameError').html('');
		var name = $(this).val();
		var nameRegex = "^[a-zA-Z'òèé -]+$";
		if(name == ''){
			$('#nameError').html('The name is required.').addClass('error');
		}else if(name.match(nameRegex) == null){
			$('#nameError').html('The name must consist of letters').addClass('error');
		}else{
			$('#nameError').html('');
		}
	});
	
	$('#txb_surname').on('blur', function(){
		$('#surnameError').html('');
		var surname = $(this).val();
		var surnameRegex = "^[a-zA-Z'òèé -]+$";
		if(surname == ''){
			$('#surnameError').html('The surname is required.').addClass('error');
		}else if(surname.match(surnameRegex) == null){
			$('#surnameError').html('The surname must consist of letters').addClass('error');
		}else{
			$('#surnameError').html('');
		}
	});
	
	$('#txb_pwd_id').on('blur', function(){
		var pwd = $(this).val();
		if(pwd.length < 8){
			$('#pwdError').html('The password must be almost 8 characters.').addClass('error');
		}else{
			$('#pwdError').html('');
		}
	});
	
	$('#txb_pwd2').on('blur', function(){
		if($('#txb_pwd_id').val() != $(this).val()){
			$('#pwd2Error').html('The passwords mismatch.').addClass('error');
		}else{
			$('#pwd2Error').html('');
		}
	});
});