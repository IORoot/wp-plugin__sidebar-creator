<?php

namespace andyp\sidebarmenu\lib\walkers;


/**
 * Displays posts in the listing.
 * 
 * Adds function to switch on the display of parent posts. Usually each
 * post will be a member of both its parent and grandparent taxonomy
 * terms. But you only want to see it in the parent. This function 
 * allows you to switch off viewing in the grandparent term.
 */
class walker_taxonomy_posts extends \Walker_Category {

    public $category;
    public $show_parent_posts = false;
    public $classes = [];

    /**
     * Set whether to show parent posts or not.
     */
    public function switch_parent_posts($setting = false)
    {
        $this->show_parent_posts = $setting;
    }

    public function set_classes_data($classes)
    {
        $this->classes = $classes;
    }

    /**
     * Open element
     */
    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0 ) {

        $this->category = $category;

        parent::start_el($output, $category, $depth, $args);
    }

    /**
     * Close element
     */
    function end_el(&$output, $page, $depth = 0, $args = array(), $id = 0) {

        global $wp_taxonomies; // needed for the post_type associated with the taxonomy.

        if ( 'list' != $args['style'] ){
            return;
        }

        if (!$this->show_parent_posts && $page->parent == 0){
            return;
        }

        $posts = get_posts([
            'post_type' => $wp_taxonomies[$page->taxonomy]->object_type[0],
            'numberposts' => -1,
            'tax_query' => [
                [
                    'taxonomy' => $page->taxonomy,
                    'terms' => $page->term_taxonomy_id,
                    'include_children' => false // Remove if you need posts from term 7 child terms
                ],
            ],
        ]);


        if( !empty( $posts ) ) {

            $posts_list = '<ul class="children '.$this->classes['unordered_list_classes'].'">';

            foreach( $posts as $post )
                $posts_list .= '<li class="post-item post-item-'.$post->ID.' '.$this->classes['list_item_classes'].'"><a class="'.$this->classes['link_classes'].'" href="' . get_permalink( $post->ID ) . '">'.get_the_title( $post->ID ).'</a></li>';

            $posts_list .= '</ul>';
        }
        else {
            $posts_list = '';
        }

        $output .= "{$posts_list}</li>\n";
        $posts = [];
    }

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }
     
        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent<ul class='children ".$this->classes['unordered_list_classes']."'>\n";
    }

}