/**
 * Created by Roman on 28.05.2016.
 */

$(function () {
   
    $('#cv-save-form').submit(function (event) {
        event.preventDefault();

        var sendData = $(this).serializeObject(),
            $submitButton = $(this).find('button[type="submit"]')
        ;

        var $sphereSelect = $('#sphere-select');
        sendData.sphere = $sphereSelect.length ? $sphereSelect.val().join(',') : '';

        sendData.id = $submitButton.val();
        
        $.ajax({
            url: '/student/cv/save',
            dataType: 'json',
            method: 'POST',
            data: sendData,
            beforeSend: function () {
                $submitButton.prop('disabled', true);
            },
            success: function (data) {

                var notyConf = {
                    text: data['message'],
                    type: data['type'],
                    timeout: 5000
                };

                if ('success' === data['type']) {

                    $submitButton.val(data['complete_id']);

                    notyConf.animation = {
                        open: 'animated bounceInRight',
                        close: 'animated bounceOutRight'
                    };
                }

                notification(notyConf);
            },
            error: function (err) {

                notification({
                    text: 'Ошибка! <br> Отказ сервера',
                    type: 'error'
                });

                console.error(err);
            },
            complete: function () {
                $submitButton.prop('disabled', false);
            }
        });
    });
});