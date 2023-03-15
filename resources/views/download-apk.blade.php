<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Descarga de Aplicación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body class="bg-dark">
    <section class="container text-dark">
        <div class="card">
            <div class="card-title text-center">
                <h1>Descarga nuestra aplicación para comenzar!</h1>
            </div>
            <div class="card-body">
                <p class="text-wrap">Sabemos la importancia de la seguridad, por lo que te recomendamos
                    descargar nuestra aplicacion solamente de nuestro sitio web.</p>
                <div class="visible-print text-center">
                    {!! QrCode::size(100)->generate(Request::url()) !!}
                    <p>O has click <a href="#">aqui</a> para ir a la descarga directa</p>
                </div>
                <hr
                    style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
                <section class="container">
                    <h2 class="text-center">¿Cómo instaló la aplicación en mi celular?</h2>
                    <p class="text-wrap">Es importante resaltar que la aplicación solo corre en equipos con sistema
                        operativo <strong>Android</strong>.
                        Una vez aclarado ese punto <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#collapseExample" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        comencemos!
                    </a>
                    </p>
                    <div class="collapse" id="collapseExample">
                        <p class="text-wrap">
                            Un archivo con la extensión APK (acrónimo de Android Application Package) es la forma en la
                            que
                            está
                            empaquetada una aplicación de Android que contiene, como instalable que es, todos los
                            archivos
                            necesarios
                            para instalar una aplicación en nuestro dispositivo basado en Android.
                            Y una vez tenemos la aplicación con la extensión .apk (el sinónimo de exe en Windows o .dmg
                            en
                            macOS),
                            toca instalarla en nuestro dispositivo, bien sea por medio de una descarga desde el mismo o
                            con
                            una memoria externa.
                        </p>
                        <div class="text-center">
                            <img src="https://i.blogs.es/e80177/casilla-de-verificacion-copia/1366_2000.webp"
                                alt="Imagen de permisos" style="width: 60%;" />
                        </div>
                        <p class="text-wrap">
                            Un proceso que ha cambiado desde que llegó Android 8, ya que Google añadió más seguridad
                            al proceso de instalación de aplicaciones externas.
                            En lugar de contar con un único punto en el que dar permiso a todas las apps instaladas en
                            nuestro teléfono para
                            que puedan usar extensiones .apk, ahora ese permiso debemos darlo aplicación por aplicación.
                            Esto quiere decir que si le hemos dado permiso a Google Chrome (o la aplicación que sea)
                            para
                            instalar archivos .apk,
                            también tendremos que otorgarlo de forma individual al explorador de archivos de turno, a
                            otro
                            navegador y en general a cualquier app que deseamos usar para instalar un .apk en nuestro
                            móvil.
                            En resumen, tendremos que dar permiso aplicación por aplicación.
                        </p>
                        <div class="text-center">
                            <img src="https://i.blogs.es/d460f8/apks-copia/1366_2000.webp" alt="Imagen de permisos"
                                style="width: 60%;" />
                        </div>
                        <p class="text-wrap">
                            Ahora cada aplicación requiere de un permiso específico y si ahora vamos a instalar una apk
                            desde una aplicación el sistema nos avisará que no podemos instalarla a no ser que le
                            otorguemos
                            permiso, para lo cual nos indica como hacerlo por medio de los ajustes en la aplicación. De
                            una
                            forma mucho más visual, el proceso queda tal que así.
                        </p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Cuando descargamos un archivo .apk, será la aplicación desde la
                                que
                                lo hagamos la que nos advertirá que está bloqueado el proceso.</li>
                            <li class="list-group-item">En la zona inferior de la pantalla veremos un aviso indicando
                                que
                                "no se pueden instalar aplicaciones de orígenes desconocidos" y nos invita a entrar en
                                los
                                "Ajustes".</li>
                            <li class="list-group-item">Dentro de la aplicación buscamos el apartado "Instalar
                                aplicaciones
                                desconocidas" y activamos la casilla.</li>
                            <li class="list-group-item">Desde ese momento, esa aplicación cuenta con permisos a la hora
                                de
                                instalar aplicaciones externas.</li>
                        </ul>
                        <p class="text-wrap">
                            Estos pasos habrá que repetirlos con cada una de las aplicaciones desde las que queramos
                            instalar un APK. Además, puede que llegado el momento nos interese revocar ese permiso. Para
                            llevar a cabo el proceso sólo tenemos que seguir estos pasos.
                            <br><br>
                            Abrir los "Ajustes" del sistema o el apartado de "Configuración" en tu móvil
                        </p>
                        <div class="text-center">
                            <img src="https://i.blogs.es/9d48ca/uno/1366_2000.webp" alt="Imagen de permisos"
                                style="width: 60%;" />
                        </div>
                        <p class="text-wrap">
                            Entre todas las opciones buscamos "Aplicaciones", un campo que en algunas marcas puede
                            variar
                            ligeramente. <br>
                            Una vez dentro tocamos en "Ver todas las aplicaciones" y seleccionamos aquella cuyos
                            permisos
                            queremos revocar. <br>
                            Dentro de la aplicación buscamos el apartado "Instalar aplicaciones desconocidas" y
                            desactivamos
                            la casilla.
                        </p>
                        <div class="text-center">
                            <img src="https://i.blogs.es/dd03a9/dos/1366_2000.webp" alt="Imagen de permisos"
                                style="width: 60%;" />
                        </div>
                        <hr
                            style="border: 0; height: 1px; background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));" />
                        <h3 class="text-center">Cómo instalar aplicaciones en APK en versiones anteriores a Android 8.0
                            Oreo
                        </h3>
                        <div class="text-center">
                            <img src="https://i.blogs.es/58d172/fuentes-desconocidos/1366_2000.webp"
                                alt="Imagen de permisos" style="width: 60%;" />
                        </div>
                        <p class="text-grap">
                            Estos son los pasos en la actualidad, al menos con las versiones más recientes de Android,
                            pero
                            si en tu caso aún usas una versión anterior a Android 8, el proceso para instalar
                            aplicaciones
                            externas es aún más sencillo.
                        </p>
                        <div class="text-center">
                            <img src="https://i.blogs.es/a96f6d/aplicacion/1366_2000.webp" alt="Imagen de permisos"
                                style="width: 60%;" />
                        </div>
                        <p class="text-grap">
                            En este caso sólo tendrás que acudir a los "Ajustes" y dentro de los mismos buscar el
                            apartado
                            "Seguridad" en el que podrás permitir la instalación de aplicaciones que no sean de Play
                            Store.
                            Sólo tendrás que activar la opción "Orígenes desconocidos" y de esa forma, cualquier archivo
                            .apk que quieran instalar tendrá vía libre en tu teléfono.
                        </p>
                </section>
            </div>
            <div class="card-body">
                Tutorial tomado de la pagina web de <a target="_blank"
                    href="https://www.xatakandroid.com/tutoriales/como-instalar-aplicaciones-en-apk-en-un-movil-android">Xataka</a>
            </div>


        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>
