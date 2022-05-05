<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
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
    'hero' => array(
        'slides' => [],
    ),
);
starter_get_preload_image( $option['hero'] );
get_header();
?>

    <section id="page-hero" class="site-hero">
        <?php starter_the_hero_content( $option['hero'] ); ?>
    </section>

    <nav id="page-breadcrumb" class="site-breadcrumb" aria-label="breadcrumb">
        <div class="container">
            <?php starter_the_breadcrumb(); ?>
        </div>
    </nav>

    <section id="page-geography" class="map-area" itemscope itemtype="http://schema.org/LocalBusiness">
        <?php starter_the_schema_map(); ?>
        <div class="map-content">
            <div class="map-initialize" style="background-image: url(../../assets/img/map/map-retro.jpg);"></div>
            <div class="map-responsive">
                <div class="map map-google" data-geography-google='{"lat":-34.397,"lng":150.644,"icon":""}'></div>
            </div>
        </div>
    </section>
    
    <main id="main-content" class="main-area">
        <div class="<?php starter_the_container($option); ?>">
            <div class="columns">

                <?php starter_get_secondary($option); ?>

                <section id="primary" class="<?php starter_the_primary($option); ?>">
                    <div id="main" class="site-main">
                        <div class="main-inner">
                        
                            <?php get_template_part( 'template-parts/content', 'page' ); ?>
                        
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