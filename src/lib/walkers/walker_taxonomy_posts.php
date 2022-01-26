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
    public $suffix_prefix = [];
    public $pregged_suffix_prefix = [];
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

    public function set_prefix_suffix_data($suffix_prefix)
    {
        $this->suffix_prefix = $suffix_prefix;
    }

    /**
     * Starts the element output.
     *
     * @since 2.1.0
     *
     * @see Walker::start_el()
     *
     * @param string  $output   Used to append additional content (passed by reference).
     * @param WP_Term $category Category data object.
     * @param int     $depth    Optional. Depth of category in reference to parents. Default 0.
     * @param array   $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
     * @param int     $id       Optional. ID of the current category. Default 0.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

        $this->category = $category;

        foreach($this->suffix_prefix as $sp_key => $sp_instance)
        {
            /**
             * search for any moustaches.
             */
            preg_match_all('/\{\{([\w|\d]*)\}\}/', $sp_instance, $matches);
            if (!empty($matches[1]))
            {
                /**
                 * match all moustaches and replace with matched values.
                 */
                foreach($matches[1] as $loop_key => $moustache_match)
                {
                    // get value
                    $mousache_value = $this->category->$moustache_match;
                    // string replace.
                    $sp_instance = str_replace($matches[0][$loop_key], $mousache_value, $sp_instance);
                }
            }
                
            $this->pregged_suffix_prefix[$sp_key] = preg_replace( '/\{\{[\w|\d]*\}\}/',  $this->category->term_id, $sp_instance);
            
        }

        /** This filter is documented in wp-includes/category-template.php */
        $cat_name = apply_filters( 'list_cats', esc_attr( $category->name ), $category );
 
        // Don't generate an element if the category name is empty.
        if ( '' === $cat_name ) {
            return;
        }
 
        $atts         = array();
        $atts['href'] = get_term_link( $category );
 
        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filters the category description for display.
             *
             * @since 1.2.0
             *
             * @param string  $description Category description.
             * @param WP_Term $category    Category object.
             */
            $atts['title'] = strip_tags( apply_filters( 'category_description', $category->description, $category ) );
        }
 
        /**
         * Filters the HTML attributes applied to a category list item's anchor element.
         *
         * @since 5.2.0
         *
         * @param array   $atts {
         *     The HTML attributes applied to the list item's `<a>` element, empty strings are ignored.
         *
         *     @type string $href  The href attribute.
         *     @type string $title The title attribute.
         * }
         * @param WP_Term $category Term data object.
         * @param int     $depth    Depth of category, used for padding.
         * @param array   $args     An array of arguments.
         * @param int     $id       ID of the current category.
         */
        $atts = apply_filters( 'category_list_link_attributes', $atts, $category, $depth, $args, $id );
 
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
 
        $link = sprintf(
            '%s<a%s>%s%s%s</a>%s',
            $this->pregged_suffix_prefix["prefix_link_open"],
            $attributes,
            $this->pregged_suffix_prefix["suffix_link_open"],
            $cat_name,
            $this->pregged_suffix_prefix["prefix_link_close"],
            $this->pregged_suffix_prefix["suffix_link_close"],
        );
 
        if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
            $link .= ' ';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= '(';
            }
 
            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';
 
            if ( empty( $args['feed'] ) ) {
                /* translators: %s: Category name. */
                $alt = ' alt="' . sprintf( __( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
            } else {
                $alt   = ' alt="' . $args['feed'] . '"';
                $name  = $args['feed'];
                $link .= empty( $args['title'] ) ? '' : $args['title'];
            }
 
            $link .= '>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= $name;
            } else {
                $link .= "<img src='" . esc_url( $args['feed_image'] ) . "'$alt" . ' />';
            }
            $link .= '</a>';
 
            if ( empty( $args['feed_image'] ) ) {
                $link .= ')';
            }
        }
 
        if ( ! empty( $args['show_count'] ) ) {
            $link .= ' '.$this->pregged_suffix_prefix["prefix_count"].'(' . number_format_i18n( $category->count ) . ')' . $this->pregged_suffix_prefix["suffix_count"];
        }
        if ( 'list' === $args['style'] ) {
            $output     .= "\t".$this->pregged_suffix_prefix["prefix_list_item_open"]."<li";
            $css_classes = array(
                'cat-item',
                'cat-item-' . $category->term_id,
            );
 
            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms(
                    array(
                        'taxonomy'   => $category->taxonomy,
                        'include'    => $args['current_category'],
                        'hide_empty' => false,
                    )
                );
 
                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                        $link          = str_replace( '<a', '<a aria-current="page"', $link );
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                    while ( $_current_term->parent ) {
                        if ( $category->term_id == $_current_term->parent ) {
                            $css_classes[] = 'current-cat-ancestor';
                            break;
                        }
                        $_current_term = get_term( $_current_term->parent, $category->taxonomy );
                    }
                }
            }
 
            /**
             * Filters the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param string[] $css_classes An array of CSS classes to be applied to each list item.
             * @param WP_Term  $category    Category data object.
             * @param int      $depth       Depth of page, used for padding.
             * @param array    $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );
            $css_classes = $css_classes ? ' class="' . esc_attr( $css_classes ) . '"' : '';
 
            $output .= $css_classes;
            $output .= ">".$this->pregged_suffix_prefix["suffix_list_item_open"]."$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }

    /**
     * Close <LI>
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

            $posts_list = $this->pregged_suffix_prefix["prefix_unordered_list_open"].'<ul class="children '.$this->classes['unordered_list_classes'].'">'.$this->pregged_suffix_prefix["suffix_unordered_list_open"];

            foreach ($posts as $post) {
                $posts_list .= $this->pregged_suffix_prefix["prefix_list_item_open"].'<li class="post-item post-item-'.$post->ID.' '.$this->classes['list_item_classes'].'">'.$this->pregged_suffix_prefix["suffix_list_item_open"];
                $posts_list .= $this->pregged_suffix_prefix["prefix_link_open"].'<a class="'.$this->classes['link_classes'].'" href="' . get_permalink($post->ID) . '">'.$this->pregged_suffix_prefix["suffix_link_open"];
                $posts_list .= get_the_title($post->ID);
                $posts_list .= $this->pregged_suffix_prefix["prefix_link_close"].'</a>'.$this->pregged_suffix_prefix["suffix_link_close"];
                $posts_list .= $this->pregged_suffix_prefix["prefix_list_item_close"].'</li>'.$this->pregged_suffix_prefix["suffix_list_item_close"];
            }

            $posts_list .= $this->pregged_suffix_prefix["prefix_unordered_list_close"].'</ul>'.$this->pregged_suffix_prefix["suffix_unordered_list_close"];
        }
        else {
            $posts_list = '';
        }

        $output .= "{$posts_list}".$this->pregged_suffix_prefix["prefix_list_item_close"]."</li>".$this->pregged_suffix_prefix["suffix_list_item_close"]."\n";
        $posts = [];
    }


    /**
     * Open <UL>
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }
     
        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent".$this->pregged_suffix_prefix["prefix_unordered_list_open"]."<ul class='children ".$this->classes['unordered_list_classes']."'>".$this->pregged_suffix_prefix["suffix_unordered_list_open"]."\n";
    }


    /**
     * Close <UL>
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( 'list' !== $args['style'] ) {
            return;
        }
 
        $indent  = str_repeat( "\t", $depth );
        $output .= "$indent".$this->pregged_suffix_prefix["prefix_list_item_close"]."</ul>".$this->pregged_suffix_prefix["suffix_list_item_close"]."\n";
    }

}