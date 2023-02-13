@extends('adminlte::page')

@section('title', 'Campaña')

@section('content_header')
    <h1>Nueva Campaña</h1>
@stop

@section('content')
    <section class="card">
        <form action="#">
            @csrf
            <div class="card-header">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la Campaña*</label>
                    <input type="text" class="form-control" id="nombre" required />
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Imagen de Campaña</label>
                    <input id="img_campaign" type="file" accept=".png, .jpg, .jpeg" />
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="partido" class="form-label">Partido</label>
                    <input type="text" class="form-control" id="partido" />
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="partido" class="form-label">Inicio De Campaña*</label>
                            <input type="date" class="form-control" id="partido" required />
                        </div>
                        <div class="col-6">
                            <label for="partido" class="form-label">Fin de Campaña*</label>
                            <input type="date" class="form-control" id="partido" required />
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="comentarios" class="form-label">Comentarios</label>
                    <textarea class="form-control" id="comentarios" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary form-control">Guardar</button>
            </div>
        </form>
    </section>

@stop

@section('css')
    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
        crossorigin="anonymous">
    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all"
        rel="stylesheet" type="text/css" />
@stop

@section('js')
    <!-- the jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <!-- buffer.min.js and filetype.min.js are necessary in the order listed for advanced mime type parsing and more correct
            preview. This is a feature available since v5.5.0 and is needed if you want to ensure file mime type is parsed
            correctly even if the local file's extension is named incorrectly. This will ensure more correct preview of the
            selected file (note: this will involve a small processing overhead in scanning of file contents locally). If you
            do not load these scripts then the mime type parsing will largely be derived using the extension in the filename
            and some basic file content parsing signatures. -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/buffer.min.js"
        type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/filetype.min.js"
        type="text/javascript"></script>

    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
            wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/piexif.min.js"
        type="text/javascript"></script>

    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
            This must be loaded before fileinput.min.js -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/sortable.min.js"
        type="text/javascript"></script>

    <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
            dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- the main fileinput plugin script JS file -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/fileinput.min.js"></script>

    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/locales/es.js"></script>

    <script src="/js/campaigns/index/campaign.index.js"></script>
@stop
