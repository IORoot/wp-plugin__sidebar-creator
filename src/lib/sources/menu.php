<?php

namespace andyp\sidebarmenu\lib\sources;

use andyp\sidebarmenu\lib\interfaces\sourceInterface;

/**
 * create the sidebar from a menu
 */
class menu implements sourceInterface
{

    public $config;
    public $options_data;
    public $menu_items;
    public $tree;
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
        $this->get_menu_items();
        $this->generate_menu_tree();
        $this->loop_list($this->tree, $this->config["menu_source_menu"]);
    }

    /**
     * Get a list of all menu terms.
     */
    private function get_menu_items()
    {
        $this->menu_items = wp_get_nav_menu_items($this->config["menu_source_menu"]);
    }

    /**
     * Create a tree of nested terms using a recursive function.
     */
    private function generate_menu_tree()
    {
        $this->tree =  $this->menu_items ? $this->buildTree( $this->menu_items, 0 ) : null;
    }

    /**
     * Recursive function to generate menu tree.
     */
    private function buildTree( array &$elements, $parentId = 0 )
    {
        $branch = [];
        foreach ( $elements as &$element )
        {
            if ( $element->menu_item_parent == $parentId )
            {
                $children = $this->buildTree( $elements, $element->ID );
                if ( $children )
                    $element->wpse_children = $children;

                $branch[$element->ID] = $element;
                unset( $element );
            }
        }
        return $branch;
    }


    /**
     * Loop tree building up a list instead.
     */
    private function loop_list($list, $extra_classes = null)
    {
        $this->output[] = $this->open_ul($extra_classes);

        foreach ($list as $this->loop_item)
        {
            $this->output[] = $this->open_li();
            $this->output[] = $this->menu_title();
            $this->output[] = $this->has_children();
            $this->output[] = $this->close_li();
        }

        $this->output[] = $this->close_ul();
    }

    /**
     * Check if current item in tree has any child terms.
     */
    private function has_children()
    {
        if (!property_exists($this->loop_item, 'wpse_children')){
            return;
        }
        return $this->loop_list($this->loop_item->wpse_children, 'children');
    }

    /**
     * Render the <ul>
     */
    private function open_ul($extra_classes)
    {
        return '<ul class="'.$extra_classes.' '.$this->config["unordered_list_classes"].'">';
    }

    /**
     * Render the </ul>
     */
    private function close_ul()
    {
        return '</ul>';
    }

    /**
     * Render the <li>
     */
    private function open_li()
    {
        return '<li class="menu-item '.$this->config["list_item_classes"].'">';
    }

    /**
     * Render the </li>
     */
    private function close_li()
    {
        return '</li>';
    }

    /**
     * Render the <a>
     */
    private function menu_title()
    {
        return '<a class="'.$this->config["link_classes"].'" href="'.$this->loop_item->url.'" title="'.$this->loop_item->title.'">' . $this->loop_item->title . '</a>';
    }

}