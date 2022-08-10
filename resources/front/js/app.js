window.$ = window.jQuery = require("jquery");
window.DateTime = require("datetime-js");
require("popper.js");
import "./bootstrap";
require("@fortawesome/fontawesome-free");
import "./pages/home";
import "animate.css";

$(function () {
    ("use strict");

    /* Start Calc Body Margin Based On Navbar Height */
    $("body").css({
        "margin-top": $("header").outerHeight(),
    });
    /* End Calc Body Margin Based On Navbar Height */

    /* Start Scroll To Top Button */
    var scrollToTop = $(".scroll-to-top");

    var lastScrollTop = 0;
    $(window).on("scroll", function () {
        // Scroll To Top Button
        // window.console.log($(window).scrollTop());

        if ($(window).scrollTop() >= $(window).height() / 4) {
            if (scrollToTop.is(":hidden")) {
                scrollToTop.fadeIn(1000);
            }
        } else {
            if (scrollToTop.is(":visible")) {
                scrollToTop.fadeOut(1000);
            }
        }

        if ($(window).width() >= 992) {
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                $("nav.top-nav").slideUp();
            } else {
                $("nav.top-nav").slideDown();
            }
            lastScrollTop = st;
        }
    });

    // Scroll To Top Button

    scrollToTop.on("click", function (ev) {
        ev.preventDefault();

        $("html, body").scrollTop(0);
    });
    /* End Scroll To Top Button */

    // Assign Page Min Height
    $("main").css({
        "min-height":
            $(window).height() -
            ($("header").outerHeight() + $("footer").outerHeight()),
    });

    $(window).on("resize", function () {
        $("main").css({
            "min-height":
                $(window).height() -
                ($("header").outerHeight() + $("footer").outerHeight()),
        });

        $("body").css({
            "margin-top": $("header").outerHeight(),
        });
    });

    function replaceCumulative(str, find, replace) {
        for (var i = 0; i < find.length; i++)
            str = str.replace(new RegExp(find[i], "g"), replace[i]);
        return str;
    }

    var english_date_time = [
        "0",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
        "Sat",
        "Sun",
        "Mon",
        "Tue",
        "Wed",
        "Thu",
        "Fri",
        "am",
        "pm",
    ];

    var arabic_date_time = [
        "٠",
        "١",
        "٢",
        "٣",
        "٤",
        "٥",
        "٦",
        "٧",
        "٨",
        "٩",
        "يناير",
        "فبراير",
        "مارس",
        "أبريل",
        "مايو",
        "يونيو",
        "يوليو",
        "أغسطس",
        "سبتمبر",
        "أكتوبر",
        "نوفمبر",
        "ديسمبر",
        "السبت",
        "الأحد",
        "الإثنين",
        "الثلاثاء",
        "الأربعاء",
        "الخميس",
        "الجمعة",
        "ص",
        "م",
    ];

    setInterval(function () {
        var date = new Date();
        var strDate = replaceCumulative(
            DateTime(date, "%D:s، %d %M:s %Y"),
            english_date_time,
            arabic_date_time
        );

        var strTime = replaceCumulative(
            DateTime(date, "%h:%i:%s %ampm"),
            english_date_time,
            arabic_date_time
        );

        $("header .top-nav .date-time .date").html(strDate);
        $("header .top-nav .date-time .time").html(strTime);
    }, 1000);
});
