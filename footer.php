<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package motaphoto
 */

?>

	<footer id="colophon" class="site-footer">
        <div>
            <?php
                wp_nav_menu(array(
                'theme_location' =>	'nav-menu-footer',
                'container' => false,
                'menu_class' => 'menu-footer',
                ));
            ?>
            <p>Tous droits réservés</p>
        </div>  
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
