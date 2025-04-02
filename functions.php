<?php

function charger_styles_theme() {
    wp_enqueue_style('style-principal', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_style('style-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), '1.0');
    wp_enqueue_style('style-modale', get_template_directory_uri() . '/assets/css/modale.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'charger_styles_theme');


function enqueue_custom_scripts() {
    // Enregistrement du script
    wp_enqueue_script(
        'custom-scripts',           // Identifiant unique
        get_template_directory_uri() . '/assets/js/scripts.js',  // Chemin vers le fichier
        array('jquery'),            // Dépendances (jQuery dans cet exemple)
        '1.0.0',                    // Version (pour gestion du cache)
        true                        // Chargement dans le footer (recommandé pour performance)
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');



function register_my_menu() {
    register_nav_menu( 'nav-menu-header', __( 'Menu Header', 'text-domain' ) );
    register_nav_menu( 'nav-menu-footer', __( 'Menu Footer', 'text-domain' ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );