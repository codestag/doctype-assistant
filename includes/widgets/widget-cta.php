<?php
add_action( 'widgets_init', array( 'stag_widget_cta', 'register' ) );

class stag_widget_cta extends WP_Widget {
	function __construct() {
		$widget_ops  = array(
			'classname'   => 'section-call-to-action',
			'description' => __( 'Displays a call to action.', 'doctype-assistant' ),
		);
		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'stag_widget_cta',
		);
		parent::__construct( 'stag_widget_cta', __( 'Section: Call To Action', 'doctype-assistant' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// VARS FROM WIDGET SETTINGS
		$title = apply_filters( 'widget_title', $instance['title'] );
		$link  = $instance['link'];
		$text  = $instance['text'];

		echo $before_widget;
		?>

		<div class="grids">
			<div class="grid-7">
				<h2><?php echo $title; ?></h2>
			</div>
			<div class="grid-5">
				<?php if ( $text != '' ) : ?>
				<a href="<?php echo esc_url( $link ); ?>" class="button"><?php echo esc_attr( $text ); ?></a>
				<?php endif; ?>
			</div>
		</div>

		<?php

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// STRIP TAGS TO REMOVE HTML
		$instance['title'] = $new_instance['title'];
		$instance['link']  = strip_tags( $new_instance['link'] );
		$instance['text']  = strip_tags( $new_instance['text'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			/* Deafult options goes here */
			'title' => '',
			'link'  => '',
			'text'  => '',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		/* HERE GOES THE FORM */
	?>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Button Link:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Button Text:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" value="<?php echo $instance['text']; ?>" />
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
