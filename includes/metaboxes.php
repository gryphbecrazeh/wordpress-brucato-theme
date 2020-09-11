<?php
/**
 * 
 * Carousel Image Uploader
 * 
 */


/**
 * 
 * Custom Image Uploader Functions
 * 
 */

 function register_metaboxes (  )
 {
     add_meta_box( 'carousel_image_metabox_1', 'Carousel Images 1', 'carousel_image_uploader_1_callback' );
     add_meta_box( 'carousel_image_metabox_2', 'Carousel Images 2', 'carousel_image_uploader_2_callback' );
     add_meta_box( 'carousel_image_metabox_3', 'Carousel Images 3', 'carousel_image_uploader_3_callback' );
     add_meta_box( 'collage_image_metabox_1', 'Collage Images 1', 'collage_image_uploader_1_callback' );

 }
 
 function register_admin_script (  )
 {
    wp_enqueue_script( 'wp_img_upload',  get_template_directory_uri(__DIR__)  . '/js/image-upload.js', array('jquery', 'media-upload') );
    // Localize Carousel Image Data
    // Carousel 1
    wp_localize_script( 'wp_img_upload', 'customUploads1', array( 'imageData' => get_post_meta( get_the_ID(), 'carousel_images_1_data', true ) ) );
    // Carousel 2
    wp_localize_script( 'wp_img_upload', 'customUploads2', array( 'imageData' => get_post_meta( get_the_ID(), 'carousel_images_2_data', true ) ) );
    // Carousel 3
    wp_localize_script( 'wp_img_upload', 'customUploads3', array( 'imageData' => get_post_meta( get_the_ID(), 'carousel_images_3_data', true ) ) );
    // Collage 1
    wp_localize_script( 'wp_img_upload', 'customUploads4', array( 'imageData' => get_post_meta( get_the_ID(), 'collage_images_1_data', true ) ) );

 }

 /**
  * 
  * 
  * Carousel 1
  * 
  * 
  */
function carousel_image_uploader_1_callback (  )
{
    wp_nonce_field( basename(__FILE__), 'carousel_images_1_nonce');
    
        ?>
<div class="metabox-wrapper" name="carousel_1">
    <div class="multi-image-uploader-wrapper">
        <input type="hidden" value="" id="image-hidden-field" name="carousel_images_1_data" />
    </div>
    <div class="button-wrapper">
        <input type="button" value="Add Image" id="image-upload-button" class="button" />
        <input type="button" value="Remove Image" id="image-delete-button" class="button" />
    </div>
</div>

<?php
}
/**
 * 
 * Save Carousel Images 1
 * 
 */
function carousel_image_uploader_1_save ( $post_id )
{
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['carousel_images_1_nonce'] ) && wp_verify_nonce( $_POST['carousel_images_1_nonce'] ) );

    if( $is_autosave || $is_revision || $is_valid_nonce ) {
        return;
    }

    if( isset( $_POST['carousel_images_1_data'] ) ) {
        $image_data_array = [];

        $image_data = json_decode( stripslashes( $_POST['carousel_images_1_data'] ) );

        foreach($image_data as $index=>$image) {
        if( is_object( $image_data[$index] ) ) {
            array_push( $image_data_array, array( 'id' => intval( $image_data[$index]->id ), 'src' => esc_url_raw( $image_data[$index]->url ) ));
        } else {
            $image_data = [];
        }

        }
        update_post_meta( $post_id, 'carousel_images_1_data', $image_data_array );
    }

}

 /**
  * 
  * 
  * Carousel 2
  * 
  * 
  */
function carousel_image_uploader_2_callback (  )
{
    // Change Here
    wp_nonce_field( basename(__FILE__), 'carousel_images_2_nonce');
    
        ?>
<div class="metabox-wrapper" name="carousel_2">
    <div class="multi-image-uploader-wrapper">
        <?php //change Change here ?>
        <input type="hidden" value="" id="image-hidden-field" name="carousel_images_2_data"
            class="image-hidden-field" />
    </div>
    <div class="button-wrapper">
        <input type="button" value="Add Image" id="image-upload-button" class="button" />
        <input type="button" value="Remove Image" id="image-delete-button" class="button" />
    </div>
</div>

<?php
}
/**
 * 
 * Save Carousel Images 2
 * 
 */
function carousel_image_uploader_2_save ( $post_id )
{
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    // Changes here
    $is_valid_nonce = ( isset( $_POST['carousel_images_2_nonce'] ) && wp_verify_nonce( $_POST['carousel_images_2_nonce'] ) );

    if( $is_autosave || $is_revision || $is_valid_nonce ) {
        return;
    }
    // Changes here
    if( isset( $_POST['carousel_images_2_data'] ) ) {
        $image_data_array = [];
    // Changes here
        $image_data = json_decode( stripslashes( $_POST['carousel_images_2_data'] ) );

        foreach($image_data as $index=>$image) {
        if( is_object( $image_data[$index] ) ) {
            array_push( $image_data_array, array( 'id' => intval( $image_data[$index]->id ), 'src' => esc_url_raw( $image_data[$index]->url ) ));
        } else {
            $image_data = [];
        }

        }
    // Changes here
        update_post_meta( $post_id, 'carousel_images_2_data', $image_data_array );
    }

}


 /**
  * 
  * 
  * Carousel 3
  * 
  * 
  */
function carousel_image_uploader_3_callback (  )
{
    // Change Here
    wp_nonce_field( basename(__FILE__), 'carousel_images_3_nonce');
    
        ?>
<?php //change Change here ?>
<div class="metabox-wrapper" name="carousel_3">
    <div class="multi-image-uploader-wrapper">
        <?php //change Change here ?>
        <input type="hidden" value="" id="image-hidden-field" name="carousel_images_3_data"
            class="image-hidden-field" />
    </div>
    <div class="button-wrapper">
        <input type="button" value="Add Image" id="image-upload-button" class="button" />
        <input type="button" value="Remove Image" id="image-delete-button" class="button" />
    </div>
</div>

<?php
}
/**
 * 
 * Save Carousel Images 3
 * 
 */
function carousel_image_uploader_3_save ( $post_id )
{
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    // Changes here
    $is_valid_nonce = ( isset( $_POST['carousel_images_3_nonce'] ) && wp_verify_nonce( $_POST['carousel_images_3_nonce'] ) );

    if( $is_autosave || $is_revision || $is_valid_nonce ) {
        return;
    }
    // Changes here
    if( isset( $_POST['carousel_images_3_data'] ) ) {
        $image_data_array = [];
    // Changes here
        $image_data = json_decode( stripslashes( $_POST['carousel_images_3_data'] ) );

        foreach($image_data as $index=>$image) {
        if( is_object( $image_data[$index] ) ) {
            array_push( $image_data_array, array( 'id' => intval( $image_data[$index]->id ), 'src' => esc_url_raw( $image_data[$index]->url ) ));
        } else {
            $image_data = [];
        }

        }
    // Changes here
        update_post_meta( $post_id, 'carousel_images_3_data', $image_data_array );
    }

}


 /**
  * 
  * 
  * Collage 1
  * 
  * 
  */
function collage_image_uploader_1_callback (  )
{
    // Change Here
    wp_nonce_field( basename(__FILE__), 'collage_images_1_nonce');
    
        ?>
<?php //change Change here ?>
<div class="metabox-wrapper" name="collage_1">
    <div class="multi-image-uploader-wrapper">
        <?php //change Change here ?>
        <input type="hidden" value="" id="image-hidden-field" name="collage_images_1_data" class="image-hidden-field" />
    </div>
    <div class="button-wrapper">
        <input type="button" value="Add Image" id="image-upload-button" class="button" />
        <input type="button" value="Remove Image" id="image-delete-button" class="button" />
    </div>
</div>

<?php
}
/**
 * 
 * Save Collage Images 1
 * 
 */
function collage_image_uploader_1_save ( $post_id )
{
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    // Changes here
    $is_valid_nonce = ( isset( $_POST['collage_images_1_nonce'] ) && wp_verify_nonce( $_POST['collage_images_1_nonce'] ) );

    if( $is_autosave || $is_revision || $is_valid_nonce ) {
        return;
    }
    // Changes here
    if( isset( $_POST['collage_images_1_data'] ) ) {
        $image_data_array = [];
    // Changes here
        $image_data = json_decode( stripslashes( $_POST['collage_images_1_data'] ) );

        foreach($image_data as $index=>$image) {
        if( is_object( $image_data[$index] ) ) {
            array_push( $image_data_array, array( 'id' => intval( $image_data[$index]->id ), 'src' => esc_url_raw( $image_data[$index]->url ) ));
        } else {
            $image_data = [];
        }

        }
    // Changes here
        update_post_meta( $post_id, 'collage_images_1_data', $image_data_array );
    }

}

 /**
  * 
  * Actions
  *
  */

 add_action( 'add_meta_boxes', 'register_metaboxes' ); 
 add_action( 'admin_enqueue_scripts', 'register_admin_script' );
//  Carousel Saves
 add_action( 'save_post', 'carousel_image_uploader_1_save' );
 add_action( 'save_post', 'carousel_image_uploader_2_save' );
 add_action( 'save_post', 'carousel_image_uploader_3_save' );
 add_action( 'save_post', 'collage_image_uploader_1_save' );