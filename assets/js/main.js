jQuery(document).ready(function () {
    ajax();

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


function ajax() {
    var paged = 2; // Start from page 2
    jQuery('.load-more-directory').on('click', function (e) {
        ajax_filter(jQuery(this), false);
        e.preventDefault();
    });


    jQuery('.submit-directory-filter a').click(function (e) {
        ajax_filter(jQuery(this), true);
        e.preventDefault();
    });
}

function ajax_filter(button, is_filter) {
    directory_filter = jQuery('input[name="directory-filter[]"]');
    search = jQuery('input[name="search"]');
    jQuery.ajax({
        url: ajax_post_loader_params.ajax_url,
        type: 'POST',
        data: {
            action: 'ajax_post_loader_load_more',
            paged: paged,
            directory_filter: directory_filter,
            search: search,
            security: ajax_post_loader_params.nonce,
        },
        beforeSend: function () {
            button.text('Loading...');
        },
        success: function (response) {
            if (response === 'no_more_posts') {
                button.text('No more posts').prop('disabled', true);
            } else {
                jQuery('#results > .row').append(response);
                paged++;
                button.text('Load More');
            }
        },
        error: function (error) {
            console.log(error);
            button.text('Error');
        }
    });
}
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