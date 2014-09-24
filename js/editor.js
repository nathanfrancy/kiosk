
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
                professorHTML += '<a href="#" class="list-group-item list-professor" professorid="' + data[i].professorid + '"><h4 class="list-group-item-heading">'+ data[i].lastname + ', ' + data[i].firstname +'</h4><!--<p class="list-group-item-text"></p>--></a>';
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
            console.log(data);
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
});