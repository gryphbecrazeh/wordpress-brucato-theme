<html lang="en">

<head>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>

    <link
        href="https://fonts.googleapis.com/css?family=Bangers|Oswald|Quicksand|Shadows+Into+Light|Special+Elite|Vibes&display=swap"
        rel="stylesheet">

    <!-- Questa Font -->
    <link rel="stylesheet" href="https://use.typekit.net/qch2ibh.css">
    <?php wp_head(); ?>

    <!-- Dev clear caching -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=60">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="Wed, 25 Jul 2018 21:00:00 GMT">

    <!-- FUCKING VIEW PORT IMPORTANT -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body <?php body_class(); ?>>

    <header>
        <nav>
            <div class="brucato-nav-button hamburger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="brucato-sidebar">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'top-menu',
                        'menu_class' => 'navigation navbar-nav',
                        'container' => false,
                        'bootstrap' => true

                    )
                );
                ?>
            </div>
        </nav>

    </header>