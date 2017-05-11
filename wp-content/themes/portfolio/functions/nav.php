<?php
/* 
====================
    MAIN NAVIGATION
====================
*/
if ( ! class_exists( 'Custom_Nav_Menu' ) ) {
	class Custom_Nav_Menu extends Walker_Nav_Menu {
		/**
		 * Specify the item type to allow different walkers
		 * @var array
		 */
		var $nav_bar = '';

		function __construct( $nav_args = '' ) {
			$defaults      = array(
				'item_type'  => 'li',
				'in_top_bar' => false
			);
			$this->nav_bar = apply_filters( 'req_nav_args', wp_parse_args( $nav_args, $defaults ) );
		}

		function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}

			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;
			$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$class_names = $value = '';
			$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[]   = 'menu-item-' . $item->ID;

			// Check for flyout
			$flyout_toggle = '';
			if ( $args->has_children && $this->nav_bar['item_type'] == 'li' ) {
				if ( $depth == 0 && $this->nav_bar['in_top_bar'] == false ) {
					$classes[] = 'has-drop';
				} else if ( $this->nav_bar['in_top_bar'] == true ) {
					$classes[]     = 'has-dropdown';
					$flyout_toggle = '';
				}
			}
			/**
			 * Add class names to the li.divider from parent menu item
			 * @var string
			 *
			 * @since  required+ Foundation 1.0.7
			 */
			$class_names_divider = join( ' ', $item->classes );
			$class_names         = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names         = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			if ( $depth > 0 ) {
				$output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';
			} else {
				$output .= $indent . ( $this->nav_bar['in_top_bar'] == true ? '<li class="divider' . $class_names_divider . '"></li>' : '' ) . '<' . $this->nav_bar['item_type'] . ' id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';
			}

			$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
			$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

			$item_output = $args->before;
			$item_output .= '<a ' . $attributes . '>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $flyout_toggle; // Add possible flyout toggle
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		function end_el( &$output, $item, $depth = 0, $args = array() ) {
			if ( $depth > 0 ) {
				$output .= "</li>\n";
			} else {
				$output .= "</" . $this->nav_bar['item_type'] . ">\n";
			}
		}

		function start_lvl( &$output, $depth = 0, $args = array() ) {
			if ( $depth == 0 && $this->nav_bar['item_type'] == 'li' ) {
				$indent = str_repeat( "\t", 1 );
				$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"navdrop\">\n";
			} else {
				$indent = str_repeat( "\t", $depth );
				$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"level-$depth\">\n";
			}
		}
	}
}

/**
 * Mega Nav Walker
 */

if ( ! class_exists( 'Mega_Walker_Nav_Menu' ) ) {
	class Mega_Walker_Nav_Menu extends Walker_Nav_Menu {

		// Capture our parent item for a sub-menu
		private $current_item;

		function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

			$id_field = $this->db_fields['id'];

			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}

			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array $args An array of arguments. @see wp_nav_menu()
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {

			// Setup sub-menu ID
			$sub_menu_id = $this->current_item->ID ? ' id="sub-menu-' . esc_attr( $this->current_item->ID ) . '"' : '';

			$indent = str_repeat( "\t", $depth );
			//$output .= "\n$indent<ul$sub_menu_id class=\"sub-menu\">\n";

			if ( $depth !== 1 ) {
				$output .= "\n$indent<ul$sub_menu_id class=\"sub-menu level-1\">\n";
			} else {
				$output .= "\n$indent<ul$sub_menu_id class=\"sub-menu\">\n";
			}

		}

		/**
		 * @see      Walker::start_el()
		 * @since    3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array|object $args
		 * @param int $id
		 *
		 * @internal param int $current_page Menu item ID.
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			// Setup our parent item
			$this->current_item = $item;

			// Setup parent anchor class
			$parent_anchor_class = 'is-parent-trigger';

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			// Customize and add our parent and current classes
			$classes[] = ( $args->has_children ) ? 'is-parent' : '';
			$classes[] = ( $item->current ) ? 'is-current' : '';

			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param object $item The current menu item.
			 * @param array $args An array of {@see wp_nav_menu()} arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param object $item The current menu item.
			 * @param array $args An array of {@see wp_nav_menu()} arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $class_names . '>';

			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) && ! $args->has_children ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) && ! $args->has_children ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) && ! $args->has_children ? $item->url : '';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 * @type string $title Title attribute.
			 * @type string $target Target attribute.
			 * @type string $rel The rel attribute.
			 * @type string $href The href attribute.
			 * }
			 *
			 * @param object $item The current menu item.
			 * @param array $args An array of {@see wp_nav_menu()} arguments.
			 * @param int $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;
			if ( $args->has_children && $depth !== 1 ) {
				$item_output .= '<button' . $id . $attributes . 'class="' . $parent_anchor_class . '" type="button">';
			} elseif ( $args->has_children && $depth === 1 ) {
				$item_output .= '<button' . $id . $attributes . 'class="' . $parent_anchor_class . ' level-2" type="button">';
			} else {
				$item_output .= '<a' . $attributes . '>';
			}
			// $item_output .= ( $args->has_children ) ? '<button' . $id . $attributes . $parent_anchor_class . '>' : '<a' . $attributes . '>';
			/** This filter is documented in wp-includes/post-template.php */
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children ) ? '</button>' : '</a>';
			if ( $args->has_children && $depth !== 1 ) {
				$item_output .= '</button>';
			} elseif ( $args->has_children && $depth === 1 ) {
				$item_output .= '</button>';
			} else {
				$item_output .= '</a>';
			}
			$item_output .= $args->after;

			/**
			 * Filter a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param object $item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @param array $args An array of {@see wp_nav_menu()} arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		}

	}
}