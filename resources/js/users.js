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
				"Create":{
					// TODO
				}
			}
		});
	});
});