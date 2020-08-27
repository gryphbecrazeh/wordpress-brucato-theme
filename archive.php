<?php get_header(); ?>
<section class="title">
    <h1><?php single_cat_title(); ?></h1>
</section>
<section class="archive">
<?php

if (have_posts()) : while (have_posts()) : the_post();
?>
        <div class="archive-card card bg-dark text-white">
            <div class="card-body">
                <h3><?php the_title(); ?></h3>
                <?php
                the_excerpt();
                ?>
            </div>
            <div class="card-footer">
                <a href="<?php the_permalink(); ?>" class='btn btn-warning d-block'>Read More...</a>

            </div>
        </div>
<?php
    endwhile;
endif;


?>
</section>
<?php get_footer(); ?>