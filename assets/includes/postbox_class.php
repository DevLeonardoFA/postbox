<?php

class postbox_class {

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'create_menupage_postbox' ) );

    }


    // Menu Page Function
    public function create_menupage_postbox() {
        
        add_menu_page( 
            'Postbox', 
            'Postbox', 
            'manage_options', 
            'postbox', 
            array( $this, 'postbox_page' ), 
            'dashicons-admin-post',
            25 
        );

    }
    // Render Content
    public function postbox_page() {
        require_once dirname(__DIR__, 1) . '/templates/postbox_admin_area.php';
    }



}

new postbox_class();


?>