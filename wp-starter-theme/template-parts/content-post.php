<?php 
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link https://moz.com/blog/structured-data-for-seo-2
 */
?>

    <article class="post hentry" itemscope itemtype="http://schema.org/NewsArticle">
        <div class="hentry-inner">

            <header class="page-header entry-header">
                <div class="container">
                    <?php starter_the_entry_title($post->ID, $tag='h2', $class='page-title display-1'); ?>
                    <?php starter_the_entry_meta($post->ID, $d='', $screen=true); ?>
                </div>
            </header>

            <?php starter_the_entry_thumbnail($post->ID, $screen=false); ?>
            <?php starter_the_entry_summary($post->ID); ?>

            <div class="page-content entry-content" itemprop="articleBody">
                
                <div class="editor-content">
                    <div class="container">
                        <?php the_content(); ?>
                    </div>
                </div><!-- .editor-content -->

                <div class="embeded-content">
                    <div class="container">
                        <?php // ... ?>
                    </div>
                </div>
                
            </div><!-- .page-content -->

        </div><!-- .hentry-inner -->
    </article>
