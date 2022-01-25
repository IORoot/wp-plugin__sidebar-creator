<?php

namespace andyp\sidebarmenu\lib;

/**
 * Register all shortcodes declared in ACF Panel.
 */
class register_shortcodes
{

    public function __construct(){
        $this->register_shortcodes();
    }
    

    private function register_shortcodes()
    {
        add_shortcode( 'sidebar_menu', [$this, 'run'] );
    }


    public function run($attributes = array(), $content = null)
    {
        $sidebar = new build_sidebar;
        $sidebar->set_attributes($attributes);
        $sidebar->build_sidebar();
        return $sidebar->get_result();
    }
}