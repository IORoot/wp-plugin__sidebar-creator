<?php

namespace andyp\sidebarmenu;

/**
 * This runs from the ACF on_update action.
 */
class save {


    public function __construct()
    {
        // ┌─────────────────────────────────────────────────────────────────────────┐
        // │                        Register Shortcodes    	                         │
        // └─────────────────────────────────────────────────────────────────────────┘
        $this->register_shortcodes();
    }

    public function register_shortcodes()
    {
        new lib\register_shortcodes;
    }
}