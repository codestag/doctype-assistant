<?php
add_action( 'widgets_init', array( 'stag_widget_intro', 'register' ) );

class stag_widget_intro extends WP_Widget {
	function __construct() {
		$widget_ops  = array(
			'classname'   => 'section-intro',
			'description' => __( 'Displays a basic intro.', 'doctype-assistant' ),
		);
		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'stag_widget_intro',
		);
		parent::__construct( 'stag_widget_intro', __( 'Section: Intro', 'doctype-assistant' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		// VARS FROM WIDGET SETTINGS
		$content = $instance['content'];

		echo $before_widget;
		?>

		<h1><?php echo $content; ?></h1>

		<?php

		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// STRIP TAGS TO REMOVE HTML
		$instance['content'] = $new_instance['content'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			/* Deafult options goes here */
			'content' => __( 'I am a <span>dedicated</span> designer who enjoys <span>awesome</span> projects.', 'doctype-assistant' ),
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		/* HERE GOES THE FORM */
	?>

	<p>
	  <textarea rows="16" cols="20" name="<?php echo $this->get_field_name( 'content' ); ?>" id="<?php echo $this->get_field_id( 'content' ); ?>" class="widefat"><?php echo @$instance['content']; ?></textarea>
	  <span class="description">
			<?php _e( 'Use &lt;span&gt; tag to highlight text.', 'doctype-assistant' ); ?>
	  </span>
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
