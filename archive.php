<?php

ob_clean();
ob_start();

$category = get_the_category()[0];
//   Get all posts in category
$args = array('category'=> $category->term_id, 'post_type' => 'post');
$category_post_list = get_posts($args);
if($category_post_list[0]) {
    $post_link = get_permalink($category_post_list[0]);
wp_redirect($post_link);
exit();

}
get_header();
?>
<div>No posts found for this category...</div>
<?php get_footer(); ?>