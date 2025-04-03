<?php
/**
 * Template part pour la modale de contact
 *
 * @package motaphoto
 */
?>

<!-- HTML pour la structure de la modale -->
<div class="modal-contact" id="contactModal">
    <div class="modal-content">
        <!-- Bannière image en entête -->
        <div class="modal-header">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-modale.png' ); ?>" alt="Bannière de contact">
        </div>
        
        <!-- Formulaire Contact Form 7 -->
        <div class="modal-body">
            <?php echo do_shortcode('[contact-form-7 id="aad3963" title="Modale de contact"]'); ?>
        </div>
    </div>
</div>