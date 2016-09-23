<?php
/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 20:43
 */
?>

<form class="form" role="form" method="post">

    <div class="col-lg-12 col-md-12 col-xs-12">
        <div class="thumbnail">
            <img src="<?php echo Utils::getHttpHost(); ?>/assets/img/signup-request.jpg" alt="подача заявки">
        </div>
    </div>

    <div class="form-group col-lg-7 col-md-7 col-xs-12">

        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
            <input required id="email-input" type="email" class="form-control" name="email" placeholder="Введите адрес почтового ящика">
            <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
        </div>

    </div>

    <div class="form-group col-lg-5 col-md-5 col-xs-12">

        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default active">
                <span class="fa fa-graduation-cap"></span>
                <input type="radio" name="role" id="is-student-input" value="student" autocomplete="off" checked>
                <span class="hidden-xs"> Студент</span>
            </label>
            <label class="btn btn-default">
                <span class="fa fa-briefcase"></span>
                <input type="radio" name="role" id="is-employer-input" value="employer" autocomplete="off">
                <span class="hidden-xs"> Работодатель</span>
            </label>
        </div>

        <div class="btn-group pull-right">
            <button type="submit" name="submit" class="btn btn-primary pull-right">Подать заявку</button>
        </div>

    </div>

    <div class="signup-footer col-lg-12 col-xs-12">

        <?php if (isset($errMsg) && $errMsg): ?>

            <div class="alert alert-danger" role="alert" style="padding: 10px">
                <strong>
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Ошибка:</span>

                    <?php
                    if (isset($errMsg) && $errMsg):
                        echo $errMsg;
                    endif;
                    ?>

                </strong>
            </div>

        <?php endif; ?>

    </div>
</form>