
$("#addDepartmentButton").click(function(e) {
	e.preventDefault();
    var name = $("#adddepartment-name").val();
	
	$.ajax({
		type : "POST",
		url : "scripts/controller_administrator.php",
		data : {
			controllerType : "addDepartment",
			name : name
		},
		dataType : "json",
        success : function(data) {
            var department = {
                id : data.id,
                name : data.name
            };
            appendDepartment(department);
            $("#adddepartment-name").val('');
            $('#addDepartmentModal').modal('hide');
            showAlertBox("Added " + department.name + " successfully.", "success", 3);
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});

$("#editDepartmentButton").click(function(e) {
	e.preventDefault();
    var id = parseInt($("#editdepartment-id").val());
    var name = $("#editdepartment-name").val();
	
	$.ajax({
		type : "POST",
		url : "scripts/controller_administrator.php",
		data : {
			controllerType : "updateDepartment",
            id : id,
			name : name
		},
		dataType : "json",
        success : function(data) {
            var department = {
                id : data.id,
                name : data.name
            };
            current_delete_id = data.id;
            $(".list-department-item[departmentid="+ department.id +"]").hide();
            appendDepartment(department);
            $("#editdepartment-name").val('');
            $('#editDepartmentModal').modal('hide');
            showAlertBox("Edited " + department.name + " successfully.", "success", 3);
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});

$("#deleteDepartmentButton").click(function(e) {
	e.preventDefault();
    var id = parseInt($("#editdepartment-id").val());
	
	$.ajax({
		type : "POST",
		url : "scripts/controller_administrator.php",
		data : {
			controllerType : "deleteDepartment",
            id : id
		},
		dataType : "json",
        success : function(data) {
            $(".list-department-item[departmentid="+ id +"]").slideUp();
            $("#editdepartment-name").val('');
            $('#deleteDepartmentModal').modal('hide');
            showAlertBox("Deleted department successfully.", "success", 3);
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});

function appendDepartment(department) {
    $("<a class='list-group-item list-department-item' href='#' style='display: block;' departmentid='" + department.id + "'><h5 class='list-group-item-heading'><span class='label label-primary pull-right'>" + department.id + "</span> " + department.name + "</h5></a>")
    .hide().appendTo("#list-department").slideDown();
}

function appendUser(user) {
    $("<a class='list-group-item list-user-item' href='#' userid='" + user.id + "'><h5 class='list-group-item-heading'><span class='label label-primary pull-right'>" + user.id + "</span> " + user.nicename + "&nbsp;&nbsp; <small>" + user.username + "</small></h5></a>")
    .hide().appendTo("#list-user").slideDown();
}

/* Click handlers for navigation buttons and showing views */

$(document).on("click",".list-department-item", function(e) {
    e.preventDefault();
    var id = parseInt($(this).attr("departmentid"));
    $.ajax({
		type : "POST",
		url : "scripts/controller_administrator.php",
		data : {
			controllerType : "getDepartment",
			id : id
		},
		dataType : "json",
        success : function(data) {
            var department = {
                id : data.id,
                name : data.name
            };
            $("#editdepartment-id").val(department.id);
            $("#editdepartment-name").val(department.name);
            $('#editDepartmentModal').modal('show');
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});

$(document).on("click",".list-user-item", function(e) {
    e.preventDefault();
    $("#edituser-status-enabled, #edituser-status-disabled").removeClass("active");
    var id = parseInt($(this).attr("userid"));
    
    $.ajax({
		type : "POST",
		url : "scripts/controller_administrator.php",
		data : {
			controllerType : "getUser",
			id : id
		},
		dataType : "json",
        success : function(data) {
            var user = {
                id : data.id,
                username : data.username,
                nicename : data.nicename,
                email : data.email,
                type : data.type,
                status : data.status
            };
            $("#edituser-id").val(user.id);
            $("#edituser-nicename").val(user.nicename);
            $("#edituser-username").val(user.username);
            $("#edituser-email").val(user.email);
            $("#edituser-type").val(user.type);
            
            if (user.status === "enabled") {
                $("#edituser-status-enabled").addClass("active");
            }
            else if (user.status === "disabled") {
                $("#edituser-status-disabled").addClass("active");
            }
            
            $('#editUserModal').modal('show');
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});


$("#addUserButton").click(function(e) {
	e.preventDefault();
	var username = $("#adduser-username").val();
    var nicename = $("#adduser-nicename").val();
	var password = $("#adduser-password").val();
	var email = $("#adduser-email").val();
	var type = $("#adduser-type").val();
    var status = "";
    
    if ($("#adduser-status-enabled").hasClass("active")) {
        status = "enabled";
    }
    else if ($("#adduser-status-disabled").hasClass("active")) {
        status = "disabled";
    }
    
    console.log(status);
	
	$.ajax({
		type : "POST",
		url : "scripts/controller_administrator.php",
		data : {
			controllerType : "addUser",
			username : username,
			nicename : nicename,
			email : email,
			password : password,
			type : type,
            status : status
		},
		dataType : "json",
        success : function(data) {
            var user = {
                id : data.id,
                nicename : data.nicename,
				email : data.email,
				username : data.username,
				type : data.type,
                status : data.status
            };
            
			appendUser(user);
            $("#adduser-nicename").val('');
			$("#adduser-password").val('');
			$("#adduser-email").val('');
			$("#adduser-username").val('');
            $('#addUserModal').modal('hide');
			
            showAlertBox("Added " + user.nicename + " successfully.", "success", 3);
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});

$("#editUserButton").click(function(e) {
	e.preventDefault();
    var id = parseInt($("#edituser-id").val());
    var nicename = $("#edituser-nicename").val();
    var username = $("#edituser-username").val();
	var email = $("#edituser-email").val();
    var type = $("#edituser-type").val();
    var status = "";
    
    if ($("#edituser-status-enabled").hasClass("active")) {
        status = "enabled";
    }
    else if ($("#edituser-status-disabled").hasClass("active")) {
        status = "disabled";
    }
    
	$.ajax({
		type : "POST",
		url : "scripts/controller_administrator.php",
		data : {
			controllerType : "updateUser",
            id : id,
			nicename : nicename,
            username : username,
            email : email,
            type : type,
            status : status
		},
		dataType : "json",
        success : function(data) {
            var user = {
                id : data.id,
                nicename : data.nicename,
                username : data.username,
                email : data.email,
                type : data.type,
                status: data.status
            };
            
            $(".list-user-item[userid="+ user.id +"]").hide();
            appendUser(user);
            
            $("#edituser-id").val('');
            $("#edituser-nicename").val('');
            $("#edituser-username").val('');
            $("#edituser-email").val('');
            
            $('#editUserModal').modal('hide');
            showAlertBox("Edited " + user.nicename + " successfully.", "success", 3);
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});

function appendUser(user) {
    $("<a class='list-group-item list-user-item' href='#' style='display: block;' userid='" + user.id + "'><h5 class='list-group-item-heading'><span class='label label-primary pull-right'>" + user.id + "</span> " + user.nicename + "<small>" + user.username + "</small></h5></a>")
    .hide().appendTo("#list-user").slideDown();
}

$("#deleteUserButton").click(function(e) {
	e.preventDefault();
    var id = parseInt($("#edituser-id").val());
	
	$.ajax({
		type : "POST",
		url : "scripts/controller_administrator.php",
		data : {
			controllerType : "deleteUser",
            id : id
		},
		dataType : "json",
        success : function(data) {
            $(".list-user-item[userid="+ id +"]").slideUp();
            $("#edituser-id").val('');
            $("#edituser-nicename").val('');
            $("#edituser-username").val('');
            $("#edituser-email").val('');
            $('#deleteUserModal').modal('hide');
            showAlertBox("Deleted user successfully.", "success", 3);
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});

$("#edituser-passwordresetbutton").click(function() {
    var id = parseInt($("#edituser-id").val());
    var password1 = $("#edituser-password1").val();
    var password2 = $("#edituser-password2").val();
    
    if (password1 === password2) {
        var password = password1;
        
        if (password.length >= 6) {
            $(this).addClass("disabled");
            $.ajax({
                type : "POST",
                url : "scripts/controller_administrator.php",
                data : {
                    controllerType : "resetPassword",
                    id : id,
                    password : password
                },
                dataType : "json",
                success : function(data) {
                    $("#edituser-password1").val('');
                    $("#edituser-password2").val('');
                    showAlertBox("Password successfully reset.", "success", 3);
                    $("#edituser-passwordresetbutton").removeClass("disabled");
                },
                error: function(data) {
                    showAlertBox("Error processing department.", "danger", 3);
                }
            });
        }
        else {
            showAlertBox("Password not at least 6 characters long.", "danger", 3);
        }
    }
    else {
        showAlertBox("Passwords do not match.", "danger", 3);
    }
});

$("#edituser-status-enabled, #edituser-status-disabled").click(function() {
    $("#edituser-status-enabled, #edituser-status-disabled").removeClass("active");
    $(this).addClass("active");
});

$("#adduser-status-enabled, #adduser-status-disabled").click(function() {
    $("#adduser-status-enabled, #adduser-status-disabled").removeClass("active");
    $(this).addClass("active");
});

$(".navigation").click(function() {
    resetNavs();
    $(this).addClass("active");
    var view = $(this).attr("openview");
    $(".view").hide();
    $("#view-" + view).show();
});

function resetNavs() {
    $(".navigation").removeClass("active");
}