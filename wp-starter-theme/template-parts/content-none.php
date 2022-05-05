<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>

    <div class="no-results">

        <header class="page-header">
            <div class="container">
                <h2 class="page-title display-1">
                    <?php _e( 'Nothing Found', 'starter-text-domain' ); ?>
                </h2>
            </div>
        </header><!-- .page-header -->

        <div class="page-content">
            <div class="container">

                <?php 
                if ( is_search() ) :
                    echo '<p>';
                        _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'starter-text-domain' );
                    echo '</p>';
                    get_search_form();
                else :
                    echo '<p>';
                        _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'starter-text-domain' );
                    echo '</p>';
                    get_search_form();
                endif;
                ?>

            </div><!-- .container -->
        </div><!-- .page-content -->

    </div><!-- .no-results -->