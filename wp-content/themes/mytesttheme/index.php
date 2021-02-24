<?php get_header(); ?>


    <div class="container">
        <div class="row">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <!-- post -->

                <div class="col-md-12">
                    <div class="card">
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
                                <?php the_post_thumbnail('spec_thumb'); ?>
                            </a>
                            <?php
                        } else {
                            ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <img src="https://via.placeholder.com/300x200?text=No+Image" alt="Card image cap" width="300px"
                                 height="200px">
                        </a>
                            <?php
                        }
                        ?>
                        <!--                    <img class="card-img-top" src=".../100px180/" alt="Card image cap">-->
                        <div class="card-body">
                            <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            <!--                        <p class="card-text">-->
                            <?php //the_content(''); //the_excerpt(); ?><!--</p>-->
                            <p class="card-text"><?php the_excerpt(); // Выводит не текст поста, а отрывок поста, который заполняется в отдельном поле ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
                <!-- post navigation -->
            <?php else: ?>
                <!-- no posts found -->
                <p>Постов нет...</p>
            <?php endif; ?>
        </div>
    </div>

<?php get_footer(); ?>