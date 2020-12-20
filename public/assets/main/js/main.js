/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

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

    if (document.querySelector('.field-select')) {
        $('.field-select').selectize({
            create: true,
            sortField: 'text'
        });
    }


})(jQuery);