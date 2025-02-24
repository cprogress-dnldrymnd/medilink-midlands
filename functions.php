<?php
function wikb_child_scripts() {
    wp_enqueue_style( 'wikb-parent-style', get_template_directory_uri(). '/style.css' );
    wp_enqueue_style( 'wikb-parent-style', get_template_directory_uri(). '/style.css' );
    
     wp_enqueue_style( 'wikb-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );
    wp_enqueue_style( 'wikb-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js');
}
add_action( 'wp_enqueue_scripts', 'wikb_child_scripts' );

add_action('carbon_fields_register_fields', 'cv_register_custom_fields');

function cv_register_custom_fields()
{
	require_once dirname(__FILE__) . '/includes/post-meta.php';
}
require_once('includes/shortcodes.php');
require_once('includes/post-types.php');