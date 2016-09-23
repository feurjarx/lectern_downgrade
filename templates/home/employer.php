<?php
/**
 * Created by PhpStorm.
 * Date: 30.05.2016
 * Time: 19:09
 */
?>
<?php ob_start() ?>
    <script src="<?php echo Utils::getHttpHost(); ?>/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<?php $beforeJs = ob_get_clean() ?>

<?php if ($this->getCurrentUser()): ?>

    <div id="top-panel">

        <div class="visible-part col-lg-12 col-md-12 col-xs-12">

            <div class="col-lg-8 col-md-8 col-xs-12" style="order: 1">
                <h2 class="content-title">Резюме студентов</h2>
            </div>

            <div class="hidden-part-toggle flexbox col-lg-4 col-md-4 hidden-xs" style="order: 2">
                <button class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#filter-box" aria-expanded="false"
                        onclick="$(this).toggleClass('btn-primary')">

                    <b>Фильтр</b>
                    <span class="glyphicon glyphicon-filter"></span>
                </button>
            </div>
        </div>

        <div class="form-group col-xs-12 visible-xs">
            <button class="btn-block btn btn-primary btn-sm" data-toggle="collapse" data-target="#filter-box" aria-expanded="false"
                    onclick="$(this).toggleClass('btn-primary')">

                <b>Фильтр</b>
                <span class="glyphicon glyphicon-filter"></span>
            </button>
        </div>

        <div id="filter-box" class="hidden-part collapse fade col-lg-12 col-md-12 col-xs-12 margin-none-xs">
            <div class="col-lg-4 col-md-4 col-xs-12 padding-none">
                <label for="sphere-select">Сфера деятельности:</label>
                <select name="sphere" id="sphere-select" class="selectpicker selectpicker-filter show-tick" multiple data-actions-box="true" title="Выберите сферу">

                    <?php foreach (Utils::getSpheresTitles() as $sphere => $title): ?>

                        <option value="<?php echo $sphere; ?>"><?php echo $title; ?></option>

                    <?php endforeach; ?>

                </select>
            </div>
        </div>

    </div>


<?php else: ?>

    <div class="row margin-none text-center">
        <h2 class="content-title">Резюме студентов</h2>
    </div>

<?php endif ?>

<ul class="scrollbox list-group brick-wall list-unstyled" data-hbs="<?php echo Utils::getHttpHost()?>/templates/hbs/cvBlock.hbs" data-ajax-url="/get/cvs">

    <?php if (isset($cvs) and count($cvs)):?>

        <?php /** @var \Entity\Cv[] $cvs */ ?>
        <?php foreach ($cvs as $index => $cv): ?>
            
            <li class="col-lg-12 col-md-12 col-xs-12 list-group-item brick scroller-item" data-id="<?php echo $cv->getId(); ?>">

                <?php include __DIR__ . '/../blocks/cvBlock.php'?>

            </li>

        <?php endforeach; ?>

    <?php else: ?>

        <li class="alert alert-info scroller-item">
            <strong>
                <span class="sr-only">Внимание!</span>
                <span>Резюме не найдено</span>
            </strong>
        </li>

    <?php endif; ?>

</ul>