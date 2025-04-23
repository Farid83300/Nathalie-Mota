<?php
/**
 * Template part pour la Lightbox
 *
 * @package motaphoto
 */
?>

<div id="lightbox-overlay" class="lightbox-overlay">
    <div class="lightbox-content">
        <!-- Croix pour fermer la lightbox -->
        <img id="close-lightbox" class="closeLightbox" src="<?php echo get_stylesheet_directory_uri() . '/assets/img/croix.png'; ?>" alt="fermeture de la lightbox">
        
        <!-- Div pour afficher la photo -->
        <div class="lightbox-photo">
            <img id="lightbox-image" src="" class="lightboxImage" alt="Image à afficher">
        </div>

        <!-- Navigation -->
        <div class="lightbox-navigation">
            <span class="lightboxPrevious" id="prev-photo">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/fleche-precedent.png" alt="Précédente" />
            </span>
            <span class="lightboxNext" id="next-photo">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/fleche-suivante.png" alt="Suivante" />
            </span>
        </div>

        <!-- Référence et Catégorie -->
        <div class="lightbox-info">
            <div class="lightbox-info__reference">
                <span id="photo-reference"></span>
            </div>
            <div class="lightbox-info__category">
                <span id="photo-category"></span>
            </div>
        </div>
    </div>
</div>