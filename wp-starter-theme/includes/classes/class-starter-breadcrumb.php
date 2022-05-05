<?php 
/**
 * Displays a Breadcrumb based on permalink structure
 *
 * @link https://stackoverflow.com/questions/25708109/how-to-create-breadcrumbs-using-wordpress-nav-menu-without-plugin
 * @link https://www.codexworld.com/wordpress-how-to-display-breadcrumb-without-plugin/
 * @link https://css-tricks.com/how-to-disable-links/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Breadcrumb {

    public function __construct(){

        $this->views();

    }

    public function views() {

        $structure = get_option('permalink_structure');

        switch ( $structure ) {
            // Plain
            case '': $this->view_plain(); break;
            // Day and name
            case '/%year%/%monthnum%/%day%/%postname%/': $this->view_postname(); break;
            // Month and name
            case '/%year%/%monthnum%/%postname%/': $this->view_postname(); break;
            // Numeric
            case '/archives/%post_id%': $this->view_postname(); break;
            // Post name
            case '/%postname%/': $this->view_postname(); break;
            // Custom Structure
            case '/%category%/%postname%/': $this->view_postname(); break;
        }

    }

    public function view_plain() {

        // HTML
        $html  = '';
        $html .= '<h2 class="breadcrumb-title screen-reader-text">Breadcrumb</h2>';
        $html .= '<ol class="breadcrumb-list" itemscope itemtype="http://schema.org/BreadcrumbList">';

            // Home
            $html .= '<li class="breadcrumb-item home" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                $html .= '<a class="breadcrumb-link ir-phark" href="'. get_bloginfo('url') .'" itemprop="item">';
                    $html .= '<span itemprop="name">'. ucfirst('Home') .'</span>';
                    $html .= '<meta itemprop="position" content="0" />';
                $html .= '</a>';
            $html .= '</li>';

            if ( !is_home() ) :

                $name = '';

                if ( isset($_GET['p']) || !empty($_GET['p']) ) :
                    $name = get_post_field( 'post_title', $_GET['p'] );
                elseif ( isset($_GET['page_id']) || !empty($_GET['page_id']) ) :
                    $name = get_post_field( 'post_title', $_GET['page_id'] );
                elseif ( isset($_GET['tag']) || !empty($_GET['tag']) ) :
                    $name = $_GET['tag'];
                elseif ( isset($_GET['cat']) || !empty($_GET['cat']) ) :
                    $name = get_cat_name( $_GET['cat'] );
                elseif ( isset($_GET['m']) || !empty($_GET['m']) ) :
                    if ( preg_match( "/^[\d]{1,5}$/", $_GET['m']) ) :
                        $name = 'Year';
                    elseif( preg_match( "/^[\d]{6,7}$/", $_GET['m']) ) :
                        $name = 'Month';
                    elseif( preg_match( "/^[\d]{8,}$/", $_GET['m']) ) :
                        $name = 'Day';
                    endif;
                elseif ( isset($_GET['s']) || !empty($_GET['s']) ) :
                    $name = _e( 'Search', 'starter-text-domain' );
                endif;

                $href  = get_bloginfo('url');
                $href .= '/' . implode( '/', array_slice($items, 0, $count) );

                $html .= '<li class="breadcrumb-item disabled" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                    $html .= '<a class="breadcrumb-link" href="'. $href .'" itemprop="item">';
                        $html .= '<span itemprop="name">'. ucfirst($name) .'</span>';
                        $html .= '<meta itemprop="position" content="1" />';
                    $html .= '</a>';
                $html .= '</li>';

            endif;

        $html .= '</ol>';

        echo $html;

    }

    public function view_postname() {

        $request = $_SERVER['REQUEST_URI'];
        $param = $_SERVER['QUERY_STRING'];

        // Remove parameter
        if ( !empty($param) ) {
            $regex_param = "/(?:\?.*)/";
            if ( preg_match( $regex_param, $request ) ) {
                $request = preg_replace( $regex_param, '', $request );
            }
        }

        // Remove the beginning and trailing slash
        $regex_search = "/^(?:\/)|(?:\/)$/";
        $items = array();
        if ( preg_match( $regex_search, $request ) ) {
            $request = preg_replace( $regex_search, '', $request );
            $items = explode( '/', $request );
        }

        // HTML
        $html  = '';
        $html .= '<h2 class="breadcrumb-title screen-reader-text">Breadcrumb</h2>';
        $html .= '<ol class="breadcrumb-list" itemscope itemtype="http://schema.org/BreadcrumbList">';

            // Home
            $html .= '<li class="breadcrumb-item home" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                $html .= '<a class="breadcrumb-link ir-phark" href="'. get_bloginfo('url') .'" itemprop="item">';
                    $html .= '<span itemprop="name">'. ucfirst('Home') .'</span>';
                    $html .= '<meta itemprop="position" content="0" />';
                $html .= '</a>';
            $html .= '</li>';

            if ( !is_home() ) :
                $last = count($items);
                foreach ( $items as $key=>$name ) {
                    
                    $count = (int)$key + 1;
                    $name  = ( is_search() ) ? 'Search' : $name;
                    
                    $href = array_slice($items, 0, $count);
                    $href = implode( '/', $href );
                    $href = get_bloginfo('url') . '/' . $href;

                    if ( $count == $last ) :
                        $html .= '<li class="breadcrumb-item disabled" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                            $html .= '<a class="breadcrumb-link" href="'. $href .'" itemprop="item">';
                                $html .= '<span itemprop="name">'. ucfirst($name) .'</span>';
                                $html .= '<meta itemprop="position" content="'. $count .'" />';
                            $html .= '</a>';
                        $html .= '</li>';
                    else :
                        $is_taxonomy = ( preg_match( "/(?:archives|category|tag)/i", $name ) ) ? true : false;
                        $is_disabled    = ( $is_taxonomy ) ? 'disabled' : '';

                        $html .= '<li class="breadcrumb-item '. $is_disabled .'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
                            $html .= '<a class="breadcrumb-link" href="'. $href .'" itemprop="item">';
                                $html .= '<span itemprop="name">'. ucfirst($name) .'</span>';
                                $html .= '<meta itemprop="position" content="'. $count .'" />';
                            $html .= '</a>';
                        $html .= '</li>';
                    endif;
                }
            endif;

        $html .= '</ol>';

        echo $html;

    }

}

// new Starter_Breadcrumb();