<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package motaphoto
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <title>Nathalie Mota</title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="logo" alt="Logo du site Nathalie Mota">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
            </a>
		</div>
		<nav id="site-navigation" class="menu-header">
			<?php
                wp_nav_menu(array(
					'theme_location' => 'nav-menu-header',
					'container' => false,
					'menu_class' => 'menu-header',
				))
			?>
		</nav>
		<div class="burger-menu" id="burger-menu">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
	</header>
