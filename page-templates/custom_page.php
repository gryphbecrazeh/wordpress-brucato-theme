<?php
/*
Template Name: CustomPageTemplate
Template Post Type: post, page, event

*/


global $wp_query;

include_once(__DIR__ . '../includes/scripts.php');


$post = $wp_query->post;
$post_id = $post->ID;
$custom_fields = get_post_custom($post_id);
$test_label = PHP_TOOLBOX::get_custom_field_values('test_label', $post_id);


// $test_label = get_post_custom_values('test_label', $post_id);
?>
<?php get_header(); ?>
<section class="title">
    <h1><?php the_title(); ?></h1>
</section>
<section class="custom_field">
    <?php
    echo $test_label;
    ?>
</section>
<?php

if (have_posts()) : while (have_posts()) : the_post();

        the_content();
    endwhile;
endif;


?>
<?php get_footer(); ?>