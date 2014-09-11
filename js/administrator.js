

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