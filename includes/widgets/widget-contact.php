<?php
add_action( 'widgets_init', array( 'stag_widget_contact', 'register' ) );

class stag_widget_contact extends WP_Widget {
	function __construct() {
		$widget_ops  = array(
			'classname'   => 'section-contact',
			'description' => __( 'Displays contact information.', 'doctype-assistant' ),
		);
		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'stag_widget_contact',
		);
		parent::__construct( 'stag_widget_contact', __( 'Section: Contact Info', 'doctype-assistant' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// VARS FROM WIDGET SETTINGS
		$title       = apply_filters( 'widget_title', $instance['title'] );
		$subtitle    = $instance['subtitle'];
		$lat         = $instance['lat'];
		$long        = $instance['long'];
		$description = $instance['description'];

		echo $before_widget;

		?>

		<?php if ( $title ) : ?>
		<header class="page-header page-header--portfolio">
			<h2 class="blog-title"><span><?php echo $title; ?></span></h2>
			<?php if ( $subtitle ) : ?>
			<p class="blog-subtitle"><?php echo $subtitle; ?></p>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php
		if ( $lat != '' && $long != '' ) {
			echo do_shortcode( "[stag_map lat='$lat' long='$long' height=400px]" );
		}
			?>

		<span class="inner-section-divider"><i class="fa fa-envelope-o"></i></span>

		<div class="entry-content">
			<?php echo wpautop( $description ); ?>
		</div>


		<?php endif; ?>



		<?php

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// STRIP TAGS TO REMOVE HTML
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['subtitle']    = strip_tags( $new_instance['subtitle'] );
		$instance['description'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['description'] ) ) );
		$instance['lat']         = $new_instance['lat'];
		$instance['long']        = $new_instance['long'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			/* Deafult options goes here */
			'title'       => __( 'Get in Touch', 'doctype-assistant' ),
			'subtitle'    => '',
			'description' => '',
			'lat'         => '',
			'long'        => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		/* HERE GOES THE FORM */
	?>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Subtitle:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'lat' ); ?>"><?php _e( 'Google Map Latitude:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'lat' ); ?>" name="<?php echo $this->get_field_name( 'lat' ); ?>" value="<?php echo $instance['lat']; ?>" />
		<span class="description"><?php echo sprintf( __( 'Enter the latitude of Google Map, which can be found <a href="%s" target="_blank">here</a>.', 'doctype-assistant' ), '//universimmedia.pagesperso-orange.fr/geo/loc.htm' ); ?></span>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'long' ); ?>"><?php _e( 'Google Map Longitude:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'long' ); ?>" name="<?php echo $this->get_field_name( 'long' ); ?>" value="<?php echo $instance['long']; ?>" />
		<span class="description"><?php _e( 'Enter the longitude of Google map.', 'doctype-assistant' ); ?></span>
	</p>

	<p>
	<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Contact Information:', 'doctype-assistant' ); ?></label>
	  <textarea rows="16" cols="20" name="<?php echo $this->get_field_name( 'description' ); ?>" id="<?php echo $this->get_field_id( 'description' ); ?>" class="widefat"><?php echo @$instance['description']; ?></textarea>
	</p>

	<?php
    }

	/**
	 * Registers the widget with the WordPress Widget API
	 */
	public static function register() {
		register_widget( __CLASS__ );
	}
}

?>
