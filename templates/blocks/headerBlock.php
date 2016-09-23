<?php
/**
 * Created by PhpStorm.
 * Date: 18.05.2016
 * Time: 22:29
 */

use Entity\User;

/** @var $this BaseController */

/** @var User $currentUser */
$currentUser = $this->currentUser;
?>

<nav class="navbar navbar-default margin-none-xs">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="/assets/img/logo.gif" class="img-rounded" alt="Кафедра">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">

                <li class="<?php echo isset($active_item) && $active_item === 'home' ? 'active' : '' ?>">

                    <?php if ($currentUser): ?>

                        <?php if (Constants::EMPLOYER_ROLE === $currentUser->getRole()): ?>
                            <a href="/"><span class="fa fa-group"></span> Резюме</a>
                        <?php endif ?>

                        <?php if (Constants::STUDENT_ROLE === $currentUser->getRole()): ?>
                            <a href="/"><span class="fa fa-life-saver"></span> Вакансии</a>
                        <?php endif ?>

                    <?php else: ?>
                        <a href="/"><span class="fa fa-home"></span> Главная</a>
                    <?php endif; ?>

                </li>

                <?php if ($currentUser): ?>
                    <?php if (Constants::EMPLOYER_ROLE === $currentUser->getRole()): ?>

                        <li class="<?php echo isset($active_item) && $active_item === 'vacancies' ? 'active' : '' ?>">
                            <a href="/vacancies">
                                <span class="fa fa-wpforms"></span> Вакансии
                            </a>
                        </li>

                    <?php endif; ?>
                <?php endif; ?>

                <?php if (Constants::ADMIN_ROLE !== $this->getRole()): ?>

                    <li class="<?php echo isset($active_item) && $active_item === 'about' ? 'active' : '' ?>">
                        <a href="/about"><i class="fa fa-info"></i> О нас</a>
                    </li>

                    <li class="<?php echo isset($active_item) && $active_item === 'reviews' ? 'active' : '' ?>">
                        <a href="/reviews"><i class="fa fa-comments-o"></i> Отзывы</a>
                    </li>

                    <?php if ($currentUser): ?>

                        <li class="<?php echo isset($active_item) && $active_item === 'cabinet' ? 'active' : '' ?>">
                            <a href="/cabinet">

                                <?php if ($currentUser->getRole() === Constants::STUDENT_ROLE): ?>

                                    <span class="glyphicon glyphicon-education"></span>

                                <?php elseif ($currentUser->getRole() === Constants::EMPLOYER_ROLE): ?>

                                    <span class="glyphicon glyphicon-briefcase"></span>

                                <?php endif; ?>

                                <span>Личный кабинет</span>

                                <?php if (($user = $this->getCurrentUser()) && $user->getRole() === Constants::STUDENT_ROLE && !$user->getPerson()->getCvs()->count()): ?>
                                    <span style="color: darkorange" class="fa fa-exclamation-circle" data-qtip-theme="dark" data-qtip-at="right center" title="Создайте резюме"></span>
                                <?php endif; ?>

                            </a>
                        </li>

                    <?php endif ?>

                <?php endif; ?>

            </ul>

            <?php if ($currentUser): ?>

                <?php include __DIR__ . '/../forms/profileForm.php'; ?>

            <?php elseif (isset($active_item) && $active_item !== 'none'): ?>

                <?php include __DIR__ . '/../forms/signinForm.php'; ?>

            <?php endif ?>

        </div>
    </div>
</nav>