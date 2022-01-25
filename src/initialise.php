<?php

namespace andyp\sidebarmenu;

class initialise {


    public function __construct()
    {

        // ┌─────────────────────────────────────────────────────────────────────────┐
        // │                                ACF    	                          	     │
        // └─────────────────────────────────────────────────────────────────────────┘
        $this->acf_init();

        // ┌─────────────────────────────────────────────────────────────────────────┐
        // │                        Register Shortcode    	                         │
        // └─────────────────────────────────────────────────────────────────────────┘
        $this->register_shortcodes();
    }


    /**
     * Create ACF Panels
     */
    public function acf_init()
    {
        new acf\acf_init;
    }


    /**
     * Create the [sidebar_menu] shortcode.
     */
    public function register_shortcodes()
    {
        new lib\register_shortcodes;
    }

}