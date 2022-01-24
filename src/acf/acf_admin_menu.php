<?php
namespace andyp\sidebarmenu\acf;

/**
 * Create Syllabus Settings Menu Item
 */
class acf_admin_menu
{

    public function __construct(){

        if (function_exists('acf_add_options_page')) {
            $argsparent = array(
            'page_title' => 'Sidebar Creator',
            'menu_title' => 'Sidebar Creator',
            'menu_slug' => 'sidebar_creator',
            'capability' => 'manage_options',
            'position' => 100,
            'icon_url' => 'data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZmlsbD0iIzA4OTFCMiIgZD0iTTMsM0g5VjdIM1YzTTE1LDEwSDIxVjE0SDE1VjEwTTE1LDE3SDIxVjIxSDE1VjE3TTEzLDEzSDdWMThIMTNWMjBIN0w1LDIwVjlIN1YxMUgxM1YxM1oiLz48L3N2Zz4=',
            'redirect' => true,
            'post_id' => 'options',
            'autoload' => false,
            'update_button'		=> __('Update', 'acf'),
            'updated_message'	=> __("Options Updated", 'acf'),
        );
            acf_add_options_page($argsparent);
        }

    }

}