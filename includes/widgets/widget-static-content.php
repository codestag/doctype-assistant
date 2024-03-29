<?php
add_action( 'widgets_init', array( 'stag_widget_static_content', 'register' ) );

class stag_widget_static_content extends WP_Widget {
	public function __construct() {
		$widget_ops  = array(
			'classname'   => 'section-static-content',
			'description' => __( 'Displays content from a specific page.', 'doctype-assistant' ),
		);
		$control_ops = array(
			'width'   => 300,
			'height'  => 350,
			'id_base' => 'stag_widget_static_content',
		);
		parent::__construct( 'stag_widget_static_content', __( 'Section: Static Content', 'doctype-assistant' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		// VARS FROM WIDGET SETTINGS
		$title      = apply_filters( 'widget_title', $instance['title'] );
		$page       = $instance['page'];
		$bg_color   = $instance['bg_color'];
		$bg_image   = $instance['bg_image'];
		$bg_opacity = $instance['bg_opacity'];
		$text_color = $instance['text_color'];
		$link_color = $instance['link_color'];

		echo $before_widget;

		$query_args = array(
			'page_id' => $page,
		);

		$query = new WP_Query( $query_args );

		while ( $query->have_posts() ) :
			$query->the_post();

		?>

		<style>
			.section-title span:before{ background: <?php echo $text_color; ?> !important; }
		</style>

		<article <?php post_class(); ?> data-bg-color="<?php echo $bg_color; ?>" data-bg-image="<?php echo $bg_image; ?>" data-bg-opacity="<?php echo $bg_opacity; ?>" data-text-color="<?php echo $text_color; ?>" data-link-color="<?php echo $link_color; ?>">
			<?php
			if ( $title != '' ) {
					echo $before_title;
					echo "<span>{$title}</span>";
					echo $after_title;
			}
				?>
			<div class="entry-content">
				<?php
					global $more;
					$more = false;
					the_content( __( 'Read More&hellip;', 'doctype-assistant' ) );
					wp_link_pages(
						array(
							'before'         => '<p><strong>' . __( 'Pages:', 'doctype-assistant' ) . '</strong> ',
							'after'          => '</p>',
							'next_or_number' => 'number',
						)
					);
				?>
			</div>
		</article>

		<?php

		endwhile;

		wp_reset_query();

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// STRIP TAGS TO REMOVE HTML
		$instance['title']      = wp_strip_all_tags( $new_instance['title'] );
		$instance['page']       = wp_strip_all_tags( $new_instance['page'] );
		$instance['bg_color']   = wp_strip_all_tags( $new_instance['bg_color'] );
		$instance['bg_image']   = esc_url( $new_instance['bg_image'] );
		$instance['bg_opacity'] = wp_strip_all_tags( $new_instance['bg_opacity'] );
		$instance['text_color'] = wp_strip_all_tags( $new_instance['text_color'] );
		$instance['link_color'] = wp_strip_all_tags( $new_instance['link_color'] );

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
			/* Deafult options goes here */
			'title'      => 'Static Content',
			'bg_color'   => '#363f48',
			'bg_opacity' => 50,
			'bg_image'   => '',
			'text_color' => '#ffffff',
			'link_color' => doctype_get_thememod_value( 'accent-color' ),
			'page'       => 0,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		/* HERE GOES THE FORM */
	?>
	<script type='text/javascript'>
		jQuery(document).ready(function($) {
			$('.colorpicker').wpColorPicker();

			$('.widget').find('.wp-picker-container').each(function(){
				var len = $(this).find('.wp-color-result').length;
				if ( len > 1){
					$(this).find('.wp-color-result').first().hide();
				}
			});
		});
	</script>


	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
	  <label for="<?php echo $this->get_field_id( 'page' ); ?>"><?php _e( 'Select Page:', 'doctype-assistant' ); ?></label>

	  <select id="<?php echo $this->get_field_id( 'page' ); ?>" name="<?php echo $this->get_field_name( 'page' ); ?>" class="widefat">
		<?php

		$args  = array(
			'sort_order'  => 'ASC',
			'sort_column' => 'post_title',
		);
		$pages = get_pages( $args );

		foreach ( $pages as $paged ) {
			?>
			<option value="<?php echo $paged->ID; ?>"
										<?php
										if ( $instance['page'] == $paged->ID ) {
											echo 'selected';}
?>
><?php echo $paged->post_title; ?></option>
		<?php
		}

		?>
	 </select>
	 <span class="description">This page will be used to display static content.</span>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php _e( 'Background Color:', 'doctype-assistant' ); ?></label><br>
		<input type="text" data-default-color="<?php echo $defaults['bg_color']; ?>" class="colorpicker" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" id="<?php echo $this->get_field_id( 'bg_color' ); ?>" value="<?php echo @$instance['bg_color']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'bg_image' ); ?>"><?php _e( 'Background Image URL:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" name="<?php echo $this->get_field_name( 'bg_image' ); ?>" value="<?php echo @$instance['bg_image']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'bg_opacity' ); ?>"><?php _e( 'Background Opacity:', 'doctype-assistant' ); ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bg_opacity' ); ?>" name="<?php echo $this->get_field_name( 'bg_opacity' ); ?>" value="<?php echo @$instance['bg_opacity']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'text_color' ); ?>"><?php _e( 'Text Color:', 'doctype-assistant' ); ?></label><br>
		<input type="text" data-default-color="<?php echo $defaults['text_color']; ?>" class="colorpicker" name="<?php echo $this->get_field_name( 'text_color' ); ?>" id="<?php echo $this->get_field_id( 'text_color' ); ?>" value="<?php echo @$instance['text_color']; ?>" />

	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'link_color' ); ?>"><?php _e( 'Link Color:', 'doctype-assistant' ); ?></label><br>
		<input type="text" data-default-color="<?php echo doctype_get_thememod_value( 'accent-color' ); ?>" class="colorpicker" name="<?php echo $this->get_field_name( 'link_color' ); ?>" id="<?php echo $this->get_field_id( 'link_color' ); ?>" value="<?php echo @$instance['link_color']; ?>" />
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
