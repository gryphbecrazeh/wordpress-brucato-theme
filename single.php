<?php
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


function find_index_from_array($key, $query, $array) {
  foreach($array as $array_index=>$value) {
    if(strval($value->$key) == $query) {
      return $array_index;
    }
  }
}





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
          }
        ?>
        </div>
        <div class="next">
            <?php
          if($next_post) {
            ?>
            <a href="<?php echo get_the_permalink($next_post); ?>">Next</a>
            <?php
          }
        ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>