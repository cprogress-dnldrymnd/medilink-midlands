jQuery(document).ready(function () {
    ajax_member_directory();
    ajax_member_marketplace();
    select__2();
    membership_form();
    package();
    learn_more();
    textarea_counter();
    profile_marketplace_nav();
    claim_offer();
});

function claim_offer() {
    jQuery('.claim-offer-button').click(function (e) {
        $offer_title = jQuery(this).attr('offer_title');
        $offer_desc = jQuery(this).attr('offer_desc');
        $offer_owner = jQuery(this).attr('offer_owner');
        $offer_owner_email = jQuery(this).attr('offer_owner_email');
        $offer_owner_company = jQuery(this).attr('offer_owner_company');
        $offer_owner_company = jQuery(this).attr('offer_owner_company');
        $offer_image = jQuery(this).attr('offer_image');
        $offer_details = jQuery(this).attr('offer_details');
        $documents = jQuery(this).attr('documents');

        jQuery('input[name="offer_title"]').val($offer_title);
        jQuery('input[name="offer_desc"]').val($offer_desc);
        jQuery('input[name="offer_owner"]').val($offer_owner);
        jQuery('input[name="offer_owner_email"]').val($offer_owner_email);
        jQuery('input[name="offer_owner_company"]').val($offer_owner_company);

        jQuery('.claim-offer-form .offer-title').text($offer_title);
        jQuery('.claim-offer-form .offer-author').text($offer_owner_company);
        jQuery('.claim-offer-form .offer-details').html($offer_details);
        jQuery('.claim-offer-form .offer-image img').attr('src', $offer_image);
        jQuery('.claim-offer-form .supporting-documents').html($documents);

        jQuery('#form-clicked .wpcf7-submit').click();
        e.preventDefault();
    });
}
function profile_marketplace_nav() {
    if (jQuery('body').hasClass('um-page-user')) {
        $anchor = '<div class="um-profile-nav-item um-profile-nav-marketplace"><a href="?profiletab=marketplace" class="profile-nav-marketplace" title="Marketplace"> <svg xmlns="http://www.w3.org/2000/svg" width="90.78" height="90.78" viewBox="0 0 90.78 90.78"><g id="materials-svgrepo-com" transform="translate(-1 -1)"><path id="Path_35" data-name="Path 35" d="M3,22.284,36.748,3,89.78,22.284M3,22.284V46.39L56.032,65.674,89.78,46.39V22.284M3,22.284,56.032,41.569,89.78,22.284" transform="translate(0 0)" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"/><path id="Path_36" data-name="Path 36" d="M3,12V36.106L56.032,55.39,89.78,36.106V12" transform="translate(0 34.39)" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"/></g></svg> <span class="title">Marketplace</span> </a></div>';
        jQuery($anchor).appendTo('.um-profile-nav')
    }
}


function textarea_counter() {

    // Function to update character count
    function updateCharacterCount(textarea, counterElement, MAX_LENGTH, WARNING_THRESHOLD) {
        const text = textarea.val();
        const length = text.length;

        counterElement.text(length + ' / ' + MAX_LENGTH + ' char');

        // Remove any existing classes first.
        counterElement.removeClass('warning error');

        if (length > MAX_LENGTH) {
            counterElement.addClass('error');
        } else if (length > WARNING_THRESHOLD) {
            counterElement.addClass('warning');
        }
    }

    // Create counter for each textarea
    jQuery('.text-counter').each(function () {
        const textarea = jQuery(this).find('textarea');
        MAX_LENGTH = textarea.attr('maxlength');
        WARNING_THRESHOLD = jQuery(this).attr('threshold');
        counter = jQuery(this).find('.text-counter-holder');
        // Initial count update
        updateCharacterCount(textarea, counter, MAX_LENGTH, WARNING_THRESHOLD);

        // Bind input event to update count dynamically
        textarea.on('input', function () {
            updateCharacterCount(textarea, counter, MAX_LENGTH, WARNING_THRESHOLD);
        });
    });
}
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
        placeholder: "Category",
    });


    jQuery('select[name="offer_category_pseudo[]"]').on('change', function () {
        var selectedValues = jQuery(this).val();

        if (selectedValues) {
            jQuery('input[name="submit_offer_category"]').val(selectedValues.join(", "));
        } else {
            jQuery('input[name="submit_offer_category"]').val('');
        }
    });


    jQuery('select[name="blog_category_pseudo[]"]').on('change', function () {
        var selectedValues = jQuery(this).val();

        if (selectedValues) {
            jQuery('input[name="submit_blog_category"]').val(selectedValues.join(", "));
        } else {
            jQuery('input[name="submit_blog_category"]').val('');
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


function ajax_member_directory() {
    jQuery('.load-more-directory').on('click', function (event) {
        _ajax_filter_member_directory(jQuery(this), 'false', 'loadmore');
        event.preventDefault();
    });

    jQuery('.submit-directory-filter').on('click', function (event) {
        _ajax_filter_member_directory(jQuery(this), 'true');
        event.preventDefault();
    });
}

function _ajax_filter_member_directory(button, is_filter, type = 'search') {
    search_var = jQuery('input[name="search_var"]').val();
    var directory_filter = jQuery("input[name='directory-filter[]']:checked")
        .map(function () {
            return jQuery(this).val();
        })
        .get();
    jQuery.ajax({
        url: ajax_params.ajax_url,
        type: 'POST',
        data: {
            action: 'ajax_member_directory_load_more',
            paged: ajax_params.paged,
            search_var: search_var,
            is_filter: is_filter,
            directory_filter: directory_filter,
            security: ajax_params.nonce,
        },
        beforeSend: function () {
            if (type == 'search') {
                jQuery('.ajax-result').addClass('loading loading-search');
            } else {
                jQuery('.ajax-result').addClass('loading loading-loadmore');
            }

        },
        success: function (response) {
            if (response === 'no_more_posts') {
                button.text('No more posts').prop('disabled', true).addClass('no-more-post');
            } else {
                if (is_filter == 'true') {
                    jQuery('#results').html(response);
                } else {
                    jQuery('#results > .row').append(response);
                }
                if (is_filter == 'false') {
                    ajax_params.paged = parseInt(ajax_params.paged) + 1;
                }
            }
            jQuery('.ajax-result').removeClass('loading loading-search loading-loadmore');

        },
        error: function (error) {
            console.log(error);
            button.text('Error');
        }
    });
}
function ajax_member_marketplace() {
    jQuery('.load-more-marketplace').on('click', function (event) {
        _ajax_member_marketplace();
        event.preventDefault();
    });

}
function _ajax_member_marketplace() {
    membersmarketplace_category = jQuery('input[name="membersmarketplace_category"]').val();
    jQuery.ajax({
        url: ajax_params.ajax_url,
        type: 'POST',
        data: {
            action: 'ajax_member_marketplace',
            paged: ajax_params.paged,
            membersmarketplace_category: membersmarketplace_category,
            security: ajax_params.nonce,
        },
        beforeSend: function () {
            jQuery('.ajax-result').addClass('loading loading-loadmore');
        },
        success: function (response) {
            if (response === 'no_more_posts') {
                jQuery('.load-more-marketplace').text('No more posts').prop('disabled', true).addClass('no-more-post');
            } else {
                jQuery('#results  .row').append(response);
                ajax_params.paged = parseInt(ajax_params.paged) + 1;
            }
            jQuery('.ajax-result').removeClass('loading loading-loadmore');
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