<?php

add_action( 'add_meta_boxes', 'stag_metabox_page' );

function stag_metabox_page() {

	$meta_box = array(
		'id'          => 'stag-metabox-page',
		'title'       => __( 'Page Settings', 'doctype-assistant' ),
		'description' => __( 'Customize your page details.', 'doctype-assistant' ),
		'page'        => 'page',
		'context'     => 'normal',
		'priority'    => 'high',
		'fields'      => array(
			array(
				'name' => __( 'Subtitle', 'doctype-assistant' ),
				'desc' => __( 'Enter the subtitle for this page.', 'doctype-assistant' ),
				'id'   => '_stag_page_subtitle',
				'type' => 'text',
				'std'  => '',
			),
		),
	);
	stag_add_meta_box( $meta_box );
}
