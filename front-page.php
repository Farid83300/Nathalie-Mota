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

<section class="filtres_container">
    <?php get_template_part('template-parts/filtres'); ?>   <!-- template des filtres -->
</section>

<!-- Catalogue Photos -->
<section class="catalogueContainer"> 
    <?php afficher_photos_catalogue(); ?> 
    <button class="btnLoad-more">Charger Plus</button>
</section>


<?php get_footer(); ?>