
$(document).ready(function(){

    $("#print").click(function () {
        $('.invoice').printThis({
            // importStyle: true,
            importStyle: true,
        });
    });

    $("#sideBarBtn").click(function () {
        $('#sideBar').toggleClass("hidden");
    });
});
