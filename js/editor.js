
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
		url: "scripts/controller_editor.php",
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
		url: "scripts/controller_editor.php",
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
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
	
	$("#addEditProfessorModal").modal('show');
});

function prepareAddProfessor() {
	$("#addeditprofessor-id-container").hide();
	$("#addEditProfessorModal input").val('');
	$("#addUserButton").html("Add Professor");
	$(".panel-classschedule .panel-body").html("Save this professor to add these values.");
	$(".panel-officehours .panel-body").html("Save this professor to add these values.");
	edit = false;
}

function prepareEditProfessor() {
	$("#addeditprofessor-id-container").show();
	$("#addUserButton").html("Save Changes");
	edit = true;
}

