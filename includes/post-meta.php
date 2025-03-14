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

Container::make('theme_options', 'Packages')
	->add_fields(
		array(
			Field::make('complex', 'packages', __(''))
				->add_fields(array(
					Field::make('text', 'package_name', __('package_name')),
					Field::make('rich_text', 'package_short_description', __('short_description')),
					Field::make('text', 'package_core_benefits_title', __('core_benefits_title')),
					Field::make('rich_text', 'package_core_benefits', __('core_benefits')),
					Field::make('rich_text', 'package_additional_benefits', __('additional_benefits')),
					Field::make('rich_text', 'package_discounts', __('discounts')),
					Field::make('text', 'package_member_level', __('package_member_level')),
					Field::make('text', 'package_price', __('package_price')),
				))
				->set_header_template('<%- package_name %>')
				->set_layout('tabbed-vertical')
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

Container::make('post_meta', 'Packages Details')
	->where('post_type', '=', 'packages')
	->add_fields(
		array(
			Field::make('select', 'membership_review', __('Membership Review'))
				->set_options(array(
					'' => 'None',
					'Annual' => 'Annual',
					'Per Quarter' => 'Per Quarter'
				)),

			Field::make('text', 'discount_mm_training_networking', __('Discount: MM training & networking')),
			Field::make('text', 'discount_events_marketing_services', __('Discount: Events and/or Marketing services')),
			Field::make('text', 'discount_medtech_expo', __('Discount: MedTech Innovation Expo (MTI) exhibition space')),
			Field::make('text', 'discount_internation_trade', __('Discount: Access to International Trade Shows discounts')),
			Field::make('select', 'marketing_level', __('Marketing Level'))
				->set_options(array(
					'' => 'None',
					'Level 1' => 'Level 1',
					'Level 2' => 'Level 2',
					'Level 3' => 'Level 3',
					'Level 4' => 'Level 4',
				)),

		)
	);
