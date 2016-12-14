/**
 * Created by jowy on 12/10/16.
 */

function readURL(input) {
    if (input.files && input.files[0]) {
        var _thumb = $(input).parent().find('img');
        if (!_thumb.length) {
            _thumb = $(input).parent().prev().find('img.img-responsive');
        }
        if (_thumb.length) {
            var reader = new FileReader();
            var height = _thumb.attr('height') || _thumb.height();
            reader.onload = function (e) {
                _thumb
                    .attr('src', e.target.result)
                    .width(height)
                    .css('object-fit', 'cover')
                    .height(height);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
}

/**
 * jQuery started here
 */
$(document).ready(function() {

    if ($('.input-inner[data-property=image-upload]')) {
        imgPropertyUpload = $('[data-property=image-upload]').clone();
        if (imgPropertyUpload.find('[type=file]')) {
            imgPropertyUpload.find('[type=file]').val('');
        }
    }
    var addNewImage = $('#add-images');
    if (imgPropertyUpload) {
        addNewImage.find('.btn').click(function (e) {
            var imgBody = $('#add-images').prev();
            var photoLen = $('.input-inner').length;

            if (photoLen < 4) {
                imgPropertyUpload.clone().appendTo(imgBody);
            } else {
                $(this).addClass('hide');
            }
        });
    }


});