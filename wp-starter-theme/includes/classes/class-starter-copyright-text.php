<?php
/**
 * Copyright Text
 *
 * @link https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Copyright_Text {

    public $_opts;

    public function __construct( $opts=array() ){
        $this->_opts = $opts;
        $this->views();
    }

    public function options() {
        
        $options = $this->_opts;

        $defaults = array(
            'skin'      => 'default',
            'year'      => COPYRIGHT_YEAR,
            'holder'    => COPYRIGHT_HOLDER,
            'permalink' => COPYRIGHT_URL,
        );

        $settings = ( is_array($options) ) ? array_replace_recursive($defaults, $options) : $defaults;

        return $settings;
    }

    public function views() {
        $opts = $this->options();

        switch ( $opts['skin'] ) {
            case 'default':
                $this->skin_default();
                break;
            case 'github':
                $this->skin_github();
                break;
        }

        
    }

    public function skin_default() {
        $opts = $this->options();

        // get dynamic copyright date if year in option is empty
        $year = ( empty($opts['year']) ) ? $this->get_year() : $opts['year'];

        $html  = '';
        $html .= 'Copyright(c) ';
        $html .= '<span itemprop="copyrightYear">'. $year .'</span>';
        $html .= ' by ';
        $html .= '<span itemprop="copyrightHolder" itemscope itemtype="http://schema.org/Person">';
            $html .= '<a href="'. $opts['permalink'] .'" target="_blank"><span itemprop="name">'. $opts['holder'] .'</span></a>';
        $html .= '</span>';

        echo $html;
    }

    public function skin_github() {
        $opts = $this->options();

        $html  = '';
        $html .= '<span>WP Starter Theme is licensed under the '. COPYRIGHT_LICENSE .', '. COPYRIGHT_LICENSE_VERSION .'</span>';
        $html .= '<br>';
        $html .= '<a href="'. STARTER_URI .'/LICENSE">'. COPYRIGHT_LICENSE .'</a> | ';
        $html .= '<a href="'. COPYRIGHT_GITHUB_URL .'" target="_blank">View on Github</a>';
        
        echo $html;
    }

    public function get_year() {
        global $wpdb;
        
        $copyright_dates = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish'");
        
        $output = '';
        if($copyright_dates) {
            $copyright = $copyright_dates[0]->firstdate;
            if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
                $copyright .= '-' . $copyright_dates[0]->lastdate;
            }
            $output = $copyright;
        }

        return $output;
    }

}