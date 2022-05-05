<?php 
/**
 * Displays page links for paginated posts 
 *
 * @link https://codex.wordpress.org/Pagination
 * @link https://developer.wordpress.org/themes/functionality/pagination/
 * @link https://codex.wordpress.org/Function_Reference/get_adjacent_post
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Post_Navigation {

    public $_opts;

    public function __construct( $opts=array() ){

        $this->_opts = $opts;
        $this->views();

    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'prev' => array(
                'in_same_term' => true,
                'excluded_terms' => '',
                'previous' => true,
                'taxonomy' => 'category',
            ),
            'next' => array(
                'in_same_term' => true,
                'excluded_terms' => '',
                'previous' => false,
                'taxonomy' => 'category',
            ),
            'infinite' => true,
            'infinite_post' => get_post_type(),
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function views() {

        $opts = $this->options();

        $html  = '';
        $html .= '<nav class="site-postnav">';
            $html .= '<h3 class="postnav-heading screen-reader-text">Post Navigation</h3>';
            $html .= '<ul class="postnav-list">';
                $html .= $this->view_prev($opts);
                $html .= $this->view_next($opts);
            $html .= '</ul>';
        $html .= '</nav>';

        echo $html;

    }

    public function view_prev( $opts ) {
        
        $prev_post = get_adjacent_post( $opts['prev']['in_same_term'], $opts['prev']['excluded_terms'], $opts['prev']['previous'], $opts['prev']['taxonomy'] );
        
        $html = '';

        if ( is_a( $prev_post, 'WP_Post' ) ) {
            $html .= $this->view_prev_item($prev_post);
        }
        else {

            if ( $opts['infinite'] ) {
                $infinite_query = new WP_Query(array(
                    'post_type' => $opts['infinite_post'],
                    'posts_per_page' => 1,
                    'order' => 'DESC',
                )); 
                if ( $infinite_query->have_posts() ) : $infinite_query->the_post();
                    $html .= $this->view_prev_item($infinite_query);
                else :
                    $html .= $this->view_noexist('prev');
                endif;
                wp_reset_query();
            }
            else {
                $html .= $this->view_noexist('prev');
            }

        }

        return $html;
    }

    public function view_prev_item( $post ) {

        $html  = '';
        $html .= '<li class="postnav-item prev">';
            $html .= '<a class="postnav-link" href="'. get_permalink( $post->ID ) .'" rel="Previous">';
                $html .= '<span class="postnav-arrow">&lang;</span>';
                $html .= '<span class="postnav-rel">Previous</span>';
                $html .= '<h4 class="postnav-title">'. get_the_title( $post->ID ) .'</h4>';
            $html .= '</a>';
        $html .= '</li>';    
        
        return $html;    
    }

    public function view_next( $opts ) {

        $next_post = get_adjacent_post( $opts['next']['in_same_term'], $opts['next']['excluded_terms'], $opts['next']['previous'], $opts['next']['taxonomy'] );
        
        $html = '';

        if ( is_a( $next_post, 'WP_Post' ) ) {
            $html .= $this->view_next_item($next_post);
        }
        else {

            if ( $opts['infinite'] ) {
                $infinite_query = new WP_Query(array(
                    'post_type' => $opts['infinite_post'],
                    'posts_per_page' => 1,
                    'order' => 'ASC',
                )); 
                if ( $infinite_query->have_posts() ) : $infinite_query->the_post();
                    $html .= $this->view_next_item($infinite_query);
                else :
                    $html .= $this->view_noexist('prev');
                endif;
                wp_reset_query();
            }
            else {
                $html .= $this->view_noexist('prev');
            }

        }

        return $html;
    }

    public function view_next_item( $post ) {

        $html  = '';
        $html .= '<li class="postnav-item next">';
            $html .= '<a class="postnav-link" href="'. get_permalink( $post->ID ) .'" rel="Next">';
                $html .= '<span class="postnav-arrow">&rang;</span>';
                $html .= '<span class="postnav-rel">Next</span>';
                $html .= '<h4 class="postnav-title">'. get_the_title( $post->ID ) .'</h4>';
            $html .= '</a>';
        $html .= '</li>';    
        
        return $html;    
    }

    public function view_noexist( $arrow='prev' ) {
        
        $html  = '';
        
        switch ($arrow) {
            case 'prev':
                $html .= '<li class="postnav-item prev disabled">';
                    $html .= '<span class="postnav-arrow">&lang;</span>';
                    $html .= '<h4 class="postnav-title">Previous post does not exist.</h4>';
                $html .= '</li>';
                break;
            case 'next':
                $html .= '<li class="postnav-item next disabled">';
                    $html .= '<span class="postnav-arrow">&rang;</span>';
                    $html .= '<h4 class="postnav-title">Next post does not exist.</h4>';
                $html .= '</li>';
                break;            
        }

        return $html;
    }

}