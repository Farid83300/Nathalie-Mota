<?php
/////////////////////////////////////////////////
///////////// Enregistrement du CSS /////////////
function charger_styles_theme() {
    wp_enqueue_style('style-reset', get_template_directory_uri() . '/assets/css/reset.css', array(), '1.0', 'all');
    wp_enqueue_style('style-principal', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_style('style-theme', get_template_directory_uri() . '/assets/css/front-page.css', array(), '1.0');
    wp_enqueue_style('style-modale', get_template_directory_uri() . '/assets/css/modale.css', array(), '1.0');
    wp_enqueue_style('style-single-photo', get_template_directory_uri() . '/assets/css/single-photo.css', array(), '1.0');
    wp_enqueue_style('style-lightbox', get_template_directory_uri() . '/assets/css/lightbox.css', array(), '1.0');
    wp_enqueue_style('style-filtres', get_template_directory_uri() . '/assets/css/filtres.css', array(), '1.0');
    wp_enqueue_style('style-burger-menu', get_template_directory_uri() . '/assets/css/burger-menu.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'charger_styles_theme');




////////////////////////////////////////////////////////
///////////// Enregistrement du JavaScript /////////////
function enqueue_custom_scripts() {
    // Enregistre le script principal
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
    
    // Enregistre le script load-more.js
    wp_enqueue_script('load-more', get_template_directory_uri() . '/assets/js/load-more.js', array('jquery'), '1.0.0', true);

    // Enqueue le script de la lightbox
    wp_enqueue_script('lightbox', get_template_directory_uri() . '/assets/js/lightbox.js', array('jquery'), null, true);
    
    // Localise le script load-more.js avec les données nécessaires
    wp_localize_script('load-more', 'motaphoto_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('motaphoto_load_more_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');




/////////////////////////////////////////////////////////////////////
///////////// Enregistrement des Menus header et Footer /////////////
function register_my_menu() {
    register_nav_menu( 'nav-menu-header', __( 'Menu Header', 'motaphoto' ) );
    register_nav_menu( 'nav-menu-footer', __( 'Menu Footer', 'motaphoto' ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );




/////////////////////////////////////////////////////////////////
///////////// Action  sur la miniature single-photo /////////////
function enqueue_photo_navigation_script() {
    // Enqueue votre script
    wp_enqueue_script('miniature-script', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);

    // Localise les variables PHP et les passer à JavaScript
    $all_thumbnails = [];
    $all_photo_ids = [];

    // Récupére toutes les photos
    $all_photos_query = new WP_Query(array(
        'post_type' => 'photo',
        'posts_per_page' => -1,  // Charger toutes les photos
        'orderby' => 'date',
        'order' => 'ASC'
    ));

    // Stocke les informations dans les tableaux
    if ($all_photos_query->have_posts()) :
        while ($all_photos_query->have_posts()) : $all_photos_query->the_post();
            $all_thumbnails[] = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $all_photo_ids[] = get_permalink(get_the_ID());
        endwhile;
    endif;

    wp_reset_postdata();

    // Localise les variables et les transmettre au script JS
    wp_localize_script('miniature-script', 'photoData', array(
        'thumbnails' => $all_thumbnails,
        'photo_ids' => $all_photo_ids
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_photo_navigation_script');





//////////////////////////////////////////////////////////////////////////////////////////////
///////////// Fonction pour afficher les photos dans la galerie (front-page.php) /////////////
function afficher_photos_catalogue($args = array()) {
    // Définie les arguments de la requête
    $default_args = array(
        'post_type' => 'photo',   
        'posts_per_page' => 8,   
    );
    $args = array_merge($default_args, $args);

    // Requête WP_Query pour récupérer les photos
    $photo_query = new WP_Query($args);
    if ($photo_query->have_posts()) :
        echo '<div class="photo-display">';
        while ($photo_query->have_posts()) : $photo_query->the_post();
            // Inclus le fichier load.php pour l'afficher chaque photo
            include(get_template_directory() . '/template-parts/load.php'); 

        endwhile;
        echo '</div>';
    else :
        echo '<p>Aucune photo apparentée trouvée !</p>';
    endif;

    wp_reset_postdata();  // Réinitialise les données de la requête
}




/////////////////////////////////////////////////////////////
///////////// Fonction AJAX pour "Charger Plus" /////////////
function load_more_photos_ajax() {
    // Vérifie le nonce pour la sécurité
    check_ajax_referer('motaphoto_load_more_nonce', 'nonce', false);
    // Récupére le numéro de page depuis la requête
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    // Arguments de base pour la requête
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
    );
    // Exécute la requête WP_Query
    $photo_query = new WP_Query($args);
    // Boucle pour afficher les photos
    if ($photo_query->have_posts()) {
        while ($photo_query->have_posts()) {
            $photo_query->the_post();
            // Inclue le template qui génère chaque élément .photo-item
            include(get_template_directory() . '/template-parts/load.php');
        }
    }
    wp_reset_postdata();
    // Terminer le processus AJAX
    wp_die();
}
// Enregistre les actions AJAX pour les utilisateurs connectés et non connectés
add_action('wp_ajax_load_more_photos', 'load_more_photos_ajax');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos_ajax');



/////////////////////////////////////////////////////////
///////////// Fonction AJAX pour le filtrage ////////////
function filtrer_photos_ajax() {
    // Vérifie le nonce pour la sécurité
    check_ajax_referer('ajax_filter_nonce', 'nonce');
    
    // Récupération des filtres
    $filters = isset($_POST['filters']) ? $_POST['filters'] : array();
    
    // Arguments de base pour la requête
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
    );
    
    // Traitement du tri spécial en premier (à l'extérieur de la boucle des taxonomies)
    if (isset($filters['sort'])) {
        $args['orderby'] = 'date';
        $args['order'] = $filters['sort']; // ASC ou DESC
        // Supprime sort du tableau des filtres pour qu'il ne soit pas traité comme taxonomie
        unset($filters['sort']);
    }
    
    // Ajout des taxonomies au tableau tax_query si des filtres sont appliqués
    if (!empty($filters)) {
        $tax_query = array('relation' => 'AND');
        
        foreach ($filters as $taxonomy => $term) {
            // N'ajoute que les taxonomies valides
            if ($taxonomy === 'categorie' || $taxonomy === 'format') {
                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => $term,
                );
            }
        }
        
        // N'ajoute tax_query que s'il y a des critères taxonomiques
        if (count($tax_query) > 1) { // > 1 car nous avons déjà ajouté 'relation' => 'AND'
            $args['tax_query'] = $tax_query;
        }
    }
    
    // Exécute la requête WP_Query
    $photo_query = new WP_Query($args);
    
    // Boucle pour afficher les photos filtrées
    if ($photo_query->have_posts()) {
        while ($photo_query->have_posts()) {
            $photo_query->the_post();
            // Inclut le template qui génère chaque élément .photo-item
            include(get_template_directory() . '/template-parts/load.php');
        }
    } else {
        echo '<p>Aucune photo ne correspond à vos critères de filtrage.</p>';
    }
    
    wp_reset_postdata();
    wp_die(); // Termine le processus AJAX
}


/////////////////////////////////////////////////////////
///////////// Select2 et AJAX pour le filtrage //////////
add_action('wp_ajax_filtrer_photos', 'filtrer_photos_ajax');
add_action('wp_ajax_nopriv_filtrer_photos', 'filtrer_photos_ajax');


function enqueue_select2() {
    // Enregistrement de Select2 CSS
    wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0');
    
    // Enregistrement de Select2 JS
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0', true);
    
    // Enregistrement de votre script ajax-filter.js
    wp_enqueue_script('ajax-filter', get_template_directory_uri() . '/assets/js/ajax-filter.js', array('jquery', 'select2-js'), '1.0', true);

    // Enregistrement du Menu Burger
    wp_enqueue_script('burger-menu', get_template_directory_uri() . '/assets/js/burger-menu.js', array('jquery'), '1.0.0', true);

    
    // Localisation pour ajax-filter.js
    wp_localize_script('ajax-filter', 'ajax_filter_obj', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('ajax_filter_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_select2');


