/**
 * Created on 01.06.2016.
 */
$(function () {

    var $jRate = $('#jRate');
    $jRate.jRate({
        startColor: 'yellow',
        endColor: 'orange',
        rating: 1,
        min: 0,
        max: 5,
        minSelected: 1,
        precision: 1,
        strokeWidth: '20px',
        strokeColor: '#34495e',
        onSet: function(rating) {
            $jRate.next('input').val(rating);
        }
    });

    $('#review-poster').on('submit', function (event) {
        event.preventDefault();

        var gRecaptchaResponse = $('[name="g-recaptcha-response"]').val();

        if (gRecaptchaResponse) {

            var dataSending = $.extend($(this).serializeObject(), {
                'g-recaptcha-response': gRecaptchaResponse
            });

            var $submitBtn = $(this).find('button[type="submit"]');

            $.ajax({
                url: '/review/new',
                dataType: 'JSON',
                method: 'POST',
                data: dataSending,
                beforeSend: function () {
                    $submitBtn.prop('disabled', true);
                },
                success: function (data) {

                    var notyConf = {
                        text: data['message'],
                        type: data['type'],
                        timeout: 5000
                    };

                    if ('success' === data['type']) {

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

                    $submitBtn.prop('disabled', false);
                }
            });

        } else {

            notification({
                text: 'Внимание! <br> Подтведите, что вы не робот',
                type: 'warning'
            });
        }
    });

    // get handlebars
    $.ajax({
        url: window.location.origin + '/bower_components/handlebars/handlebars.min.js',
        cache: true,
        dataType: 'script',
        success: function (script) {

            // get hbs template
            $.ajax({
                url: 'templates/hbs/reviewModal.hbs',
                cache: true,
                success: function (source) {
                    var render = Handlebars.compile(source);

                    $(document).on('click', '.popover-review', function () {

                        var $modal = $(render({
                            title: $(this).find('.popover-title').text(),
                            description: $(this).closest('.panel').find('.full-description').text()
                        }));

                        $modal.on('hidden.bs.modal', function () {
                            $(this).remove();
                        });

                        $('body').append($modal);

                        $modal.modal();
                    });
                }
            });
        },
        error: function (err) {
            console.error(err);
        }
    });
});

