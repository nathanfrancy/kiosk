<?php
require("header.php");
?>
		
<div class="container-fluid"> 
    <div class="container-body">
        <div class="view" id="view-user">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h3 style="margin-top: 0px;">User Tracking <button class="btn btn-default" id="clearTrackings">Clear All Trackings</button></h3>
                    <div id="list-track-container"></div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(".nav-admin .btn-group a:nth-child(3)").addClass("active");

function refreshTrackings() {
    $.post( "controllers/controller_administrator.php", {controllerType : "getAllTrackings"}, function(data) {
        var trackshtml = "<div class='list-group' id='list-tracks'>";
        for (var i = 0; i < data.length; i++) {
            trackshtml += "<a class='list-group-item list-track-item' href='#' trackid='" + data[i].track.id + "'><h4 class='list-group-item-heading'>&nbsp;<span class='label label-warning pull-right'>"+ data[i].user.ip_address +"</span><span class='label label-primary pull-right'>"+ data[i].track.track_code + "</span>"+ data[i].user.nicename + " <span class='label label-default pull-right'>"+  data[i].user.username +"</span></h4><p class='list-group-item-text'>"+  data[i].track.description +"<br>" +  dateConverterToNice(data[i].track.date_executed) + "</p></a>"
        }
        trackshtml += "</div>";
        $("#list-track-container").html(trackshtml);
    });
}
    
$("#clearTrackings").click(function(e) {
    $.post( "controllers/controller_administrator.php", {controllerType : "clearAllTrackings"}, function(data) {
        refreshTrackings();
        showAlertBox("Cleared all trackings.", "success", 3);
    });
});
    
refreshTrackings();
    
</script>

<?php
require("footer.php");
?>
