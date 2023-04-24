<?php

add_action( 'add_meta_boxes', 'stag_metabox_portfolio' );

function stag_metabox_portfolio() {

	$meta_box = array(
		'id'          => 'stag-metabox-portfolio',
		'title'       => __( 'Portfolio Settings', 'doctype-assistant' ),
		'description' => __( 'Here you can customize your project details.', 'doctype-assistant' ),
		'page'        => 'portfolio',
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name' => __( 'Project Images', 'doctype-assistant' ),
				'desc' => __( 'Choose project images, ideal size 1170px x unlimited.', 'doctype-assistant' ),
				'id'   => '_stag_portfolio_images',
				'type' => 'images',
				'std'  => __( 'Upload Images', 'doctype-assistant' ),
			),
			array(
				'name' => __( 'Subtitle', 'doctype-assistant' ),
				'desc' => __( 'Enter the subtitle for this portfolio item', 'doctype-assistant' ),
				'id'   => '_stag_portfolio_subtitle',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'Client Name', 'doctype-assistant' ),
				'desc' => __( 'Enter the client name of the project', 'doctype-assistant' ),
				'id'   => '_stag_portfolio_client',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'Project Date', 'doctype-assistant' ),
				'desc' => __( 'Choose the project date in MM/DD/YYYY format. E.g. 12/23/2012', 'doctype-assistant' ),
				'id'   => '_stag_portfolio_date',
				'type' => 'text',
				'std'  => '',
			),
			array(
				'name' => __( 'Project URL', 'doctype-assistant' ),
				'desc' => __( 'Enter the project URL', 'doctype-assistant' ),
				'id'   => '_stag_portfolio_url',
				'type' => 'text',
				'std'  => '',
			),
		),
	);
	stag_add_meta_box( $meta_box );
}
