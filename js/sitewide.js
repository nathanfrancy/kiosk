

function showAlertBox(message, type, seconds) {
	var millis = seconds * 1000;
	
	if (message === "") {
		"Error.";
	}
	if (type === "") {
		type = "info";
	}
	if (seconds === "") {
		millis = 3000;
	}
	
	$('#alertBox').html('<div class="alert alert-' + type + '" id="alertBoxBody" role="alert">' + message + '</div>');
	$("#alertBox").fadeIn();
	setTimeout( function(){
		$("#alertBox").fadeOut();
	}, millis );
}