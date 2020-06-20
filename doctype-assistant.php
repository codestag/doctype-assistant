<?php
/**
 * Plugin Name: Doctype Assistant
 * Plugin URI: https://github.com/Codestag/doctype-assistant
 * Description: A plugin to assist Doctype theme in adding widgets.
 * Author: Codestag
 * Author URI: https://codestag.com
 * Version: 1.0
 * Text Domain: doctype-assistant
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Doctype
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Doctype_Assistant' ) ) :
	/**
	 * Doctype assistant class.
	 *
	 * @since 1.0
	 */
	class Doctype_Assistant {

		/**
		 * Base instance var.
		 *
		 * @var
		 * @since 1.0
		 */
		private static $instance;

		/**
		 * Register method for creating an instance.
		 *
		 * @since 1.0
		 */
		public static function register() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Doctype_Assistant ) ) {
				self::$instance = new Doctype_Assistant();
				self::$instance->init();
				self::$instance->define_constants();
				self::$instance->includes();
			}
		}

		/**
		 * Add hooks and filters at plugin initialization.
		 *
		 * @since 1.0
		 */
		public function init() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		}

		/**
		 * Define constants.
		 *
		 * @since 1.0
		 */
		public function define_constants() {
			$this->define( 'DA_VERSION', '1.0' );
			$this->define( 'DA_DEBUG', true );
			$this->define( 'DA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'DA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Define a constant.
		 *
		 * @param string $name
		 * @param string $value
		 * @since 1.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Include files for the plugin.
		 *
		 * @since 1.0
		 */
		public function includes() {
			// Shortcodes.
			require_once DA_PLUGIN_PATH . 'includes/shortcodes/contact-form.php';

			// Widgets.
			require_once DA_PLUGIN_PATH . 'includes/widgets/widget-contact.php';
			require_once DA_PLUGIN_PATH . 'includes/widgets/widget-cta.php';
			require_once DA_PLUGIN_PATH . 'includes/widgets/widget-hero.php';
			require_once DA_PLUGIN_PATH . 'includes/widgets/widget-intro.php';
			require_once DA_PLUGIN_PATH . 'includes/widgets/widget-recent-projects.php';
			require_once DA_PLUGIN_PATH . 'includes/widgets/widget-static-content.php';

			if ( is_admin() ) {
				require_once DA_PLUGIN_PATH . 'includes/meta/stag-admin-metaboxes.php';
				require_once DA_PLUGIN_PATH . 'includes/meta/page-meta.php';
				require_once DA_PLUGIN_PATH . 'includes/meta/portfolio-meta.php';
			}

		}

		/**
		 * Enqueue admin scripts & styles
		 *
		 * @since 1.0
		 */
		public function enqueue_admin_scripts( $hook ) {
			if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
				wp_register_style( 'stag-admin-metabox', DA_PLUGIN_URL . 'assets/css/stag-admin-metabox.css', array( 'wp-color-picker' ), DA_VERSION );
				wp_enqueue_style( 'stag-admin-metabox' );
			}
			if ( 'post.php' === $hook || 'post-new.php' === $hook || 'widgets.php' === $hook ) {
				wp_enqueue_media();
				wp_register_script( 'stag-admin-metabox', DA_PLUGIN_URL . 'assets/js/stag-admin-metabox.js', array( 'jquery', 'wp-color-picker' ) );
				wp_enqueue_script( 'stag-admin-metabox' );
				wp_enqueue_style( 'wp-color-picker' );
			}
			return;
		}
	}
endif;


/**
 * Plugin instance.
 *
 * @since 1.0
 */
function doctype_assistant() {
	return Doctype_Assistant::register();
}

/**
 * Plugin activation notice.
 *
 * @since 1.0
 */
function doctype_assistant_activation_notice() {
	echo '<div class="error"><p>';
	echo esc_html__( 'Doctype Assistant requires Doctype WordPress Theme to be installed and activated.', 'doctype-assistant' );
	echo '</p></div>';
}

/**
 * Plugin activation check.
 *
 * @since 1.0
 */
function doctype_assistant_activation_check() {
	$theme = wp_get_theme(); // gets the current theme.
	if ( 'Doctype' === $theme->name || 'Doctype' === $theme->parent_theme ) {
		add_action( 'after_setup_theme', 'doctype_assistant' );
	} else {
		if ( ! function_exists( 'deactivate_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'doctype_assistant_activation_notice' );
	}
}

// Plugin loads.
doctype_assistant_activation_check();
