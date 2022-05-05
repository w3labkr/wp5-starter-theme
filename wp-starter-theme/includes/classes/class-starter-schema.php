<?php 
/**
 * The Schema Markup
 *
 * @link http://microformats.org/wiki/hentry
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Schema {

    /**
     * Embedding a Google Map
     * 
     * @link https://schema.org/Map
     * @link http://schema.org/LocalBusiness
     */
    public static function view_map( $opts=array() ) {

        // options
        $_opts = array(
            'map'       => STARTER_IMG . '/map.jpg',
            'name'      => BUSINESS_NAME,
            'address'   => BUSINESS_ADDRESS,
            'telephone' => BUSINESS_TELEPHONE,
        );
        $args = ( is_array($opts) ) ? array_replace_recursive($_opts, $opts) : $_opts;

        // markup
        $html = '';
        $html .= '<div class="map-meta screen-reader-text">';
            $html .= '<span itemprop="name">'. $args['name'] .'</span>';
            $html .= '<span itemprop="address">'. $args['address'] .'</span>';
            $html .= '<span itemprop="telephone">'. $args['telephone'] .'</span>';
            $html .= '<img itemprop="image" src="'. $args['map'] .'" alt="Local business"/>';
        $html .= '</div>';

        return $html;
    }

}