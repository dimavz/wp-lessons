<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php wp_head(); ?>
</head>
<body <?php body_class();?>>
<div class="container">
<?php if(is_front_page()): // Проверяем является ли страница главной страницой сайта?>
    <?php if(has_header_image()): // Проверяем установлено ли изображение для хэдера в кастомайзере темы?>
        <div class="header-image" style="background: url(<?php echo get_custom_header()->url?>) center no-repeat; background-size: cover;height: 30vh;"></div>
    <?php endif;?>
<?php endif;?>
</div>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <?php if (has_custom_logo()):?>
            <a class="navbar-brand" href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <?php the_custom_logo();?>
            </a>
        <?php endif; ?>
        <a class="navbar-brand" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
        <!--    <span>-->
        <!--        --><?php //bloginfo('description'); ?>
        <!--    </span>-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php
            $args = array(
//        'menu' => 'Основное меню', // выводится по названию меню. На практике практически не используется
                'theme_location' => 'header_menu', // На практиче указывается идентификатор меню, который мы добавляли в функцию register_nav_menus()
                'container' => false,
                'menu_class' => 'navbar-nav mr-auto',
//            'items_wrap' => '<ul class="navbar-nav mr-auto">%3$s</ul>',
                'walker' => new MyTestTheme_Walker_Nav_Menu,
            );
            wp_nav_menu($args);
            ?>
            <!--        <ul class="navbar-nav mr-auto">-->
            <!--            <li class="nav-item active">-->
            <!--                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>-->
            <!--            </li>-->
            <!--            <li class="nav-item">-->
            <!--                <a class="nav-link" href="#">Link</a>-->
            <!--            </li>-->
            <!--            <li class="nav-item dropdown">-->
            <!--                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
            <!--                    Dropdown-->
            <!--                </a>-->
            <!--                <div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
            <!--                    <a class="dropdown-item" href="#">Action</a>-->
            <!--                    <a class="dropdown-item" href="#">Another action</a>-->
            <!--                    <div class="dropdown-divider"></div>-->
            <!--                    <a class="dropdown-item" href="#">Something else here</a>-->
            <!--                </div>-->
            <!--            </li>-->
            <!--            <li class="nav-item">-->
            <!--                <a class="nav-link disabled" href="#">Disabled</a>-->
            <!--            </li>-->
            <!--        </ul>-->
            <?php get_sidebar('search'); // Подключаем шаблон сайдбара sidebar-left.php. Без параметра name?>
<!--            <form class="form-inline my-2 my-lg-0">-->
<!---->
<!--                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
<!--                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
<!--            </form>-->
        </div>
    </nav>
</div><!--end .container -->


<div class="wrapper">

