<?php $titlePage = 'Вакансии'; ?>

<?php ob_start() ?>
    <link href="../assets/css/brick-wall.css" rel="stylesheet">
<?php $css = ob_get_clean() ?>

<?php ob_start() ?>
<?php $beforeJs = ob_get_clean() ?>

<?php ob_start() ?>
    <script src="<?php echo Utils::getHttpHost(); ?>/assets/js/hbs-scroller.js"></script>
    <script src="<?php echo Utils::getHttpHost(); ?>/assets/js/student-page.js"></script>
<?php $afterJs = ob_get_clean() ?>

<?php ob_start() ?>

    <div class="row margin-none">
        <h2 class="content-title">Вакансии</h2>
    </div>

    <ul class="scrollbox list-group brick-wall list-unstyled" data-hbs="<?php echo Utils::getHttpHost()?>/templates/hbs/adBlock.hbs" data-ajax-url="/get/ads">

        <?php if (isset($ads) and count($ads)):?>

            <?php /** @var \Entity\Ad[] $ads */ ?>
            <?php foreach ($ads as $index => $ad): ?>

                <li class="col-lg-12 col-md-12 col-xs-12 list-group-item brick scroller-item" data-id="<?php echo $ad->getId(); ?>">

                    <?php include __DIR__ . '/blocks/adBlock.php'?>

                </li>

            <?php endforeach; ?>

        <?php else: ?>

            <li class="alert alert-info scroller-item">
                <strong>
                    <span class="sr-only">Внимание!</span>
                    <span>Объявлений не найдено</span>
                </strong>
            </li>

        <?php endif; ?>

    </ul>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>