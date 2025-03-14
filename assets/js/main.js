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
        maximumSelectionLength: 3,
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
            $key = jQuery('.cf7mls_current_fs').attr('data-cf7mls-order');
            jQuery('.cf7-nav li').removeClass('active');
            jQuery('.cf7-nav li[key="' + $key + '"]').addClass('active');
        }, 2000);


    });


    jQuery(document).on("click", ".cf7mls_back", function () {
        setTimeout(function () {
            $key = jQuery('.cf7mls_current_fs').attr('data-cf7mls-order');
            jQuery('.cf7-nav li').removeClass('active');
            jQuery('.cf7-nav li[key="' + $key + '"]').addClass('active');
        }, 100);

    });

    const radioButtons = document.querySelectorAll('input[name="sectors"]');
    let previouslySelected = null;

    radioButtons.forEach(radioButton => {
        radioButton.addEventListener('click', function () {
            if (this === previouslySelected) {
                this.checked = false;
                previouslySelected = null;
            } else {
                previouslySelected = this;
            }
            displaySelected();
        });
    });

    function displaySelected() {
        let selected = document.querySelector('input[name="sectors"]:checked');
        let displayArea = document.getElementById("selectedOption");
        if (selected) {
            displayArea.textContent = "Selected option: " + selected.value;
        } else {
            displayArea.textContent = "No option selected";
        }
    }
    displaySelected();

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