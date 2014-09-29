
$("#changeThemeButton").click(function() {
	$('#changeThemeModal').modal('show');
});

$("#changeThemeInput").change(function() {
	var requested = $(this).val();
	$("#bootstrapsource").attr("href", "assets/css/bootstrap/" + requested + ".css");
});

$("#saveTheme").click(function() {
	var userid = parseInt($("#changeTheme-userid").val());
	var requestedtheme = $("#changeThemeInput").val();
	
	console.log(userid + " wants " + requestedtheme + " theme");
	
	$.ajax({
		type: "POST",
		url: "controllers/controller_administrator.php",
		data: {
			controllerType: "changeTheme",
			userid: userid,
			theme: requestedtheme
		},
		dataType: "json",
		success: function (data) {
			showAlertBox("Changed theme successfully.", "success", 3);
			$("#changeThemeModal").modal('hide');
		},
		error: function (data) {
			showAlertBox("Error changing theme.", "danger", 3);
		}
	});
});

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