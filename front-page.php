<?php
/*
Template Name: Brucato Homepage Template
Template Post Type: page

*/
get_header();

global $wp_query, $current_user;
wp_get_current_user();

include_once(__DIR__ . '/includes/scripts.php');


$post = $wp_query->post;
$post_id = $post->ID;
$custom_fields = get_post_custom($post_id);

$main_description = get_field('main_description');
$featured_categories = get_field('featured_categories');
$featured_categories_length = count($featured_categories) - 1;
$sub_description = get_field('sub_description');

?>
<section class="main">
    <div class="nav-menu">
        <div class="nav-button">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <div class="brucato-navigation closed">
            <div class="view">
                <p><?php echo $main_description; ?></p>
                <p>
                    <?php
foreach( $featured_categories as $key=>$value ) {
$category = get_category($value);
if($category) {
?>
                    <a href="/<?php echo $category->slug ?>"><?php 
echo $category->name;
if($key < $featured_categories_length) {
    echo ",";
} else {
    echo ".";
}
 ?></a>
                    <?php
}

}
?>
                </p>
                <p><?php echo $sub_description; ?></p>
            </div>
        </div>
    </div>
    <h1 class="name">Isabella-Sofia Maria</h1>
</section>

<?php get_footer(); ?>