<?php
/**
 * Prevent direct access to the file.
 * @subpackage grandchile/inc/grandchild-theme-admin.php
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Grandchile Options Page
 *
 * Add options page for the plugin.
 *
 * @since 1.0
 */
function grandchile_custom_plugin_page() {

	add_options_page(
		__( 'Grandchile Options', 'grandchile' ),
		__( 'Grandchile Editor', 'grandchile' ),
		'manage_options',
		'grandchile',
		'grandchile_render_admin_page'
	);

}
add_action( 'admin_menu', 'grandchile_custom_plugin_page' );
add_action( 'admin_init', 'grandchile_register_admin_options' ); 
/**
 * Register settings for options page
 *
 * @since    1.0.0
 * 
 * a.) register all settings groups
 * Register Settings $option_group, $option_name, $sanitize_callback 
 */
function grandchile_register_admin_options() 
{
    
    register_setting( 'grandchile_options', 'grandchile_options' );
        
    //add a section to admin page
    add_settings_section(
        'grandchile_options_settings_section',
        '',
        'grandchile_options_settings_section_callback',
        'grandchile_options'
    );
    add_settings_field(
        'grandchile_print_styles',
        __( 'Style Editor', 'grandchile' ),
        'grandchile_print_styles_cb',
        'grandchile_options',
        'grandchile_options_settings_section',
        array( 
            'type'        => 'text',
            'option_name' => 'grandchile_options', 
            'name'        => 'grandchile_print_styles',
            'value'       => ( empty( get_option('grandchile_options')['grandchile_print_styles'] )) 
                            ? false : get_option('grandchile_options')['grandchile_print_styles'],
            'default'     => '',
            'description' => esc_html__( 'Enter styles. Please validate', 'grandchile' ),
            'tip'     => esc_attr__( 'Be sure to check your styles', 'grandchile' ),  
            'placeholder' => esc_attr__( '', 'grandchile' )   
        ) 
    );    
}

/** 
 * render for '0' field
 * @since 1.0.0
 */
function grandchile_print_styles_cb($args)
{  
    printf(
    '<fieldset><b class="grctip" data-title="%5$s">?</b><sup></sup>
    <p><span class="vmarg">%4$s </span></p>
    <textarea id="%1$s" class="widefat textarea grandchile-textarea" name="%2$s[%1$s]" cols="40" rows="25">%3$s</textarea><br>
    </fieldset>',
        $args['name'],
        $args['option_name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}

//callback for description of options section
function grandchile_options_settings_section_callback() 
{
	esc_html_e( 'GrandChild Theme Styles', 'grandchile' );
}
// display the plugin settings page
function grandchile_render_admin_page()
{
	// check if user is allowed access
    if ( ! current_user_can( 'manage_options' ) ) return;
    
	print( '<form action="options.php" method="post">' );

	// output security fields
	settings_fields( 'grandchile_options' );

	// output setting sections
	do_settings_sections( 'grandchile_options' );
	submit_button();

print( '</form>' ); 

printf( '<p>%s <a href="%s" target="_blank" title="%s">%s</a></p>',
__( 'To validate your work visit', 'grandchile' ),
__( 'To validate your work visit', 'grandchile' ),
esc_url( 'http://www.css-validator.org/' ),
esc_html( 'http://www.css-validator.org/' )
);
	
}