<?
/**
 * Adds support for wp.com-specific theme functions.
 *
 * @global array $themecolors
 */
function yidl_wpcom_setup() {
	global $themecolors;

	// Set theme colors for third party services.
	if ( ! isset( $themecolors ) ) {
		$themecolors = array(
			'bg'     => 'FFFFFF', // $config-global--color-background-default
			'border' => 'D0D0D0', // $config-global--color-border-default
			'text'   => '303030', // $config-global--color-foreground-default
			'link'   => 'F86900', // $config-global--color-primary-default
			'url'    => 'F86900', // $config-global--color-primary-default
		);
	}
}
add_action( 'after_setup_theme', 'yidl_wpcom_setup' );
