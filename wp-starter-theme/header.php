<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="format-detection" content="telephone=no" />
    <!-- Do not change the meta tag above. -->
    <!-- X-UA-Compatible does not work in Explorer if http-equiv is not directly below it. -->
    
    <?php wp_head(); ?>

    <?php 
    if ( ! starter_is_plugin_active( 'wp-seo' ) ) : ?>
        <meta name="description" content="<?php bloginfo('description'); ?>" />
        <!-- Canonical URL -->
        <link rel="canonical" href="<?php echo get_home_url() . $_SERVER['REQUEST_URI']; ?>" />
        <?php
    endif;
    ?>

    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

    <!-- Font -->
    <script src="<?php echo STARTER_JS; ?>/font.js?ver=1.0.2" defer></script>
    <noscript>
        <link rel="stylesheet" href="<?php echo STARTER_CSS; ?>/font.css?ver=1.0.2" />
    </noscript>
</head>
<?php starter_set_post_view(); ?>
<body itemscope itemtype="http://schema.org/WebPage">
<!--[if lt IE 9]>
<noscript>
    <div class="message-alert message-noscript-warning" role="alert" style="padding:10px">
        <strong>This web page requires JavaScript to be enabled.</strong><br/>
        JavaScript is an object-oriented computer programming language
        commonly used to create interactive effects within web browsers.
    </div>
</noscript>
<div class="message-alert message-browser-upgrade" role="alert" style="padding:10px">
    You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.
</div>
<![endif]-->
<div id="page" class="site">
    <a id="skip-navigation" class="screen-reader-text" href="#main">Skip to content</a>
    
    <header id="masthead" class="site-header navbar fixed" itemscope itemtype="http://schema.org/WPHeader">
        <div class="container">

            <?php starter_the_brand(); ?>

            <?php 
            if ( starter_is_search_has_results() !== false ) {
                get_search_form(); 
            }
            ?>

            <nav id="primary-navigation" class="site-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                <h2 class="screen-reader-text">Site Navigation</h2>
                <div id="navbg" class="nav-bg"></div>
                <div id="navbtn" class="nav-btn burger">
                    <span class="bar bar-1"></span>
                    <span class="bar bar-2"></span>
                    <span class="bar bar-3"></span>
                </div>
                <?php
                wp_nav_menu( array(
                    'menu'            => '',
                    'container'       => '',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'site-menu dropdown-menu mobile-dropdown-menu',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    'item_spacing'    => 'preserve',
                    'depth'           => 3,
                    'walker'          => new Starter_Walker_Menu,
                    'theme_location'  => 'menu-1',
                ) );
                ?>
            </nav><!-- .site-navigation -->

        </div><!-- .container -->
    </header><!-- #masthead -->

    <div id="page-content" class="site-content">
        