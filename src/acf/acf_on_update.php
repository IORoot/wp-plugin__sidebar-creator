<?php

/**
 * On save of options page, run.
 */
function update_sidebar_menu( $post_id = 0, $values = null )
{
    $screen = get_current_screen();

    if ($screen->id != "toplevel_page_sidebar_creator") {
        return;
    }
        
    // ┌─────────────────────────────────────────────────────────────────────────┐
    // │                           Kick off the program                          │
    // └─────────────────────────────────────────────────────────────────────────┘
    $sidebar = new \andyp\sidebarmenu\save;
    
    return;
}

// MUST be in a hook
add_action('acf/save_post', 'update_sidebar_menu', 30);