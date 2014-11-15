var departments = null;
var posts = null;
var professors = null;
var professor = null;
var post = null;

function refreshDepartments() {
	$.get( "api/?requestType=getDepartments", function(data) {
		departments = jQuery.parseJSON(data);
		for (var i = 0; i < departments.departments.length; i++) {
			$("#list-group-departments").append('<a href="#" class="list-group-item list-group-item-department" departmentid="'+ departments.departments[i].id +'"><h4 class="list-group-item-heading">'+ departments.departments[i].name +'</h4></a>');
		}
	});
}

refreshDepartments();


/*

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

*/

$(document).on("click", ".list-group-item-department", function(e) {
    $(".prof-el").hide();
    $(".list-group-item-department").removeClass("active");
    $(this).addClass("active");
	$("#list-group-professors").html('');
	var id = parseInt($(this).attr("departmentid"));
    var name = $(this).find(".list-group-item-heading").html();
	$.get( "api/?requestType=getDepartmentProfessors&id=" + id, function(data) {
		professors = jQuery.parseJSON(data);
		showProfessors(professors, name);
	});
    $.get( "api/?requestType=getDepartmentCourses&id=" + id, function(data) {
		courses = jQuery.parseJSON(data);
        showCourses(courses);
	});
});

function showCourses(courses) {
    $("#list-group-courses").html('');
    if (courses.courses.length !== 0) {
            for (var i = 0; i < courses.courses.length; i++) {
                $("#list-group-courses").append('<a href="#" class="list-group-item list-group-item-course" courseid="' + courses.courses[i].id + '"><h4 class="list-group-item-heading">' + courses.courses[i].name + '</h4><p class="list-group-item-text">' + courses.courses[i].number + '</p></a>');
            }
        }
        else {
            $("#list-group-courses").html("<div class='text-center'>No courses found.</div>");
        }
    
    $(".sidebar-label-classes").fadeIn();
    $("#list-group-courses").fadeIn();
}

function showProfessors(professors, departmentname) {
    $("#list-group-professors").html('');
        if (professors.professors.length !== 0) {
            for (var i = 0; i < professors.professors.length; i++) {
                $("#list-group-professors").append('<a href="#" class="list-group-item list-group-item-professor" professorid="' + professors.professors[i].id + '"><h4 class="list-group-item-heading"><img class="pull-right img-responsive prof-img" src="'+ professors.professors[i].pictureurl +'"' + ">" + professors.professors[i].lastname + ', '+ professors.professors[i].firstname +'</h4><p class="list-group-item-text">' + professors.professors[i].officebuilding + ' ' + professors.professors[i].officeroom + '</p></a>');
            }
        }
        else {
            $("#list-group-professors").html("<div class='text-center'>No professors found.</div>");
        }
    $(".sidebar-label-professors").fadeIn();
    $("#list-group-professors").fadeIn();
    $(".container-middle").removeClass("greyed");
}

$(document).on("click", "#filter-lastname-container button", function(e) {
    $("#list-group-courses").hide();
    $(".prof-el").hide();
	$("#list-group-professors").html('');
	var letter = $(this).html();
    name = 'Last names starting with "' + letter + '"';
	$.get( "api/?requestType=getProfessorsWithLastName&letter="+ letter, function(data) {
		professors = jQuery.parseJSON(data);
		showProfessors(professors);
	});
});

$(document).on("click", ".list-group-item-professor", function(e) {
    $(".list-group-item-professor").removeClass("active");
    $(this).addClass("active");
	var id = parseInt($(this).attr("professorid"));
    $("#prof-el-courses").html('');
    $("#prof-el-officehours").html('');
	$.get( "api/?requestType=getProfessor&id=" + id, function(data) {
		professor = jQuery.parseJSON(data);
		$("#prof-el-name").html(professor.professor.firstname + " " + professor.professor.lastname);
		$("#prof-el-office").html(professor.professor.officebuilding + " " + professor.professor.officeroom);
		$("#prof-el-phone").html(professor.professor.phonenumber);
		$("#prof-el-email").html(professor.professor.email);
		$("#prof-el-img").attr("src", professor.professor.pictureurl);
		
        if (professor.professor.courses.length > 0) {
            for (var i = 0; i < professor.professor.courses.length; i++) {
                $("#prof-el-courses").append("<tr><td><strong>" + professor.professor.courses[i].coursename + "</strong></td><td>" + professor.professor.courses[i].days + "<br>" + professor.professor.courses[i].time + "</td></tr>");
            }
        }
        else {
            $("#prof-el-courses").append("<tr><td>No courses found.</td></tr>");
        }
		
        if (professor.officehours.length > 0) {
            for (var i = 0; i < professor.officehours.length; i++) {
                $("#prof-el-officehours").append("<tr><td><strong>" + professor.officehours[i].days + "</strong></td><td>" + professor.officehours[i].times + "</td></tr>");
            }
        }
        else {
            $("#prof-el-officehours").append("<tr><td>No office hours found.</td></tr>");
        }
	});
    $(".prof-el").show();
});

$(document).on("click", "#filter-lastname", function(e) {
    $(".prof-el, #list-group-departments").hide();
    $("#filter-lastname-container").show();
    $(".container-middle").addClass("greyed");
    $(".sidebar-label-professors").hide();
    $(".sidebar-label-classes").hide();
    $("#list-group-professors").hide();
    $("#list-group-courses").hide();
    $(".list-group-item-department").removeClass("active");
});

$(document).on("click", "#filter-program", function(e) {
    $(".prof-el, #filter-lastname-container").hide();
    $("#list-group-departments").show();
    $(".container-middle").addClass("greyed");
    $(".sidebar-label-professors").hide();
    $(".sidebar-label-classes").hide();
    $("#list-group-professors").hide();
    $("#list-group-courses").hide();
    $(".list-group-item-department").removeClass("active");
});

/*

refreshNewsPosts();

$("#filter-Program").click(function(e){
	e.preventDefault();
	$("#filter-lastname-container").fadeOut("fast");
    setTimeout(function() {
        $("#list-group-departments").fadeIn();
    }, 350);
    $("#filter-lastName, #filter-Program").removeClass("active");
    $(this).addClass("active");
});

$("#filter-lastName").click(function(e){
	e.preventDefault();
	$("#list-group-departments").fadeOut("fast");
    setTimeout(function() {
        $("#filter-lastname-container").fadeIn();
    }, 350);
    $("#filter-lastName, #filter-Program").removeClass("active");
    $(this).addClass("active");
});


$("#nav-button-professor").click(function() {
    $("#nav-button-professor, #nav-button-news").removeClass("active");
    $(".pub-news-master").fadeOut("fast");
    setTimeout(function() {
        $(".pub-department-master").fadeIn();
    }, 350);
    $(this).addClass("active");
});

$("#nav-button-news").click(function() {
    $("#nav-button-professor, #nav-button-news").removeClass("active");
    $(".pub-department-master").fadeOut();
	setTimeout(function() {
    	$(".pub-news-master").fadeIn();
    }, 350);
    $(this).addClass("active");
});

$("#nav-back-button").click(function() {
    $("#pub-container-professor-input").fadeOut("fast");
    setTimeout(function() {
        $("#pub-container-department-input").fadeIn();
    }, 350);
});

var timeoutHandle = window.setInterval(function() {
    window.location.href = "index.php";
}, 60000);

$(document).click(function(e) {
    window.clearInterval(timeoutHandle);
    timeoutHandle = window.setInterval(function() {
        window.location.href = "index.php";
    }, 60000);
});

$(".pub-news-master").hide();
*/