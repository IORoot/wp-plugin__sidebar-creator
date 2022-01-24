<?php

namespace andyp\sidebarmenu\acf\filters;

/**
 * Populate select box with complete list of all taxonomies.
 */
class populate_taxonomy_list
{

    public function __construct(){

        add_filter('acf/load_field/name=menu_source_taxonomy', [$this, 'populate']);
    }

    public function populate($field)
    {
        $taxonomies = \get_taxonomies();
        $field['choices'] = $taxonomies;
        $field['choices']['none'] = 'None';
        return $field;
    }

}
