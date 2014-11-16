$("#addDepartmentButton").click(function (e) {
	e.preventDefault();

    // Validate fields that are required
    if ($("#adddepartment-name").val().length < 1) {
        showAlertBox("Department name is required", "warning", 3);
    }
    else {
        var name = $("#adddepartment-name").val();
        var prefix = $("#adddepartment-prefix").val();

        $.ajax({
            type: "POST",
            url: "controllers/controller_administrator.php",
            data: {
                controllerType: "addDepartment",
                name: name,
                prefix: prefix
            },
            dataType: "json",
            success: function (data) {
                var department = {
                    id: data.id,
                    name: data.name
                };
                refreshDepartments();
                $("#adddepartment-name").val('');
                $('#addDepartmentModal').modal('hide');
                showAlertBox("Added " + department.name + " successfully.", "success", 3);
            },
            error: function (data) {
                showAlertBox(data, "danger", 3);
            }
        });
    }

});

$(document).on("click", "#addDepartmentModal", function(e) {
    e.preventDefault();
    $("#adddepartment-name").val('');
    $("#adddepartment-prefix").val('');
});

function refreshDepartments() {
    $.get( "/api/", {requestType : "getDepartments"}, function(data) {
        var apiData = JSON.parse(data);
        var departments = apiData.departments;
        var departmenthtml = "<div class='list-group' id='list-department'>";
        for (var i = 0; i < departments.length; i++) {
            departmenthtml += "<a class='list-group-item list-department-item' href='#' departmentid='" + departments[i].id + "'><h4 class='list-group-item-heading'><span class='label label-primary pull-right'>"+ departments[i].prefix +"</span> "+ departments[i].name +"</h4></a>"
        }
        departmenthtml += "</div>";
        $("#list-department-container").html(departmenthtml);
    });
}

$("#editDepartmentButton").click(function (e) {
	e.preventDefault();

    if ( $("#editdepartment-name").val().length < 1) {
        showAlertBox("Department name is required", "warning", 3);
    }
    else {
        var id = parseInt($("#editdepartment-id").val());
        var name = $("#editdepartment-name").val();
        var prefix = $("#editdepartment-prefix").val();

        $.ajax({
            type: "POST",
            url: "controllers/controller_administrator.php",
            data: {
                controllerType: "updateDepartment",
                id: id,
                name: name,
                prefix: prefix
            },
            dataType: "json",
            success: function (data) {
                var department = {
                    id: data.id,
                    name: data.name,
                    prefix: data.prefix
                };
                current_delete_id = data.id;
                refreshDepartments();
                $("#editdepartment-name").val('');
                $('#editDepartmentModal').modal('hide');
                showAlertBox("Edited " + department.name + " successfully.", "success", 3);
            },
            error: function (data) {
                showAlertBox(data, "danger", 3);
            }
        });
    }
});

$("#deleteDepartmentButton").click(function (e) {
	e.preventDefault();
	var id = parseInt($("#editdepartment-id").val());

	var r = window.confirm("Are you sure you want to delete this department? It will delete all professors and courses linked.");
	if (r) {
		$.ajax({
			type: "POST",
			url: "controllers/controller_administrator.php",
			data: {
				controllerType: "deleteDepartment",
				id: id
			},
			dataType: "json",
			success: function (data) {
				refreshDepartments();
				$("#editdepartment-name").val('');
				$('#deleteDepartmentModal').modal('hide');
				showAlertBox("Deleted department successfully.", "success", 3);
			},
			error: function (data) {
				showAlertBox(data, "danger", 3);
			}
		});
	}
});

function appendDepartment(department) {
	$("<a class='list-group-item list-department-item' href='#' style='display: block;' departmentid='" + department.id + "'><h4 class='list-group-item-heading'><span class='label label-primary pull-right'>" + department.id + "</span> " + department.name + "</h4></a>")
		.hide().appendTo("#list-department").slideDown();
}

$(document).on("click", ".list-department-item", function (e) {
	e.preventDefault();
	var id = parseInt($(this).attr("departmentid"));
	$.ajax({
		type: "POST",
		url: "controllers/controller_administrator.php",
		data: {
			controllerType: "getDepartment",
			id: id
		},
		dataType: "json",
		success: function (data) {
			var department = {
				id: data.id,
				name: data.name,
				prefix: data.prefix
			};
			$("#editdepartment-id").val(department.id);
			$("#editdepartment-name").val(department.name);
			$("#editdepartment-prefix").val(department.prefix);
			$('#editDepartmentModal').modal('show');
		},
		error: function (data) {
			showAlertBox("Error processing department.", "danger", 3);
		}
	});
});

$(document).on("click", ".list-user-item", function (e) {
	e.preventDefault();
	$("#edituser-status-enabled, #edituser-status-disabled").removeClass("active");
	$(".addaccess-department").prop('checked', false);
	var id = parseInt($(this).attr("userid"));
	$("#edituser-departmentaccess").hide();

	$.ajax({
		type: "POST",
		url: "controllers/controller_administrator.php",
		data: {
			controllerType: "getUser",
			id: id
		},
		dataType: "json",
		success: function (data) {
		},
		error: function (data) {
			showAlertBox("Error getting user.", "danger", 3);
		}
	}).done(function (data) {
		var user = {
			id: data.id,
			username: data.username,
			nicename: data.nicename,
			email: data.email,
			type: data.type,
			status: data.status
		};
		$("#edituser-id").val(user.id);
		$("#edituser-nicename").val(user.nicename);
		$("#edituser-username").val(user.username);
		$("#edituser-email").val(user.email);
		$("#edituser-type").val(user.type);

		// Check if user is enabled or disabled
		if (user.status === "enabled") {
			$("#edituser-status-enabled").addClass("active");
		} else if (user.status === "disabled") {
			$("#edituser-status-disabled").addClass("active");
		}

		// Check if the user is any type of editor, show and hide the editor panel
		if (user.type === "editor" || user.type === "editorposter") {
			$("#edituser-departmentaccess").show();
			$.ajax({
				type: "POST",
				url: "controllers/controller_administrator.php",
				data: {
					controllerType: "getGrantedDepartmentIds",
					userid: id
				},
				dataType: "json",
				success: function (data) {
					$.each(data, function (i, item) {
						var deptid = item;
						$(".addaccess-department[value=" + deptid + "]").prop('checked', true);
					});
				},
				error: function (data) {
					showAlertBox("Error processing department.", "danger", 3);
				}
			});
		}

		$('#editUserModal').modal('show');
	});


});

$("#addUserButton").click(function (e) {
	e.preventDefault();

    // Name, username, password, email is required
    if ( $("#adduser-nicename").val().length < 1 ) {
        showAlertBox("Name field is required.", "warning", 3);
    }
    else if ( $("#adduser-username").val().length < 1 ) {
        showAlertBox("Username field is required.", "warning", 3);
    }
    else if ( $("#adduser-password").val().length < 1 ) {
        showAlertBox("Password field is required.", "warning", 3);
    }
    else if ( $("#adduser-email").val().length < 1 ) {
        showAlertBox("Email field is required.", "warning", 3);
    }
    else {
        var username = $("#adduser-username").val();
        var nicename = $("#adduser-nicename").val();
        var password = $("#adduser-password").val();
        var email = $("#adduser-email").val();
        var type = $("#adduser-type").val();
        var status = "";

        if ($("#adduser-status-enabled").hasClass("active")) {
            status = "enabled";
        } else if ($("#adduser-status-disabled").hasClass("active")) {
            status = "disabled";
        }

        $.ajax({
            type: "POST",
            url: "controllers/controller_administrator.php",
            data: {
                controllerType: "addUser",
                username: username,
                nicename: nicename,
                email: email,
                password: password,
                type: type,
                status: status
            },
            dataType: "json",
            success: function (data) {
                var user = {
                    id: data.id,
                    nicename: data.nicename,
                    email: data.email,
                    username: data.username,
                    type: data.type,
                    status: data.status
                };

                appendUser(user);
                $("#adduser-nicename").val('');
                $("#adduser-password").val('');
                $("#adduser-email").val('');
                $("#adduser-username").val('');
                $('#addUserModal').modal('hide');

                showAlertBox("Added " + user.nicename + " successfully.", "success", 3);
            },
            error: function (data) {
                showAlertBox(data, "danger", 3);
            }
        });
    }
});

$("#editUserButton").click(function (e) {
	e.preventDefault();

    if ( $("#edituser-nicename").val().length < 1 ) {
        showAlertBox("Name field is required.", "warning", 3);
    }
    else if ( $("#edituser-username").val().length < 1 ) {
        showAlertBox("Username field is required.", "warning", 3);
    }
    else if ( $("#edituser-email").val().length < 1 ) {
        showAlertBox("Email field is required.", "warning", 3);
    }
    else {
        var id = parseInt($("#edituser-id").val());
        var nicename = $("#edituser-nicename").val();
        var username = $("#edituser-username").val();
        var email = $("#edituser-email").val();
        var type = $("#edituser-type").val();
        var status = "";

        if ($("#edituser-status-enabled").hasClass("active")) {
            status = "enabled";
        } else if ($("#edituser-status-disabled").hasClass("active")) {
            status = "disabled";
        }

        $.ajax({
            type: "POST",
            url: "controllers/controller_administrator.php",
            data: {
                controllerType: "updateUser",
                id: id,
                nicename: nicename,
                username: username,
                email: email,
                type: type,
                status: status
            },
            dataType: "json",
            success: function (data) {
                var user = {
                    id: data.id,
                    nicename: data.nicename,
                    username: data.username,
                    email: data.email,
                    type: data.type,
                    status: data.status
                };

                $(".list-user-item[userid=" + user.id + "]").remove();
                appendUser(user);

                $("#edituser-id").val('');
                $("#edituser-nicename").val('');
                $("#edituser-username").val('');
                $("#edituser-email").val('');

                $('#editUserModal').modal('hide');
                showAlertBox("Edited " + user.nicename + " successfully.", "success", 3);
            },
            error: function (data) {
                showAlertBox(data, "danger", 3);
            }
        });
    }
});

function appendUser(user) {
	$("<a class='list-group-item list-user-item' href='#' style='display: block;' userid='" + user.id + "'><h4 class='list-group-item-heading'><span class='label label-primary pull-right'>" + user.id + "</span> " + user.nicename + "&nbsp;<small>" + user.username + "</small></h4><p class='list-group-item-text'>"+ cap(user.type) +"</p></a>")
		.hide().appendTo("#list-user").fadeIn();
}

$("#deleteUserButton").click(function (e) {
	e.preventDefault();
	var id = parseInt($("#edituser-id").val());
    
    if (confirm("Are you sure you want to delete this user?") == true) {
        $.ajax({
            type: "POST",
            url: "controllers/controller_administrator.php",
            data: {
                controllerType: "deleteUser",
                id: id
            },
            dataType: "json",
            success: function (data) {
                $(".list-user-item[userid=" + id + "]").slideUp();
                $("#edituser-id").val('');
                $("#edituser-nicename").val('');
                $("#edituser-username").val('');
                $("#edituser-email").val('');
                $('#deleteUserModal').modal('hide');
                showAlertBox("Deleted user successfully.", "success", 3);
            },
            error: function (data) {
                showAlertBox(data, "danger", 3);
            }
        });
    }
});

$("#edituser-passwordresetbutton").click(function () {
	var id = parseInt($("#edituser-id").val());
	var password1 = $("#edituser-password1").val();
	var password2 = $("#edituser-password2").val();

	if (password1 === password2) {
		var password = password1;

		if (password.length >= 6) {
			$(this).addClass("disabled");
			$.ajax({
				type: "POST",
				url: "controllers/controller_administrator.php",
				data: {
					controllerType: "resetPassword",
					id: id,
					password: password
				},
				dataType: "json",
				success: function (data) {
					$("#edituser-password1").val('');
					$("#edituser-password2").val('');
					showAlertBox("Password successfully reset.", "success", 3);
					$("#edituser-passwordresetbutton").removeClass("disabled");
				},
				error: function (data) {
					showAlertBox("Error processing department.", "danger", 3);
				}
			});
		} else {
			showAlertBox("Password not at least 6 characters long.", "danger", 3);
		}
	} else {
		showAlertBox("Passwords do not match.", "danger", 3);
	}
});

$(".addaccess-department").change(function () {
	var departmentid = parseInt($(this).val());
	var userid = parseInt($("#edituser-id").val());
	var checked = $(this).prop('checked');

	if (checked) {
		$.ajax({
			type: "POST",
			url: "controllers/controller_administrator.php",
			data: {
				controllerType: "grantDepartmentAccess",
				userid: userid,
				departmentid: departmentid
			},
			dataType: "json",
			success: function (data) {
				showAlertBox("Access granted successfully.", "success", 3);
			},
			error: function (data) {
				showAlertBox("Error granting access.", "danger", 3);
			}
		});
	} else {
		$.ajax({
			type: "POST",
			url: "controllers/controller_administrator.php",
			data: {
				controllerType: "revokeDepartmentAccess",
				userid: userid,
				departmentid: departmentid
			},
			dataType: "json",
			success: function (data) {
				showAlertBox("Access revoked successfully.", "success", 3);
			},
			error: function (data) {
				showAlertBox("Error revoking access.", "danger", 3);
			}
		});
	}


});

$("#edituser-status-enabled, #edituser-status-disabled").click(function () {
	$("#edituser-status-enabled, #edituser-status-disabled").removeClass("active");
	$(this).addClass("active");
});

$("#adduser-status-enabled, #adduser-status-disabled").click(function () {
	$("#adduser-status-enabled, #adduser-status-disabled").removeClass("active");
	$(this).addClass("active");
});

$("#list-user-filter button").click(function (e) {
	e.preventDefault();
	var type = $(this).attr("filtertype");
	$("#list-user-filter button").removeClass("active");
	$(this).addClass("active");

	if (type === "editor") {
		$(".list-user-item").hide();
		$(".list-user-item[usertype=editor]").show();
		$(".list-user-item[usertype=editorposter]").show();
	} else if (type === "poster") {
		$(".list-user-item").hide();
		$(".list-user-item[usertype=poster]").show();
		$(".list-user-item[usertype=editorposter]").show();
	} else if (type === "admin") {
		$(".list-user-item").hide();
		$(".list-user-item[usertype=admin]").show();
	} else {
		$(".list-user-item").show();
	}

	$("#list-user-filter button").blur();
});

$(".navigation").click(function () {
	resetNavs();
	$(this).addClass("active");
	var view = $(this).attr("openview");
	$(".view").hide();
	$("#view-" + view).show();
});

function resetNavs() {
	$(".navigation").removeClass("active");
}

function cap(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

$("#helpButton").click(function(e) {
    var helpSections = null;
    $.getJSON('documentation/help/admin.json', function(data) {
        var html = "";
        for (var i = 0; i < data.length; i++) {
            var videohtml = "";
            var listhtml = "";
            for (var j = 0; j < data[i].steps.length; j++) {
                listhtml += "<li>" + data[i].steps[j] + "</li>";
            }
            
            if (data[i].demoVideo !== "") {
                videohtml = "<p><a href='"+ data[i].demoVideo +"' class='btn btn-default' target='_blank'>Demo available here</a></p>";
            }
            
            html += "<div class='help-title'>"+ data[i].title +"</div><div class='help-body'><p>"+ data[i].body +"</p><ol>"+ listhtml +"</ol>" + videohtml + "</div>";
        } 
        $("#helpSections").html(html);
    });
    
    $("#helpModal").modal('show');
});

$(document).on("click", ".help-title", function(e) {
    e.preventDefault();
    $(".help-title").removeClass("help-active");
    $(".help-body").slideUp();
    if ( $(this).next(".help-body").is(":hidden") ) {
        $(this).addClass("help-active");
        $(this).next(".help-body").slideDown();
    }
});

refreshDepartments();
