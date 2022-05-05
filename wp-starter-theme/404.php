<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
$option = array(
    'container' => '',
    'secondary' => array(
        'display' => false,
        'column'  => 3,
    ),
    'tertiary'  => array(
        'display' => false,
        'column'  => 3,
    ),
);
get_header();
?>
<style type="text/css" media="screen">
    .site-footer{display: none;}
</style>
    
    <main class="main-content aligns" style="min-height: 0;height:100vh;">
        <div class="<?php starter_the_container($option); ?> align-middle">
            <div class="columns">

                <?php starter_get_secondary($option); ?>

                <section id="primary" class="<?php starter_the_primary($option); ?>">
                    <div id="main" class="site-main aligns vh-100">
                        <div class="main-inner align-middle text-center">

<header class="page-header">
    <div class="container-fluid">
        <h2 class="page-title screen-reader-text">
            <?php _e( 'Page not found', 'starter-text-domain' ); ?>
        </h2>
    </div>
</header>
<div class="page-content" style="text-align:center;">
    <div class="container-fluid">
        <b style="display:block;font-size: 30vw; font-weight: 900; line-height: 1;">404</b>
        <p>Take me back to <a href="#">Home</a></p>
    </div>
</div>

                        </div><!-- .main-inner -->
                    </div><!-- #main -->
                </section><!-- #primary -->

                <?php starter_get_tertiary($option); ?>

            </div><!-- .columns -->
        </div><!-- .container -->
    </main>
    
<?php 
get_footer(); 
?>