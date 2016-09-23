<?php
/**
 * Created by PhpStorm.
 * Date: 18.05.2016
 * Time: 21:23
 */
use Entity\Cv;

/** @var BaseController $this */

/** @var Cv $cv */
?>

<?php if (isset($cv) and $cv instanceof Cv and $cv): ?>
    
    <div class="col-lg-1 col-md-1 col-xs-2 thumbnail">
        <img src="<?php echo $cv->getPerson()->getUser()->getImgUrl(); ?>" alt="<?php echo $cv->getPerson()->getLastName(); ?>">
    </div>

    <div class="col-lg-11 col-lg-11 col-xs-10">
        <div class="list-group-item-heading" data-target="#brick-details-<?php echo $cv->getId(); ?>" data-toggle="collapse" aria-expanded="false">

            <h3 class="margin-none">
                <a href="javascript: void(0)" class="ellipsis-box font-size-xs"><?php echo $cv->getPerson()->getFullName(); ?></a>
            </h3>

            <?php if (Constants::EMPLOYER_ROLE === $this->getRole()): ?>

                <p>
                    <span><b>Образование: </b><?php echo $cv->getEducation(); ?></span>
                    <?php if ($spheresString = Utils::getSpheresString($cv->getSphere())): ?>
                        <br>
                        <span><b>Желаемая сфера занятости: </b><?php echo $spheresString ; ?></span>
                    <?php endif ?>
                </p>

            <?php else: ?>


                <?php if ($spheresString = Utils::getSpheresString($cv->getSphere())): ?>
                    <span><b>Желаемая сфера занятости: </b><?php echo $spheresString ; ?></span>
                    <br>
                <?php endif ?>

                <small class="text-muted">создано: <?php echo date('d/m/Y', $cv->getCreatedAt()); ?></small>

            <?php endif ?>

        </div>
    </div>

    <?php if (Constants::EMPLOYER_ROLE === $this->getRole()): ?>

        <?php if ($this->getRoute() === '/cabinet'): ?>

            <div class="pull-right">
                <button type="button" class="actions btn btn-success btn-sm">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Пригласить на собеседование
                </button>
            </div>

        <?php else: ?>

            <div class="pull-right">
                <button type="button" class="actions btn btn-default btn-xs">
                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Запросить резюме
                </button>
            </div>

        <?php endif ?>



    <?php endif; ?>

    <span class="badge pull-left visible-xs visible-sm"><?php echo $cv->getPerson()->getOrganisation(); ?></span>

    <?php if (Constants::EMPLOYER_ROLE === $this->getRole()): ?>

        <div class="col-lg-12 col-md-12 col-xs-12 padding-none">
            <div class="collapse list-group-item-text" id="brick-details-<?php echo $cv->getId(); ?>">
                <small class="text-muted">создано: <?php echo date('d/m/Y', $cv->getCreatedAt()); ?></small>
		<?php $workExperiencesTitles = Utils::getWorkExperiencesTitles(); ?>
                <small class="text-muted pull-right">стаж: <?php echo $workExperiencesTitles[$cv->getWorkExperience()]; ?></small>

                <pre class="well margin-none"><span>Имеющиеся навыки: <?php echo $cv->getSkills(); ?></span><br><?php echo $cv->getAbout() ? ('О себе: ' . $cv->getAbout() . '<br>') : '' ?><?php echo $cv->getHobbies() ? ('Увлечения: ' . $cv->getHobbies() . '<br>') : '' ?></pre>
            </div>
        </div>

    <?php endif; ?>

    <span class="badge badge-salary pull-right visible-lg visible-md"><?php echo $cv->getPerson()->getOrganisation(); ?></span>

<?php endif; ?>