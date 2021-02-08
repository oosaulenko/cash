const axios = require('axios');


(function ($) {

    $('#sideNavButton').on('click', function () {
        if ($(this).hasClass('active')) {
            $('.sidenav, body').removeClass('active');
            $(this).removeClass('active');
        } else {
            $('.sidenav, body').addClass('active');
            $(this).addClass('active');
        }
    });

    $('#sideFilterButton').on('click', function () {
        if ($(this).hasClass('active')) {
            $('.filter, body').removeClass('active--filter');
            $(this).removeClass('active');
        } else {
            $('.filter, body').addClass('active--filter');
            $(this).addClass('active');
        }
    });

})(jQuery);

axios.get('')