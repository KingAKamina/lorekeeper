@if (!isset($tinymceScript) || $tinymceScript)
<script>
    $(document).ready(function() {
@endif
        tinymce.init({
            selector: '{{ $tinymceSelector ?? ".wysiwyg" }}',
            height: {{ $tinymceHeight ?? 500 }},
            menubar: false,
            convert_urls: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks fullscreen spoiler',
                'insertdatetime media table paste {{ config('lorekeeper.extensions.tinymce_code_editor') ? 'codeeditor' : 'code' }} help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | spoiler-add spoiler-remove | removeformat | {{ config('lorekeeper.extensions.tinymce_code_editor') ? 'codeeditor' : 'code' }}',
            content_css: [
                '{{ asset('css/app.css') }}',
                '{{ asset('css/lorekeeper.css') }}'
            ],
            spoiler_caption: 'Toggle Spoiler',
            target_list: false,
            @if(Auth::user()->hasPower('edit_site_settings'))
            file_picker_callback: function (callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                let y = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

                // Match folder_category key exactly (case-sensitive)
                let type = 'file';
                if (meta.filetype === 'image') type = 'image';

                let cmsURL = '/admin/laravel-filemanager?type=' + type + '&editor=' + meta.fieldname;

                tinymce.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'File Manager (Admin Only)',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: true,
                    close_previous: false,

                    onMessage: function (api, message) {
                        // This is what actually inserts the URL into TinyMCE
                        callback(message.content);
                        api.close();
                    }
                });
            },
            @endif
        });
@if (!isset($tinymceScript) || $tinymceScript)
    });
</script>
@endif