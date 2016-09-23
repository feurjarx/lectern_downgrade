<?php
/**
 * Created by PhpStorm.
 * Date: 05.05.2016
 * Time: 21:05
 */

use Entity\Cv;

/** @var $this BaseController */
/** @var Cv $cv */
$cv = ($user = $this->getCurrentUser()) ? $user->getPerson()->getCvs()->first() : null;

?>

<?php ob_start() ?>
    <script src="<?php echo Utils::getHttpHost(); ?>/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?php echo Utils::getHttpHost(); ?>/assets/js/cv-save.js"></script>
<?php $afterJs = ob_get_clean(); ?>

<h1 class="text-center">Заполнение резюме</h1>
<form id="cv-save-form" action="/student/cv/save" method="post">

    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="form-group">
            <label for="sphere-select">Сфера деятельности</label>
            <br>
            <select name="sphere" id="sphere-select" class="selectpicker show-tick" multiple data-actions-box="true">

                <?php $cvSpheres = $cv ? explode(',', $cv->getSphere()) : array() ?>

                <?php foreach (Utils::getSpheresTitles() as $sphere => $title): ?>

                    <option <?php echo $cv ? ( in_array($sphere, $cvSpheres)? 'selected' : '' ) : '' ?> value="<?php echo $sphere; ?>"><?php echo $title; ?></option>

                <?php endforeach; ?>

            </select>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="form-group">
            <label for="skills-textarea">Навыки</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-hand-rock-o"></i>
                </span>
                <textarea required style="resize: vertical" rows="7" class="form-control" name="skills" id="skills-textarea" placeholder="Перечислите навыки и языки программирования, которыми владеете"><?php echo $cv ? $cv->getSkills() : '' ?></textarea>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-asterisk"></span>
                </span>
            </div>
        </div>
    </div>


    <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label for="work-experience-select">Рабочий стаж</label>
            <br>
            <select name="work_experience" id="work-experience-select" class="selectpicker show-tick">

                <?php foreach (Utils::getWorkExperiencesTitles() as $experience => $title): ?>

                    <option <?php echo $cv ? ( $cv->getWorkExperience() === $experience ? 'selected' : '' ) : '' ?> value="<?php echo $experience; ?>"><?php echo $title ?></option>

                <?php endforeach; ?>

            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label for="schedule-select">Желаемый рабочий график</label>
            <br>
            <select name="schedule" id="schedule-select" class="selectpicker show-tick">

                <?php foreach (Utils::getSchedulesTitles() as $schedule => $title): ?>

                    <option <?php echo $cv ? ( $cv->getSchedule() === $schedule ? 'selected' : '' ) : '' ?> value="<?php echo $schedule; ?>"><?php echo $title ?></option>

                <?php endforeach; ?>

            </select>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label for="desire-salary-input">Заработная плата</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                <input value="<?php echo $cv ? $cv->getDesireSalary() : '' ?>"
                    type="number" step="100" class="form-control" name="desire_salary" id="desire-salary-input" placeholder="Введите желаемую з/п">
                <span class="input-group-addon"><i class="fa fa-rub" aria-hidden="true"></i></span>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="form-group">
            <label for="foreign-languages-input">Владение иностранными языками</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-language"></i>
                </span>
                <input value="<?php echo $cv ? $cv->getForeignLanguages() : '' ?>"
                    type="text" class="form-control" name="foreign_languages" id="foreign-languages-input" placeholder="Перечислите через запятую">
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="form-group">
            <label for="education-textarea">Образование</label>
            <textarea style="resize: vertical" rows="3" class="form-control" name="education" id="education-textarea" placeholder="Укажите сведения об образовании"><?php echo $cv ? $cv->getEducation() : '' ?></textarea>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
            <label for="about-textarea">О себе</label>
            <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-comment-o"></i>
            </span>
                <textarea style="resize: vertical" rows="5" class="form-control" name="about" id="about-textarea" placeholder="Напишите о себе то, что считаете желательно знать будущему работодателю"><?php echo $cv ? $cv->getAbout() : '' ?></textarea>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
            <label for="hobbies-textarea">Увлечения</label>
            <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-arrow-circle-o-right"></i>
            </span>
                <textarea style="resize: vertical" rows="5" class="form-control" name="hobbies" id="hobbies-textarea" placeholder="Напишите о своих увлечениях, а также то, чем бы желали заниматься"><?php echo $cv ? $cv->getHobbies() : '' ?></textarea>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="form-group">
            <input value="<?php echo $cv ? $cv->getIsDriversLicense() : '' ?>" <?php echo $cv ? ($cv->getIsDriversLicense() ? 'checked' : '') : '' ?>
                id="is-drivers-license-checkbox" name="is_drivers_license" type="checkbox" data-toggle="checkbox-x" data-size="sm" data-three-state="false"
            />
            <label for="is-drivers-license-checkbox">Водительское удостоверение</label>
            <br>
            <input value="<?php echo $cv ? $cv->getIsSmoking() : '' ?>" <?php echo $cv ? ($cv->getIsSmoking() ? 'checked' : '') : '' ?>
                id="is-smoking-checkbox" name="is_smoking" type="checkbox" data-toggle="checkbox-x" data-size="sm" data-three-state="false"
            />
            <label for="is-smoking-checkbox">Курение сигарет</label>
            <br>
            <input value="<?php echo $cv ? $cv->getIsMarried() : '' ?>" <?php echo $cv ? ($cv->getIsMarried() ? 'checked' : '') : '' ?>
                id="is-married-checkbox" name="is_married" type="checkbox" data-toggle="checkbox-x" data-size="sm" data-three-state="false"
            />
            <label for="is-married-checkbox">В браке</label>
        </div>

    </div>

    <div class="form-group col-lg-6 col-md-6 col-xs-12">

        <div class="col-lg-12 col-md-12 col-xs-12 padding-none">
            <label>Режим доступа&nbsp;</label>
        </div>

        <div class="col-lg-9 col-md-9 col-xs-9 padding-none">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default<?php echo $cv ? ( $cv->getAccessType() === 'public' ? ' active' : '' ) : ' active' ?>">
                    <span class="fa fa-unlock"></span>
                    <input <?php echo $cv ? ( $cv->getAccessType() === 'public' ? 'checked' : '' ) : 'checked' ?>
                        type="radio" name="access_type" value="public" autocomplete="off"
                    />
                    <span> Публичный</span>
                </label>
                <label class="btn btn-default<?php echo $cv ? ( $cv->getAccessType() === 'private' ? ' active' : '' ) : '' ?>">
                    <span class="fa fa-unlock-alt"></span>
                    <input <?php echo $cv ? ( $cv->getAccessType() === 'private' ? 'checked' : '' ) : '' ?>
                        type="radio" name="access_type" value="private" autocomplete="off"
                    />
                    <span> Закрытый</span>
                </label>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-xs-3 padding-none">
            <div class="btn-group btn-group-md pull-right">
                <button name="id" value="<?php echo $cv ? $cv->getId() : ''; ?>" class="btn btn-success pull-right" type="submit">
                    <em class="glyphicon glyphicon-floppy-disk"></em>
                    <span class="hidden-xs">Сохранить</span>
                </button>
            </div>
        </div>
    </div>

    <input type="hidden" name="flash" value="<?php echo $_SESSION['flash']; ?>">
</form>