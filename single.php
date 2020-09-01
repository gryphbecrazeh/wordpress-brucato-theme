<?php

// ob_clean();
// ob_start();

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

// print_r($previous_post);
// echo '<br/><br/>';
// print_r($next_post);
// echo $next_post->guid;
// die();
?>

<?php get_header(); ?>
<section class="brucato-post">
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
    <div class="brucato-heading">
        <div class="brucato-title">
            <h1>
                <?php
//   var_export($active_post);
//   die();
echo $active_post->post_title;?>
            </h1>
        </div>
        <div class="brucato-description">
            <?php echo $post_description; ?>
        </div>
    </div>
    <div class="featured-image">
        <?php echo $post_featured_image; ?>
    </div>
    <div class="brucato-carousel">
        <?php echo $image_carousel; ?>
    </div>
    <div class="brucato-pdf-viewer">
        <?php echo $pdf_viewer; ?>
    </div>
    <div class="brucato-post-body">
        <?php

if (have_posts()) : while (have_posts()) : the_post();

the_content();
endwhile;
endif;


?>
    </div>
    <div class="brucato-carousel">
        <?php echo $additional_image_carousel; ?>
    </div>

    <div class="brucato-post-navigation">
        <div class="previous">
            <?php
          if($previous_post) {
            ?>
            <a href="<?php echo get_the_permalink($previous_post); ?>">Prev</a>
            <?php
          } else {
              ?>
            <a href="<?php echo get_permalink($previous_category_post); ?>"><?php echo $previous_category->name ?></a>
            <?php
          }
        ?>
        </div>
        <div class="next">
            <?php
          if($next_post) {
            ?>
            <a href="<?php echo get_the_permalink($next_post); ?>">Next</a>
            <?php
          } else {
              ?>
            <a href="<?php echo get_category_link($next_category); ?>"><?php echo $next_category->name ?></a>
            <?php
          }
        ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>