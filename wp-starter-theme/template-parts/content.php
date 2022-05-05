<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>

    <article class="column hentry" itemscope itemtype="http://schema.org/NewsArticle">
        <div class="hentry-inner">
            
            <?php starter_the_entry_thumbnail($post->ID); ?>
            
            <header class="entry-header">
                <?php starter_the_entry_title($post->ID, $tag='h3', $class='', $gradient=false); ?>
                <?php starter_the_entry_meta($post->ID); ?>
            </header>

            <?php starter_the_entry_summary($post->ID, $screen=true); ?>
            <?php starter_the_entry_permalink($post->ID); ?>

        </div><!-- .hentry-inner -->
    </article>
