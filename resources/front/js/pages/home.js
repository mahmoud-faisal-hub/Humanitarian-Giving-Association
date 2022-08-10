const $ = require("jquery");

$(function () {
    $("main.home-page section.home").height($(window).height());

    $(window).on("resize", function() {
        console.log("resizing");
        $("main.home-page section.home").height($(window).height());
    });
});
