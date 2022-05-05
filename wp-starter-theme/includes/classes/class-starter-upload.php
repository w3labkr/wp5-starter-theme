<?php 
/**
 * Change Filenames for Uploads
 *
 * @link https://wpartisan.me/tutorials/rename-clean-wordpress-media-filenames
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/wp_handle_upload_prefilter
 * @link https://stackoverflow.com/questions/51724496/wordpress-how-to-get-the-next-new-post-id
 */

if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter_Upload {

    public function __construct(){
        add_filter( 'wp_handle_upload_prefilter', array( $this, 'reinit_upload_file_name' ), 11, 1 );
        add_filter( 'upload_mimes', array( $this, 'upload_mime_types' ) );
    }

    public function reinit_upload_file_name( $file ) {

        if ( !current_user_can('upload_files') ) {
            return $file;
        }

        // Convert urlencode to urldecode
        $file['name'] = urldecode($file['name']);

        // Convert string to lower
        $file['name'] = strtolower($file['name']);

        // Remove Invalid Character
        $invalid = array(
            ' '   => '-',
            '%20' => '-',
            '_'   => '-',
        );
        $file['name'] = str_replace( array_keys( $invalid ), array_values( $invalid ), $file['name'] );
        
        // Get new post_id - auto increment
        global $wpdb;
        $result  = $wpdb->get_results( "SHOW TABLE STATUS LIKE '". $wpdb->prefix ."posts'", ARRAY_A );
        $auto_increment = $result[0]['Auto_increment'];
        
        // Get user id
        $current_user = wp_get_current_user();
        $current_user_id = $current_user->ID;

        // Serial = 190101u1p1 = date_ymd-user_id-attachment_id
        $serial = current_time('ymd') .'u'. $current_user_id .'p'. $auto_increment;
        $file['name'] = $serial .'-'. $file['name'];

        // Convert to ASCII
        $file['name'] = sanitize_file_name( $file['name'] );
     
        return $file;
    }

    public function upload_mime_types() {
        
        // New allowed mime types.
        $mimes['csv']  = 'text/csv';
        $mimes['hwp']  = 'application/x-hwp';
        $mimes['doc']  = 'application/msword';
        $mimes['pdf']  = 'application/pdf';
        $mimes['egg']  = 'application/alzip';
        
        // Image formats
        $mimes['jpg|jpeg|jpe']  = 'image/jpeg';
        $mimes['png']  = 'image/png';
        $mimes['gif']  = 'image/gif';
        $mimes['bmp']  = 'image/bmp';
        $mimes['ico']  = 'image/x-icon';
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';

        // Optional. Remove a mime type.
        $excludes = []; // (array) 'exe','doc', ...
        if ( ! empty($excludes) ) {
            foreach($excludes as $exclude) {
                unset( $mimes[$exclude] );
            }            
        }

        return $mimes;
    }

}

// new Starter_Upload();