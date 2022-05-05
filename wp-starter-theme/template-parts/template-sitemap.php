<?php
/**
 * Template Name: Sitemap
 * Template Post Type: page
 *
 * Show all titles of post type posts such as tag clouds
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
        </div><!-- .container -->
    </nav><!-- #page-breadcrumb -->
    
    <main id="main-content" class="main-area">
        <div class="<?php starter_the_container($option); ?>">
            <div class="columns">

                <?php starter_get_secondary($option); ?>

                <section id="primary" class="<?php starter_the_primary($option); ?>">
                    <div id="main" class="site-main">
                        <div class="main-inner">


<header class="page-header">
    <div class="container">
        <h2 class="page-title display-1">
            <?php the_title(); ?>
        </h2>
    </div>
</header>

<div class="page-content">
    <div class="container">

        <nav class="sitemap-navigation">
            <h2 class="sitemap-title screen-reader-text">Sitemap Navigation</h2>
            <ul class="sitemap-list columns gutter-10 column-count-4 mobile-column-count-1">
                <?php wp_list_pages(array(
                    'title_li'    => '',
                    'child_of'    => 0, // (int) Display only the sub-pages of a single page by ID.
                    // 'exclude'     => '', // (string) Comma-separated list of page IDs to exclude.
                    'post_type'   => 'page',
                    'post_status' => 'publish',
                    'sort_column' => 'menu_order, post_title', // (string) Comma-separated list of column names to sort the pages by
                    'walker'      => new Starter_Walker_Sitemap()
                )); ?>
            </ul>
        </nav>

    </div>
</div><!-- .page-content -->


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