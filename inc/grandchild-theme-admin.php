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
    add_settings_field(
        'grandchile_priority_order',
        __( 'Style Editor', 'grandchile' ),
        'grandchile_priority_order_cb',
        'grandchile_options',
        'grandchile_options_settings_section',
        array( 
            'type'        => 'number',
            'option_name' => 'grandchile_options', 
            'name'        => 'grandchile_priority_order',
            'value'       => ( empty( get_option('grandchile_options')['grandchile_priority_order'] )) 
                            ? absint( 10 ) : get_option('grandchile_options')['grandchile_priority_order'],
            'default'     => '',
            'description' => esc_html__( 'Enter Priority of this styles script', 'grandchile' ),
            'tip'     => esc_attr__( '10 is default and should allow styles to show last in the head. Raise number to 11 or 12 if your styles are not taking.', 'grandchile' ),  
            'placeholder' => esc_attr__( '', 'grandchile' )   
        ) 
    );    
    // settings checkbox 
    add_settings_field(
        'grandchile_styles_radio',
        __('Deactivate Styles', 'grandchile'),
        'grandchile_styles_radio_cb',
        'grandchile_options',
        'grandchile_options_settings_section',
        array( 
            'type'        => 'checkbox',
            'option_name' => 'grandchile_options', 
            'name'        => 'grandchile_styles_radio',
            'value'       => ( empty( get_option('grandchile_options')['grandchile_styles_radio'] )) 
                                ? 0 : get_option('grandchile_options')['grandchile_styles_radio'],
            'checked'     => esc_attr( checked( 1, 
                             get_option('grandchile_options')['grandchile_styles_radio'], 
                             false ) ),
            'description' => esc_html__( 'Check to use styles.', 'grandchile' ),
            'tip'     => esc_attr__( 'Default is ON (check). Uncheck to discontinue using styles. Could be used for theme change.', 'grandchile' )  
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

/** 
 * render for 'priority order' field
 * @since 1.0.0
 */
function grandchile_priority_order_cb($args)
{  
    printf(
    '<fieldset><b class="grctip" data-title="%5$s">?</b><sup></sup>
    <p><span class="vmarg">%4$s </span></p>
    <input id="%1$s" class="text-field" name="%2$s[%1$s]" type="%6$s" value="%3$s"/>
    </fieldset>',
        $args['name'],
        $args['option_name'],
        $args['value'],
        $args['description'],
        $args['tip'],
        $args['type']
    );
}
/** 
 * switch for 'allow styles' field
 * @since 1.0.1
 * @input type checkbox
 */
function grandchile_styles_radio_cb($args)
{ 
     printf(
        '<fieldset><b class="grctip" data-title="%6$s">?</b><sup></sup>
        <input type="hidden" name="%3$s[%1$s]" value="0">
        <input id="%1$s" type="%2$s" name="%3$s[%1$s]" value="1"  
        class="regular-checkbox" %7$s /><br>
        <span class="vmarg">%5$s </span></fieldset>',
            $args['name'],
            $args['type'],
            $args['option_name'],
            $args['value'],
            $args['description'],
            $args['tip'],
            $args['checked']
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
