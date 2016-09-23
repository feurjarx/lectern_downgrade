<?php
/**
 * Created by PhpStorm.
 * Date: 15.05.2016
 * Time: 19:00
 */
?>

<form class="modal fade" id="ad-plus-modal" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавление нового объявления о работе</h4>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label for="ad-name-input">Наименование</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input required type="text" class="form-control" name="name" id="ad-name-input" placeholder="Введите наименование работы">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sphere-select">Сфера деятельности</label>
                    <br>
                    <select required name="sphere" id="sphere-select" class="selectpicker show-tick" multiple data-actions-box="true">

                        <?php foreach (Utils::getSpheresTitles() as $sphere => $title): ?>

                            <option value="<?php echo $sphere; ?>"><?php echo $title; ?></option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="ad-salary-input">Средняя заработная плата</label>
                    <div class="input-group">
                        <input type="number" step="100" class="form-control" name="salary" id="ad-salary-input" placeholder="Введите среднию заработную оплату">
                        <span class="input-group-addon"><i class="fa fa-rub" aria-hidden="true"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="brick-details-input">Описание</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <textarea required style="resize: vertical" rows="7" class="form-control" name="details" id="brick-details-input" placeholder="Укажите необходимые требования и обязанности"></textarea>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                
            </div>

            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Опубликовать</button>
                </div>
            </div>
            
        </div>
    </div>
</form>
