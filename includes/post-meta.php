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
			Field::make('select', 'membership_review', __('Membership Review'))
				->set_options(array(
					'' => 'None',
					'&nbsp;' => 'None(Blank)',
					'Annual' => 'Annual',
					'Per Quarter' => 'Per Quarter'
				)),

			Field::make('text', 'discount_mm_training_networking', __('Discount: MM training & networking')),
			Field::make('text', 'discount_events_marketing_services', __('Discount: Events and/or Marketing services')),
			Field::make('text', 'discount_medtech_expo', __('Discount: MedTech Innovation Expo (MTI) exhibition space')),
			Field::make('text', 'discount_internation_trade', __('Discount: Access to International Trade Shows discounts')),
			Field::make('text', 'marketing_thought_leadership_article', __('Marketing: Thought leadership article')),
			Field::make('text', 'marketing_blog', __('Marketing: Blog (1 per year)')),
			Field::make('text', 'marketing_promotion', __('Marketing: Promotion of events')),
			Field::make('text', 'marketing_memeber_marketplace', __('Marketing: Member Market place listing')),
			Field::make('select', 'marketing_level', __('Marketing Level'))
				->set_options(array(
					'' => 'None',
					'Level 1' => 'Level 1',
					'Level 2' => 'Level 2',
					'Level 3' => 'Level 3',
					'Level 4' => 'Level 4',
				)),


			Field::make('complex', 'taxonomy_terms_custom_text', __('Taxonomy Terms Custom Text'))
				->add_fields(array(
					Field::make('text', 'term_slug', __('Term Slug')),
					Field::make('select', 'membership_review', __('Membership Review'))
						->set_options(packages_category()),
					Field::make('text', 'custom_text', __('Custom Text')),
				))
				->set_layout('tabbed-horizontal')
				->set_header_template('<%- term_slug %> : <%- custom_text %> ')
		)
	);
