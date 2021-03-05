</div><!-- end .wrapper -->
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse">
            <?php
            $args = array(
//        'menu' => 'Основное меню', // выводится по названию меню. На практике практически не используется
                'theme_location' => 'footer_menu', // На практиче указывается идентификатор меню, который мы добавляли в функцию register_nav_menus()
                'container' => false,
                'menu_class' => 'navbar-nav mr-auto',
                'walker' => new MyTestTheme_Walker_Nav_Menu,
            );
            wp_nav_menu($args);
            ?>
        </div>
    </nav>
</div><!--end /.container -->


<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<?php wp_footer(); ?>

</body>
</html>