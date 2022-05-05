<?php 
if ( !defined('ABSPATH') ) {
    wp_die( "Oops, you don't have access to the", "Permission Denied" );
}

class Starter {

    public function __construct(){
        $this->includes();
        $this->init_hooks();
    }

    public function includes() {

        include_once( __DIR__ . '/constant.php' );
        include_once( __DIR__ . '/class-starter-autoloader.php' );
        include_once( __DIR__ . '/helper.php' );
        /* Do not change the include_once file above.. */

        // Put your code
        include_once( __DIR__ . '/template-tag.php' );

    }

    public function init_hooks() {

        /* Common */
        new Starter_Image();
        new Starter_Upload();
        new Starter_Video();
        new Starter_Sidebar();
        new Starter_Content();
        new Starter_Search_Form(); 
        new Starter_Post_View();
        new Starter_Security();
        new Starter_Pingback();
        new Starter_Emoji();
        new Starter_Script_Loader_Tag();

        // new Starter_Comments_Remove();
        // new Starter_Feed_Remove();

        /* Admin Area */
        // new Starter_Admin_User();
        new Starter_Admin_Dashboard(array(
            'remove_widget' => array('dashboard' => 'all')
        ));
        new Starter_Admin_Posttype_Support(array(
            'remove_post_type_support' => array(
                'posttype' => array(
                    'all'  => 'all', // (string|array) 'all', or ['feature','feature']
                ),
                'template' => array(
                    'template-home.php' => array( 
                        'all'  => ['editor'], 
                    ),
                ),
            ),
        ));
        new Starter_Admin_Notice(array('disable' => 'all'));
        new Starter_Admin_Update(array('disable' => 'all'));
        new Starter_Admin_Bar_Show(array(
            'roles' => 'all',
        ));
        new Starter_Admin_Bar_Menu(array(
            'howdy' => 'Hi,'
        ));
        new Starter_Metabox_Remove(array(
            'remove_meta_box' => array(
                'posttype' => array(
                    'all' => 'all', // (string|array) 'all' or ['metabox','metabox']
                ),
            ),
        ));

        /* Third-Party */
        new Starter_Third_Party_Cf7();
        new Starter_Third_Party_Jetpack();

        /* Markup Validation Service */
        new Starter_W3();
    }

}

new Starter();