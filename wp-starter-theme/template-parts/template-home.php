<?php
/**
 * Template Name: Home
 * Template Post Type: page
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 */
$option = array(
    'container' => 'fluid',
    'secondary' => array(
        'display' => false,
        'column'  => 3,
    ),
    'tertiary'  => array(
        'display' => false,
        'column'  => 3,
    ),
    'hero' => array(
        'slides' => [
            [ 'image'=>''. STARTER_IMG .'/hero/hero-1.jpg' .'', 'caption'=>'<h3>Dillon Shook</h3><p>Photo by Rolands Varsbergs on Unsplash</p>' ],
            [ 'image'=>''. STARTER_IMG .'/hero/hero-2.jpg' .'', 'caption'=>'<h3>LUM3N</h3><p>Photo by Rolands Varsbergs on Unsplash</p>' ],
            [ 'image'=>''. STARTER_IMG .'/hero/hero-3.jpg' .'', 'caption'=>'<h3>LUM3N</h3><p>Photo by Rolands Varsbergs on Unsplash</p>' ],
            [ 'image'=>''. STARTER_IMG .'/hero/hero-4.jpg' .'', 'caption'=>'<h3>Tim van der Kuip</h3><p>Photo by Rolands Varsbergs on Unsplash</p>' ],
            [ 'image'=>''. STARTER_IMG .'/hero/hero-5.jpg' .'', 'caption'=>'<h3>Hello I\'m Nik</h3><p>Photo by Rolands Varsbergs on Unsplash</p>' ],
        ]
    ),
);
starter_get_preload_image( $option['hero'] );
get_header();
?>

    <section id="page-hero" class="site-hero vh-100">
        <?php starter_the_hero_content( $option['hero'] ); ?>
    </section>
    
    <main id="main-content" class="main-area">
        <div class="<?php starter_the_container($option); ?>">
            <div class="columns">

                <?php starter_get_secondary($option); ?>

                <section id="primary" class="<?php starter_the_primary($option); ?>">
                    <div id="main" class="site-main">
                        <div class="main-inner">

                            <header class="page-header screen-reader-text">
                                <div class="container">
                                    <h2 class="page-title display-1">
                                        <?php the_title(); ?>
                                    </h2>
                                </div>
                            </header>

                            <div class="page-content">



<section id="home-blog" class="section">
    <?php 
    $blog = new WP_Query( array( 
        'post_type' => 'post',
        'posts_per_page' => 4
    ) );
    if ( $blog->have_posts() ) : ?>
        
        <header class="section-header">
            <div class="container">
                <h2 class="section-title display-2 text-center">Blog</h2>
            </div>
        </header>

        <div class="section-content">
            <div class="container">
                <div class="columns gutter-10 column-count-4 mobile-column-count-2">
                <?php 
                while ( $blog->have_posts() ) : $blog->the_post();

                    get_template_part( 'template-parts/content' );
                
                endwhile; 
                ?>
                </div><!-- .columns -->
            </div><!-- .container -->
        </div><!-- .section-content -->

        <?php
    else :
        // no posts found
        get_template_part( 'template-parts/content', 'none' );
    endif;
    ?>
</section>

<section id="home-news" class="section">
    <header class="section-header">
        <div class="container">
            <h2 class="section-title display-2 text-center">News</h2>
        </div>
    </header>
    <div class="section-content">
        <div class="container">                                    
        <?php starter_the_fetch_feed( 'https://news.google.com/rss/search?q=wordpress', 4, 'every_week' ); ?>
        </div>
    </div><!-- .section-content -->
</section>

<section id="home-features" class="section">
    <header class="section-header">
        <div class="container">
            <h2 class="section-title display-2 text-center">Features</h2>
        </div>
    </header>
    <div class="section-content">
        <div class="container">
            <div class="columns gutter-10 column-count-3 mobile-column-count-1">

                <div class="column">
                    <h3>Main Features</h3>
                    <ul>
                        <li><a target="_blank" href="https://validator.w3.org">W3C Validated Code</a></li>
                        <li><a target="_blank" href="https://mapstyle.withgoogle.com">Google Map Style</a></li>
                        <li><a target="_blank" href="https://search.google.com/structured-data/testing-tool">SEO Optimized</a></li>
                        <li>Blog Details</li>
                        <li>Feed Fetch</li>
                        <li>Clean Code</li>
                        <li>Cross Browser Support</li>
                        <li>Fully Responsive Design</li>
                        <li>No console error</li>
                        <li>User Friendly Code</li>
                        <li>and much more…</li>
                    </ul>
                </div>
                <div class="column">
                    <h3>Libraries</h3>
                    <ul>
                        <li><a target="_blank" href="https://animejs.com">Anime JS</a></li>
                        <li><a target="_blank" href="https://github.com/aFarkas/html5shiv">Html5shiv</a></li>
                        <li><a target="_blank" href="https://github.com/desandro/imagesloaded">Imagesloaded</a></li>
                        <li><a target="_blank" href="https://jquery.com">Jquery</a></li>
                        <li><a target="_blank" href="https://github.com/desandro/masonry">Masonry</a></li>
                        <li><a target="_blank" href="https://github.com/scottjehl/Respond">Respond</a></li>
                        <li><a target="_blank" href="https://github.com/keithclark/selectivizr">Selectivizr</a></li>
                        <li><a target="_blank" href="https://kenwheeler.github.io/slick">Slick Slider</a></li>
                    </ul>
                </div>
                <div class="column">
                    <h3>PhotoCredit</h3>
                    <ul>
                        <li><a target="_blank" href="https://unsplash.com">Unsplash</a></li>
                        <li><a target="_blank" href="https://ionicons.com">ionicons</a></li>
                    </ul>
                </div>
                
            </div><!-- .columns -->
        </div><!-- .container -->
    </div><!-- .section-content -->
</section>




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