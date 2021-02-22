<?php //get_header('test'); ?>
<?php get_header(); ?>

    <h1>Hello, world!</h1>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <!-- post -->
        <?php the_title('<h4>','</h4>'); ?>
    <?php endwhile; ?>
    <!-- post navigation -->
<?php else: ?>
    <!-- no posts found -->
    <p>Постов нет...</p>
<?php endif; ?>

<?php get_footer(); ?>