<?php function DWPostModel($post, $widget_title){ 

    setup_postdata($post);

    $thumbnail_url = get_the_post_thumbnail_url($post->ID);
    $thumbnail = $thumbnail_url ? "<img src='". $thumbnail_url ."' class='thumbnail' alt='img'>" : "";
    $link = get_edit_post_link($post->ID);
    $title = get_the_title($post->ID);

    $title = str_replace(' ', '_', sanitize_title($widget_title)) . '_widget';
    $color = get_option($title . '_colour');

    $img_off = $thumbnail_url ? "" : "img-off";

    return "
    <div class='dashboard-widget-post'>
        <div class='colorbox' style='background-color: ". $color ." !important;'></div>
        <div class='content ". $img_off ."'>
            ". $thumbnail ."
            <div class='text'>
                <h4 class='title'>". $title ."</h4>
                <a href='". $link ."' class='button button-primary'>" . __( 'Edit', 'postbox' ) . "</a>
            </div>
        </div>
    </div>";

    wp_reset_postdata();

} ?>