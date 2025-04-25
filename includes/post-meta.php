<?php

use Carbon_Fields\Container;
use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;

/*-----------------------------------------------------------------------------------*/
/* Membership Marketplace
/*-----------------------------------------------------------------------------------*/

Container::make('post_meta', 'Resources')
	->where('post_type', '=', 'membersmarketplace')
	->set_priority('high')
	->add_fields(
		array(
			Field::make('complex', 'submit_offer_supporting_resource', __(''))
				->add_fields(array(
					Field::make('file', 'resource', __('Resource File')),
				)),
		)
	);

/*-----------------------------------------------------------------------------------*/
/* Membership Marketplace
/*-----------------------------------------------------------------------------------*/

Container::make('post_meta', 'Submitted By')
	->where('post_type', '=', 'post')
	->set_priority('high')
	->set_context('side')
	->add_fields(
		array(
			Field::make('text', 'submit_blog_full_name', __('Full Name')),
			Field::make('text', 'submit_blog_email_address', __('Email Address')),
			Field::make('text', 'submit_blog_organisation', __('Organisation')),
			Field::make('text', 'submit_blog_phone_number', __('Phone')),
		)
	);

/*-----------------------------------------------------------------------------------*/
/* Membership Marketplace
/*-----------------------------------------------------------------------------------*/

function packages_category()
{
	global $wpdb;

	$taxonomy = 'packages_category';
	$terms_arr = [];

	$results = $wpdb->get_results($wpdb->prepare(
		"SELECT t.slug, t.name
		FROM {$wpdb->terms} AS t
		INNER JOIN {$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id
		WHERE tt.taxonomy = %s",
		$taxonomy
	));

	if ($results) {
		foreach ($results as $row) {
			$terms_arr[$row->slug] = $row->name;
		}
	}

	return $terms_arr;
}

Container::make('post_meta', 'Packages Details')
	->where('post_type', '=', 'packages')
	->add_fields(
		array(
			Field::make('text', 'price', __('Price')),
			Field::make('select', 'marketing_level', __('Marketing Level'))
				->set_options(array(
					'' => 'None',
					'Level 1' => 'Level 1',
					'Level 2' => 'Level 2',
					'Level 3' => 'Level 3',
					'Level 4' => 'Level 4',
				)),
			Field::make('select', 'marketing_level_custom_text', __('Marketing Level Custom Text')),


			Field::make('complex', 'taxonomy_terms_custom_text', __('Taxonomy Terms Custom Text'))
				->add_fields(array(
					Field::make('select', 'term_slug', __('Select Term'))
						->set_width(50)
						->set_options(packages_category()),
					Field::make('text', 'custom_text', __('Custom Text'))
						->set_width(50)

				))
				->set_layout('grid')
				->set_collapsed(true)
				->set_header_template('<%- term_slug %> : <%- custom_text %> ')
		)
	);
