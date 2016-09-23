<?php $titlePage = 'Регистрация'; ?>

<?php ob_start() ?>
    <link href="../assets/css/signup.css" rel="stylesheet">
    <link href="../bower_components/cropper/dist/cropper.min.css" rel="stylesheet">
<?php $css = ob_get_clean() ?>

<?php ob_start() ?>
    <script src="../bower_components/blueimp-load-image/js/load-image.all.min.js"></script>
    <script src="../bower_components/cropper/dist/cropper.min.js"></script>
<?php $beforeJs = ob_get_clean() ?>

<?php ob_start() ?>
    <script type="application/javascript" src="../assets/js/signup.js"></script>
<?php $afterJs = ob_get_clean() ?>

<?php ob_start() ?>

    <?php if (isset($isSuccess) && $isSuccess): ?>

        <?php include 'signup/success.php' ?>

    <?php elseif (isset($isConfirmError) && $isConfirmError): ?>

        <?php include 'signup/error.php' ?>

    <?php elseif (isset($isConfirmSuccess) && $isConfirmSuccess): ?>

        <?php include 'signup/finally.php' ?>

    <?php else: ?>

        <?php include 'signup/main.php' ?>

    <?php endif; ?>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>