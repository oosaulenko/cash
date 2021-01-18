
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

})(jQuery);