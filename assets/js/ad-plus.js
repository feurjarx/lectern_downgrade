/**
 * Created on 15.05.2016.
 */

$('#ad-plus-modal')
    .on('submit', function (event) {
        event.preventDefault();

        var
            $addPlusModal = $(this),
            $submitButton = $addPlusModal.find('button[type="submit"]'),
            sendData = $addPlusModal.serializeObject()
        ;

        var $sphereSelect = $('#sphere-select');
        sendData.sphere = $sphereSelect.length ? $sphereSelect.val().join(',') : '';

        $.ajax({
            url: '/employer/ad/plus',
            type: 'post',
            dataType: 'json',
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

                    var $adsList = $('#ads').find('ul');

                    var $newAd = $('<li>', {
                        class: 'col-lg-12 col-md-12 col-xs-12 list-group-item brick',
                        html: [
                            $('<div>', {
                                class: 'col-lg-1 col-md-1 col-xs-2 checkbox-block padding-none',
                                html: $('<input>', {
                                    type: 'checkbox',
                                    'data-toggle': 'checkbox-x',
                                    'data-three-state': false,
                                    'data-size': 'sm',
                                    'data-ad-id': data['complete_id']
                                })
                            }),
                            $('<div>', {
                                class: 'col-lg-11 col-lg-11 col-xs-10',
                                html: [
                                    $('<div>', {
                                        class: 'list-group-item-heading',
                                        'data-target': '#brick-details-' + data['complete_id'],
                                        'data-toggle': 'collapse',
                                        'aria-expanded': 'false',
                                        html: [
                                            $('<a>', {
                                                href: '#',
                                                class: 'ellipsis-box',
                                                style: 'width: 75%',
                                                html: $('<b>', {
                                                    text: sendData['name'].ucfirst()
                                                })
                                            }),
                                            $('<small>', {
                                                class: 'text-muted',
                                                text: 'размещено: только что'
                                            })
                                        ]
                                    })
                                ]
                            }),
                            $('<div>', {
                                class: 'col-lg-12 col-md-12 col-xs-12 padding-none',
                                html: $('<div>', {
                                    class: 'collapse list-group-item-text',
                                    id: 'brick-details-' + data['complete_id'],
                                    html: $('<pre>', {
                                        class: 'well margin-none',
                                        text: sendData['details'].ucfirst()
                                    })
                                })
                            }),
                            $('<span>', {
                                class: 'badge badge-salary pull-right',
                                html: [
                                    $('<span>', {
                                        text: sendData['salary'] ? (sendData['salary'] + ' ') : 'Не указано'
                                    }),
                                    $('<i>', {
                                        class: sendData['salary'] ? 'fa fa-rub' : '',
                                        'aria-hidden': 'true'
                                    })
                                ]
                            })
                        ]
                    });

                    $newAd.find('input[type="checkbox"]').checkboxX();

                    $adsList
                        .append($newAd)
                        .find('.alert').remove()
                    ;

                    $addPlusModal
                        .modal('hide')
                        .get(0).reset()
                    ;

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
    })
    .on('shown.bs.modal', function () {
        $('#ad-name-input').focus();
    })
;