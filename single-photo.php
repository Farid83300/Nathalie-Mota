<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package motaphoto
 */
?>
<?php
    //   --------- VARIABLES PHP ---------   //
    // S'assurer que nous avons l'ID du post actuel
    $post_id = get_the_ID();
    // Récupère l'image mise en avant (featured image) du post
    $photo = get_the_post_thumbnail($post_id, 'full');
    // Récupère le titre du post
    $title = get_the_title($post_id);
    // Récupère les champs personnalisés (SCF)
    $reference = get_post_meta($post_id,'reference', true);
    $type = get_post_meta($post_id,'type', true);
    // Récupère les termes des taxonomies associées
    $categories = get_the_terms($post_id, 'categorie');
    $formats = get_the_terms($post_id, 'format');


    //   --------- NAVIGATION ENTRE LES PHOTOS ---------   //
    // Récupère le post précédent
    $previous_post = get_previous_post();
    if ($previous_post) {
        $previous_id = $previous_post->ID;
        $previous_img = get_the_post_thumbnail_url($previous_post, 'thumbnail');
        $previous_link = get_permalink($previous_post);
    } else {
        $previous_post = get_posts(['numberposts' => 1, 'post_type' => 'photo', 'orderby' => 'date', 'order' => 'DESC'])[0];
        $previous_id = $previous_post->ID;
        $previous_img = get_the_post_thumbnail_url($previous_post, 'thumbnail');
        $previous_link = get_permalink($previous_post);
    }
    // Récupère le post suivant
    $next_post = get_next_post();
    if ($next_post) {
        $next_id = $next_post->ID;
        $next_img = get_the_post_thumbnail_url($next_post, 'thumbnail');
        $next_link = get_permalink($next_post);
    } else {
        $next_post = get_posts(['numberposts' => 1, 'post_type' => 'photo', 'orderby' => 'date', 'order' => 'ASC'])[0];
        $next_id = $next_post->ID;
        $next_img = get_the_post_thumbnail_url($next_post, 'thumbnail');
        $next_link = get_permalink($next_post);
    }
?>

<?php get_header(); ?>

<section class="page-photo">
    <!-- Section Photos unique et descriptions -->
    <div class="photo-content">
        <div class="bloc-photo">
            <?php echo $photo; ?> 
        </div>
        <div class="infos-bloc">
            <h2 class="title-infos"><?php echo esc_html($title); ?></h2>
            <p class="txt-infos">Référence : <?php echo $reference; ?></p>
            <p class="txt-infos">Catégorie : <?php foreach( $categories as $category ) {
                echo $category->name;
                } ?>
            </p>
            <p class="txt-infos">Format : <?php foreach( $formats as $format ) {
                echo $format->name;
                } ?>
            </p>  
            <p class="txt-infos">Type : <?php echo $type; ?></p>
            <p class="txt-infos">Année : <?php echo get_the_date('Y'); ?></p>

        </div>
    </div>
    <!-- Bloc contact -->
    <div class="contact-content">
        <div class="contact-ref">
            <p class="interesse">Cette photo vous intéresse ?</p>
            <button id="ref-btn" data-ref="<?php echo $reference; ?>">Contact</button>
        </div>
        <!-- Section des miniatures et flèches -->
        <div class="navigationPhoto">
            <a href="<?php echo get_permalink($post->ID); ?>" class="miniature-link" id="miniaturePhoto"></a>
            <div class="arrowNav">
                <?php if (!empty($previous_id)) : ?>
                    <img class="arrow arrow-left" src="<?php echo get_template_directory_uri() . '/assets/img/left_arrow.png'; ?>" alt="Photo précédente" data-thumbnail-url="<?php echo $previous_img; ?>" data-target-url="<?php echo esc_url($previous_link); ?>">
                <?php endif; ?>

                <?php if (!empty($next_id)) : ?>
                    <img class="arrow arrow-right" src="<?php echo get_template_directory_uri() . '/assets/img/right_arrow.png'; ?>" alt="Photo suivante" data-thumbnail-url="<?php echo $next_img; ?>" data-target-url="<?php echo esc_url($next_link); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Section des photos apparentées -->
    <div class="related-photos">
        <h3>Vous aimerez aussi</h3>
        <div class="related-photos-list">
            <?php
            // Récupérer les ID des catégories de la photo
            $category_ids = wp_list_pluck($categories, 'term_id');
            
            // Ajouter un argument pour récupérer uniquement les photos de la même catégorie, de façon aléatoire et exclure la photo actuelle
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 2, // Limiter à 2 photos seulement
                'post__not_in' => array(get_the_ID()), // Exclure la photo actuelle
                'orderby' => 'rand', // Tri aléatoire des photos
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field' => 'id',
                        'terms' => $category_ids,
                        'operator' => 'IN',
                    )
                ),
            );
            
            // Exécuter la requête pour obtenir les photos apparentées
            $related_photos = new WP_Query($args);
            
            // Vérifier si des photos apparentées ont été trouvées
            if ($related_photos->have_posts()) :
                while ($related_photos->have_posts()) : $related_photos->the_post();
                    // Structure simplifiée pour chaque photo apparentée
                    ?>
                    <div class="related-photo-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('full'); ?>
                            <div class="photo-overlay">
                                <!-- Vous pouvez ajouter ici les éléments de votre overlay si nécessaire -->
                            </div>
                        </a>
                    </div>
                <?php
                endwhile;
                // Réinitialiser les données de post
                wp_reset_postdata();
            else :
                echo '<p>Aucune photo apparentée trouvée.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>