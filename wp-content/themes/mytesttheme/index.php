<?php get_header(); ?>


<div class="container">
    <div class="row">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <!-- post -->

            <div class="col-md-12">
                <div class="card">
                    <img class="card-img-top" src=".../100px180/" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <p class="card-text"><?php the_content(''); //the_excerpt(); ?></p>
<!--                        <p class="card-text">--><?php //the_excerpt(); // Выводит не текст поста, а отрывок поста, который заполняется в отдельном поле ?><!--</p>-->
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