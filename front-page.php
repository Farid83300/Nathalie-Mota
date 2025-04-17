<?php
/**
 * Template Name: Page d'accueil personnalisée
 *
 * @package WordPress
 */
?>

<?php get_header(); ?>

<!-- Appel du Hero -->
<?php get_template_part('/template-parts/hero'); ?>    


<!-- Contenu de la page d'acceuil -->
<section id="catalogueContainer"> 
    <div id="photo-display"> 
        <?php afficher_photos_catalogue(); ?> 
    </div>
    <button id="btnLoad-more">Charger Plus</button>
</section>


<?php get_footer(); ?>