<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) 	exit;
/**
 * Plugin Scripts
 * @subpackage grandechile/inc/grandchild-styles-functions
 * 
 * Register and Enqueues public side styles -if used
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
 * Option to add a priority position of styles in head order.
 * @since 1.0.0
 * @param string $priory Priority order from plugin options
 * 
 */
function grandchile_get_position()
{

    $priory = '';
    $priory = ( empty( get_option('grandchile_options')['grandchile_priority_order'] )) 
    ? absint( 10 ) : get_option('grandchile_options')['grandchile_priority_order'];

        return absint( $priory );
}
/**
 * Put scripts in the head.
 * @since 1.0.0
 * @param wp_unslash   Remove slashes from a string or array of strings.
 */

add_action( 'wp_head', function()
{
 
    $output     = '';
    $html_toget = '';

    $html_toget = ( empty( get_option('grandchile_options')['grandchile_print_styles'])) 
    ? false : get_option('grandchile_options')['grandchile_print_styles'];

    $opt_styles = ( empty( get_option('grandchile_options')['grandchile_styles_radio'])) 
    ? '0' : get_option('grandchile_options')['grandchile_styles_radio'];

    
    if( $html_toget ) {
$output .= '<style type="text/css" id="grandchile-styles">';
    if( $opt_styles == "1" ) : 
$output .= wp_unslash( $html_toget );
    endif;
$output .= '</style> ';
    } 
    
    print( $output );

},  grandchile_get_position() );
