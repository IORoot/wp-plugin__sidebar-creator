<?php

namespace andyp\sidebarmenu\lib\sources;

use andyp\sidebarmenu\lib\interfaces\sourceInterface;
use andyp\sidebarmenu\lib\walkers\walker_taxonomy_posts;

/**
 * create the sidebar from a taxonomy
 */
class taxonomy implements sourceInterface
{

    public $config;
    public $options_data;
    public $walker = '';
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
        $this->set_walker();
        $this->switch_parent_posts();
        $this->set_classes_data();
        $this->classes_filters();
        $this->get_source();
    }

    private function set_walker()
    {
        if ($this->config["list_posts"]){
            $this->walker = new walker_taxonomy_posts();
        }
    }

    private function switch_parent_posts()
    {
        $this->walker->switch_parent_posts($this->config["list_parent_posts"]);
    }

    private function set_classes_data()
    {
        $this->walker->set_classes_data([
            'unordered_list_classes' => $this->options_data["unordered_list_classes"],
            'list_item_classes' => $this->options_data["list_item_classes"],
            'link_classes' => $this->options_data["link_classes"],
        ]);
    }

    private function classes_filters()
    {
        /**
         * Anchor filter
         */
        \add_filter('category_list_link_attributes', function() { return ['class' => $this->options_data["link_classes"]]; });

        /**
         * list item filter.
         */
        \add_filter('category_css_class', function() { return [$this->options_data["list_item_classes"]]; });
    }

    private function get_source()
    {   
        ob_start();

            echo '<ul class="'. $this->options_data["unordered_list_classes"] . ' '. $this->config["menu_source_taxonomy"].'">';
            wp_list_categories([
                'taxonomy'     => $this->config["menu_source_taxonomy"],
                'orderby'      => 'name',
                'show_count'   => true,
                'pad_counts'   => false,
                'hierarchical' => true,
                'title_li'     => '',
                'walker'       => $this->walker
            ]);
            echo '</ul>';

        $this->output[] = ob_get_clean();
    }


}