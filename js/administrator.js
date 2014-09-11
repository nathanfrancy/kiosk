
var current_delete_id = 0;

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
    $("<a class='list-group-item list-department-item' href='#' style='display: block;' departmentid='" + department.id + "'><h5 class='list-group-item-heading'><span class='label label-primary'>" + department.id + "</span> " + department.name + "</h5></a>")
    .hide().appendTo("#list-department").slideDown();
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

$(".navigation").click(function() {
    resetNavs();
    $(this).addClass("active");
    var view = $(this).attr("openview");
    console.log(view);
    $(".view").hide();
    $("#view-" + view).show();
});

function resetNavs() {
    $(".navigation").removeClass("active");
}