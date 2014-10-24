
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

function dateConverterToNice(unix_timestamp) {
    var date = new Date(unix_timestamp*1000);
    var hours = date.getHours();
    var minutes = "0" + date.getMinutes();
    var seconds = "0" + date.getSeconds();
    var indicator = "AM";
    
    if (hours > 12 && hours < 25) {
        hours = hours - 12;
        indicator = "PM";
    }
    
    var month = date.getMonth() + 1;
    var dayt = date.getDate();
    var year = date.getFullYear();

    // will display time in 10:30:23 format
    var formattedTime = month + "/" + dayt + "/" + year + " " + hours + ':' + minutes.substr(minutes.length-2) + ':' + seconds.substr(seconds.length-2) + " " + indicator;
    return formattedTime;
}

function htmlDecode(input){
    var e = document.createElement('div');
    e.innerHTML = input;
    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}

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