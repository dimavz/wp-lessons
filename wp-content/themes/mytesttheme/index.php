<?php get_header(); ?>

    <div class="container">
        <div class="row">
            <div class="col-9">
            </div>
            <div class="col">
                <p class="test-phone"<?php if (false === get_theme_mod('test_show_phone')) echo ' style="display: none;"' ?>>
                    Телефон: <span><?php echo get_theme_mod('test_phone'); ?></span>
                </p>
            </div>
        </div>
        <div class="row">
            <?php get_sidebar('left'); // Подключаем шаблон сайдбара sidebar-left.php. Без параметра name
            // подключается шаблон sidebar.php?>
            <div class="col">
                <div class="row">
                    <!-- Цикл WP loop -->
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <!-- post -->

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h5>
                                </div>
                                <!--                    <img class="card-img-top" src=".../100px180/" alt="Card image cap">-->
                                <div class="card-body">
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
//                            the_post_thumbnail('spec_thumb');
                                        ?>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <!--                                --><?php //the_post_thumbnail('spec_thumb'); ?>
                                            <?php the_post_thumbnail('thumbnail', array('class' => 'float-left mr-3')); ?>
                                        </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <img src="https://via.placeholder.com/150x150?text=No+Image"
                                                 alt="Card image cap"
                                                 class="float-left mr-3">
                                        </a>
                                        <?php
                                    }
                                    ?>
                                    <!--                        <p class="card-text">-->
                                    <?php //the_content(''); //the_excerpt(); ?><!--</p>-->
                                    <div class="card-text">
                                        <?php the_excerpt(); // Выводит не текст поста, а отрывок поста, который заполняется в отдельном поле ?>
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                                            <?php _e('Читать далее...', 'mytesttheme') ?>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                        <!-- post navigation -->
                        <?php the_posts_pagination(array(
                                'screen_reader_text' => 'Навигация:',
                                'show_all' => false,
                                'mid_size' => 1,
                                'type' => 'list',
                            )
                        ); ?>
                    <?php else: ?>
                        <!-- no posts found -->
                        <p>Постов нет...</p>
                    <?php endif; ?>
                </div><!-- end .row-->
            </div><!-- end .col -->
            <?php get_sidebar('right'); // Подключаем шаблон сайдбара sidebar-right.php. Без параметра name
            // подключается шаблон sidebar.php?>
        </div><!-- end .row-->
    </div><!-- end .container-->
<?php
$params = array(
//    'cat'=>'22,31', // Выбор рубрик по их IDs
    'category_name'=>'block,classic', // Выбор рубрик по их слэгам
    'posts_per_page'=>20,
    'orderby'=>'title', // Сортировка записей по заголовку
    'order'=>'ASC'// Сортировка записей по возрастанию
);
$query = new WP_Query($params); // Выборка записей из категорий с ID 22 и 31
//и пагинацией вывода всех записей на страницу
if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
    <!-- post -->
    <?php the_title('<h4>', '</h4>'); ?>
<?php endwhile; ?>
    <!-- post navigation -->
<?php else: ?>
    <!-- no posts found -->
    <p>Постов нет...</p>
<?php endif; ?>
<?php wp_reset_postdata(); //Возвращает глобальную переменную $post в правильное состояние: в соответствие с текущим.
//Функцию нужно использовать каждый раз после запуска произвольного цикла.
// Т.е. в случаях, когда на странице есть дополнительный цикл WordPress с использованием глобальной переменной $post

?>
<?php get_footer(); ?>