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
					Field::make('textarea', 'package_name', __('package_name')),
					Field::make('textarea', 'package_short_description', __('short_description')),
					Field::make('textarea', 'package_core_benefits_title', __('core_benefits_title')),
					Field::make('textarea', 'package_core_benefits', __('core_benefits')),
					Field::make('textarea', 'package_additional_benefits', __('additional_benefits')),
					Field::make('textarea', 'package_discounts', __('discounts')),
				)),
		)
	);
