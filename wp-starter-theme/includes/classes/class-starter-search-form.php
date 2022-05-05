<?php 
/**
 * Generate custom search form
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Search_Form {

    public function __construct(){
        
        add_filter( 'get_search_form', array( $this, 'views' ) );

    }

    public function views( $form ) {
        
        $html  = '';
        $html .= '<form class="search-form" action="'. esc_url( home_url('/') ) .'" method="get">';
            $html .= '<label>';
                $html .= '<input type="search" name="s" id="s" placeholder="Search" value="' . get_search_query() . '">';
            $html .= '</label>';
            $html .= '<button class="ir-phark" type="submit">';
                $html .= esc_attr__( 'Search', 'starter-text-domain' );
            $html .= '</button>';
        $html .= '</form>';
     
        return $html;
    }

}

// new Starter_Search_Form();