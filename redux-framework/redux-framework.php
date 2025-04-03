<?php
if (class_exists('Redux')) {
    // BE SURE TO RENAME THE FUNCTION NAMES TO YOUR OWN NAME OR PREFIX
    if (!function_exists("redux_add_metaboxes")):
        function redux_add_metaboxes_plan_settings($metaboxes)
        {
            $redux_opt_name = 'plan_settings';
            // Declare your sections
            $boxSections = array();
            $boxSections[] = array(
                //'title'         => __('General Settings', 'redux-framework-demo'),
                //'icon'          => 'el-icon-home', // Only used with metabox position normal or advanced
                'fields'        => array(
                    array(
                        'id' => 'short_description',
                        'title' => __('Short Description', 'redux-framework-demo'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'core_benefits_title',
                        'title' => __('Core Benefits Title', 'redux-framework-demo'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'core_benefits',
                        'title' => __('Core Benefits', 'redux-framework-demo'),
                        'type' => 'editor',
                    ),
                    array(
                        'id' => 'additional_benefits',
                        'title' => __('Additional Benefits', 'redux-framework-demo'),
                        'type' => 'editor',
                    ),
                    array(
                        'id' => 'discounts',
                        'title' => __('Discounts', 'redux-framework-demo'),
                        'type' => 'editor',
                    ),
                ),
            );

            // Declare your metaboxes
            $metaboxes = array();
            $metaboxes[] = array(
                'id'            => 'plan_settings',
                'title'         => __('Plan Settings', 'wikb'),
                'post_types'    => array('umm_stripe'),
                //'page_template' => array('page-test.php'), // Visibility of box based on page template selector
                //'post_format' => array('image'), // Visibility of box based on post format
                'position'      => 'normal', // normal, advanced, side
                'priority'      => 'high', // high, core, default, low - Priorities of placement
                'sections'      => $boxSections,
            );

            return $metaboxes;
        }
        // Change {$redux_opt_name} to your opt_name
        add_action("redux/metaboxes/{$redux_opt_name}/boxes", "redux_add_metaboxes_plan_settings");

        function redux_add_metaboxes_page_options($metaboxes)
        {
            $redux_opt_name = 'page_options';
            // Declare your sections
            $boxSections = array();
            $boxSections[] = array(
                //'title'         => __('General Settings', 'redux-framework-demo'),
                //'icon'          => 'el-icon-home', // Only used with metabox position normal or advanced
                'fields'        => array(
                    array(
                        'id' => 'header_title_style',
                        'title' => __('Header Title Style', 'redux-framework-demo'),
                        'type' => 'select',
                        'options' => array(
                            'style-default' => 'Default',
                            'style-1' => 'Style 1',
                            'style-2' => 'Style 2'
                        )
                    ),
                    array(
                        'id' => 'title_area_description',
                        'title' => __('Title Area Description', 'redux-framework-demo'),
                        'type' => 'select',
                        'options' => array(
                            'style-default' => 'Default',
                            'style-1' => 'Style 1',
                            'style-2' => 'Style 2'
                        )
                    ),
                ),
            );

            // Declare your metaboxes
            $metaboxes = array();
            $metaboxes[] = array(
                'id'            => 'page_options',
                'title'         => __('Page Options', 'wikb'),
                'post_types'    => array('page'),
                //'page_template' => array('page-test.php'), // Visibility of box based on page template selector
                //'post_format' => array('image'), // Visibility of box based on post format
                'position'      => 'side', // normal, advanced, side
                'priority'      => 'high', // high, core, default, low - Priorities of placement
                'sections'      => $boxSections,
            );

            return $metaboxes;
        }
        // Change {$redux_opt_name} to your opt_name
        add_action("redux/metaboxes/{$redux_opt_name}/boxes", "redux_add_metaboxes_page_options");
    endif;
}
