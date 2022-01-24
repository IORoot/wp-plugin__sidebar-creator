<?php

namespace andyp\sidebarmenu\lib;

/**
 * Register all shortcodes declared in ACF Panel.
 */
class register_shortcodes
{

    public $options_data;
    public $loop_key;
    public $loop_instance;



    public function __construct(){

        $this->get_sidebar_data();
        if (!$this->options_data){ return; };

        $this->register_shortcodes();
    }



    /**
     * Retrieve all data from the options page.
     */
    private function get_sidebar_data()
    {
        $data = get_fields( 'options' );

        if (array_key_exists('sidebars', $data)){
            $this->options_data = $data['sidebars'];
        }
        
    }


    private function register_shortcodes()
    {
        foreach($this->options_data as $this->loop_key => $this->loop_instance)
        {
            add_shortcode( $this->loop_instance['slug'], [$this, 'run_sidebar'] );
        }
    }



    public function run_sidebar($atts = array(), $content = null, $shortcode = null)
    {
        return $shortcode;
    }
}