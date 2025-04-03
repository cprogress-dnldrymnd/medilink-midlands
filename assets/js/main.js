jQuery(document).ready(function () {
    ajax();
    select__2();
    membership_form();
    package();
    learn_more();
});

function package() {

    if (jQuery('.package-price-main-details-inner').length > 0) {
        matchHeights('.package-price-main-details-inner');
    }

}
function learn_more() {
    jQuery('.learn-more a').click(function (e) {
        jQuery(this).parents('.inner').addClass('package-active');
        e.preventDefault();
    });
}
function select__2() {
    jQuery('.select-2-trigger select').select2({
        placeholder: "Other",
        maximumSelectionLength: 3,
    });


    jQuery('select[name="more-sectors-pseudo[]"]').on('change', function () {
        var selectedValues = jQuery(this).val();
        // Clear the existing list items
        var listElement = jQuery('.selected-sectors');
        listElement.empty();
        // Get the selected values from the multiselect

        // If there are selected values, create list items
        if (selectedValues) {
            // Iterate over the selected values and create list items
            selectedValues.forEach(function (value) {
                var listItem = jQuery("<div class='selected-sector' for='" + value + "'>").text(value);
                listElement.append(listItem);
            });
        }
        if (selectedValues) {
            jQuery('input[name="more-sectors"]').val(selectedValues.join(", "));
        } else {
            jQuery('input[name="more-sectors"]').val('');
        }
    });



    jQuery('body').on('click', '.selected-sectors .selected-sector', function () {
        // The value you want to remove. Change this to the actual value.
        var valueToRemove = jQuery(this).attr('for');
        console.log(valueToRemove);
        jQuery('select[name="more-sectors-pseudo[]"]').val(function (index, currentValues) {
            if (currentValues) {
                return currentValues.filter(function (value) {
                    return value !== valueToRemove;
                });
            }
            return null;
        }).trigger('change');
    });

    // Initialize Select2 for the category select element

    jQuery('.select-2-category select').select2({
        placeholder: "Offer Category",
    });


    jQuery('select[name="offer_category_pseudo[]"]').on('change', function () {
        var selectedValues = jQuery(this).val();

        if (selectedValues) {
            jQuery('input[name="submit_offer_category"]').val(selectedValues.join(", "));
        } else {
            jQuery('input[name="submit_offer_category"]').val('');
        }
    });

}


function membership_form() {
    $nav = jQuery('<ul class="cf7-nav"></ul>');
    $key = 0;
    jQuery('.fieldset-cf7mls .step-title').each(function (index, element) {
        $text = jQuery(this).text();
        $text_html = jQuery('<li key="' + $key + '">' + $text + '</li>');
        $text_html.appendTo($nav);
        $key++;
    });

    $nav.insertBefore('.fieldset-cf7mls-wrapper');

    jQuery('.cf7-nav > li:first-child').addClass('active');



    jQuery(document).on("click", ".cf7mls_next", function () {

        setTimeout(function () {
            var intervalId = window.setInterval(function () {
                check_steps();
            }, 100);
        }, 2000);


    });

    function check_steps() {
        if (jQuery('.action-button.sending').length == 0) {
            $key = jQuery('.cf7mls_current_fs').attr('data-cf7mls-order');
            jQuery('.cf7-nav li').removeClass('active');
            jQuery('.cf7-nav li[key="' + $key + '"]').addClass('active');
        } else {
            clearInterval(intervalId);
        }
    }


    jQuery(document).on("click", ".cf7mls_back", function () {
        setTimeout(function () {
            $key = jQuery('.cf7mls_current_fs').attr('data-cf7mls-order');
            jQuery('.cf7-nav li').removeClass('active');
            jQuery('.cf7-nav li[key="' + $key + '"]').addClass('active');
        }, 100);

    });

    jQuery('input[name="select-sector[]"]').change(function () {
        jQuery('input[name="select-sector[]"]').not(this).prop('checked', false);
    });


}


function ajax() {
    jQuery('.load-more-directory').on('click', function (event) {
        _ajax_filter(jQuery(this), 'false');
        event.preventDefault();
    });

    jQuery('.submit-directory-filter').on('click', function (event) {
        _ajax_filter(jQuery(this), 'true');
        event.preventDefault();
    });
}

function _ajax_filter(button, is_filter) {
    search_var = jQuery('input[name="search_var"]').val();

    var directory_filter = jQuery("input[name='directory-filter[]']:checked")
        .map(function () {
            return jQuery(this).val();
        })
        .get();
    jQuery.ajax({
        url: ajax_post_loader_params.ajax_url,
        type: 'POST',
        data: {
            action: 'ajax_post_loader_load_more',
            paged: ajax_post_loader_params.paged,
            search_var: search_var,
            is_filter: is_filter,
            directory_filter: directory_filter,
            security: ajax_post_loader_params.nonce,
        },
        beforeSend: function () {
            button.text('Loading...');
        },
        success: function (response) {
            if (response === 'no_more_posts') {
                button.text('No more posts').prop('disabled', true);
            } else {
                if (is_filter == 'true') {
                    jQuery('#results').html(response);
                } else {
                    jQuery('#results > .row').append(response);
                }
                if (is_filter == 'false') {
                    ajax_post_loader_params.paged = parseInt(ajax_post_loader_params.paged) + 1;
                }

                console.log(ajax_post_loader_params.paged);
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

document.addEventListener('DOMContentLoaded', function () {
    var wpcf7Elm = document.querySelector('.wpcf7'); // Adjust selector if needed

    if (wpcf7Elm) {
        wpcf7Elm.addEventListener('wpcf7mailsent', function (event) {
            // Success message
            var responseOutput = wpcf7Elm.querySelector('.wpcf7-response-output');
            if (responseOutput) {
                // Define your success SVG code here
                var successSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="green" aria-hidden="true" style="vertical-align: middle; margin-right: 5px;"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>';
                // Prepend the SVG to the existing message
                responseOutput.innerHTML = successSVG + responseOutput.innerHTML;
            }
        }, false);

        wpcf7Elm.addEventListener('wpcf7invalid', function (event) {
            // Validation error message
            var responseOutput = wpcf7Elm.querySelector('.wpcf7-response-output');
            if (responseOutput) {
                // Define your error SVG code here
                var errorSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="orange" aria-hidden="true" style="vertical-align: middle; margin-right: 5px;"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>';
                responseOutput.innerHTML = errorSVG + responseOutput.innerHTML;
            }
        }, false);

        wpcf7Elm.addEventListener('wpcf7spam', function (event) {
            // Spam message
            var responseOutput = wpcf7Elm.querySelector('.wpcf7-response-output');
            if (responseOutput) {
                // Use an appropriate SVG (e.g., similar to error)
                var spamSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="red" aria-hidden="true" style="vertical-align: middle; margin-right: 5px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>';
                responseOutput.innerHTML = spamSVG + responseOutput.innerHTML;
            }
        }, false);

        wpcf7Elm.addEventListener('wpcf7mailfailed', function (event) {
            // Mail sending failed message (server error)
            var responseOutput = wpcf7Elm.querySelector('.wpcf7-response-output');
            if (responseOutput) {
                // Use an appropriate SVG (e.g., similar to error)
                var mailFailSVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="red" aria-hidden="true" style="vertical-align: middle; margin-right: 5px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>';
                responseOutput.innerHTML = mailFailSVG + responseOutput.innerHTML;
            }
        }, false);
    }
});
