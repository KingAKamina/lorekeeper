tinymce.init({
    selector: '.wysiwyg',
    height: 500,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | image | bullist numlist outdent indent | removeformat | code',
    content_css: [
        '//www.tiny.cloud/css/codepen.min.css',
        '{{ asset('css/app.css') }}',
        '{{ asset('css/lorekeeper.css') }}'
    ],

    file_picker_types: 'image file',

    @if(Auth::user()->hasPower('edit_site_settings'))
    file_picker_callback: function (callback, value, meta) {
        let x = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        let y = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

        let type = 'file';
        if (meta.filetype === 'image') type = 'image';

        let cmsURL = '/admin/laravel-filemanager?type=' + type + '&editor=' + (meta.fieldname ?? '');

        // External window (TinyMCE 6 does not support openUrl/open)
        const w = x * 0.8;
        const h = y * 0.8;
        const left = (x - w) / 2;
        const top = (y - h) / 2;

        const fileWindow = window.open(
            cmsURL,
            'FileManager',
            `width=${w},height=${h},left=${left},top=${top},resizable=yes`
        );

        // LFM calls this function
        window.SetUrl = function (item) {
        callback(item.url);
            fileWindow.close();
        };
    },
    @endif

});