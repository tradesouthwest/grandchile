<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) 	exit;
/**
 * Plugin Scripts
 * @subpackage grandechile/inc/grandchild-styles-functions
 * 
 * Register and Enqueues public side styles
 *
 * @since 1.0.0
 */
//add_action( 'wp_enqueue_scripts', 'grandchile_plugin_public_scripts' ); 

function grandchile_plugin_public_scripts() 
{
    /*
     * Register Styles */
    // The plugin stylesheet 
    wp_enqueue_style( 'grandchild-theme', 
                    GRANDCHILE_URL . 'css/grandchild-theme.css', 
                        array(), GRANDCHILE_VER, 
                        false 
                    );
}

/**
 * Plugin Core 
 * @since 1.0.0
 * 
 */
add_action( 'admin_enqueue_scripts', 'grandchile_editor_scripts_enqueue_script' );
/**
 * Enqueue the Code Editor and JS
 *
 * @param string $hook
 */
function grandchile_editor_scripts_enqueue_script() 
{
 
        wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
        wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) 
                            . 'js/js-code-editor.js', array( 'jquery' ), '', true );
    
}

add_action( 'wp_head', 'grandchile_page_scripts_add_head', 30 );
/**
 * Put scripts in the head.
 * @since 1.0.0
 * @param wp_unslash   Remove slashes from a string or array of strings.
 */
function grandchile_page_scripts_add_head() 
{
    $html_toget = '';
    $html_toget = ( empty( get_option('grandchile_options')['grandchile_print_styles'] )) 
    ? false : get_option('grandchile_options')['grandchile_print_styles'];

if( $html_toget ) 

echo '<style type="text/css" id="grandchile-styles">' . wp_unslash($html_toget) . '</style>';

}