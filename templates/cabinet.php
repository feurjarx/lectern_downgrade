<?php
/**
 * Created by PhpStorm.
 * Date: 05.05.2016
 * Time: 20:58
 */
/** @var $this BaseController */

?>
<?php $titlePage = 'Личный кабинет'; ?>

<?php ob_start() ?>
    <link href="<?php echo Utils::getHttpHost(); ?>/assets/css/cabinet.css" rel="stylesheet">
    <link href="<?php echo Utils::getHttpHost(); ?>/assets/css/brick-wall.css" rel="stylesheet">
    <link href="<?php echo Utils::getHttpHost(); ?>/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" >
<?php $css = ob_get_clean() ?>

<?php $active_item = 'cabinet' ?>

<?php ob_start() ?>

    <?php if ($this->getCurrentUser()->getRole() === Constants::STUDENT_ROLE): ?>

        <?php include 'cabinet/student.php' ?>

    <?php elseif ($this->getCurrentUser()->getRole() === Constants::EMPLOYER_ROLE): ?>

        <?php include 'cabinet/employer.php' ?>

    <?php endif; ?>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>