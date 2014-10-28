var departments = null;
var posts = null;
var professors = null;
var professor = null;
var post = null;

function refreshDepartments() {
	$.get( "api/?requestType=getDepartments", function(data) {
		departments = jQuery.parseJSON(data);
		for (var i = 0; i < departments.departments.length; i++) {
			$("#list-group-departments").append('<a href="#" class="list-group-item list-group-item-department" departmentid="'+ departments.departments[i].id +'">'+ departments.departments[i].name +'</a>');
		}
	});
}

function refreshNewsPosts() {
	$.get( "api/?requestType=getPosts", function(data) {
		posts = jQuery.parseJSON(data);
		for (var i = 0; i < posts.posts.length; i++) {
			$("#list-group-newspost").append('<a href="#" class="list-group-item list-group-item-newspost" postid="'+ posts.posts[i].id +'">'+ posts.posts[i].title +'</a>');
		}
	});
}

$(document).on("click", ".list-group-item-newspost", function(e) { 
	var id = parseInt($(this).attr("postid"));
	$.get( "api/?requestType=getPost&id=" + id, function(data) {
		post = jQuery.parseJSON(data);
		$("#title").html(post.post.title);
		$("#body").html(post.post.body);
		$("#newspost-modal").modal("show");
	});
});

$(document).on("click", ".list-group-item-department", function(e) {
	$("#list-group-professors").html('');
	var id = parseInt($(this).attr("departmentid"));
	$.get( "api/?requestType=getDepartmentProfessors&id=" + id, function(data) {
		professors = jQuery.parseJSON(data);
		for (var i = 0; i < professors.professors.length; i++) {
			$("#list-group-professors").append('<a href="#" class="list-group-item list-group-item-professor" professorid="' + professors.professors[i].id + '"><h4 class="list-group-item-heading">'+ professors.professors[i].lastname + ', '+ professors.professors[i].firstname +'</h4><p class="list-group-item-text">' + professors.professors[i].officebuilding + ' ' + professors.professors[i].officeroom + '</p></a>');
		}
	});
}); 

$(document).on("click", ".list-group-item-professor", function(e) {
	var id = parseInt($(this).attr("professorid"));
	$.get( "api/?requestType=getProfessor&id=" + id, function(data) {
		professor = jQuery.parseJSON(data);
		$("#professorModal").modal('show');
		$("#name").html(professor.professor.firstname + " " + professor.professor.lastname);
		$("#office").html(professor.professor.officebuilding + " " + professor.professor.officeroom);
		$("#phone").html(professor.professor.phonenumber);
		$("#email").html(professor.professor.email);
		$("#img").attr("src", professor.professor.pictureurl);
		
		for (var i = 0; i < professor.professor.courses.length; i++) {
			$("#courses").append("<li>" + professor.professor.courses[i].coursename + " (" + professor.professor.courses[i].days + ", "+ professor.professor.courses[i].time +")</li>");
		}
		for (var i = 0; i < professor.officehours.length; i++) {
			$("#officehours").append("<li>" + professor.officehours[i].days + ", "+ professor.officehours[i].times +"</li>");
		}
	});
});


refreshDepartments();
refreshNewsPosts();

$("#filter-Program").click(function(e){
	e.preventDefault();
	$("#list-group-departments").show();
	$("#filter-lastname-container").hide();
});

$("#filter-lastName").click(function(e){
	e.preventDefault();
	$("#list-group-departments").hide();
	$("#filter-lastname-container").show();
});