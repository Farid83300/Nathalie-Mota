<?php
/**
 * Template Name: Page d'accueil personnalisée
 *
 * @package WordPress
 */
?>

<?php get_header(); ?>  <!-- Appel du Header -->

<?php get_template_part('/template-parts/hero'); ?>    <!-- Appel du Hero -->



<section id="catalogueContainer"> 
    <div id="photo-display"> <!-- id pour afficher charger plus -->
        <?php afficher_photos_catalogue(); // Affiche les photos par défaut ?>
    </div>
    <!-- Bouton Charger Plus -->
    <button id="btnLoad-more">Charger Plus</button>
</section>


<?php get_footer(); ?>  <!-- Appel du Footer -->