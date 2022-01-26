<?php

namespace andyp\sidebarmenu\lib\sources;

use andyp\sidebarmenu\lib\interfaces\sourceInterface;

/**
 * create the sidebar from a menu
 */
class rawcode implements sourceInterface
{

    public $config;
    public $options_data;
    public $output = [];

    public function config($config)
    {
        $this->config = $config;
    }
    
    public function options_data($options_data)
    {
        $this->options_data = $options_data;
    }

    public function out()
    {
        return implode('',$this->output);
    }

    public function run()
    {
        $this->output_rawcode();
    }

    /**
     * Get a list of all menu terms.
     */
    private function output_rawcode()
    {
        $this->output[] = $this->config["rawcode"];
    }


}