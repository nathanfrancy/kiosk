
// global variables
var edit = false;
var edit_departmentid = 0;

$("#addProfessorButton").click(function() {
	$("#addEditProfessorModal").modal('show');
	prepareAddProfessor();
	
	if (edit_departmentid !== 0) {
		$("#addeditprofessor-departmentid").val(edit_departmentid);
	}
});

$(".panel-department").click(function() {
    var departmentid = parseInt($(this).attr("departmentid"));
    $(".panel-department").removeClass("active");
	edit_departmentid = departmentid;
	$(this).addClass("active");
    fillDepartmentsProfessors(departmentid);
});

function fillDepartmentsProfessors(departmentid) {
	
	// ajax function to fill in professors for the department
	$.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "getDepartmentsProfessors",
			departmentid : departmentid
		},
		dataType: "json",
		success: function (data) {
            var professorHTML = "<div class='list-group'>";
            var count = 0;
            for (var i = 0; i < data.length; i++) {
                professorHTML += '<a href="#" class="list-group-item list-professor" professorid="' + data[i].professorid + '" departmentid="' + departmentid + '"><h4 class="list-group-item-heading"><span class="glyphicon glyphicon-user"></span> '+ data[i].lastname + ', ' + data[i].firstname +'<img src="' + data[i].pictureurl + '" class="img-responsive pull-right img-thumbnail img-thumbs"></h4><p class="list-group-item-text">'+ data[i].officebuilding +' '+ data[i].officeroom +'</p></a>';
                count++;
            }
            professorHTML += "</div>";
            
            if (count === 0) { professorHTML = "No professors found for this department."; }
            
            $("#filldepartmentprofessors").html(professorHTML).hide().fadeIn();
		},
		error: function (data) {
			showAlertBox("Error loading professors.", "danger", 3);
		}
	});
	
	// ajax function to fill in the courses for the department
	$.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "getDepartmentsCourses",
			id : departmentid
		},
		dataType: "json",
		success: function (data) {
            var courseHTML = "<div class='list-group'>";
            var count = 0;
			
            for (var i = 0; i < data.length; i++) {
                courseHTML += '<a href="#" class="list-group-item list-course" courseid="' + data[i].id + '" departmentid="' + departmentid + '"><h4 class="list-group-item-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;'+ data[i].number + ', ' + data[i].name + '</h4></a>';
                count++;
            }
            courseHTML += "</div>";
            
            if (count === 0) { courseHTML = "No courses found for this department."; }
            
            $("#filldepartmentcourses").html(courseHTML).hide().fadeIn();
		},
		error: function (data) {
			showAlertBox("Error loading professors.", "danger", 3);
		}
	});
	
}

$(document).on("click", ".list-professor", function(e) {
	prepareEditProfessor();
    var id = $(this).attr("professorid");
	resetStatusProfessor();
    
    // Load up the professor's attributes
    $.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "getProfessor",
			professorid : id
		},
		dataType: "json",
		success: function (data) {
            $("#addeditprofessor-id").val(data.id);
			$("#addeditprofessor-firstname").val(data.firstname);
			$("#addeditprofessor-lastname").val(data.lastname);
			$("#addeditprofessor-officebuilding").val(data.officebuilding);
			$("#addeditprofessor-officeroom").val(data.officeroom);
			$("#addeditprofessor-phonenumber").val(data.phonenumber);
			$("#addeditprofessor-email").val(data.email);
			$("#addeditprofessor-pictureurl").val(data.pictureurl);
			$("#addeditprofessor-departmentid").val(data.department_id);
			$("#imagebox-professor img").attr("src", data.pictureurl);
			
			if (data.status === "enabled") {
				$("#adddepartment-status-enabled").addClass("active");
			}
			else if (data.status === "disabled") {
				$("#adddepartment-status-disabled").addClass("active");
			}
			
			fillOfficeHours(data.id);
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
	
	$("#addEditProfessorModal").modal('show');
});

$("#addProfessorButtonSubmit").click(function() {
	
	// Compile all of the submitted values into variables to prepare for the ajax call
	//var id = $("#addeditprofessor-id").val();
	var firstname = $("#addeditprofessor-firstname").val();
	var lastname = $("#addeditprofessor-lastname").val();
	var officebuilding = $("#addeditprofessor-officebuilding").val();
	var officeroom = $("#addeditprofessor-officeroom").val();
	var phonenumber = parseInt($("#addeditprofessor-phonenumber").val());
	var email = $("#addeditprofessor-email").val();
	var pictureurl = $("#addeditprofessor-pictureurl").val();
	var departmentid = parseInt($("#addeditprofessor-departmentid").val());
	$("#imagebox-professor img").attr("src", pictureurl);
	
	if (edit === false) {
		$.ajax({
			type: "POST",
			url: "controllers/controller_editor.php",
			data: {
				controllerType: "addProfessor",
				firstname : firstname,
				lastname : lastname,
				officebuilding : officebuilding,
				officeroom : officeroom,
				phonenumber : phonenumber,
				email : email,
				imageurl : pictureurl,
				departmentid : departmentid
			},
			dataType: "json",
			success: function (data) {
				$("#addeditprofessor-id-container").slideDown();
				$("#addeditprofessor-id").val(data.id);
				prepareEditProfessor();
				$(".panel-department[departmentid="+ departmentid +"] .list-group").append('<a href="#" class="list-group-item list-professor" professorid="' + data.professorid + '" departmentid="' + departmentid + '"><h4 class="list-group-item-heading">'+ data.lastname + ', ' + data.firstname +'</h4><!--<p class="list-group-item-text"></p>--></a>');
				
				if (data.status === "enabled") {
					$("#adddepartment-status-enabled").addClass("active");
				}
				else if (data.status === "disabled") {
					$("#adddepartment-status-disabled").addClass("active");
				}
				
				showAlertBox("Added professor successfully!", "success", 3);
			},
			error: function (data) {
				showAlertBox("Error loading professor data.", "danger", 3);
			}
		});
	}
	else {
		var id = parseInt($("#addeditprofessor-id").val());
		$.ajax({
			type: "POST",
			url: "controllers/controller_editor.php",
			data: {
				id: id,
				controllerType: "editProfessor",
				firstname : firstname,
				lastname : lastname,
				officebuilding : officebuilding,
				officeroom : officeroom,
				phonenumber : phonenumber,
				email : email,
				imageurl : pictureurl,
				departmentid : departmentid
			},
			dataType: "json",
			success: function (data) {
				$("#addeditprofessor-id-container").slideDown();
				$("#addeditprofessor-id").val(data.id);
				prepareEditProfessor();
				$(".panel-department[departmentid="+ departmentid +"] .list-group").append('<a href="#" class="list-group-item list-professor" professorid="' + data.professorid + '" departmentid="' + departmentid + '"><h4 class="list-group-item-heading">'+ data.lastname + ', ' + data.firstname +'</h4><!--<p class="list-group-item-text"></p>--></a>');
				showAlertBox("Edited professor successfully!", "success", 3);
			},
			error: function (data) {
				showAlertBox("Error loading professor data.", "danger", 3);
			}
		});
	}
	// Refill the professors to ensure data is accurate back to the view
	if (edit_departmentid !== 0) {
		fillDepartmentsProfessors(departmentid);
	}
	fillOfficeHours(id);
});

function fillOfficeHours(professorid) {
	$("#professor-officehours-list").html('');
	$.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "getOfficeHours",
			professorid : professorid
		},
		dataType: "json",
		success: function (data) {
			if (data.length !== 0) {
				for (var i = 0; i < data.length; i++) {
					$("<li class='list-group-item'><button class='btn btn-danger btn-xs deleteOfficeHoursButton pull-right' officehoursid='"+ data[i].id +"'>Delete</button>" + data[i].days + " (" + data[i].times + ")</li>").appendTo("#professor-officehours-list");
				}
			}
			else {
				$("#professor-officehours-list").append("No office hours found.");
			}
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
}

$("#addofficehours-button").click(function() {
	var professorid = parseInt($("#addeditprofessor-id").val());
	var days = $("#addedofficehours-days").val();
	var times = $("#addedofficehours-times").val();
	$.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "addOfficeHours",
			professorid : professorid,
			days : days,
			times : times
		},
		dataType: "json",
		success: function (data) {
			var rows = $("#professor-officehours-list > li").length;
			if (rows === 0) {
				$("#professor-officehours-list").html("<li class='list-group-item'><button class='btn btn-danger btn-xs deleteOfficeHoursButton pull-right' officehoursid='"+ data +"'>Delete</button>" + days + " (" + times + ")</li>");
			}
			else {
				$("<li class='list-group-item'><button class='btn btn-danger btn-xs deleteOfficeHoursButton pull-right' officehoursid='"+ data +"'>Delete</button>" + days + " (" + times + ")</li>").appendTo("#professor-officehours-list");
			}
			
			$("#addedofficehours-days").val("");
			$("#addedofficehours-times").val("");
			showAlertBox("Successfully added office hours.", "success", 3);
		},
		error: function (data) {
			showAlertBox("Error deleting office hours.", "danger", 3);
		}
	});
});

$(document).on("click", ".deleteOfficeHoursButton", function(e) {
	e.preventDefault();
	var id = parseInt($(this).attr("officehoursid"));
	deleteOfficeHours(id);
});

function deleteOfficeHours(id) {
	$.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "deleteOfficeHours",
			id : id
		},
		dataType: "json",
		success: function (data) {
			$(".list.group-item").find(".deleteOfficeHoursButton[officehoursid=" + id + "]").remove();
			showAlertBox("Successfully deleted office hours.", "success", 3);
			var professorid = parseInt($("#addeditprofessor-id").val());
			fillOfficeHours(professorid);
		},
		error: function (data) {
			showAlertBox("Error deleting office hours.", "danger", 3);
		}
	});
}

$("#adddepartment-status-enabled").click(function() {
	resetStatusProfessor();
	$(this).addClass("active");
	
	if (edit) {
		var id = parseInt($("#addeditprofessor-id").val());
		
		$.ajax({
			type: "POST",
			url: "controllers/controller_editor.php",
			data: {
				controllerType: "enableProfessor",
				id : id
			},
			dataType: "json",
			success: function (data) {
				showAlertBox("Successfully enabled professor.", "success", 3);
			},
			error: function (data) {
				showAlertBox("Error enabling professor.", "danger", 3);
			}
		});
		
	}
});

$("#adddepartment-status-disabled").click(function() {
	resetStatusProfessor();
	$(this).addClass("active");
	
	if (edit) {
		var id = parseInt($("#addeditprofessor-id").val());
		
		$.ajax({
			type: "POST",
			url: "controllers/controller_editor.php",
			data: {
				controllerType: "disableProfessor",
				id : id
			},
			dataType: "json",
			success: function (data) {
				showAlertBox("Successfully disabled professor.", "success", 3);
			},
			error: function (data) {
				showAlertBox("Error disabling professor.", "danger", 3);
			}
		});
		
	}
});

$("#addeditprofessor-pictureurl").change(function() {
	var url = $(this).val();
	$("#imagebox-professor img").attr("src", url);
});

function resetStatusProfessor() {
	$("#adddepartment-status-enabled").removeClass("active");
	$("#adddepartment-status-disabled").removeClass("active");
}

function prepareAddProfessor() {
	$("#addeditprofessor-id-container").hide();
	$("#addEditProfessorModal input").val('');
	$("#addUserButton").html("Add Professor");
	$("#professor-classschedule-list").html("Save this professor to add these values.");
	$("#professor-officehours-list").html("Save this professor to add these values.");
	$("#addofficehours-container").hide();
	$("#imagebox-professor img").attr("src", "assets/img/no-image-available.png");
	resetStatusProfessor();
	edit = false;
}

function prepareEditProfessor() {
	$("#professor-officehours-list").html('');
	$("#addeditprofessor-id-container").show();
	$("#addUserButton").html("Save Changes");
	$("#addofficehours-container").show();
	edit = true;
}

