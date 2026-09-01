<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Blogus_Customize {
	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}
		return $instance;
	}
	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}
	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {
		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Loads Customizer helper functions.
		add_action( 'after_setup_theme', array( $this, 'customize_helpers' ) );

		add_action( 'customize_register', array( $this, 'customize_controls' ), 10 );

		add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );

		add_action( 'customize_register', array( $this, 'customize_options' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}
	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {
		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . '/inc/ansar/customize-pro/section-pro.php' );
		// Register custom section types.
		$manager->register_section_type( 'Blogus_Customize_Section_Pro' );
		// Register sections.
		$manager->add_section(
			new Blogus_Customize_Section_Pro(
				$manager,
				'blogus_pro_upsell',
				array(
					'title'    => esc_html__( 'Blogus Pro Available!', 'blogus' ),
					'pro_text' => esc_html__( 'Go Pro','blogus' ),
					'pro_url'  => 'https://themeansar.com/themes/blogus-pro/',
					'priority'	=> 1
				)
			)
		);
	}

	/**
	 * Sets up the customizer controls.
	*/
	public function customize_controls( $wp_customize ) {

		// Load customize controls.
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/controls/customize-control-helper.php';

		require BLOGUS_THEME_DIR . 'inc/ansar/customizer-repeater/customizer-repeater-control.php';
	}
	 /**
	 * Loads Customizer helper functions and sanitization callbacks.
	 *
	 * @since 1.0.0
	 */
	public function customize_helpers() {

		// Load customize default values.
		require BLOGUS_THEME_DIR . '/inc/ansar/customize/customizer-callback.php';
		require BLOGUS_THEME_DIR . '/inc/ansar/customize/selective-refresh-and-partial.php';
		require BLOGUS_THEME_DIR . '/inc/ansar/customize/customizer-default.php';
		require BLOGUS_THEME_DIR . '/inc/ansar/customize/customizer-sanitize.php';
	}
	/**
	 * Sets up the customizer options.
	*/
	public function customize_options( $wp_customize ) {
        // Panels and Sections 
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/panels-and-sections.php';

		// Header Settings
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/header/social-icons.php';
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/header/search.php';
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/header/subscribe.php';
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/header/dark-mode.php';

		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/customize-global.php';
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/theme-options.php';
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/theme-layout.php';
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/frontpage-featured.php';
		require BLOGUS_THEME_DIR . 'inc/ansar/customize/settings/frontpage-options.php';
	}
	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		wp_enqueue_script( 'blogus-customize-controls', BLOGUS_THEME_URI . 'inc/ansar/customize-pro/customize-controls.js', array( 'customize-controls' ) );
		wp_enqueue_style( 'blogus-customize-controls', BLOGUS_THEME_URI . 'inc/ansar/customize-pro/customize-controls.css' );
	}
	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	public function customize_preview_js() {

		wp_enqueue_style('blogus-custom-css', BLOGUS_THEME_URI . 'inc/ansar/customize/assets/css/customizer.css', array(), BLOGUS_THEME_VERSION, 'all');

		wp_enqueue_script( 'blogus-customizer',	BLOGUS_THEME_URI . 'inc/ansar/customize/assets/js/customizer.js', array( 'customize-preview' ), BLOGUS_THEME_VERSION, true	);
	}
}
// Doing this customizer thang!
Blogus_Customize::get_instance();