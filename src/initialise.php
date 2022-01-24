<?php

namespace andyp\sidebarmenu;

class initialise {


    public function __construct()
    {

        // ┌─────────────────────────────────────────────────────────────────────────┐
        // │                                ACF    	                          	     │
        // └─────────────────────────────────────────────────────────────────────────┘
        $this->acf_init();
    }


    /**
     * Create ACF Panels
     */
    public function acf_init()
    {
        new acf\acf_init;
    }

}