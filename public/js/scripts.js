$(document).ready(function () {

    $("#print").click(function () {
        $('.invoice').printThis({
            // importStyle: true,
            importStyle: true,

        });
    });

    $("#printResult").click(function () {
        $('.result').printThis({
            // importStyle: true,
            importStyle: true,

        });
    });

    function printResult() {
        $('.invoice').printThis({
            // importStyle: true,
            importStyle: true,

        });
    }


    $("#printReport").click(function () {
        $('.report').printThis({
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
