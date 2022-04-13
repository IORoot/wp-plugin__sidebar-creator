<?php

namespace andyp\sidebarmenu\lib;

/**
 * Register all shortcodes declared in ACF Panel.
 */
class register_shortcodes
{

    private $cache_busting_version = '1.0.2';
    private $TTL = DAY_IN_SECONDS;
    private $transient;

    public function __construct(){
        $this->register_shortcodes();
    }
    

    private function register_shortcodes()
    {
        add_shortcode( 'sidebar_menu', [$this, 'run'] );
    }


    // Get the sidebar.
    public function run($attributes = array(), $content = null)
    {

        if (isset($_GET["CLEAR_TRANSIENT"])) {
            delete_transient('sidebar_menu__' . $this->cache_busting_version);
        }

        if ($this->check_transient()) {
            return $this->transient;
        }

        $sidebar = new build_sidebar;
        $sidebar->set_attributes($attributes);
        $sidebar->build_sidebar();
        $sidebar_html = $sidebar->get_result();

        // Set the data transient.
        set_transient( 'sidebar_menu__' . $this->cache_busting_version, $sidebar_html, $this->TTL );
    
        return $sidebar_html;
    }


    /**
     * Check if there is a cacheed copy of the data or not.
     *
     * @return void
     */
    private function check_transient()
    {
        $this->transient = get_transient( 'sidebar_menu__' . $this->cache_busting_version);
        if (!empty($this->transient)){  return true; }
        return false;
    }
    
}