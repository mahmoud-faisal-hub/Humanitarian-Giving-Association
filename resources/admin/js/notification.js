// Error Message

$(".notification").css({

    "top": $(".navbar").outerHeight() + 10,
    "right": $(".error-message").outerWidth() * -1

});

$(".notification").each(function () {

    $(this).animate({

        "right": 0

    }, 1000).delay(3000).animate({

        "right": $(this).outerWidth() * -1

    }, 1000);


});
