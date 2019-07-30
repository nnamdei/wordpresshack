<?php
/**
 * Remove failed error message.
 */
function login_error_override() {
	return 'Incorrect login details.';
}
add_filter( 'login_errors', 'login_error_override' );

/**
 * Remove wordpress login page shake.
 */
function my_login_head() {
	remove_action( 'login_head', 'wp_shake_js', 12 );
}
add_action( 'login_head', 'my_login_head' );

/**
 * Remove menu in users dashboard.
 */
function remove_menus() {
	if ( ! current_user_can( 'manage_options' ) ) {
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'options-general.php' );
	}
}
add_action( 'admin_menu', 'remove_menus' );

/**
 * Removing pressthis widget in user dashboard
 */
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

/**
 * Removing admin dashboard footer text
 *
 * Change "add your text here" to your input value.
 */
function remove_footer_admin() {
	echo "Add your text here";
}
add_filter( 'admin_footer_text', 'remove_footer_admin' );

/**
 * Disable remember me option
 */
function do_not_remember_me() {
	echo '<style type="text/css">.forgetmenot { display:none; }</style>';
}
add_action( 'login_head', 'do_not_remember_me' );

/**
 * Removing wordpress version number from rss,header.
 */
function namdi_remove_version() {
	return '';
}
add_filter( 'the_generator', 'namdi_remove_version' );

/**
 * Hide admin footer from admin.
 */
function change_footer_admin() {
	return ' ';
}
add_filter( 'admin_footer_text', 'change_footer_admin', 9999 );

/**
 * Hide admin footer version.
 */
function change_footer_version() {
	return '';
}
add_filter( 'update_footer', 'change_footer_version', 9999 );

/**
 * Remove WP Version From Styles.
 */
add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );

// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

/**
 * Function to remove version numbers.
 */
function sdt_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}

/**
 * Changing wp login logo url.
 */
function my_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

/**
 * Update logo url title.
 */
function my_login_logo_url_title() {
	return 'Vendes Nigeria';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

/**
 * Restrict jetpack for all user roles.
 */
add_action( 'admin_init', 'restrict_page' );
function restrict_page() {
	if ( class_exists( 'Jetpack' ) && ! current_user_can( 'manage_options' ) ) {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'jetpack' ) {
			wp_die( 'no access' );
		}
	}
}

/**
 * Disable Editing in Dashboard (add to wp-config.php)
 */
define( 'DISALLOW_FILE_EDIT', true );

add_filter( 'rest_authentication_errors', 'rest_authentication_errors');

/**
 * Disable REST API for not users that are not logged in.
 */
function rest_authentication_errors( $result ) {
    if ( ! empty( $result ) ) {
        return $result;
    }
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
    }
    return $result;
}

?>

/*=== CSS ===*/

/**
* Remove back to website hyperlink.
*/
p#backtoblog {
display: none;
}

/*disabling directory browsing

Add this to .htaccess file */

Options -Indexes

/*block php execution in specific folders 

Go to the folder .../wp-content/themes for example, create .htaccess file and put this code inside */
*/

<Files *.php>
deny from all
</Files>
