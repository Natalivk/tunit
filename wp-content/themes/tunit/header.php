<?php
/**
 * The theme header
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png"
          href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/svg+xml"
          href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon.svg"/>
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon//favicon.ico"/>
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon.png"/>
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/site.webmanifest"/>
    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?> >

<?php include get_stylesheet_directory() . '/assets/images/svg/icon-sprite.svg'; ?>

<div id="test" class="page-wrap">
    <header class="header">
        <div class="header__inner inner">
            <button class="header__hamburger" aria-label="Toggle menu">
                <span class="header__hamburger-line"></span>
                <span class="header__hamburger-line"></span>
                <span class="header__hamburger-line"></span>
            </button>
            <?php if ($logo = get_field('logo', 'option')): ?>
                <div class="header__logo-container">
                    <a class="header__logo" href="<?php echo home_url('/'); ?>">
                        <img class="header__logo-img" src="<?php echo $logo['url']; ?>" alt="<?php echo get_bloginfo('title'); ?>">
                        <?php if ($logo_text = get_field('logo_text', 'option')): ?>
                            <span><?php echo $logo_text; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>
            <div class="header__menus">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'header-nav',
                    'container' => 'nav',
                    'container_class' => 'header__main-nav',
                    'menu_class' => 'header__main-nav-menu js-header-menu',
                    'fallback_cb' => '__return_false',
                ));
                ?>
            </div>
        </div>
    </header>


    <main id="content" class="page-content">
