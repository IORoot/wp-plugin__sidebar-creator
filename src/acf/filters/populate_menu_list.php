<?php

namespace andyp\sidebarmenu\acf\filters;

/**
 * Populate select box with complete list of all menus.
 */
class populate_menu_list
{

    public function __construct(){

        add_filter('acf/load_field/name=menu_source_menu', [$this, 'populate']);
    }

    public function populate($field)
    {
        $menus = \wp_get_nav_menus();

        foreach ($menus as $menu)
        {
            $menulist[$menu->slug] = $menu->name;
        }
        $field['choices'] = $menulist;
        $field['choices']['none'] = 'None';
        return $field;
    }

}
