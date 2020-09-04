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

/**
 * 
 * Carousel Image Uploader
 */
 function register_metaboxes (  )
 {
     add_meta_box( 'image_metabox', 'Image Uploader', 'image_uploader_callback' );
 }

 add_action( 'add_meta_boxes', 'register_metaboxes' ); 

 function register_admin_script ()
 {
    wp_enqueue_script( 'wp_img_upload',  get_template_directory_uri(__DIR__)  . '/js/image-upload.js', array('jquery', 'media-upload') );
    wp_localize_script( 'wp_img_upload', 'customUploads', array( 'imageData' => get_post_meta( get_the_ID(), 'custom_image_data', true ) ) );
 }

 add_action( 'admin_enqueue_scripts', 'register_admin_script' );

function image_uploader_callback ()
{
    wp_nonce_field( basename(__FILE__), 'custom_image_nonce');
    

    ?>
<div id="metabox-wrapper">
    <div class="image-wrapper">
        <img id="image-tag" src="" alt="" />
        <input type="hidden" value="" id="image-hidden-field" name="custom_image_data" />
    </div>
    <div class="button-wrapper">
        <input type="button" value="Add Image" id="image-upload-button" class="button" />
        <input type="button" value="Remove Image" id="image-delete-button" class="button" />
    </div>
</div>
<?php //close image_uploader_callback
}

function save_custom_image ( $post_id )
{
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['custom_image_nonce'] ) && wp_verify_nonce( $_POST['custom_image_nonce'] ) );

    if( $is_autosave || $is_revision || $is_valid_nonce ) {
        return;
    }

    if( isset( $_POST['custom_image_data'] ) ) {
        $image_data_array = [];

        $image_data = json_decode( stripslashes( $_POST['custom_image_data'] ) );

        foreach($image_data as $index=>$image) {
        if( is_object( $image_data[$index] ) ) {
            array_push( $image_data_array, array( 'id' => intval( $image_data[$index]->id ), 'src' => esc_url_raw( $image_data[$index]->url ) ));
        } else {
            $image_data = [];
        }

        }
        

        update_post_meta( $post_id, 'custom_image_data', $image_data_array );

    }

}

add_action( 'save_post', 'save_custom_image' );