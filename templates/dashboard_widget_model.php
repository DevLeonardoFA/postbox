<?php function DWModel($cpt_slug){ 

    return "
    <div class='actions'>
        <a href='edit.php?post_type=" . $cpt_slug . "' class='button button-primary'>" . __( 'All Posts', 'postbox' ) . "</a>
        <a href='post-new.php?post_type=' . $cpt_slug . ' class='button button-primary'>" . __( 'Add New', 'postbox' ) . "</a>
    </div>
    ";

} ?>