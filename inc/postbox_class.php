<?php

class postbox_class {

    public function __construct() {

        
        add_action('admin_init', [$this, 'disable_dashboard_widgets']);

        add_action('admin_menu', [$this, 'create_menupage_postbox']);
        add_action('admin_init', [$this, 'init_widget_options']);
        add_action('wp_dashboard_setup', [$this, 'register_dashboard_widgets']);
        add_action('admin_init', [$this, 'save_options']);


    }

    // disable all dashboard widgets
    public function disable_dashboard_widgets() {
        remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
        remove_meta_box('dashboard_activity', 'dashboard', 'normal');
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
        remove_meta_box('dashboard_primary', 'dashboard', 'side');
        remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    }





    // Menu Page Function
    public function create_menupage_postbox() {
        
        add_menu_page( 
            'Postbox', 
            'Postbox', 
            'manage_options', 
            'postbox', 
            array( $this, 'render_postbox_page' ), 
            'dashicons-admin-post',
            25 
        );

    }
    // Render Content
    public function render_postbox_page() {
        require_once dirname(__DIR__, 1) . '/templates/postbox_admin_area.php';
    }
    



    // this one will create the widget
    private function register_widget($widget_title, $dashboard_widget_html, $enable_colour) {

        $widget_title_slug = str_replace(' ', '_', sanitize_title($widget_title));

        wp_add_dashboard_widget(
            $widget_title_slug,
            __($widget_title, 'postbox'),
            [$this, 'render_dashboard_widget_content'],
            null,
            ['html' => $dashboard_widget_html, 'enable_colour' => $enable_colour],
            
        );
    }

    // this one will render the widget
    public function render_dashboard_widget_content($post, $callback_args) {
        echo $callback_args['args']['html'];
    }

    // this one will create the widget option within postbox_admin_area.php
    private function register_widget_option($widget_title, $enable_colour) {

        $widget_title_slug = str_replace(' ', '_', sanitize_title($widget_title));
        $enable_colour = $enable_colour == true ? true : false;
        
        add_action('render_admin_postbox_options', function() use ($widget_title, $widget_title_slug, $enable_colour) {
            $option_name = $this->get_widget_option_name($widget_title);
            $checked = checked(1, get_option($option_name), false);

            $checked = $checked ? 'checked' : '';
            $colour = get_option($option_name . '_colour');

            if( !$enable_colour ){
                $html = '
                <div class="form-group">
                    <input type="checkbox" id="'.$option_name.'" name="'.$option_name.'" value="1" '.$checked.'>
                    <label for="'.$option_name.'">' . sprintf(__('Display "%s" Widget', 'postbox'), $widget_title) . '</label>
                </div>';
                echo $html;
            }

            
        });

        add_action('render_admin_postbox_posts', function() use ($widget_title, $widget_title_slug, $enable_colour) {
            $option_name = $this->get_widget_option_name($widget_title);
            $checked = checked(1, get_option($option_name), false);

            $checked = $checked ? 'checked' : '';
            $colour = get_option($option_name . '_colour');

            if( $enable_colour ){
                $html = '
                    <div class="form-group">
                        <input type="checkbox" id="'.$option_name.'" name="'.$option_name.'" value="1" '.$checked.'>
                        <label for="'.$option_name.'">' . sprintf(__('Display "%s" Widget', 'postbox'), $widget_title) . '</label>
                        <input type="color" id="'.$option_name.'_colour" name="'.$option_name.'_colour" value="'.$colour.'">
                        <label for="'.$option_name.'_colour">Colour Reference</label>
                    </div>';

                echo $html;
            }

            
        });

    }

    // return the option name
    private function get_widget_option_name($widget_title) {
        return str_replace(' ', '_', sanitize_title($widget_title)) . '_widget';
    }
    
    // this one will first render the options and then create the widget case the option is checked
    public function create_dashboard_widget($widget_title, $dashboard_widget_html, $enable_colour ) {

        $this->register_widget_option($widget_title, $enable_colour );

        if (get_option($this->get_widget_option_name($widget_title))) {
            $this->register_widget($widget_title, $dashboard_widget_html, $enable_colour);
        }
    }
    
    // this function execute the hook to create the widget
    public function register_dashboard_widgets() {
        do_action('register_dashboard_widget', [$this, 'create_dashboard_widget']);
    }
    
    // setting up default values
    public function init_widget_options() {
        do_action('register_dashboard_widget', function($title, $html, $enable_colour) {
            $this->register_widget_option($title, $enable_colour);
        });
    }

    // save options
    public function save_options() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                if (strpos($key, '_widget') !== false) {
                    update_option($key, $value);
                }
            }
        }
    }






}

new postbox_class();


?>