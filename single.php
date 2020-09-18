<?php

ob_clean();
ob_start();

global $post;
//  echo do_shortcode('[sp_wpcarousel id="73"]'); 
$active_post = $post;
$work_status_array = get_field("work_done_array_website_status");
$post_description = get_field("post_description");
$post_featured_image = get_field("post_featured_image");
$image_carousel = get_field("image_carousel");
$pdf_viewer = get_field("pdf_viewer");
$additional_image_carousel = get_field("additional_image_carousel");
$postId = get_the_ID();
$category = get_the_category($postId)[0];

// Change to new carousel values
$carousel_1_images = get_field( "carousel_images_1_data" );
$carousel_2_images = get_field( "carousel_images_2_data" );
$carousel_3_images = get_field( "carousel_images_3_data" );

// Collage Images
$collage_images = get_field('collage_images_1_data');


function reconstruct_array ($old_array) {
    $new_array = [];
    $index = 0;
    foreach($old_array as $value) {
        $new_array[$index++] = $value;
    }
        return $new_array;

}
function find_index_from_array($key, $query, $array) {
  foreach($array as $array_index=>$value) {
    if(strval($value->$key) == $query) {
      return $array_index;
    }
  }
}
function get_category_last_post ($category_id) {
    $args = array('category'=> $category_id, 'post_type' => 'post');
    $post_list = get_posts($args);
    $max_index = count($post_list) -1;
    return $post_list[$max_index];
}
function displayCarousel ($array) {
    if(count($array>0)) {
    ?>
<div class="brucato-carousel-container">
    <div class="brucato-carousel carousel-container">
        <?php foreach($array as $carousel_image) { ?>
        <div class="slide"><img src="<?php echo $carousel_image["src"]?>" alt="" srcset="" width="300" height="300" />
        </div>
        <?php } ?>
    </div>

</div>
<?php
    }
}

// Get All Post categories
$retrieved_category_list = get_categories( array(
    'orderby' => 'name',
    'order'   => 'ASC'
));
// Reconstruct the array because javascript is better and doesn't perserve indexes, who the hell would ever need to perserve the damn indexes, it's almost unpredictable
$category_list = reconstruct_array($retrieved_category_list);
// Find the index of the current category
$current_category_index = find_index_from_array('term_id',$category->term_id, $category_list);
$category_list_length = count($category_list);
$max_index = $category_list_length - 1;

// Get next and previous categories
// If the current category index incremented is greater than the max possible index, then it cycles back to 0
$next_category_index = $current_category_index + 1 <= $max_index ? $current_category_index + 1 : 0;
$next_category = $category_list[$next_category_index];

// If the current category index decremented is less than 0 then it cycles back to the end of the array
$previous_category_index = $current_category_index - 1 >= 0 ? $current_category_index - 1 : $max_index;
$previous_category = $category_list[$previous_category_index];
// Get the last post in that category
$previous_category_post = get_category_last_post($previous_category->term_id);


//   Get all posts in category
$args = array('category'=> $category->cat_ID, 'post_type' => 'post');
$post_list = get_posts($args);

$current_post_index = find_index_from_array('ID', $postId, $post_list);
$previous_post = $post_list[$current_post_index - 1];
$next_post = $post_list[$current_post_index + 1];


?>

<?php get_header(); ?>
<section class="brucato-post">
    <?php //Brucato Shadowbox                   BEGIN?>

    <div class="brucato-shadowbox" id="brucato-shadowbox-display"></div>
    <?php //Category Bread Crumbs Display                   BEGIN?>
    <div class="brucato-category-list">
        <span class="category"><?php echo $category->name; ?></span>
        <ol>
            <?php
foreach ($post_list as $index=>$post) : setup_postdata($post);
?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <?php echo $index+1; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
    <?php //Category Bread Crumbs Display                   END?>
    <?php //POST HEADING                   BEGIN?>
    <div class="brucato-heading">
        <div class="brucato-title">
            <h1>
                <?php
echo $active_post->post_title;?>
            </h1>
        </div>
        <div class="brucato-description">
            <?php echo $post_description; ?>
        </div>
    </div>
    <?php //POST HEADING                   END?>
    <?php //HERO IMAGE                   BEGIN?>
    <div class="featured-image" style="background-image:url('<?php echo $post_featured_image; ?>')">

    </div>
    <?php //HERO IMAGE                   END?>
    <?php //CAROUSEL 1                   BEGIN?>
    <?php displayCarousel($carousel_1_images); ?>
    <?php //CAROUSEL 1                   END?>
    <?php //PDF VIEWER 1                   BEGIN?>
    <div class="brucato-pdf-viewer">
        <?php echo $pdf_viewer; ?>
    </div>
    <?php //PDF VIEWER 1                   END?>
    <?php //POST BODY 1                   BEGIN?>
    <div class="brucato-post-body">
        <?php

if (have_posts()) : while (have_posts()) : the_post();

the_content();
endwhile;
endif;


?>
    </div>
    <?php //POST BODY 1                   END?>
    <?php //CAROUSEL 2                   BEGIN?>
    <?php displayCarousel($carousel_2_images); ?>
    <?php //CAROUSEL 2                   END?>
    <?php //CAROUSEL 3                   BEGIN?>
    <?php displayCarousel($carousel_3_images); ?>
    <?php //CAROUSEL 3                   END?>
    <?php //COLLAGE 1                   BEGIN?>
    <?php
if($collage_images) {
?>

    <div class="brucato-cascading-container">
        <div class="brucato-shadowbox" id="brucato-shadowbox-display"></div>
        <?php

foreach($collage_images as $image) {
?>
        <div class="tile">
            <div class="image-container">
                <img src="<?php echo $image['src']; ?>" alt="" />
            </div>
        </div>
        <?php
}
?>
    </div>
    <?php
}
?>
    <?php //COLLAGE 1                   END?>
    <?php //NAVIGATION                   BEGIN?>
    <div class="brucato-post-navigation">
        <?php
          if($previous_post) {
            ?>
        <a class="previous" href="<?php echo get_the_permalink($previous_post); ?>">Prev</a>
        <?php
          } else {
              ?>
        <a class="previous"
            href="<?php echo get_permalink($previous_category_post); ?>"><?php echo $previous_category->name ?></a>
        <?php
          }
        ?>
        <?php
          if($next_post) {
            ?>
        <a class="next" href="<?php echo get_the_permalink($next_post); ?>">Next</a>
        <?php
          } else {
              ?>
        <a class="next" href="<?php echo get_category_link($next_category); ?>"><?php echo $next_category->name ?></a>
        <?php
          }
        ?>
    </div>
    <?php //NAVIGATION                   END?>
</section>


<?php get_footer(); ?>