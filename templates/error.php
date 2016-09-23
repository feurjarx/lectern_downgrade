<?php $titlePage = 'Ошибка' ?>

<?php ob_start() ?>

    <?php if (isset($type) and $type === Constants::ERROR_NOT_FOUND): ?>
    
        <img src="/assets/img/404.jpg" class="img-responsive center-block">

    <?php elseif(isset($type) and $type === Constants::ERROR_ACCESS_DENIED): ?>

        <img src="/assets/img/403.png" class="img-responsive center-block">

    <?php else: ?>

        <div class="text-center">
            <img src="/assets/img/error.gif" class="img-circle">
        </div>

    <?php endif ?>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>