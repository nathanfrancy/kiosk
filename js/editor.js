
$(".panel-department").click(function() {
    var departmentid = parseInt($(this).attr("departmentid"));
    
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
                professorHTML += '<a href="#" class="list-group-item"><h4 class="list-group-item-heading">'+ data[i].lastname + ', ' + data[i].firstname +'</h4><!--<p class="list-group-item-text"></p>--></a>';
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