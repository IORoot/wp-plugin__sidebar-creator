<?php

add_action( 'plugins_loaded', function() {
    do_action('register_andyp_plugin', [
        'title'     => 'Sidebar Menu',
        'icon'      => 'page-layout-sidebar-left',
        'color'     => '#F59E0B',
        'path'      => __FILE__,
    ]);
} );