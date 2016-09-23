<?php
/**
 * Created by PhpStorm.
 * Date: 30.05.2016
 * Time: 19:09
 */
/** @var BaseController $this */
?>
<?php ob_start() ?>
    <script src="<?php echo Utils::getHttpHost(); ?>/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<?php $beforeJs = ob_get_clean() ?>


<?php if ($this->getCurrentUser()): ?>

    <?php if (Constants::ADMIN_ROLE === $this->getRole()): ?>

        <div class="row margin-none">
            <h2 class="content-title">Ожидающие подтверждения объявления вакансий</h2>
        </div>

    <?php endif; ?>

    <?php if (Constants::STUDENT_ROLE === $this->getRole()): ?>

        <?php $topPanelTitle = 'Вакансии'; ?>

        <div id="top-panel">
            
            <div class="visible-part col-lg-12 col-md-12 col-xs-12">
    
                <div class="col-lg-8 col-md-8 col-xs-12" style="order: 1">
                    <h2 class="content-title"><?php echo isset($topPanelTitle) ? $topPanelTitle : 'Панель управления'; ?></h2>
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
                <div class="col-lg-4 col-md-4 col-xs-12 padding-none">
                    <label for="salary-range-select">Предлагаемая з/п:</label>
                    <select name="salary_range" id="salary-range-select" class="selectpicker selectpicker-filter show-tick">
                        <option value="*">любая</option>
                        <option value="<10000">До 10000р</i></option>
                        <option value=">10000">От 10000р</i></option>
                        <option value=">20000">От 20000р</i></option>
                        <option value=">30000">От 30000р</i></option>
                        <option value=">40000">От 40000р</i></option>
                        <option value=">50000">От 50000р</i></option>7
                    </select>
                </div>
            </div>
            
        </div>

    <?php endif; ?>

<?php else: ?>

    <div class="row margin-none text-center">
        <h2 class="content-title">Вакансии</h2>
    </div>

<?php endif ?>

<ul class="scrollbox list-group brick-wall list-unstyled" data-hbs="<?php echo Utils::getHttpHost()?>/templates/hbs/adBlock.hbs" data-ajax-url="/get/ads">

    <?php if (isset($ads) and count($ads)):?>

        <?php foreach ($ads as $index => $ad): ?>

            <li class="col-lg-12 col-md-12 col-xs-12 list-group-item brick scroller-item" data-id="<?php echo $ad->getId(); ?>">

                <?php include __DIR__ . '/../blocks/adBlock.php'?>

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
