<?php
add_filter( 'gform_is_feed_asynchronous', function ( $is_asynchronous, $feed, $entry, $form ) {
    if ( ! $is_asynchronous || rgar( $feed, 'addon_slug' ) !== 'gravityformsuserregistration' ) {
        return $is_asynchronous;
    }
 
    return false;
}, 10, 4 );
?>
