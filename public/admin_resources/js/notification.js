// Error Message

$(".notification").css({
    top: $(".navbar").outerHeight() + 10,
    right: $(".notification").outerWidth() * -1,
});

$(window).on("resize", function () {
    $(".notification").css({
        top: $(".navbar").outerHeight() + 10,
        right: $(".notification").outerWidth() * -1,
    });
});

function notify(element, delay = 2000, duration = 1000) {
    $(element).each(function () {
        $(this)
            .show()
            .animate(
                {
                    right: 0,
                },
                duration
            )
            .delay(delay)
            .animate(
                {
                    right: $(this).outerWidth() * -1,
                },
                duration,
                function () {
                    $(this).hide();
                }
            );
    });
}
