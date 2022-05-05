<?php
/**
 * Displays a feed content
 *
 * @link https://codex.wordpress.org/Function_Reference/fetch_feed
 * @link https://developer.wordpress.org/reference/functions/fetch_feed/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Feed_Fetch {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        $this->includes();
        $this->views();
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'feed'    => 'https://news.google.com/rss/search?q=css3',
            'maxitem' => 12,
            'cache'   => true,
            'classes' => array(
                'list'  => 'columns gutter-10 column-count-4 mobile-column-count-2',
                'article'  => 'column hentry',
                'content'  => 'hentry-inner',
            ),
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    // Get RSS Feed(s)
    public function includes() {
        include_once( ABSPATH . WPINC . '/feed.php' );
    }

    public function views() {
        $opts = $this->options();
        ?>
        <div class="<?php echo $opts['classes']['list']; ?>">
            <?php 
            $feed = fetch_feed( $opts['feed'] );
            $maxitems = 0;
            if ( ! is_wp_error( $feed ) ) {
                $maxitems = $feed->get_item_quantity( $opts['maxitem'] ); 
                $items = $feed->get_items( 0, $maxitems );
            }
            ?>
            <?php if ( $maxitems == 0 ) : ?>
            <article class="<?php echo $opts['classes']['article']; ?>" itemscope itemtype="http://schema.org/NewsArticle">
                <div class="<?php echo $opts['classes']['content']; ?>">
                    <?php $this->not_found(); ?>
                </div>
            </article>
            <?php else : ?>
                <?php foreach ( $items as $item ) : ?>
                <article class="<?php echo $opts['classes']['article']; ?>" itemscope itemtype="http://schema.org/NewsArticle">
                    <div class="<?php echo $opts['classes']['content']; ?>">
                        <?php $this->get_the_image( $item ); ?>
                        <header class="entry-header">
                            <?php $this->get_the_title( $item ); ?>
                            <div class="entry-meta screen-reader-text">
                                <p class="entry-published">
                                    <?php $this->get_the_author( $item ); ?>
                                    <?php $this->get_the_published( $item ); ?>
                                    <?php $this->get_the_updated( $item ); ?>
                                </p>
                                <div class="entry-publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                    <?php $this->get_the_logo( $item ); ?>
                                    <?php $this->get_the_organization( $item ); ?>
                                </div>
                            </div>
                        </header>
                        <?php $this->get_the_description( $item ); ?>
                        <?php $this->get_the_permalink( $item ); ?>
                    </div><!-- .hentry-inner -->
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div><!-- .columns -->
    <?php
    }

    /**
     * Title Character Length
     * 
     * The curious case of a WordPress plugin, a rival site spammed with traffic, a war of words, and legal threats - The Register 
     * Headline string length must be within range [0, 110]
     *
     * @link https://search.google.com/structured-data
     * @link https://stackoverflow.com/questions/4617769/wordpress-titles-if-longer-than-50-characters-show-ellipsis
     */
    public function get_the_title ( $item ) {
        $html  = '';
        $html .= '<h3 class="entry-title" itemprop="headline">';
            $html .= $this->get_title($item);
        $html .= '</h3>';
        echo $html;
    }

    public function get_title( $item ){
        return esc_html(mb_strimwidth( $item->get_title(), 0, 110, '...'));
    }

    public function not_found() {
        $html  = '';
        $html .= '<h3 class="entry-title" itemprop="headline">';
            $html .= 'Could not get first article';
        $html .= '</h3>';
        echo $html;
    }

    public function get_the_description ( $item ) {
        $text = $item->get_description();
        $text = preg_replace( "/(?:<a.*?.<\/font>)/", '', $text );
        $text = strip_tags($text);
        $text = trim($text);

        $html  = '';
        $html .= '<div class="entry-summary" itemprop="description">';
            $html .= $text;
        $html .= '</div>';

        echo $html;
    }

    public function get_the_image ( $item ) {
        $html = '';
        if ( $enclosure = $item->get_enclosure() ) {
            if ( $enclosure->get_medium() !== NULL && $enclosure->get_medium() == 'image' ) {
                $html .= '<div class="entry-thumbnail" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';
                    $html .= '<img src="'. esc_url( $enclosure->get_link() ) .'" alt="'. $this->get_title($item) .'">';
                    $html .= '<meta itemprop="url" content="'. esc_url( $enclosure->get_link() ) .'">';
                    $html .= '<meta itemprop="width" content="'. $enclosure->width .'">';
                    $html .= '<meta itemprop="height" content="'. $enclosure->height .'">';
                $html .= '</div>';
            }
        }
        echo $html;
    }

    public function get_the_published ( $item ) {
        $html  = '';
        $html .= 'on';
        $html .= '<time class="published" datetime="'. $item->get_date(DATE_W3C) .'" itemprop="datePublished" content="'. $item->get_date(DATE_W3C) .'">';
            $html .= esc_html( $item->get_date('j F Y | g:i a') );
        $html .= '</time>';
        echo $html; 
    }

    public function get_the_updated ( $item ) {
        $html  = '';
        $html .= 'on';
        $html .= '<time class="updated" datetime="'. $item->get_date(DATE_W3C) .'" itemprop="dateModified" content="'. $item->get_date(DATE_W3C) .'">';
            $html .= esc_html( $item->get_date('j F Y | g:i a') );
        $html .= '</time>';
        echo $html; 
    }

    public function get_the_permalink ( $item ) {
        $html  = '';
        $html .= '<a class="entry-permalink" href="'. esc_url( $item->get_permalink() ) .'" rel="bookmark" itemprop="mainEntityOfPage url" target="_blank">';
            $html .= '&mdash; '. esc_html( $this->get_the_source($item) ) .'';
        $html .= '</a>';
        echo $html; 
    }

    public function get_the_author ( $item ) {
        $html  = '';
        $html .= 'Published by ';
        $html .= '<span class="author vcard" itemprop="author" itemscope itemtype="https://schema.org/Person">';
            $html .= '<span class="fn" itemprop="name">'. $this->get_the_source($item) .'</span>';
        $html .= '</span>';
        echo $html; 
    }

    public function get_the_logo ( $item ) {
        if ( $enclosure = $item->get_enclosure() ) {
            if ( $enclosure->get_medium() !== NULL && $enclosure->get_medium() == 'image' ) {
                $html .= '<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">';
                    $html .= '<img src="'. esc_url( $enclosure->get_link() ) .'" alt="'. $this->get_title($item) .'">';
                    $html .= '<meta itemprop="url" content="'. esc_url( $enclosure->get_link() ) .'">';
                    $html .= '<meta itemprop="width" content="'. $enclosure->width .'">';
                    $html .= '<meta itemprop="height" content="'. $enclosure->height .'">';
                $html .= '</div>';
            }
        }
        echo $html;
    }

    public function get_the_organization ( $item ) {
        $html  = '';
        $html .= '<span class="fn org" itemprop="name" content="'. $this->get_the_source($item) .'">';
            $html .= $this->get_the_source($item);
        $html .= '</span>';
        echo $html;
    }

    public function get_the_source ( $item ) {
        $html = '';
        if ( $source = $item->get_item_tags('', 'source') ) {
            $html = $source[0]['data'];
        }
        return $html;
    }

}
