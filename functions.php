<?php

function charger_styles_theme() {
    wp_enqueue_style('style-principal', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_style('style-theme', get_template_directory_uri() . '/assets/css/theme.css', array(), '1.0');
    wp_enqueue_style('style-modale', get_template_directory_uri() . '/assets/css/modale.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'charger_styles_theme');