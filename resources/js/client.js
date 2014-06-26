/**
 * 
 */
$(document).ready(function(){
	
	var initialize = function initialize() {
	    var input = document.getElementById('txb_address');
	    new google.maps.places.Autocomplete(input);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	
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
});
