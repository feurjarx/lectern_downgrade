/**
 * Created on 15.05.2016.
 */

$('#ad-remove-button').on('click', function () {

    var adsIds = $('#ads').find('input:checked').map(function (_, it) {
        return it.dataset.adId;
    }).get();

    if (adsIds.length) {

        notification({
            text: 'Вы действительно желаете удалить ' + adsIds.length + ' ' + (((adsIds.length % 10 == 1) && adsIds.length != 11) ? 'объявление' : ((parseInt(adsIds.length / 10) == 0 && (adsIds.length % 10 < 5 ))  ? 'объявления' : 'объявлений')),
            type: 'confirm',
            layout: 'top',
            dismissQueue: true,
            animation: {
                open: {height: 'toggle'},
                close: {height: 'toggle'},
                easing: 'swing',
                speed: 500
            },
            killer: true,
            buttons: [{
                addClass: 'btn btn-danger',
                text: 'Да',
                onClick: function($noty) {

                    var $okButton = $(this);

                    $.ajax({
                        url: '/employer/ad/remove',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            ids: adsIds
                        },
                        beforeSend: function () {
                            $okButton.prop('disabled', true);
                        },
                        success: function (data) {

                            var notyConf = {
                                text: data['message'],
                                type: data['type'],
                                timeout: 5000
                            };

                            if ('success' === data['type']) {

                                data['complete_ids'].forEach(function (id) {
                                    $('#brick-details-' + id).closest('li').remove();
                                });

                                var $adsList = $('#ads').find('ul');
                                if (!$adsList.html().trim()) {

                                    $adsList.append($('<div>', {
                                        class: 'col-lg-12 alert alert-info list-group-item',
                                        html: $('<strong>', {
                                            html: [
                                                $('<span>', {
                                                    class: 'glyphicon glyphicon-info-sign'
                                                }),
                                                $('<span>', {
                                                    class: 'sr-only',
                                                    text: 'Информация!'
                                                }),
                                                $('<span>', {
                                                    text: 'Объявлений не найдено'
                                                })
                                            ]
                                        })
                                    }));
                                }

                                notyConf.animation = {
                                    open: 'animated bounceInRight',
                                    close: 'animated bounceOutRight'
                                };
                            }

                            notification(notyConf);
                        },
                        error: function () {

                            notification({
                                text: 'Ошибка! <br> Отказ сервера',
                                type: 'error'
                            });

                            console.error(err);
                        },
                        complete: function () {
                            $noty.close();
                        }
                    });
                }
            }, {
                addClass: 'btn btn-default',
                text: 'Отмена',
                onClick: function($noty) {
                    $noty.close();
                }
            }]
        });

    } else {

        notification({
            text: 'Внимание! <br>Сначала отметьте хотя бы одно объявление',
            type: 'warning',
            timeout: 3000,
            animation: {
                open: 'animated fadeIn',
                close: 'animated fadeOut'
            }
        });
    }
});

