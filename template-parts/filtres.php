<?php
/**
 * Template pour les filtres de la galerie photo
 * 
 * @package motaphoto
 */

// Définie les filtres de taxonomie
$taxonomies = [
    'categorie' => 'CATÉGORIES',
    'format' => 'FORMATS',
];

// Section des filtres taxonomiques (côté gauche)
echo '<div class="filtre-gauche">';

// Génére les filtres de taxonomie
foreach ($taxonomies as $taxonomy_slug => $label) {
    $terms = get_terms([
        'taxonomy' => $taxonomy_slug,
        'hide_empty' => true, // Montre que les termes qui ont des posts associés
    ]);
    
    if (!is_wp_error($terms) && !empty($terms)) {
        echo '<div class="filter-group">';
        
        // Label accessible pour le select
        echo '<label for="filter-' . esc_attr($taxonomy_slug) . '" class="screen-reader-text">' . esc_html($label) . '</label>';
        
        // Select avec attributs d'accessibilité améliorés
        echo '<select id="filter-' . esc_attr($taxonomy_slug) . '" 
                      class="custom-select taxonomy-select" 
                      data-taxonomy="' . esc_attr($taxonomy_slug) . '"
                      data-placeholder="' . esc_attr(strtoupper($label)) . '"
                      aria-label="' . esc_attr($label) . '">';
        
        // Option vide avec data-placeholder="true" pour Select2
        echo '<option value="" data-placeholder="true"></option>';
        
        foreach ($terms as $term) {
            echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
        }
        
        echo '</select>';
        echo '</div>';
    }
}

echo '</div>'; // Fin filtre-gauche

// Section de tri (côté droit)
echo '<div class="filtre-droite">';

echo '<div class="filter-group">';
echo '<label for="filter-sort" class="screen-reader-text">Trier par date</label>';
echo '<select id="filter-sort" class="custom-select taxonomy-select" data-sort="date" data-placeholder="TRIER PAR" aria-label="Trier par date">';
// Option vide avec data-placeholder="true" pour Select2
echo '<option value="" data-placeholder="true"></option>';
echo '<option value="ASC">Du plus ancien au plus récent</option>';
echo '<option value="DESC">Du plus récent au plus ancien</option>';
echo '</select>';
echo '</div>';

echo '</div>'; // Fin filtre-droite

// Ajoute un nonce caché pour la sécurité
wp_nonce_field('filter_nonce', 'filter_security', false);
?>