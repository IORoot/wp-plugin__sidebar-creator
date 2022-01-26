<?php

namespace andyp\sidebarmenu\lib;

/**
 * create the sidebar
 */
class build_sidebar
{

    public $attributes;
    public $options_data;
    public $output = [];

    public function __construct(){
        $this->options_data = get_fields( 'options' );
    }

    public function set_attributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function get_result()
    {
        return implode('',$this->output);
    }


    public function build_sidebar()
    {
        $this->get_sidebars_data();
        $this->get_single_sidebar();
        $this->open_wrapper();
        $this->build_structure();
        $this->insert_styles();
        $this->close_wrapper();
    }

    /**
     * Retrieve all sidebar data from the options page.
     */
    private function get_sidebars_data()
    {
        if (array_key_exists('sidebars', $this->options_data)){
            $this->options_data = $this->options_data['sidebars'];
        }
    }

    /**
     * Narrow down to single sidebar requested in the attributes.
     */
    private function get_single_sidebar()
    {
        foreach ($this->options_data as $key => $instance)
        {
            if ($instance['slug'] !== $this->attributes['slug']) {
                continue;
            }
            $this->options_data = $instance;
        }
    }

    /**
     * Loop through each source in the structure.
     */
    private function build_structure()
    {
        if (!$this->options_data['enabled']){ return; }

        foreach ($this->options_data["structure"]["structure_source"] as $loop_key => $loop_source)
        {
            $classname = "andyp\\sidebarmenu\\lib\\sources\\". $loop_source['acf_fc_layout'];
            $structure = new $classname;
            $structure->config($loop_source);
            $structure->options_data($this->options_data);
            $structure->run();
            $this->output[] = $structure->out();
        }
    }

    private function open_wrapper()
    {
        $this->output[] = '<div class="'.$this->attributes["slug"]. ' ' . $this->options_data["wrapper_classes"] .'">';
    }

    private function close_wrapper()
    {
        $this->output[] = '</div>';
    }

    private function insert_styles()
    {
        $this->output[] = '<style>'.$this->options_data["style"].'</style>';
    }
}