
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
            // construct the book and add it to the table
            var department = {
                id : data.id,
                name : data.name
            };
            
            console.log(department);
            appendDepartment(department);
            
            // Clear the fields in case adding another one
            $("#adddepartment-name").val('');
            
            $('#addDepartmentModal').modal('hide');
            showAlertBox("Added '" + department.name + "'!", "success", 3);
        },
        error: function(data) {
        	showAlertBox("Error processing department.", "danger", 3);
        }
	});
});

function appendDepartment(department) {
    $("<a class='list-group-item' href='#' style='display: block;'><span class='label label-primary'>"+ department.id +"</span> "+ department.name +"</a>")
    .hide().appendTo("#list-department").slideDown();
}

/* Click handlers for navigation buttons and showing views */
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