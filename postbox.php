<?php

/**
 * 
 * Plugin Name: Postbox
 * Plugin URI: 
 * Description: Active and Deactive Postbox at Admin Panel Dashboard
 * Version: 1.0.0
 * Author: Leonardo F. Alonso
 * Author URI: https://leonardofalonso.vercel.app
 * PHP Version: 8.2.27
 * WordPress Version: <= 6.8.2 
 * 
 */

defined ( 'ABSPATH' ) || exit;

require_once __DIR__ . '/inc/postbox_class.php';




// register css
add_action('admin_enqueue_scripts', function(){

    wp_enqueue_style('postbox_backend', plugin_dir_url(__FILE__) . '/assets/css/backend.css');

    // color picker wp
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

});




add_action('init', function() {

    include __DIR__ . '/templates/dashboard_widget_model.php';
    include __DIR__ . '/templates/dashboard_widget_post_model.php';

    $cpt_slugs = get_post_types([ 'public' => true ], 'objects', 'and');

    foreach( $cpt_slugs as $cpt_slug ) {
    
        $label = $cpt_slug->label;
        $slug = $cpt_slug->name;
        $html = DWModel($slug);

        add_action('register_dashboard_widget', function($create_widget) use ($label, $html) {
            $create_widget($label, (string)$html, false);
        });

        $posts_args = array(    
            'post_type' => $slug,
            'posts_per_page' => 4,
        );

        $posts = get_posts($posts_args);

        if( $posts ) {

            $title = __('Recent '. $label, 'postbox');
            $content = '<div class="dashboard-widget-posts">';

            foreach( $posts as $post ) {
                $content .= DWPostModel($post, $title);
            }

            $content .= '</div>';

            add_action('register_dashboard_widget', function($create_widget) use ($title, $content) {
                $create_widget($title, $content, true);
            });

        }
    
    }


});





?>