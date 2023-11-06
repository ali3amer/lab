$(document).ready(function () {

    $("#print").click(function () {
        $('.invoice').printThis({
            // importStyle: true,
            importStyle: true,
            header: $('#myHeader'),
            footer: $('#myFooter'),
        });
    });

    $("#sideBarBtn").click(function () {
        $('#sideBar').toggleClass("hidden");
    });
});
