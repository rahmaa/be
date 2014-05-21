<?php
/**
 * Stream Theme Customizer
 *
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function upbootwp_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    // LOGO Section
	$wp_customize->add_section( 'themeslug_logo_section' , array(
	    'title'       => __( 'Logo', 'themeslug' ),
	    'priority'    => 20,
	    'description' => 'Upload a logo to replace the default site name and description in the header',
	) );  
	//LOGO settings  
	$wp_customize->add_setting( 'themeslug_logo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
	    'label'    => __( 'Logo', 'themeslug' ),
	    'section'  => 'themeslug_logo_section',
	    'settings' => 'themeslug_logo',
	) ) );

	$wp_customize->add_setting(
	    'primary-menu',
	    array(
	        'default' => 'value1',
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Control(
	        $wp_customize,
	        'primary-menu',
	        array(
	            'label' => 'Primary Menu Style',
	            'section' => 'nav',
	            'settings' => 'primary-menu',
	     		'type' => 'radio',
	     		'choices' => array(
       			'value1' => 'Permenant Toggle',
        		'value2' => 'Responsive',
        		),           
	        )
	    )
	);

	$wp_customize->add_setting(
	    'primary-color',
	    array(
	        'default' => '#57ad68',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'primary-color',
	        array(
	            'label' => 'Primary Color',
	            'section' => 'colors',
	            'settings' => 'primary-color',
	        )
	    )
	);
 	// Main Menu BG Color
	$wp_customize->add_setting(
	    'main-menu-color',
	    array(
	        'default' => '#fafafa',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'main-menu-color',
	        array(
	            'label' => 'Main Menu Bar Color',
	            'section' => 'colors',
	            'settings' => 'main-menu-color',
	        )
	    )
	);	
 	// Secondary Menu BG Color
	$wp_customize->add_setting(
	    'secondary-color',
	    array(
	        'default' => '#545454',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color-setting',
	        array(
	            'label' => 'Secondary Menu Bar Color',
	            'section' => 'colors',
	            'settings' => 'secondary-color',
	        )
	    )
	);	
 	// Footer Color
	$wp_customize->add_setting(
	    'footer-color',
	    array(
	        'default' => '#EBEBEB',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'footer-color',
	        array(
	            'label' => 'Footer Colors',
	            'section' => 'colors',
	            'settings' => 'footer-color',
	        )
	    )
	);		
 	// Stroke/Border Colors
	$wp_customize->add_setting(
	    'stroke-color',
	    array(
	        'default' => '#EBEBEB',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'stroke-color',
	        array(
	            'label' => 'Stroke/Border Colors',
	            'section' => 'colors',
	            'settings' => 'stroke-color',
	        )
	    )
	);	
}
add_action( 'customize_register', 'upbootwp_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function upbootwp_customize_preview_js() {
	wp_enqueue_script( 'upbootwp_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'upbootwp_customize_preview_js' );
