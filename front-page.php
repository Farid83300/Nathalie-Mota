<?php
/**
 * Template Name: Page d'accueil personnalisée
 *
 * @package WordPress
 */
?>

<?php get_header(); ?>

<main id="primary" class="site-main">

    <?php if ( have_posts() ) : ?>
        
        <!-- Section Hero -->
        <section class="hero">
            <div class="container">
                <h1><?php echo get_bloginfo('name'); ?></h1>
                <p><?php echo get_bloginfo('description'); ?></p>
                <a href="#contact" class="btn">Contactez-nous</a>
            </div>
        </section>



    <?php else : ?>
        
        <section class="no-content">
            <div class="container">
                <h1>Aucun contenu trouvé</h1>
                <p>Il semble qu'il n'y ait pas de contenu à afficher pour le moment.</p>
            </div>
        </section>

    <?php endif; ?>

</main>

<?php get_footer(); ?>