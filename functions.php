<?php

// Enregistrement du CSS
function charger_styles_theme() {
    wp_enqueue_style('style-principal', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_style('style-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), '1.0');
    wp_enqueue_style('style-modale', get_template_directory_uri() . '/assets/css/modale.css', array(), '1.0');
    wp_enqueue_style('style-single-photo', get_template_directory_uri() . '/assets/css/single-photo.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'charger_styles_theme');


// Enregistrement du JavaScript
function enqueue_custom_scripts() {
    wp_enqueue_script(
        'custom-scripts',           
        get_template_directory_uri() . '/assets/js/scripts.js',  
        array('jquery'),            // Dépendances jQuery
        '1.0.0',                    // Version 
        true                        // Chargement dans le footer 
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');



// Enregistrement des Menus header et Footer
function register_my_menu() {
    register_nav_menu( 'nav-menu-header', __( 'Menu Header', 'motaphoto' ) );
    register_nav_menu( 'nav-menu-footer', __( 'Menu Footer', 'motaphoto' ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );


