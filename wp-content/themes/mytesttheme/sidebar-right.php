<?php if (is_active_sidebar('right-sidebar')): ?>
<div class="col-3">
    <!--<div class="row">-->

    <?php
    dynamic_sidebar('right-sidebar'); // Выводит виджеты из сайдбара виджетов с id = 'right-sidebar',
    // который мы указываем при регистрации панели при помощи функции register_sidebar() в фале functions.php
    ?>
    <!--</div>-->
</div><!--  end .col-3  -->
<?php endif; ?>