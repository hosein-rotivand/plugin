jQuery(document).ready(function($) {
    $('.rotify-upload-button').on('click', function(e) {
        e.preventDefault();
        var inputId = $(this).data('input');
        var frame = wp.media({
            title: 'انتخاب یا آپلود آیکون',
            button: { text: 'استفاده از این تصویر' },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#' + inputId).val(attachment.url);
        });

        frame.open();
    });
});
