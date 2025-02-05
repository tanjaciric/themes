<?php
/**
 * Child Theme Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage yidl
 * @since 1.0.0
 */

if ( ! function_exists( 'yidl_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function yidl_setup() {
		// Add child theme editor styles, compiled from `style-child-theme-editor.scss`.
		add_editor_style( 'style-editor.css' );

		// Add child theme editor font sizes to match Sass-map variables in `_config-child-theme-deep.scss`.
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name'      => __( 'Small', 'yidl' ),
					'shortName' => __( 'S', 'yidl' ),
					'size'      => 16.666,
					'slug'      => 'small',
				),
				array(
					'name'      => __( 'Normal', 'yidl' ),
					'shortName' => __( 'M', 'yidl' ),
					'size'      => 20,
					'slug'      => 'normal',
				),
				array(
					'name'      => __( 'Large', 'yidl' ),
					'shortName' => __( 'L', 'yidl' ),
					'size'      => 28.8,
					'slug'      => 'large',
				),
				array(
					'name'      => __( 'Huge', 'yidl' ),
					'shortName' => __( 'XL', 'yidl' ),
					'size'      => 34.56,
					'slug'      => 'huge',
				),
			)
		);

		/*
		 * Get customizer colors and add them to the editor color palettes
		 *
		 * - if the customizer color is empty, use the default
		 */
		$colors_array     = get_theme_mod( 'colors_manager' ); // color annotations array()
		$primary          = is_array( $colors_array ) && array_key_exists( 'colors', $colors_array ) ? $colors_array['colors']['link'] : '#F86900'; // $config-global--color-primary-default;
		$secondary        = is_array( $colors_array ) && array_key_exists( 'colors', $colors_array ) ? $colors_array['colors']['fg1'] : '#BC2213';  // $config-global--color-secondary-default;
		$background       = is_array( $colors_array ) && array_key_exists( 'colors', $colors_array ) ? $colors_array['colors']['bg'] : '#FFFFFF';   // $config-global--color-background-default;
		$foreground       = is_array( $colors_array ) && array_key_exists( 'colors', $colors_array ) ? $colors_array['colors']['txt'] : '#303030';  // $config-global--color-foreground-default;
		$foreground_light = ( is_array( $colors_array ) && array_key_exists( 'colors', $colors_array ) && $colors_array['colors']['txt'] != '#303030' ) ? $colors_array['colors']['txt'] : '#505050';  // $config-global--color-foreground-light-default;
		$foreground_dark  = ( is_array( $colors_array ) && array_key_exists( 'colors', $colors_array ) && $colors_array['colors']['txt'] != '#303030' ) ? $colors_array['colors']['txt'] : '#101010';  // $config-global--color-foreground-dark-default;

		// Editor color palette.
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'yidl' ),
					'slug'  => 'primary',
					'color' => $primary,
				),
				array(
					'name'  => __( 'Secondary', 'yidl' ),
					'slug'  => 'secondary',
					'color' => $secondary,
				),
				array(
					'name'  => __( 'Background', 'yidl' ),
					'slug'  => 'background',
					'color' => $background,
				),
				array(
					'name'  => __( 'Foreground', 'yidl' ),
					'slug'  => 'foreground',
					'color' => $foreground,
				),
				array(
					'name'  => __( 'Foreground Light', 'yidl' ),
					'slug'  => 'foreground-light',
					'color' => $foreground_light,
				),
				array(
					'name'  => __( 'Foreground Dark', 'yidl' ),
					'slug'  => 'foreground-dark',
					'color' => $foreground_dark,
				),
			)
		);

		// Add child theme support for core custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 96,
				'width'       => 96,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'yidl_setup', 12 );

/**
 * Filter the content_width in pixels, based on the child-theme's design and stylesheet.
 */
function yidl_content_width() {
	return 750;
}
add_filter( 'varia_content_width', 'yidl_content_width' );

/**
 * Add Google webfonts
 *
 * - See: http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 */
function yidl_fonts_url() {

	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Roboto Condensed, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$roboto_condensed = esc_html_x( 'on', 'Roboto Condensed font: on or off', 'yidl' );

	/* Translators: If there are characters in your language that are not
	* supported by Roboto, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$roboto = esc_html_x( 'on', 'Roboto font: on or off', 'yidl' );

	if ( 'off' !== $roboto_condensed || 'off' !== $roboto ) {
		$font_families = array();

		if ( 'off' !== $roboto_condensed ) {
			$font_families[] = 'Roboto Condensed:400,400i,700,700i';
		}

		if ( 'off' !== $roboto ) {
			$font_families[] = 'Roboto:400,400i,700,700i';
		}

		/**
		 * A filter to enable child themes to add/change/omit font families.
		 * 
		 * @param array $font_families An array of font families to be imploded for the Google Font API
		 */
		$font_families = apply_filters( 'included_google_font_families', $font_families );

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function yidl_scripts() {

	// enqueue Google fonts
	wp_enqueue_style( 'yidl-fonts', yidl_fonts_url(), array(), null );

	// dequeue parent styles
	wp_dequeue_style( 'varia-style' );

	// enqueue child styles
	wp_enqueue_style( 'yidl-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

	// enqueue child RTL styles
	wp_style_add_data( 'yidl-style', 'rtl', 'replace' );

}
add_action( 'wp_enqueue_scripts', 'yidl_scripts', 99 );

/**
 * Enqueue theme styles for the block editor.
 */
function yidl_editor_styles() {

	// Enqueue Google fonts in the editor
	wp_enqueue_style( 'yidl-editor-fonts', yidl_fonts_url(), array(), null );

	// Hide duplicate palette colors
	$colors_array = get_theme_mod( 'colors_manager', array( 'colors' => true ) ); // color annotations array()
	if ( ! empty( $colors_array ) && $colors_array['colors']['txt'] != '#394d55' ) { // $config-global--color-foreground-light-default;
		$inline_palette_css = '.components-circular-option-picker__option-wrapper:nth-child(5),
			.components-circular-option-picker__option-wrapper:nth-child(6) {
				display: none;
			}';
		wp_add_inline_style( 'wp-edit-blocks', $inline_palette_css );
	}
}
add_action( 'enqueue_block_editor_assets', 'yidl_editor_styles' );
