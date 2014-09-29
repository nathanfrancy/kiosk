
// global variables
var edit = false;

$("#addProfessorButton").click(function() {
	$("#addEditProfessorModal").modal('show');
	prepareAddProfessor();
});

$(".panel-heading").click(function() {
    var departmentid = parseInt($(this).parent(".panel-department").attr("departmentid"));
    
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
                professorHTML += '<a href="#" class="list-group-item list-professor" professorid="' + data[i].professorid + '" departmentid="' + departmentid + '"><h4 class="list-group-item-heading">'+ data[i].lastname + ', ' + data[i].firstname +'</h4><!--<p class="list-group-item-text"></p>--></a>';
                count++;
            }
            professorHTML += "</div>";
            
            if (count === 0) { professorHTML = "No professors found for this department."; }
            
            $(".panel-department[departmentid="+ departmentid + "]").children(".panel-body").html(professorHTML).slideDown();
		},
		error: function (data) {
			showAlertBox("Error loading professors.", "danger", 3);
		}
	});
    
});

$(document).on("click", ".list-professor", function(e) {
	prepareEditProfessor();
    var id = $(this).attr("professorid");
    
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
			showAlertBox("Added professor successfully!", "success", 3);
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
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

$("#addeditprofessor-pictureurl").change(function() {
	var url = $(this).val();
	$("#imagebox-professor img").attr("src", url);
});

function prepareAddProfessor() {
	$("#addeditprofessor-id-container").hide();
	$("#addEditProfessorModal input").val('');
	$("#addUserButton").html("Add Professor");
	$("#professor-classschedule-list").html("Save this professor to add these values.");
	$("#professor-officehours-list").html("Save this professor to add these values.");
	$("#addofficehours-container").hide();
	$("#imagebox-professor img").attr("src", "assets/img/no-image-available.png");
	edit = false;
}

function prepareEditProfessor() {
	$("#professor-officehours-list").html('');
	$("#addeditprofessor-id-container").show();
	$("#addUserButton").html("Save Changes");
	$("#addofficehours-container").show();
	edit = true;
}

