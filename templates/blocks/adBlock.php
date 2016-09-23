<?php
/**
 * Created by PhpStorm.
 * Date: 18.05.2016
 * Time: 21:23
 */
use Entity\Ad;

/** @var BaseController $this */
$isCabinet = '/cabinet' === parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$self = $this;

$isCvSendAble = function() use ($self) {
    return ($user = $self->getCurrentUser()) && $user->getRole() === Constants::STUDENT_ROLE && $user->getPerson()->getCvs()->count();
};

/** @var Ad $ad */

$notSendableAdsIds = isset($notSendableAdsIds) ? $notSendableAdsIds : array();
?>

<?php if (isset($ad) and $ad instanceof Ad and $ad): ?>

    <?php if ($isCabinet): ?>

        <div class="col-lg-1 col-md-1 col-xs-2 checkbox-block padding-none">
            <input type="checkbox" placeholder=""  data-toggle="checkbox-x" data-size="sm"
                   data-three-state="false" data-ad-id="<?php echo $ad->getId(); ?>">
        </div>

    <?php else: ?>

        <div class="col-lg-1 col-md-1 col-xs-2 thumbnail">
            <img src="<?php echo $ad->getPerson()->getUser()->getImgUrl(); ?>" alt="<?php echo $ad->getPerson()->getLastName(); ?>">
        </div>

    <?php endif ?>

    <div class="col-lg-11 col-lg-11 col-xs-10">

        <div class="list-group-item-heading" data-target="#brick-details-<?php echo $ad->getId(); ?>" data-toggle="collapse" aria-expanded="false">
            
            <?php if ($isCabinet): ?>

                <a href="#" class="ellipsis-box" style="width: 75%">
                    <b><?php echo ucfirst($ad->getName()); ?></b>
                </a>

            <?php else: ?>

                <h3 class="margin-none">
                    <a href="javascript: void(0)" class="ellipsis-box font-size-xs" style="width: 70%"><?php echo ucfirst($ad->getName()); ?></a>
                </h3>

                <?php if ($this->getRole()): ?>

                    <span><?php echo $ad->getPerson()->getFullName(); ?></span>
                    <span>(<?php echo $ad->getPerson()->getOrganisation(); ?>)</span>
                    <br>

                <?php endif ?>

                <?php if (Utils::getSpheresString($ad->getSphere())): ?>
                    <span>Требуется <?php echo Utils::getSpheresString($ad->getSphere()); ?></span>
                    <br>
                <?php endif; ?>

            <?php endif; ?>

            <?php if ($ad->getPublishedAt()): ?>

                <small class="text-muted">размещено: <?php echo date('d/m/Y H:i:s', $ad->getPublishedAt()); ?></small>

            <?php endif; ?>

        </div>
    </div>

    <?php if ($isCvSendAble() && !in_array($ad->getId(), $notSendableAdsIds)):?>

        <div class="pull-right">
            <button type="button" class="actions cv-send btn btn-default btn-xs">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Отправить резюме
            </button>
        </div>

    <?php endif; ?>

    <?php if (Constants::ADMIN_ROLE === $this->getRole()):?>

        <div class="btn-group actions pull-right col-lg-2 col-md-2 col-xs-12 padding-none">
            <button type="button" data-type="accept" class="ad-action btn btn-success btn-xs col-xs-6">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                <span> Разрешить</span>
            </button>
            <button type="button" data-type="remove" class="ad-action btn btn-danger btn-xs col-xs-6">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                <span> Удалить</span>
            </button>
        </div>

    <?php endif; ?>

    <?php if ($this->getRole()): ?>

        <div class="col-lg-12 col-md-12 col-xs-12 padding-none">
            <div class="collapse list-group-item-text" id="brick-details-<?php echo $ad->getId(); ?>">
                <pre class="well margin-none"><?php echo trim(strip_tags(ucfirst($ad->getDetails()))); ?></pre>
            </div>
        </div>

    <?php endif; ?>

    <span class="badge badge-salary pull-right">

        <?php if ($ad->getSalary()): ?>
            <?php echo $ad->getSalary(); ?>

            <i class="fa fa-rub" aria-hidden="true"></i>

        <?php else: ?>
            <?php echo 'Не указано'; ?>
        <?php endif; ?>

    </span>

<?php endif; ?>