// global variables
var edit = false;
var edit_departmentid = 0;
var current_departmentid = 0;


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
	current_departmentid = departmentid;
	$(this).addClass("active");
    fillDepartmentsProfessors(departmentid);
});

function fillDepartmentsProfessors(departmentid) {
	
	// ajax function to fill in professors for the department
	refreshProfessors(departmentid);
	
	// ajax function to fill in the courses for the department
	refreshCourses(departmentid);
	
}

$(document).on("click", ".list-professor", function(e) {
	prepareEditProfessor();
    var id = $(this).attr("professorid");
	$("#professor-courses-list").html('');
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
            $("#addprofessorcourse-departmentid").val(data.department_id);
			
			if (data.status === "enabled") {
				$("#adddepartment-status-enabled").addClass("active");
			}
			else if (data.status === "disabled") {
				$("#adddepartment-status-disabled").addClass("active");
			}
			
			// Populate current courses
			var courses = data.courses;
			for (var i = 0; i < courses.length; i++) {
				$("#professor-courses-list").append('<li class="list-group-item">'+ courses[i].coursename +'<br>'+ courses[i].days +', '+ courses[i].time +'</li>');
			}
            if (courses.length === 0) { $("#professor-courses-list").append('No linked courses found.'); }
			
			// Populate available courses
			var availableCourses = data.availableCourses;
			for (var i = 0; i < availableCourses.length; i++) {
				$("#addprofessorcourse-courseid").append("<option value='"+ availableCourses[i].id +"'>" + availableCourses[i].name + "</li>");
			}
			
			fillOfficeHours(data.id);
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
	
	$("#addEditProfessorModal").modal('show');
});

$(document).on("click", ".list-course", function(e) {
    var id = parseInt($(this).attr("courseid"));
	$("#addCourseButtonSubmit").html("Save Changes");
    
    $.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "getCourse",
			id : id
		},
		dataType: "json",
		success: function (data) {
			$("#addEditCourseTitle").html("Edit Course");
			$("#addeditcourse-id-container").show();
			$("#addeditcourse-id").val(data.id);
			$("#addeditcourse-number").val(data.number);
			$("#addeditcourse-name").val(data.name);
			$("#addeditcourse-departmentid").val(data.department_id);
			$("#addEditCourseModal").modal('show');
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
});

$("#addprofessorcourse-departmentid").change(function() {
    var id = parseInt($(this).val());
    
    $.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "getDepartmentsCourses",
			id: id
		},
		dataType: "json",
		success: function (data) {
            $("#addprofessorcourse-courseid").html('');
			for (var i = 0; i < data.length; i++) {
				$("#addprofessorcourse-courseid").append("<option value='"+ data[i].id +"'>" + data[i].name + "</li>");
			}
		},
		error: function (data) {
			showAlertBox("Error loading courses.", "danger", 3);
		}
	});
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
				$("#addEditProfessorModal").modal('hide');
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
					$("<li class='list-group-item'><button class='btn btn-danger btn-xs deleteOfficeHoursButton pull-right' officehoursid='"+ data[i].id +"'><span class='glyphicon glyphicon-trash'></span></button>" + data[i].days + " (" + data[i].times + ")</li>").appendTo("#professor-officehours-list");
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
				$("#professor-officehours-list").html("<li class='list-group-item'><button class='btn btn-danger btn-xs deleteOfficeHoursButton pull-right' officehoursid='"+ data +"'><span class='glyphicon glyphicon-trash'></span></button>" + days + " (" + times + ")</li>");
			}
			else {
				$("<li class='list-group-item'><button class='btn btn-danger btn-xs deleteOfficeHoursButton pull-right' officehoursid='"+ data +"'><span class='glyphicon glyphicon-trash'></span></button>" + days + " (" + times + ")</li>").appendTo("#professor-officehours-list");
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

$("#addCourseButton").click(function() {
	$("#addEditCourseModal").modal('show');
	$("#addEditCourseTitle").html("Add Course");
	$("#addCourseButtonSubmit").html("Add Course");
	$("#addeditcourse-id-container").hide();
	$("#addeditcourse-id").val('');
	$("#addeditcourse-number").val('');
	$("#addeditcourse-name").val('');
	
	// if a department is selected put the select box on that department automagically
	if (current_departmentid !== 0) {
		$("#addeditcourse-departmentid").val(current_departmentid);
	}
});

$("#addCourseButtonSubmit").click(function() {
	var name = $("#addeditcourse-name").val();
	var number = parseInt($("#addeditcourse-number").val());
	var departmentid = parseInt($("#addeditcourse-departmentid").val());
	
	// If the button says to add it, add it
	if ($(this).html() === "Add Course") {
		$.ajax({
			type: "POST",
			url: "controllers/controller_editor.php",
			data: {
				controllerType: "addCourse",
				name : name, 
				number : number, 
				departmentid : departmentid
			},
			dataType: "json",
			success: function (data) {

				// check if the class just added is in the currently selected department, to see if we need to reload the panel
				if ( (departmentid === current_departmentid) && (departmentid === parseInt($(".panel-department.active").attr("departmentid")) ) ) {
						refreshCourses(parseInt($(".panel-department.active").attr("departmentid")));
					}

				showAlertBox("Successfully added course.", "success", 3);
				$("#addEditCourseModal").modal('hide');
			},
			error: function (data) {
				showAlertBox("Error adding course.", "danger", 3);
			}
		});
	}
	
	// if the button says "save changes" do that instead of adding it
	else if ($(this).html() === "Save Changes") {
		var id = parseInt($("#addeditcourse-id").val());
		
		$.ajax({
			type: "POST",
			url: "controllers/controller_editor.php",
			data: {
				controllerType: "editCourse",
				id : id,
				name : name, 
				number : number, 
				departmentid : departmentid
			},
			dataType: "json",
			success: function (data) {

				// check if the class just added is in the currently selected department, to see if we need to reload the panel
				if ( (departmentid === current_departmentid) && (departmentid === parseInt($(".panel-department.active").attr("departmentid")) ) ) {
						refreshCourses(parseInt($(".panel-department.active").attr("departmentid")));
					}

				showAlertBox("Successfully added course.", "success", 3);
				$("#addEditCourseModal").modal('hide');
			},
			error: function (data) {
				showAlertBox("Error adding course.", "danger", 3);
			}
		});
	}
	else {
		showAlertBox("Error processing this change.", "danger", 3);
	}
	
});

$("#addeditprofessor-pictureurl").change(function() {
	var url = $(this).val();
	$("#imagebox-professor img").attr("src", url);
});

$("#addprofessorcourse-button").click(function() {
    var professorid = parseInt($("#addeditprofessor-id").val());
    var courseid = parseInt($("#addprofessorcourse-courseid").val());
    var days = $("#addprofessorcourse-days").val();
    var time = $("#addprofessorcourse-time").val();
    
    $.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "linkCourseToProfessor",
			professorid : professorid,
            courseid : courseid,
            days : days,
            time : time
		},
		dataType: "json",
		success: function (data) {
            $("#addprofessorcourse-days").val('');
            $("#addprofessorcourse-time").val('');
            
            if ($("#professor-courses-list").html() === "No linked courses found.") { $("#professor-courses-list").html('') }
            
			$("#professor-courses-list").append('<li class="list-group-item" linkedcourseid='+ data.id +'>'+ data.courseinfo.name +'<br>'+ data.days +', '+ data.time +'</li>');
            showAlertBox("Successfully linked course.", "success", 3);
		},
		error: function (data) {
			showAlertBox("Error loading professors.", "danger", 3);
		}
	});
});

function refreshCourses(departmentid) {
	$.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "getDepartmentsCourses",
			id: departmentid
		},
		dataType: "json",
		success: function (data) {
			var courseHTML = "<div class='list-group'>";
			var count = 0;

			for (var i = 0; i < data.length; i++) {
				courseHTML += '<a href="#" class="list-group-item list-course" courseid="' + data[i].id + '" departmentid="' + departmentid + '"><h4 class="list-group-item-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;' + data[i].number + ', ' + data[i].name + '</h4></a>';
				count++;
			}
			courseHTML += "</div>";

			if (count === 0) {
				courseHTML = "No courses found for this department.";
			}

			$("#filldepartmentcourses").html(courseHTML).hide().fadeIn();
		},
		error: function (data) {
			showAlertBox("Error loading professors.", "danger", 3);
		}
	});
}

function refreshProfessors(departmentid) {
	// reload current departments' professors and place them into page
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
}

$(".openclose").click(function() {
    $(this).next(".panel-body").slideToggle();
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
	$("#professor-courses-list").html('');
	$("#addprofessorcourse-courseid").html('');
	resetStatusProfessor();
	edit = false;
}

function prepareEditProfessor() {
	$("#professor-officehours-list").html('');
	$("#addeditprofessor-id-container").show();
	$("#addUserButton").html("Save Changes");
	$("#addofficehours-container").show();
	$("#professor-courses-list").html('');
	$("#addprofessorcourse-courseid").html('');
	edit = true;
}

$(function(){
	$('[rel="tooltip"]').tooltip();
});
