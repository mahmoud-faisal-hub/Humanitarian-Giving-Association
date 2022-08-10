import "./bootstrap";

$(function () {
    "use strict";

    $(":input, textarea select").on("keyup change", function () {
        var name = $(this).attr("name");
        $("#" + name + "_error").fadeOut(600);
    });

    /* Start Scroll To Top Button */
    var scrollToTop = $(".scroll-to-top");

    $(window).on("scroll", function () {
        if ($(window).scrollTop() >= $(window).height() / 4) {
            scrollToTop.fadeIn(1000);
        } else {
            scrollToTop.fadeOut(1000);
        }
    });

    scrollToTop.on("click", function (ev) {
        ev.preventDefault();

        $("html, body").scrollTop(0);
    });
    /* End Scroll To Top Button */

});
