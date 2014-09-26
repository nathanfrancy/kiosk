
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
			showAlertBox("Added professor successfully!.", "success", 3);
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
});

function fillOfficeHours(professorid) {
	$.ajax({
		type: "POST",
		url: "controllers/controller_editor.php",
		data: {
			controllerType: "getOfficeHours",
			professorid : professorid
		},
		dataType: "json",
		success: function (data) {
			for (var i = 0; i < data.length; i++) {
				$("#professor-officehours-list").append("<li>" + data[i].days + ", " + data[i].times + "</li>");
			}
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
}

function prepareAddProfessor() {
	$("#addeditprofessor-id-container").hide();
	$("#addEditProfessorModal input").val('');
	$("#addUserButton").html("Add Professor");
	$(".panel-classschedule .panel-body").html("Save this professor to add these values.");
	$(".panel-officehours .panel-body").html("Save this professor to add these values.");
	edit = false;
}

function prepareEditProfessor() {
	$("#professor-officehours-list").html('');
	$("#addeditprofessor-id-container").show();
	$("#addUserButton").html("Save Changes");
	edit = true;
}

