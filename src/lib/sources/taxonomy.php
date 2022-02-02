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
    public $expand = '';

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
        $this->set_auto_expand_data();
        $this->set_post_query();
        $this->set_prefix_suffix_data();
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

    private function set_post_query()
    {
        $this->walker->set_post_query($this->config["post_query"]);
    }

    private function set_classes_data()
    {
        $this->walker->set_classes_data([
            'unordered_list_classes' => $this->config["unordered_list_classes"],
            'list_item_classes' => $this->config["list_item_classes"],
            'link_classes' => $this->config["link_classes"],
        ]);
    }    
    
    private function set_auto_expand_data()
    {

        if (!$this->config["auto_expand"]){
            return;
        }
        
        // get current page
        global $wp_query;

        // TERM
        if (is_a($wp_query->queried_object, 'WP_Term'))
        {
            $this->walker->set_expanded([$wp_query->queried_object->parent, $wp_query->queried_object->term_id]);
            
        }

        // POST
        if (is_a($wp_query->queried_object, 'WP_Post'))
        {
            $terms = [];
            $term_ids = [];
            $taxonomies = get_post_taxonomies($wp_query->queried_object);

            if (!empty($taxonomies))
            {
                foreach ($taxonomies as $taxonomy)
                {
                    $terms = get_the_terms($wp_query->queried_object, $taxonomy);
                }
            }

            if (!empty($terms))
            {
                foreach ($terms as $term){
                    $term_ids[]  = $term->term_id;
                }
            }

            if (!empty($term_ids)){
                $this->walker->set_expanded($term_ids);
            }

        }

        // Top parent
        if (!is_page()){
            $this->options_data["prefix_suffix"]["suffix_top_unordered_list_open"] = str_replace('<input', '<input checked', $this->options_data["prefix_suffix"]["suffix_top_unordered_list_open"]);
        }

    }

    private function set_prefix_suffix_data()
    {
        $ps = $this->options_data["prefix_suffix"];
        $this->walker->set_prefix_suffix_data([
            'prefix_link_open' => $ps["prefix_link_open"],
            'suffix_link_open' => $ps["suffix_link_open"],
            'prefix_link_close' => $ps["prefix_link_close"],
            'suffix_link_close' => $ps["suffix_link_close"],
            'prefix_count' => $ps["prefix_count"],
            'suffix_count' => $ps["suffix_count"],
            'prefix_list_item_open' => $ps["prefix_list_item_open"],
            'suffix_list_item_open' => $ps["suffix_list_item_open"],
            'prefix_list_item_close' => $ps["prefix_list_item_close"],
            'suffix_list_item_close' => $ps["suffix_list_item_close"],
            'prefix_unordered_list_open' => $ps["prefix_unordered_list_open"],
            'suffix_unordered_list_open' => $ps["suffix_unordered_list_open"],
            'prefix_unordered_list_close' => $ps["prefix_unordered_list_close"],
            'suffix_unordered_list_close' => $ps["suffix_unordered_list_close"],
        ]);
    }

    private function classes_filters()
    {
        /**
         * Anchor filter
         */
        \add_filter('category_list_link_attributes', function($atts) { 
            $atts['class'] = $this->config["link_classes"];
            return $atts; 
        });

        /**
         * list item filter.
         */
        \add_filter('category_css_class', function($atts) { 
            $atts['class'] = $this->config["list_item_classes"];
            return $atts; 
        });
    }

    private function get_source()
    {   
        ob_start();

            echo $this->options_data["prefix_suffix"]["prefix_top_unordered_list_open"].'<ul class="'. $this->config["unordered_list_classes"] . ' '. $this->config["menu_source_taxonomy"].'">'.$this->options_data["prefix_suffix"]["suffix_top_unordered_list_open"];
            wp_list_categories([
                'taxonomy'     => $this->config["menu_source_taxonomy"],
                'orderby'      => 'name',
                'show_count'   => true,
                'pad_counts'   => false,
                'hierarchical' => true,
                'title_li'     => '',
                'walker'       => $this->walker
            ]);
            echo $this->options_data["prefix_suffix"]["prefix_top_unordered_list_close"].'</ul>'.$this->options_data["prefix_suffix"]["suffix_top_unordered_list_close"];

        $this->output[] = ob_get_clean();
    }


}