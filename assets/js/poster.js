var edit_post = false;

$(document).on("click", ".list-item-post", function() {
    edit_post = true;
    var postid = parseInt($(this).attr("postid"));
    
    $.ajax({
		type: "POST",
		url: "controllers/controller_poster.php",
		data: {
			controllerType: "getPost",
			id : postid
		},
		dataType: "json",
		success: function (data) {
            $("#addeditpost-id").val(data.id);
            $("#addeditpost-title").val(data.title);
             $("#addeditpost-body").val(data.body);
            $("#addeditpost-userid").val(data.user_created.username);
            $("#addeditpost-createddate").val(dateConverterToNice(parseInt(data.date_created)));
            $("#addeditpost-lastmodified").html( dateConverterToNice(parseInt(data.date_modified)) + " by " + data.user_modified.username );
            
            $("#addEditPostModal").modal('show');
		},
		error: function (data) {
			showAlertBox("Error loading professor data.", "danger", 3);
		}
	});
    
    // Show these fields
    $("#addeditpost-readonly-first").show();
    $("#addeditpost-readonly-second").show();
});

$("#addPostOpenModal").click(function() {
    edit_post = false;
    
    // Disable fields that don't apply yet
    $("#addeditpost-readonly-first").hide();
    $("#addeditpost-readonly-second").hide();
    
    $("#addeditpost-title").val('');
    $("#addeditpost-body").val('');
    
});

$("#savePostButtonSubmit").click(function() {
    
    var title = $("#addeditpost-title").val();
    var body = $("#addeditpost-body").val();
    var userid = parseInt($("#userid-key").attr("userid"));
    
    // If edit-mode is off, add this post
    if (edit_post == false) {
        $.ajax({
            type: "POST",
            url: "controllers/controller_poster.php",
            data: {
                controllerType: "addPost",
                title: title,
                body: body,
                userid: userid
            },
            dataType: "json",
            success: function (data) {
                $("#addEditPostModal").modal('hide');
               
                refreshAllPosts();
                showAlertBox("Added post successfully.", "success", 3);
            },
            error: function (data) {
                showAlertBox("Error loading professor data.", "danger", 3);
            }
        });
    }
    
    // Else if edit-mode is on, edit the post
    else if (edit_post == true) {
        var id = parseInt($("#addeditpost-id").val());
        alert("wanting to edit " + id);
    }
    
});

function refreshAllPosts() {
    // Clear what is currently there
    $("#list-all-posts").html('');
    
    // Make ajax call and fill results
    $.ajax({
        type: "POST",
        url: "controllers/controller_poster.php",
        data: {
            controllerType: "getPosts"
        },
        dataType: "json",
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                $("#list-all-posts").append('<li class="list-group-item list-item-post" postid="' + data[i].id + '"><h4 class="list-group-item-heading"><span class="badge pull-right">Edited '+ data[i].date_modified +'</span>'+ data[i].title +'</h4><p class="list-group-item-text">'+ data[i].user_created.nicename +'</p></li>');
            }
        },
        error: function (data) {
            showAlertBox("Error loading posts.", "danger", 3);
        }
    });
}










