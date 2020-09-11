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
// $metabox_data='carousel_images_1_data';
// $metabox_nonce='carousel_images_1_nonce';
// $metabox_callback='carousel_image_uploader_1_callback';
 function handleMetaBoxes ( $metabox_name, $metabox_data, $metabox_nonce ) {
    // $metabox_data='carousel_images_1_data';
    // $metabox_nonce='carousel_images_1_nonce';
    $metabox_callback='carousel_image_uploader_callback';
    // $metabox_name='Carousel Images 1';


    function register_metaboxes (  )
    {
        add_meta_box( 'image_metabox', $metabox_name, $metabox_callback );
    }

 function register_admin_script (  )
 {
    wp_enqueue_script( 'wp_img_upload',  get_template_directory_uri(__DIR__)  . '/js/image-upload.js', array('jquery', 'media-upload') );
    // Localize Carousel Image Data
    // Carousel 1
    wp_localize_script( 'wp_img_upload', 'customUploads', array( 'imageData' => get_post_meta( get_the_ID(), $metabox_data, true ) ) );
 }

function carousel_image_uploader_callback (  )
{
    wp_nonce_field( basename(__FILE__), $metabox_nonce);
    
        ?>
<div id="metabox-wrapper">
    <div class="multi-image-uploader-wrapper">
        <input type="hidden" value="" id="image-hidden-field" name="<?php echo $metabox_data; ?>" />
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
 * Save Custom Images
 * 
 */
function save_custom_image ( $post_id )
{
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[$metabox_nonce] ) && wp_verify_nonce( $_POST[$metabox_nonce] ) );

    if( $is_autosave || $is_revision || $is_valid_nonce ) {
        return;
    }

    if( isset( $_POST[$metabox_data] ) ) {
        $image_data_array = [];

        $image_data = json_decode( stripslashes( $_POST[$metabox_data] ) );

        foreach($image_data as $index=>$image) {
        if( is_object( $image_data[$index] ) ) {
            array_push( $image_data_array, array( 'id' => intval( $image_data[$index]->id ), 'src' => esc_url_raw( $image_data[$index]->url ) ));
        } else {
            $image_data = [];
        }

        }
        update_post_meta( $post_id, $metabox_data, $image_data_array );
    }
}

 /**
  * 
  * Actions
  *
  */

 add_action( 'add_meta_boxes', 'register_metaboxes' ); 
 add_action( 'admin_enqueue_scripts', 'register_admin_script' );
 add_action( 'save_post', 'save_custom_image' );
 }
 
handleMetaBoxes('Carousel Images 1','carousel_images_1_data','carousel_images_1_nonce');

if(!class_exists("Carousel_Image_Metabox")) {
    class Carousel_Image_Metabox {
        public $name;
        public $data;
        public $nonce;

        function __construct ($name, $data, $nonce) {
            $this->name = $name;
            $this->data = $data;
            $this->nonce = $nonce;
        }
        function metabox_callback () {
            wp_nonce_field( basename(__FILE__), $this->nonce);
            ?>
<div id="metabox-wrapper">
    <div class="multi-image-uploader-wrapper">
        <input type="hidden" value="" id="image-hidden-field" name="<?php echo $this->data; ?>" />
    </div>
    <div class="button-wrapper">
        <input type="button" value="Add Image" id="image-upload-button" class="button" />
        <input type="button" value="Remove Image" id="image-delete-button" class="button" />
    </div>
</div>
<?php
        };

        public function get_name () {
            return $this->name;
        }
        public function get_data () {
            return $this->data;
        }
        public function get_nonce () {
            return $this->nonce;
        }
        public function get_callback () {

            return $this;
        }
    }
}