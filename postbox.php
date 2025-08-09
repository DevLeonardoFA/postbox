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


$args = array(
    'public'   => true,
    '_builtin' => true // Exclude built-in post types
);
$output = 'names'; // Return an array of post type slugs
$operator = 'and'; // All arguments must be true

$cpt_slugs = get_post_types( $args, $output, $operator );

if( $cpt_slugs ) {
    foreach( $cpt_slugs as $cpt_slug ) {

        $cpt_slug = str_replace(' ', '_', sanitize_title($cpt_slug));
        $html = '<a href="post-new.php?post_type='.$cpt_slug.'" class="button button-primary">'. __('New '.$cpt_slug, 'postbox') .'</a>';

        add_action('register_dashboard_widget', function($create_widget) use ($cpt_slug, $html) {
            $create_widget($cpt_slug, $html);
        });


        $posts_args = array(
            'post_type' => $cpt_slug,
            'posts_per_page' => 4,
        );

        $posts = get_posts($posts_args);

        if( $posts ) {
            $title = __('Recent '.$cpt_slug, 'postbox');
            $content = [];
            foreach( $posts as $post ) {
                $content[] = '<li><a href="post.php?post='.$post->ID.'&action=edit">'.$post->post_title.'</a></li>';
            }
        }

        add_action('register_dashboard_widget', function($create_widget) use ($title, $content) {
            $create_widget($title, '<ul>'.implode('', $content).'</ul>');
        });

    }
}


?>