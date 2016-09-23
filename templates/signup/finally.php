<?php
/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 20:41
 */

use Entity\User;

/** @var $user User*/
?>

<form role="form" method="post" enctype="multipart/form-data">

    <div class="col-lg-6 col-md-6 col-xs-12">

        <h2>Личные данные</h2>

        <div class="form-group">
            <label for="last-name-input">Фамилия</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <b>Ф</b>
                </span>
                <input autofocus required type="text" class="form-control" name="last_name" id="last-name-input" placeholder="Введите фамилию">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-asterisk"></span>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="first-name-input">Имя</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <b>И</b>
                </span>
                <input required type="text" class="form-control" name="first_name" id="first-name-input" placeholder="Введите имя">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-asterisk"></span>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="father-name-input">Отчество</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <b>О</b>
                </span>
                <input type="text" class="form-control" name="father_name" id="father-name-input" placeholder="Введите отчество">
            </div>
        </div>

        <div class="form-group">
            <label for="date-birth-input">Дата рождения</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span>
                <input type="date" class="form-control" name="date_birth" id="date-birth-input" placeholder="Укажите дату рождения">
            </div>
        </div>

        <div class="form-group">
            <label>Пол</label>
            <br>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <span class="fa fa-male"></span>
                    <input type="radio" name="gender" id="is-man-input" value="man" autocomplete="off" checked>
                    <span> Мужской</span>
                </label>
                <label class="btn btn-default">
                    <span class="fa fa-female"></span>
                    <input type="radio" name="gender" id="is-woman-input" value="woman" autocomplete="off">
                    <span> Женский</span>
                </label>
            </div>
        </div>

        <div class="form-group">

            <?php if ($user->getRole() === Constants::STUDENT_ROLE): ?>

                <label for="organisation-input">Учебное заведение</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-university"></i>
                    </span>
                    <input required type="text" class="form-control" name="organisation" id="organisation-input" placeholder="Введите название учебного заведения">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-asterisk"></span>
                    </span>
                </div>

            <?php else: ?>

                <label for="organisation-input">Компания</label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </span>
                    <input required type="text" class="form-control" name="organisation" id="organisation-input" placeholder="Введите название компании">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-asterisk"></span>
                    </span>
                </div>

            <?php endif ?>

        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-xs-12">

        <?php $isCompanyForm = $user->getRole() === Constants::EMPLOYER_ROLE ?>

        <h2>Контактные данные<?php echo $isCompanyForm ? ' организации' : '' ?></h2>

        <div class="form-group">
            <label for="websites-input"><?php echo $isCompanyForm ? 'Сайт(-ы)' : 'Социальные сети' ?></label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-globe"></i>
                </span>
                <input type="text" class="form-control" name="websites" id="websites-input" placeholder="Введите через запятую ссылки">
            </div>
        </div>

        <div class="form-group">
            <label for="phone-input">Номер телефона</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                <input required type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control" name="phone" id="phone-input" placeholder="Укажите номер телефона">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-asterisk"></span>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="address-city-input">Город</label>
            <div class="input-group">
                <input required type="text" class="form-control" name="city" id="address-city-input" placeholder="Укажите город">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-asterisk"></span>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="address-street-input">Улица</label>
            <input type="text" class="form-control" name="street" id="address-street-input" placeholder="Укажите улицу">
        </div>

        <div class="form-group">
            <label for="address-house-number-input">Номер <?php echo $isCompanyForm ? 'здания' : 'дома' ?></label>
            <input type="text" class="form-control" name="house_number" id="address-house-number-input" placeholder="Укажите номер дома">
        </div>

        <div class="form-group">
            <label for="address-apartment-number-input">Номер <?php echo $isCompanyForm ? 'офиса' : 'квартиры' ?></label>
            <input type="text" class="form-control" name="apartment_number" id="address-apartment-number-input" placeholder="Укажите номер квартиры">
        </div>

    </div>

    <div class="col-lg-12 col-md-12 col-xs-12">

        <h2>Секретные данные</h2>

        <div class="col-lg-6 col-md-6 col-xs-12 padding-left-none-lg padding-none-xs">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input autofocus required type="password" class="form-control" name="password" id="password"
                           placeholder="Придумайте пароль" onkeyup="checkPasswords()">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-xs-12 padding-right-none-lg padding-none-xs">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input required type="password" class="form-control" id="repeat-password"
                           placeholder="Введите еще раз" onkeyup="checkPasswords()">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-xs-12">
        <h2>Фотография профиля</h2>

        <div class="form-group col-lg-6 col-md-6 col-xs-12 padding-left-none-lg padding-none-xs">
            <div class="input-group">
                <label class="input-group-addon btn btn-primary btn-upload" for="image-input" title="Upload image file">
                    <input type="file" class="sr-only" id="image-input" name="file" accept="image/*">
                    <span class="glyphicon glyphicon-camera"></span>
                </label>
                <input id="image-name-input" type="text" class="form-control" readonly placeholder="Выберите фотографию">
                <span disabled id="crop-button" class="btn btn-success input-group-addon">
                    <i class="glyphicon glyphicon-scissors"></i>
                </span>
                <input type="hidden" name="img_url">
            </div>
        </div>

        <div class="form-group col-lg-6 col-md-6 col-xs-12 padding-right-none-lg padding-none-xs">
            <input disabled type="submit" name="submit" id="set-password-submit" value="Завершить регистрацию" class="btn btn-success btn-block-xs">
            <input name="new_pass_session" type="hidden" value="<?php echo isset($newPassSession) ? $newPassSession : 'hack'?>">
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="form-group img-container">
            <img id="image" src="../../assets/img/default-avatar.png" style="padding: 15px;">
        </div>
    </div>

</form>