
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

$("#changePasswordButton").click(function() {
	$('#changePasswordModal').modal('show');
});

$("#savePasswordChange").click(function(e) {
    e.preventDefault();
    var newpassword1 = $("#newPassword1").val();
    var newpassword2 = $("#newPassword2").val();
    
    if (newpassword1 !== "" || newpassword2 !== "") {
        if (newpassword1 === newpassword2) {
            $.post("controllers/controller_administrator.php", { controllerType : "changePassword", newpassword : newpassword1}, 
            function(data) {
                showAlertBox(data, "success", 3);
                $('#changePasswordModal').modal('hide');
            });
        }
        else {
            showAlertBox("Passwords do not match.", "danger", 3);
        }
    }
    else {
        showAlertBox("Password field cannot be empty.", "danger", 3);
    }
    
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

function isExpired(input_date) {
    var current_date = Math.round(new Date().getTime() / 1000);
    var compare_date = parseInt(input_date);

    if (current_date > input_date) {
        return true;
    }
    else {
        return false;
    }
}

function dateConverterToNiceNoTime(unix_timestamp) {
    var date = new Date(unix_timestamp*1000);
    var month = date.getMonth() + 1;
    var dayt = date.getDate();
    var year = date.getFullYear();

    // will display time in 10:30:23 format
    var formattedTime = month + "/" + dayt + "/" + year;
    return formattedTime;
}

function getRegularDate(unix_timestamp) {
    var date = new Date(unix_timestamp*1000);
    var month = date.getMonth() + 1;
    var dayt = date.getDate();
    var year = date.getFullYear();

    // will display time in 10:30:23 format
    var formattedTime = month + "/" + dayt + "/" + year;
    return formattedTime;
}

function getTimeStamp(value) {
    var timestamp = Math.round(Date.parse(value) / 1000);
    return timestamp;
}

function htmlDecode(input){
    var e = document.createElement('div');
    e.innerHTML = input;
    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}

function showAlertBox(message, type, seconds) {
	var millis = seconds * 1000;
	
	if (message === "") {
		message = "Error.";
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