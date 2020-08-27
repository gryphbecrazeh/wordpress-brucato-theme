<?php get_header(); ?>
<section class="title">
    <h1><?php the_title(); ?></h1>
</section>
<?php

if (have_posts()) : while (have_posts()) : the_post();

        the_content();
    endwhile;
endif;


?>
<?php get_footer(); ?>