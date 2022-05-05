<?php 
/**
 * The main template file
 * 
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
        </div><!-- .container -->
    </nav><!-- #page-breadcrumb -->

    <main id="main-content" class="main-area">
        <div class="<?php starter_the_container($option); ?>">
            <div class="columns">

                <?php starter_get_secondary($option); ?>

                <section id="primary" class="<?php starter_the_primary($option); ?>">
                    <div id="main" class="site-main">
                        <div class="main-inner">
                        
<?php 
if ( have_posts() ) : ?>

    <header class="page-header">
        <div class="container">
            <h2 class="page-title display-1">
                <?php the_archive_title(); ?>
            </h2>
        </div>
    </header>
    
    <div class="page-content">
        <div class="container">
            <div class="columns gutter-10 column-count-4 mobile-column-count-2">
            <?php 
            while ( have_posts() ) : the_post();
                
                get_template_part( 'template-parts/content' );
                
            endwhile; 
            ?>
            </div>
        </div>
    </div><!-- .page-content -->
    
    <?php
else :
    // no posts found
    get_template_part( 'template-parts/content', 'none' );
endif;
?>
                    
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