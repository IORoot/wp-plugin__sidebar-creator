<?php

namespace andyp\sidebarmenu\acf;

/**
 * Start ACF Initialisation
 */
class acf_init
{

    public function __construct(){
        $this->andyp_plugin_register();
        $this->acf_admin_menu();
        $this->acf_field_filters();
        $this->acf_on_update();
        
    }

    public function andyp_plugin_register()
    {
        require __DIR__.'/andyp_plugin_register.php';
    }

    public function acf_admin_menu()
    {
        new acf_admin_menu;
    }

    public function acf_field_filters()
    {
        new filters\populate_taxonomy_list;
        new filters\populate_menu_list;
    }

    public function acf_on_update()
    {
        require __DIR__.'/acf_on_update.php';
    }
}