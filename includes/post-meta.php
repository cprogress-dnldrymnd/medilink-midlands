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
				)),
		)
	);
