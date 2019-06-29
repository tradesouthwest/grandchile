<?php
/*
Plugin Name: Grandchile
Description: Grandchild theme for Child theme as a plugin. 
Author: tradesouthwestgmailcom
Author URI: https://tradesouthwest.com
Version 1.0
*/

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {	exit; }
/** 
 * Constants
 * 
 * @param GRANDCHILE_VER         Using bumped ver.
 * @param GRANDCHILE_URL         Base path
 */
if( !defined( 'GRANDCHILE_VER' )) { define( 'GRANDCHILE_VER', '1.0.1' ); }
if( !defined( 'GRANDCHILE_URL' )) { define( 'GRANDCHILE_URL', 
    plugin_dir_url(__FILE__)); }

    // Start the plugin when it is loaded.
    register_activation_hook(   __FILE__, 'grandechile_plugin_activation' );
    register_deactivation_hook( __FILE__, 'grandechile_plugin_deactivation' );
  
/**
 * Activate/deactivate hooks
 * 
 */
function grandechile_plugin_activation() 
{

    return false;
}
function grandechile_plugin_deactivation() 
{
    return false;
}
/**
 * Define the locale for this plugin for internationalization.
 * Set the domain and register the hook with WordPress.
 *
 * @uses slug `swedest`
 */
add_action( 'plugins_loaded', 'grandechile_load_plugin_textdomain' );

function grandechile_load_plugin_textdomain() 
{

    $plugin_dir = basename( dirname(__FILE__) ) .'/languages';
                  load_plugin_textdomain( 'grandechile', false, $plugin_dir );
}

/** 
 * Admin side specific
 *
 * Enqueue admin only scripts 
 */ 
add_action( 'admin_enqueue_scripts', 'swedest_load_admin_scripts' );   
function swedest_load_admin_scripts() 
{
     /*
     * Enqueue styles */
    wp_enqueue_style( 'grandchile-admin', 
                        GRANDCHILE_URL . 'css/grandchile-admin.css', 
                        array(), GRANDCHILE_VER, false 
                        );
    wp_register_script( 'js-code-editor', plugin_dir_url( __FILE__ ) 
    . 'js/js-code-editor.js', array( 'jquery' ), '', true );

    // Put scripts to head or footer.
    wp_enqueue_script( 'js-code-editor');
    wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
}

require_once ( plugin_dir_path(__FILE__) . 'inc/grandchild-theme-admin.php' );
require_once ( plugin_dir_path(__FILE__) . 'inc/grandchild-styles-functions.php' );
?>
