<?php 
if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

/**
 * Layout
 */

/* Container */
if ( ! function_exists( 'starter_get_container' ) ) {
    function starter_get_container( $opts=array() ) {
        $layout = new Starter_Admin_Layout($opts);
        return $layout->get_container();
    }
}
if ( ! function_exists( 'starter_the_container' ) ) {
    function starter_the_container( $opts=array() ) {
        echo starter_get_container( $opts );
    }
}

/* Primary */
if ( ! function_exists( 'starter_get_primary' ) ) {
    function starter_get_primary( $opts=array() ) {
        $layout = new Starter_Admin_Layout($opts);
        return $layout->get_primary();
    }
}
if ( ! function_exists( 'starter_the_primary' ) ) {
    function starter_the_primary( $opts=array() ) {
        echo starter_get_primary( $opts );
    }
}

/* Secondary */
if ( ! function_exists( 'starter_get_secondary' ) ) {
    function starter_get_secondary( $opts=array() ) {
        $layout = new Starter_Admin_Layout($opts);
        return $layout->get_secondary();
    }
}

/* Tertiary */
if ( ! function_exists( 'starter_get_tertiary' ) ) {
    function starter_get_tertiary( $opts=array() ) {
        $layout = new Starter_Admin_Layout($opts);
        return $layout->get_tertiary();
    }
}


/**
 * Post Navigation
 */
if ( ! function_exists( 'starter_the_post_navigation' ) ) {
    function starter_the_post_navigation ( $args=array() ) {
        new Starter_Post_Navigation($args); 
    }
}


/**
 * Brand
 */
if ( ! function_exists( 'starter_the_brand' ) ) {
    function starter_the_brand () {
        return Starter_Brand::view_brand();
    }
}


/**
 * Breadcrumb
 */
if ( ! function_exists( 'starter_the_breadcrumb' ) ) {
    function starter_the_breadcrumb () {
        new Starter_Breadcrumb(); 
    }
}


/**
 * Feed Content
 */
if ( ! function_exists( 'starter_the_fetch_feed' ) ) {
    function starter_the_fetch_feed( $feed, $maxitem=10, $cache='every_month' ) {
        new Starter_Feed_Fetch(array(
            'feed'    => $feed,
            'maxitem' => $maxitem,
            'cache'   => $cache,
        )); 
    }
}


/**
 * Copyright
 */
if ( ! function_exists( 'starter_the_copyright_text' ) ) {
    function starter_the_copyright_text( $opts=array() ){
        new Starter_Copyright_Text($opts);
    }
}


/**
 * The hEntry schema 
 */

/* Title */
if ( ! function_exists( 'starter_get_entry_title' ) ) {
    function starter_get_entry_title( $post=null, $tag='h2', $class='', $gradient=true, $screen=true ) {
        return Starter_Hentry::view_title($post,$tag,$class,$gradient,$screen);
    }
}
if ( ! function_exists( 'starter_the_entry_title' ) ) {
    function starter_the_entry_title( $post=null, $tag='h2', $class='', $gradient=true, $screen=true ) {
        echo starter_get_entry_title($post,$tag,$class,$gradient,$screen);
    }
}

if ( ! function_exists( 'starter_the_gradient_text' ) ) {
    function starter_the_gradient_text( $id, $text='', $startColor='#ffdd01', $finishColor='#f7951e', $rotate='0' ) {
        echo starter_get_gradient_text($id,$text,$startColor,$finishColor,$rotate);
    }
}

/* Thumbnail */
if ( ! function_exists( 'starter_get_entry_thumbnail' ) ) {
    function starter_get_entry_thumbnail( $post=null, $screen=true, $class='' ) {
        return Starter_Hentry::view_thumbnail($post,$screen,$class);
    }
}
if ( ! function_exists( 'starter_the_entry_thumbnail' ) ) {
    function starter_the_entry_thumbnail( $post=null, $screen=true, $class='' ) {
        echo starter_get_entry_thumbnail($post,$screen,$class);
    }
}

/* Meta */
if ( ! function_exists( 'starter_get_entry_meta' ) ) {
    function starter_get_entry_meta( $post=null, $d='', $screen=false, $class='' ) {
        return Starter_Hentry::view_meta($post,$d,$screen,$class);
    }
}
if ( ! function_exists( 'starter_the_entry_meta' ) ) {
    function starter_the_entry_meta( $post=null, $d='', $screen=false, $class='' ) {
        echo starter_get_entry_meta($post,$d,$screen,$class);
    }
}

/* Author */
if ( ! function_exists( 'starter_get_entry_author' ) ) {
    function starter_get_entry_author( $screen=true, $class='' ) {
        return Starter_Hentry::view_author($screen,$class);
    }
}
if ( ! function_exists( 'starter_the_entry_author' ) ) {
    function starter_the_entry_author( $screen=true, $class='' ) {
        echo starter_get_entry_author($screen,$class);
    }
}

/* Published */
if ( ! function_exists( 'starter_get_entry_published' ) ) {
    function starter_get_entry_published( $post=null, $d='', $screen=true, $class='' ) {
        return Starter_Hentry::view_published($post,$d,$screen,$class);
    }
}
if ( ! function_exists( 'starter_the_entry_published' ) ) {
    function starter_the_entry_published( $post=null, $d='', $screen=true, $class='' ) {
        echo starter_get_entry_published($post,$d,$screen,$class);
    }
}

/* Updated */
if ( ! function_exists( 'starter_get_entry_updated' ) ) {
    function starter_get_entry_updated( $post=null, $d='', $screen=false, $class='' ) {
        return Starter_Hentry::view_updated($post,$d,$screen,$class);
    }
}
if ( ! function_exists( 'starter_the_entry_updated' ) ) {
    function starter_the_entry_updated( $post=null, $d='', $screen=false, $class='' ) {
        echo starter_get_entry_updated($post,$d,$screen,$class);
    }
}

/* Permalink */
if ( ! function_exists( 'starter_get_entry_permalink' ) ) {
    function starter_get_entry_permalink( $post=null, $screen=true, $class='' ) {
        return Starter_Hentry::view_permalink($post,$screen,$class);
    }
}
if ( ! function_exists( 'starter_the_entry_permalink' ) ) {
    function starter_the_entry_permalink( $post=null, $screen=true, $class='' ) {
        echo starter_get_entry_permalink($post,$screen,$class);
    }
}

/* mainEntityOfPage */
if ( ! function_exists( 'starter_get_entry_main_entity_of_page' ) ) {
    function starter_get_entry_main_entity_of_page( $post=null ) {
        return Starter_Hentry::view_main_entity_of_page($post);
    }
}
if ( ! function_exists( 'starter_the_entry_main_entity_of_page' ) ) {
    function starter_the_entry_main_entity_of_page( $post=null ) {
        echo starter_get_entry_main_entity_of_page($post);
    }
}

/* Publisher */
if ( ! function_exists( 'starter_get_entry_publisher' ) ) {
    function starter_get_entry_publisher( $screen=false, $class='' ) {
        return Starter_Hentry::view_publisher($screen,$class);
    }
}
if ( ! function_exists( 'starter_the_entry_publisher' ) ) {
    function starter_the_entry_publisher( $screen=false, $class='' ) {
        echo starter_get_entry_publisher($screen,$class);
    }
}

/* Summary */
if ( ! function_exists( 'starter_get_entry_summary' ) ) {
    function starter_get_entry_summary( $post=null, $screen=false, $length=150, $class='' ) {
        return Starter_Hentry::view_summary($post,$screen,$length,$class);
    }
}
if ( ! function_exists( 'starter_the_entry_summary' ) ) {
    function starter_the_entry_summary( $post=null, $screen=false, $length=150, $class='' ) {
        echo starter_get_entry_summary($post,$screen,$length,$class);
    }
}


/**
 * The Schema Markup
 */

/* Map */
if ( ! function_exists( 'starter_get_schema_map' ) ) {
    function starter_get_schema_map( $opts=array() ) {
        return Starter_Schema::view_map($opts);
    }
}
if ( ! function_exists( 'starter_the_schema_map' ) ) {
    function starter_the_schema_map( $opts=array() ) {
        echo starter_get_schema_map($opts);
    }
}


/**
 * Hero Content
 */
if ( ! function_exists( 'starter_the_hero_content' ) ) {
    function starter_the_hero_content( $opts=array() ) {
        new Starter_Hero($opts);
    }
}

if ( ! function_exists( 'starter_get_preload_image' ) ) {
    function starter_get_preload_image( $opts=array() ) {
        new Starter_Preload_Image($opts);
    }
}


/** 
 * Add prev and next article links 
 */
if ( ! function_exists( 'starter_get_adjacent_meta' ) ) {
    function starter_get_adjacent_meta(){
        return Starter_Meta::add_adjacent_meta();
    }
}


/**
 * Gradient Text 
 */
if ( ! function_exists( 'starter_get_gradient_text' ) ) {
    function starter_get_gradient_text( $id, $text='', $startColor='#ffdd01', $finishColor='#f7951e', $rotate='0' ) {

        $gradient_id = 'gradient-text-id-' . $id;

        $html  = '';
        $html .= '<span class="gradient-text-wrapper">';
            $html .= '<svg class="gradient-text-svg" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">';
                $html .= '<defs>';
                    $html .= '<linearGradient id="'. $gradient_id .'" gradientTransform="rotate('. $rotate .')">';
                        $html .= '<stop offset="0%" stop-color="'. $startColor .'"/>';
                        $html .= '<stop offset="100%" stop-color="'. $finishColor .'"/>';
                    $html .= '</linearGradient>';
                $html .= '</defs>';
                $html .= '<text fill="url(#'. $gradient_id .')" x="50%" y="80%" text-anchor="middle">';
                    $html .= $text;
                $html .= '</text>';
            $html .= '</svg>';
        $html .= '</span>';

        return $html;
    }
}
