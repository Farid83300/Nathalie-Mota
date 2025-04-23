<?php
/**
 * Template part pour du filtre Overlay sur chaque photos
 *
 * @package motaphoto
 */
?>

<div class="photo-item" data-photo-id="<?php the_ID(); ?>"> <!-- ID de la photo -->
    <a href="<?php the_permalink(); ?>" class="open-single-photo"> <!-- Lien vers la page single-photo -->
        <?php if (has_post_thumbnail()) { 
            the_post_thumbnail('full'); // Affiche la miniature de la photo
        } ?>
    </a>
    <!-- Overlay qui apparaît au survol -->
    <div class="photo-overlay">
        <h2><?php echo get_field('reference'); ?></h2> <!-- Référence de la photo -->
        <h3><?php echo implode(', ', wp_list_pluck(get_the_terms(get_the_ID(), 'categorie'), 'name')); ?></h3> <!-- Catégorie de la photo -->
        <a href="<?php the_permalink(); ?>" class="eye">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/eye.png" alt="oeil">
        </a>
        <!-- Lien vers la lightbox au survol -->
        <a href="#" class="full-screen" data-photo-id="<?php the_ID(); ?>" data-image="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" data-reference="<?php echo get_field('reference'); ?>" data-category="<?php echo implode(', ', wp_list_pluck(get_the_terms(get_the_ID(), 'categorie'), 'name')); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Icon_fullscreen.png" alt="plein écran">
        </a>
    </div>
</div>