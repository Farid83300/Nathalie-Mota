<?php

///////////// Enregistrement du CSS /////////////
function charger_styles_theme() {
    wp_enqueue_style('style-principal', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_style('style-theme', get_template_directory_uri() . '/assets/css/front-page.css', array(), '1.0');
    wp_enqueue_style('style-modale', get_template_directory_uri() . '/assets/css/modale.css', array(), '1.0');
    wp_enqueue_style('style-single-photo', get_template_directory_uri() . '/assets/css/single-photo.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'charger_styles_theme');


///////////// Enregistrement du JavaScript /////////////
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



///////////// Enregistrement des Menus header et Footer /////////////
function register_my_menu() {
    register_nav_menu( 'nav-menu-header', __( 'Menu Header', 'motaphoto' ) );
    register_nav_menu( 'nav-menu-footer', __( 'Menu Footer', 'motaphoto' ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );


///////////// Action  sur la miniature silgnle-photo /////////////
function enqueue_photo_navigation_script() {
    // Enqueue votre script
    wp_enqueue_script('miniature-script', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);

    // Localiser les variables PHP et les passer à JavaScript
    $all_thumbnails = [];
    $all_photo_ids = [];

    // Récupérer toutes les photos
    $all_photos_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => -1,  // Charger toutes les photos
        'orderby' => 'date',
        'order' => 'ASC'
    ));

    // Stocker les informations dans les tableaux
    if ($all_photos_query->have_posts()) :
        while ($all_photos_query->have_posts()) : $all_photos_query->the_post();
            $all_thumbnails[] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $all_photo_ids[] = get_permalink(get_the_ID());
        endwhile;
    endif;

    wp_reset_postdata();

    // Localiser les variables et les transmettre au script JS
    wp_localize_script('miniature-script', 'photoData', array(
        'thumbnails' => $all_thumbnails,
        'photo_ids' => $all_photo_ids
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_photo_navigation_script');