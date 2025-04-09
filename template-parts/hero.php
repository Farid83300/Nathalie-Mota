
<section>
    <div class="hero">

        <h1>Photographe event</h1>
        
        <?php
        // Récupération d'une photo aléatoire
        $hero_args = array(
            'post_type'      => 'photo',
            'posts_per_page' => 1,
            'orderby'        => 'rand', // Tri aléatoire
        );

        $hero_query = new WP_Query($hero_args);
        // Vérifie si photos dispos
        if ($hero_query->have_posts()) {
            // Boucle des photos
            while ($hero_query->have_posts()) {
                $hero_query->the_post();
                // Affichage de la photo en taille complète
                echo get_the_post_thumbnail(null, 'full');
            }
            // Réinitialisation des données après la boucle
            wp_reset_postdata();
        }
        ?>
    </div>
</section>    