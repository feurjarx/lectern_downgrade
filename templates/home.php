<?php
use Entity\User;
/** @var BaseController $this */
/** @var string $role */
?>

<?php ob_start() ?>
    <link href="../assets/css/brick-wall.css" rel="stylesheet">
    <link href="../assets/css/home.css" rel="stylesheet">
    <link href="<?php echo Utils::getHttpHost(); ?>/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" >
<?php $css = ob_get_clean() ?>


<?php ob_start() ?>

    <script src="<?php echo Utils::getHttpHost(); ?>/assets/js/hbs-scroller.js"></script>
    <script src="<?php echo Utils::getHttpHost(); ?>/assets/js/filter-box.js"></script>

    <?php if (Constants::ADMIN_ROLE === $this->getRole()): ?>

        <script src="<?php echo Utils::getHttpHost(); ?>/assets/js/student-page.js"></script>
        <script src="<?php echo Utils::getHttpHost(); ?>/assets/js/admin-actions.js"></script>

    <?php else: ?>
        <?php if ($this->getRole()): ?>
            <script src="<?php echo Utils::getHttpHost(); ?>/assets/js/<?php echo $this->getRole(); ?>-page.js"></script>
        <?php endif ?>
    <?php endif; ?>

<?php $afterJs = ob_get_clean() ?>

<?php ob_start() ?>

    <?php if (is_null($this->getRole())): ?>
        <?php $titlePage = 'Главная'; ?>

        <div class="jumbotron margin-none">
            <h2>Добро пожаловать на сайт «Содействие трудоустройству студентов кафедры ИВТ и ИБ»</h2>
            <p>Для того чтобы воспользоваться расширенным функционалом сайта войдите или зарегистрируйтесь.<br>Более подробную информацию о проекте можно прочитать в разделе
                <a href="/about"><q>О нас</q></a></p>
        </div>

    <?php endif ?>

    <?php if (is_null($this->getRole())): ?>
        <iframe class="col-lg-12 col-md-12 hidden-sm hidden-xs" src="/animation"></iframe>
    <?php endif ?>

    <?php if ($this->getRole()): ?>

        <?php if (Constants::EMPLOYER_ROLE === $this->getRole()):?>
            <?php $titlePage = 'Резюме студентов'; ?>
            <?php include 'home/employer.php' ?>
        <?php endif ?>

        <?php if (Constants::STUDENT_ROLE === $this->getRole()):?>
            <?php $titlePage = 'Вакансии'; ?>
            <?php include 'home/student.php' ?>
        <?php endif ?>

        <?php if (Constants::ADMIN_ROLE === $this->getRole()):?>
            <?php $titlePage = 'Предлагаемые объявления'; ?>
            <?php include 'home/student.php' ?>
        <?php endif ?>

    <?php else: ?>

        <div class="col-lg-6 col-md-6 col-xs-12">
            
            <?php include 'home/student.php' ?>
            
        </div>

        <div class="col-lg-6 col-md-6 col-xs-12">

            <?php include 'home/employer.php' ?>
            
        </div>

    <?php endif; ?>

    <input type="hidden" name="flash" value="<?php echo $_SESSION['flash']; ?>">

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>