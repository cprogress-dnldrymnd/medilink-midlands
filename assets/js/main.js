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
    jQuery('.load-more-directory').on('click', function (event) {
        var button = jQuery(this);
        offset = jQuery('.post-item').length;
        jQuery.ajax({
            url: ajax_post_loader_params.ajax_url,
            type: 'POST',
            data: {
                action: 'ajax_post_loader_load_more',
                offset: offset,
                security: ajax_post_loader_params.nonce,
            },
            beforeSend: function () {
                button.text('Loading...');
            },
            success: function (response) {
                if (response === 'no_more_posts') {
                    button.text('No more posts').prop('disabled', true);
                } else {
                    jQuery('#results .row').append(response);
                    paged++;
                    button.text('Load More');
                }
            },
            error: function (error) {
                console.log(error);
                button.text('Error');
            }
        });
        event.preventDefault();
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