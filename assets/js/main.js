jQuery(document).ready(function () {
    jQuery('<li id="join-us-button" ><a href="/join-us/"><?= $button ?></a> </li>').appendTo('header .nav-menu');
    jQuery('.select-2-trigger select').select2({
        maximumSelectionLength: 3,
    });

    if (jQuery('.package-price-main-details-inner').length > 0) {
        matchHeights('.package-price-main-details-inner');
    }

    jQuery('.learn-more a').click(function (e) {
        jQuery(this).parents('.inner').addClass('package-active');
        e.preventDefault();
    });
});

function matchHeights(selector) {
    var maxHeight = 0;
    // Reset heights before calculating
    jQuery(selector).css('height', 'auto');

    // Find the tallest element
    jQuery(selector).each(function () {
        maxHeight = Math.max(maxHeight, jQuery(this).outerHeight());
    });

    // Set all elements to the tallest height
    jQuery(selector).height(maxHeight);
}