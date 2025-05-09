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
			Field::make('text', 'marketing_level_custom_text', __('Marketing Level Custom Text')),


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


Container::make('term_meta', __('Category Properties'))
	->where('term_taxonomy', '=', 'packages_category')
	->add_fields(array(
		Field::make('text', 'place', __('Title Color')),
	));


Container::make('post_meta', __('Pending Update'))
	->where('post_type', '=', 'wpsl_stores')
	->add_fields(array(
		Field::make('text', 'pending_title', __('Title')),
		Field::make('textarea', 'pending_description', __('Description')),
		Field::make('text', 'pending_phone', __('Pending Phone')),
		Field::make('text', 'pending_email', __('Pending Email')),
		Field::make('text', 'pending_website', __('Pending Website')),
		Field::make('html', 'approve_changes')->set_html('<a href="/wp-admin/post.php?post=' . $_GET['post'] . '&action=edit&approve_changes=true" aria-disabled="false" class="components-button is-primary is-compact">Approve Changes</a>'),
	));


Container::make('theme_options', __('Settings'))
	->set_page_parent('edit.php?post_type=membersmarketplace')
	->add_fields(array(
		Field::make('textarea', 'member_marketplace_description', __('Hero Description')),
		Field::make('text', 'member_marketplace_form_heading', __('Form Heading')),
		Field::make('textarea', 'member_marketplace_form_description', __('Form Description')),
	));



Container::make('theme_options', __('Email Settings'))
	->set_page_parent('edit.php?post_type=wpsl_stores')
	->add_tab('Directory Submitted ', array(
		Field::make('html', 'html_1')->set_html('<div style="margin: -12px; padding: 12px; background-color: var(--color-success); color: #fff; font-weight: bold; text-transform: uppercase;"> Admin Email Notification : Entry Submitted</div>'),
		Field::make('text', 'member_directory_submitted_admin_email_subject', __('Admin Email Subject')),
		Field::make('rich_text', 'member_directory_submitted_admin_email_message', __('Admin Email Message')),

		Field::make('html', 'html_2')->set_html('<div style="margin: -12px; padding: 12px; background-color: var(--color-info); color: #fff; font-weight: bold; text-transform: uppercase;"> Client Email Notification : Entry Submitted</div>'),
		Field::make('text', 'member_directory_submitted_client_email_subject', __('Client Email Subject')),
		Field::make('rich_text', 'member_directory_submitted_client_email_message', __('Client Email Message')),

		Field::make('html', 'html_3')->set_html('<div style="margin: -12px; padding: 12px; background-color: var(--color-info); color: #fff; font-weight: bold; text-transform: uppercase;"> Client Email Notification : Entry Approve</div>'),
		Field::make('text', 'member_directory_approve_client_email_subject', __('Client Email Subject')),
		Field::make('rich_text', 'member_directory_approve_client_email_message', __('Client Email Message')),
	))
	->add_tab('Directory Updated', array(
		Field::make('html', 'html_4')->set_html('<div style="margin: -12px; padding: 12px; background-color: var(--color-success); color: #fff; font-weight: bold; text-transform: uppercase;"> Admin Email Notification : Entry Submitted</div>'),
		Field::make('text', 'member_directory_updated_admin_email_subject', __('Admin Email Subject')),
		Field::make('rich_text', 'member_directory_updated_admin_email_message', __('Admin Email Message')),

		Field::make('html', 'html_5')->set_html('<div style="margin: -12px; padding: 12px; background-color: var(--color-info); color: #fff; font-weight: bold; text-transform: uppercase;"> Client Email Notification : Entry Updated</div>'),
		Field::make('text', 'member_directory_updated_client_email_subject', __('Client Email Subject')),
		Field::make('rich_text', 'member_directory_updated_client_email_message', __('Client Email Message')),

		Field::make('html', 'html_6')->set_html('<div style="margin: -12px; padding: 12px; background-color: var(--color-info); color: #fff; font-weight: bold; text-transform: uppercase;"> Client Email Notification : Entry Update Approve</div>'),
		Field::make('text', 'member_directory_approve_update_client_email_subject', __('Client Email Subject')),
		Field::make('rich_text', 'member_directory_approve_update_client_email_message', __('Client Email Message')),
	));

Container::make('theme_options', __('Email Settings'))
	->set_page_parent('users.php')
	->add_fields(array(
		Field::make('html', 'html_1')->set_html('<div style="margin: -12px; padding: 12px; background-color: var(--color-success); color: #fff; font-weight: bold; text-transform: uppercase;"> Admin Email Notification : User Details Updated</div>'),
		Field::make('text', 'user_details_updated_admin_email_subject', __('Admin Email Subject')),
		Field::make('rich_text', 'user_details_updated_admin_email_message', __('Admin Email Message')),

		Field::make('html', 'html_2')->set_html('<div style="margin: -12px; padding: 12px; background-color: var(--color-info); color: #fff; font-weight: bold; text-transform: uppercase;"> Client Email Notification : User Details Updated</div>'),
		Field::make('text', 'user_details_updated_client_email_subject', __('Client Email Subject')),
		Field::make('rich_text', 'user_details_updated_client_email_message', __('Client Email Message')),
	));
