<?php

$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'actions';

?>

<div class="postbox-layout">

    <div class="wrap">

        <h1><?php _e( 'Postbox Options', 'postbox' ) ?></h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=postbox&tab=geral" class="nav-tab <?php echo $active_tab == 'actions' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Actions', 'postbox' ) ?></a>
            <a href="?page=postbox&tab=posts" class="nav-tab <?php echo $active_tab == 'posts' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Posts', 'postbox' ) ?></a>
        </h2>

        <form method="post">
        
            <?php 

                switch ($active_tab) {
                    case 'posts':
                        ?>

                        <h2><?php _e('Posts', 'postbox'); ?></h2>
                        <div class="options">
                            <?php do_action('render_admin_postbox_posts'); ?>
                        </div>
                        <?php
                        submit_button(__('Save Changes', 'postbox'));
                        break;
                    
                    default:
                        ?>

                        <h2><?php _e('Actions', 'postbox'); ?></h2>
                        <div class="options">
                            <?php do_action('render_admin_postbox_options'); ?>
                        </div>
                        <?php
                        submit_button(__('Save Changes', 'postbox'));
                        break;
                } ?>

            
        </form>

    </div>

</div>