<?php
    $footer_color = get_field("footer_color") ? get_field("footer_color") : "inherit";
    $footer_font_color = get_field("footer_font_color") ? get_field("footer_font_color") : "inherit";
?>

<footer style="background-color:<?php echo $footer_color ?>; color:<?php echo $footer_font_color ?>;">
    <?php
if($footer_color) {
    ?>

    <div class="footer-heading">
        <h1>Isabella-Sofia Maria</h1>
    </div>


    <?php
}
?>
    <div class="container">

        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer-menu',
                'menu_class' => 'footer'
            )
        );
        ?>
    </div>
    <?php wp_footer(); ?>

</footer>

</body>

</html>