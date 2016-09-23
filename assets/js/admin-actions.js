/**
 * Created by Roman on 31.05.2016.
 */

$(function () {

    /**
     * AD: ACCEPT | REMOVE
     */
    $(document).on('click', '.ad-action', function () {

        var $adBlock = $(this).closest('.brick'),
            flash = $('input[name="flash"]').val(),
            $actionBtn = $(this),
            type = $actionBtn.data('type')
        ;

        $.ajax({
            url: '/ad/accept/' + flash,
            dataType: 'JSON',
            method: 'POST',
            data: {
                id: $adBlock.data('id'),
                type: type
            },
            beforeSend: function () {
                $actionBtn.prop('disabled', true);
            },
            success: function (data) {
                
                var notyConf = {
                    text: data['message'],
                    type: data['type'],
                    timeout: 5000
                };

                if ('success' === data['type']) {

                    $adBlock.fadeOut('slow', function() {
                        $(this).remove();
                    });

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

                $actionBtn.prop('disabled', false);
            }
        });
    });
});