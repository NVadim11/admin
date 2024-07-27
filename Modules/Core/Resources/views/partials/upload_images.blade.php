<div style=" padding: 20px">
    <div class="sub_fields" style="font-size: 14px; text-align: center;margin: 10px 0 5px;"><small><b>Для загрузки картинок нажмите кнопку "Загрузить файл" или перетащите на нее выбранные фотографии</b></small></div>
    <fieldset class="sub_fields">
        <legend>Фото для галлереи</legend>
        <div id="file-uploader"
             data-table="{{ $images_table }}"
             data-link="{{ $table_link }}"
             data-item_id="{{ $item_id }}"
             data-back="default_gallery_response"
             data-init="default_gallery_init"
        ></div>

    </fieldset>
</div>

<script type="text/template" id="qq-template-gallery">
    <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Перетаите файлы сюда">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            <div>Загрузить  файл</div>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Перетаскивание файлов...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
        <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
            <li>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <div class="qq-thumbnail-wrapper">
                    <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                </div>
                <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                    <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                    Повторить
                </button>

                <div class="qq-file-info">
                    <div class="qq-file-name">
                        <span class="qq-upload-file-selector qq-upload-file"></span>
                        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                    </div>
                    <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                    <span class="qq-upload-size-selector qq-upload-size"></span>
                    <button type="button" class="qq-btn js-delete-gallery-image">
                        <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                    </button>
                    <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                        <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                    </button>
                    <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                        <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                    </button>
                </div>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Закрыть</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Нет</button>
                <button type="button" class="qq-ok-button-selector">Да</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Отмена</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog>
    </div>
</script>

@push('css')
    <link href="{{ asset('admin/js/fine-uploader/fine-uploader.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/js/fine-uploader/fine-uploader-gallery.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admin/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css"/>;
@endpush

@push('scripts')
    <script src="{{ asset('admin/js/fine-uploader/fine-uploader.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/uploadForm.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
@endpush