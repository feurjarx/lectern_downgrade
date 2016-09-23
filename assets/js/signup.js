/**
 * Created on 28.04.2016.
 */
function checkPasswords()
{
    var
        passl = $('#password'),
        pass2 = $('#repeat-password'),
        submit = $('#set-password-submit').get(0);

    submit.disabled = passl.val() !== pass2.val();
}
// Methods
$(function () {

    'use strict';

    var
        $image = $('#image'),
        $cropButton = $('#crop-button')
    ;

    // Cropper
    $image.cropper({
        aspectRatio: 1
    });

    // Import image
    var $inputImage = $('#image-input'),
        URL = window.URL || window.webkitURL,
        blobURL,
        extImageFile,
        nameImageFile;

    if (URL) {

        $inputImage.change(function () {

            var
                numFiles = $inputImage.get(0).files ? $inputImage.get(0).files.length : 1,
                $textInput = $(this).parents('.input-group').find(':text'),
                filename = numFiles > 1 ? numFiles + ' files selected' : $inputImage.val().replace(/\\/g, '/').replace(/.*\//, '');

            if( $textInput.length ) {

                extImageFile = filename.split('.').slice(-1)[0];
                nameImageFile = filename.split('.').slice(0, -1).join('.');

                $textInput.val(filename);

                $cropButton.removeAttr('disabled');

                var files = this.files,
                    file;

                if (!$image.data('cropper')) {
                    return;
                }

                if (files && files.length) {
                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {

                        blobURL = URL.createObjectURL(file);
                        $image
                            .one('built.cropper', function () {
                                // Revoke when load complete
                                URL.revokeObjectURL(blobURL);
                            })
                            .cropper('reset')
                            .cropper('replace', blobURL);

                        $inputImage.val('');

                        notification({
                            text: 'Информация! <br> Не забудьте обрезать фотографию',
                            type: 'info',
                            timeout: 3000
                        });
                    }
                }

            } else {

                console.error(filename );
            }
        });
        
    } else {
        
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }

    $cropButton.on('click', function () {

        if ($(this).attr('disabled')) return;

        var $this = $(this),
            data = $this.data(),
            result;

        if ($image.data('cropper')) {

            result = $image.cropper('getCroppedCanvas', data.option, data.secondOption);
            if (result) {

                var
                    b64Data = result.toDataURL().split(';')[1].split(',')[1],
                    contentType = result.toDataURL().split(';')[0] || '',
                    sliceSize = 512,
                    byteArrays = [],
                    slice,
                    byteNumbers,
                    byteArray
                ;

                var byteCharacters = atob(b64Data);
                for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                    slice = byteCharacters.slice(offset, offset + sliceSize);

                    byteNumbers = new Array(slice.length);
                    for (var i = 0; i < slice.length; i++) {
                        byteNumbers[i] = slice.charCodeAt(i);
                    }

                    byteArray = new Uint8Array(byteNumbers);
                    byteArrays.push(byteArray);
                }

                var blob = new Blob(byteArrays, {type: contentType});
                blobURL = URL.createObjectURL(blob);

                $image
                    .one('built.cropper', function () {
                        // Revoke when load complete
                        URL.revokeObjectURL(blobURL);
                    })
                    .cropper('reset')
                    .cropper('replace', blobURL);

                var sendData = new FormData();
                sendData.append('name', nameImageFile);
                sendData.append('data', blob);
                sendData.append('ext', extImageFile);

                $.ajax({
                    type: 'POST',
                    url: '/upload',
                    data: sendData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {

                        $this.prop('disabled', true);
                    },
                    success: function (data) {
                        
                        (data['type'] === 'success') && $('input[name="img_url"]').val(data['name']);
                    },
                    error: function (err) {
                        notification({
                            text: 'Ошибка! <br> Отказ сервера',
                            type: 'error'
                        });
                        console.error(err);
                    },
                    complete: function () {
                        $this.prop('disabled', false);
                    }
                });
            }
        }
    });

    $('form').submit(function(event){
        if(this.checkValidity())
        {
            $(this).find('[type="submit"]').prop('disabled', true);
        }
    });
});