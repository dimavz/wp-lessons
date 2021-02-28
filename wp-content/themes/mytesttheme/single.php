<?php get_header(); ?>

    <div class="container">
        <div class="row">
            <?php get_sidebar('left'); // Подключаем шаблон сайдбара sidebar-left.php. Без параметра name
            // подключается шаблон sidebar.php?>
            <div class="col">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="card">
                        <div class="card-header">
                            <?php the_title(); ?>
                        </div>
                        <?php
                        // Выводим картинку поста
                        if (has_post_thumbnail()) { // Проверяем прикреплено ли к записи изображение
                            //Размер миниатюры, которую нужно получить.
                            // Может быть строкой: thumbnail, medium, large, full
                            // или массивом из двух элементов (ширина и высота картинки): array(32, 32).
                            //the_post_thumbnail( 'thumbnail' ); // пример
                            //the_post_thumbnail( array(200, 120) ); // пример произвольного массива
                            // Если нас не устраивают стандартные размеры картинок [thumbnail, medium, large, full], то мы можем добавить свой
                            // в functions.php мы регистрируем дополнительный размер картинки так: add_image_size( 'spec_thumb', 100, 180, true );
                            //$img_attr = array('class' => "card-img-top");
                            //the_post_thumbnail('spec_thumb',$img_attr);
                            the_post_thumbnail('full');
                        }
                        ?>
                        <!--                        <img class="card-img-top" src=".../100px180/" alt="Card image cap">-->
                        <div class="card-body">
                            <div class="card-text"><?php the_content(''); ?></div>
                        </div>
                    </div><!-- end .card  -->
                <?php endwhile; ?>
            </div><!-- end .col  -->
            <?php get_sidebar('right'); // Подключаем шаблон сайдбара sidebar-right.php. Без параметра name
            // подключается шаблон sidebar.php?>
        </div><!-- end .row -->

    </div><!-- end .container -->

<?php get_footer(); ?>