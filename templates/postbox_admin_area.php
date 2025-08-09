<?php

$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'geral';

?>

<div class="postbox-layout">

    <div class="wrap">

        <h1><?php _e( 'Postbox Options', 'postbox' ) ?></h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=postbox&tab=geral" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General', 'postbox' ) ?></a>
        </h2>

        <form method="post">
            <?php

            echo '<h2>' . __('Options', 'postbox') . '</h2>';
            do_action('render_admin_postbox_options');
            submit_button(__('Save Changes', 'postbox'));

            ?>
        </form>

    </div>

</div>