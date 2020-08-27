<?php
include_once(__DIR__ . '/includes/register_assets.php');

add_theme_support('post-thumbnails');
add_theme_support('menus');

register_nav_menus(array(
    'top-menu' => 'Top Menu',
    'footer-menu' => 'Footer Menu'
));

/**
 * Add bootstrap classes to individual menu list items
 */

function filter_bootstrap_nav_menu_css_class($classes, $item, $args)
{
    if (isset($args->bootstrap)) {
        $classes[] = 'nav-item';

        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
        }

        if (in_array('dropdown-header', $classes)) {
            unset($classes[array_search('dropdown-header', $classes)]);
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'filter_bootstrap_nav_menu_css_class', 10, 3);

/**
 * Add bootstrap attributes to individual link elements.
 */

function filter_bootstrap_nav_menu_link_attributes($atts, $item, $args, $depth)
{
    if (isset($args->bootstrap)) {
        if (!$atts['class']) {
            $atts['class'] = '';
        }

        if ($depth > 0) {
            if (in_array('dropdown-header', $item->classes)) {
                $atts['class'] = 'dropdown-header';
            } else {
                $atts['class'] .= 'dropdown-item';
            }

            if ($item->description) {
                $atts['class'] .= ' has-description';
            }
        } else {
            $atts['class'] .= 'nav-link';

            if (in_array('menu-item-has-children', $item->classes)) {
                $atts['class'] .= ' dropdown-toggle';
                $atts['role'] = 'button';
                $atts['data-toggle'] = 'dropdown';
                $atts['aria-haspopup'] = 'true';
                $atts['aria-expanded'] = 'false';
            }
        }
    }
    return $atts;
}
// add_filter('nav_menu_link_attributes', 'filter_bootstrap_nav_menu_link_attributes', 10, 4);

/**
 * Add bootstrap classes to dropdown menus.
 */

function filter_bootstrap_nav_menu_submenu_css_class($classes, $args, $depth)
{
    if (isset($args->bootstrap)) {
        $classes[] = 'dropdown-menu';
    }
    return $classes;
}
// add_filter('nav_menu_submenu_css_class', 'filter_bootstrap_nav_menu_submenu_css_class', 10, 3);
