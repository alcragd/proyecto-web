<?php
    session_start();
    
    $sesionIniciada = isset($_SESSION["usuario"]);
    $rol = isset($_SESSION["rol"]) ? $_SESSION["rol"] : null; 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
        content="Realiza tu registro de datos generales como alumno de nuevo ingreso en la ESCOM. Completa tu proceso de admisión 2026 en línea. Escuela Superior de Cómputo IPN." />
    <title>Registro Nuevo Ingreso ESCOM 2026 | IPN oficial</title>
    <link rel="shortcut icon" href="docs/img/logoEquipo.png" type="image/x-icon">


    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Google Fonts: Playfair Display + Source Serif 4 -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Source+Serif+4:wght@400;600;700&display=swap"
        rel="stylesheet" />

    <!-- Estilos globales del proyecto -->
    <link rel="stylesheet" href="docs/css/style.css" />
</head>

<body>

    <!-- ======================================================
    ENCABEZADO / NAVBAR
    ====================================================== -->
    <header>
        <nav class="navbar-institucional" aria-label="Navegación principal">

            <!-- Banda superior institucional -->
            <div class="navbar-banda-superior">
                <div class="container d-flex justify-content-between align-items-center">
                    <span class="text-institucional">
                        Instituto Politécnico Nacional — Escuela Superior de Cómputo
                    </span>
                    <span class="text-institucional d-none d-md-inline">
                        Sistema de Registro &mdash; Nuevo Ingreso 2026
                    </span>
                </div>
            </div>

            <!-- Bloque de logos y título -->
            <div class="navbar-logos-block">
                <div class="container d-flex align-items-center justify-content-between">

                    <!-- Logos institucionales (izquierda) -->
                    <div class="d-flex align-items-center gap-2">
                        <a href="https://www.ipn.mx/" target="_blank" aria-label="Inicio IPN">
                            <img src="docs/img/logo-ipn-blanco.png" alt="Logotipo del Instituto Politécnico Nacional"
                                class="navbar-logo-img" />
                        </a>
                        <div class="navbar-logo-divider d-none d-sm-block"></div>
                        <a href="https://www.escom.ipn.mx/" target="_blank" aria-label="Inicio ESCOM">
                            <img src="docs/img/logoEscom.png" alt="Logotipo de la Escuela Superior de Cómputo"
                                class="navbar-logo-img" />
                        </a>
                    </div>

                    <!-- Título del sistema (centro/derecha) -->
                    <div class="d-none d-lg-block text-end">
                        <div class="navbar-titulo">Registro de Nuevo Ingreso</div>
                        <div class="navbar-subtitulo">Escuela Superior de Cómputo &bull; IPN</div>
                    </div>

                    <!-- Logo del equipo (extremo derecho) -->
                    <div class="d-none d-md-flex align-items-center ms-3">
                        <img src="docs/img/logoEquipo.png" alt="Logotipo del equipo de desarrollo"
                            class="navbar-logo-img" style="height: 42px;" />
                    </div>
                </div>
            </div>

            <!-- Barra de navegación -->
            <div class="navbar-nav-bar">
                <div class="container">
                    <nav class="navbar navbar-expand-md p-0" aria-label="Menú principal">
                        <!-- Botón hamburguesa para móvil -->
                        <button class="navbar-toggler ms-auto my-1" type="button" data-bs-toggle="collapse"
                            data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false"
                            aria-label="Abrir menú">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Links del menú -->
                        <div class="collapse navbar-collapse" id="menuPrincipal">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php"><i class="bi bi-house-door me-1"></i>Inicio</a>
                                </li>

                                <?php if (!$sesionIniciada): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="registro.php"><i class="bi bi-person-plus me-1"></i>Registro</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="login.php"><i class="bi bi-shield-lock me-1"></i>Iniciar Sesión</a>
                                    </li>
                                <?php else: ?>
                                    <?php if ($rol == "1"): ?>
                                        <li class="nav-item"><a class="nav-link" href="admin/"><i class="bi bi-database-lock"></i>Panel Admin</a></li>
                                    <?php else: ?>
                                        <li class="nav-item"><a class="nav-link" href="alumno/"><i class="bi bi-person"></i>Mi Cuenta</a></li>
                                    <?php endif; ?>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" href="docs/php/logout.php">
                                            <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

        </nav>
    </header>
    <!-- /NAVBAR -->


    <!-- ======================================================
       CONTENIDO PRINCIPAL
       ====================================================== -->
    <main>

        <!-- ---- SLIDER / CAROUSEL ---- -->
        <section aria-label="Noticias y avisos para nuevo ingreso">
            <div id="carouselEscom" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true">

                <!-- Diapositivas -->
                <div class="carousel-inner">

                    <!-- Diapositiva 1 — Bienvenida y registro -->
                    <div class="carousel-item active">
                        <img src="docs/img/fondo1.jpg" class="d-block w-100"
                            alt="Inicio del proceso de registro para alumnos de nuevo ingreso ESCOM 2026" />
                        <div class="carousel-caption">
                            <span class="badge-categoria">Convocatoria 2026</span>
                            <h2>Bienvenido a la Escuela Superior de Cómputo</h2>
                            <p>
                                Inicia tu proceso de registro y forma parte de una de las escuelas
                                de ingeniería más destacadas del Instituto Politécnico Nacional.
                            </p>
                            <a href="registro.php" class="btn-slider">
                                <i class="bi bi-person-plus me-2"></i>Iniciar registro
                            </a>
                        </div>s
                    </div>

                    <!-- Diapositiva 2 — Fechas importantes -->
                    <div class="carousel-item">
                        <img src="docs/img/FONDO2.jpg" class="d-block w-100"
                            alt="Calendario de fechas importantes para alumnos de nuevo ingreso" />
                        <div class="carousel-caption">
                            <span class="badge-categoria">Fechas importantes</span>
                            <h2>Conoce el Calendario Escolar y los Plazos de Inscripción</h2>
                            <p>
                                Consulta las fechas límite para la entrega de documentos, la
                                asignación de grupos y el inicio del ciclo escolar 2026.
                            </p>
                            <a href="#avisos" class="btn-slider">
                                <i class="bi bi-calendar-event me-2"></i>Ver fechas
                            </a>
                        </div>
                    </div>

                    <!-- Diapositiva 3 — Oferta educativa -->
                    <div class="carousel-item">
                        <img src="docs/img/FONDO3.png" class="d-block w-100"
                            alt="Oferta educativa y carreras en ESCOM IPN" />
                        <div class="carousel-caption">
                            <span class="badge-categoria">Oferta educativa</span>
                            <h2>Carreras en Ingeniería en Sistemas, Inteligencia Artificial y Ciencias de Datos</h2>
                            <p>
                                La ESCOM ofrece programas de licenciatura de excelencia con
                                reconocimiento nacional en el campo de la computación y la tecnología.
                            </p>
                            <a href="#bienvenida" class="btn-slider">
                                <i class="bi bi-mortarboard me-2"></i>Conocer más
                            </a>
                        </div>
                    </div>

                </div>
                <!-- /carousel-inner -->

                <!-- Control anterior -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselEscom" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>

                <!-- Control siguiente -->
                <button class="carousel-control-next" type="button" data-bs-target="#carouselEscom" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>

            </div>
        </section>
        <!-- /SLIDER -->


        <!-- ---- SECCIÓN DE BIENVENIDA ---- -->
        <section class="seccion-bienvenida text-center" id="bienvenida">
            <div class="container">
                <div class="bienvenida-linea-decorativa"></div>
                <h2 class="bienvenida-titulo">Proceso de Admisión — Nuevo Ingreso 2026</h2>
                <p class="bienvenida-texto">
                    El Sistema de Registro de Datos Generales es la plataforma oficial de la
                    Escuela Superior de Cómputo para que los alumnos admitidos en el ciclo
                    2026 completen su incorporación institucional. Utiliza el menú superior
                    para navegar entre las distintas secciones del sistema.
                </p>

                <!-- Tarjetas de acceso rápido -->
                <div class="row g-4 mt-4 justify-content-center">

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card-acceso">
                            <span class="icono-acceso"><i class="bi bi-person-plus-fill"></i></span>
                            <h5>Registro</h5>
                            <p>Completa tus datos personales, de procedencia y crea tu cuenta institucional.</p>
                            <a href="registro.php" class="btn-card-acceso">Ir a registro</a>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card-acceso">
                            <span class="icono-acceso"><i class="bi bi-file-earmark-check-fill"></i></span>
                            <h5>Documentos</h5>
                            <p>Consulta la lista de documentos requeridos para completar tu inscripción.</p>
                            <a href="#avisos" class="btn-card-acceso">Ver requisitos</a>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card-acceso">
                            <span class="icono-acceso"><i class="bi bi-calendar2-week-fill"></i></span>
                            <h5>Calendario</h5>
                            <p>Revisa las fechas clave del proceso de admisión y del inicio de clases.</p>
                            <a href="#avisos" class="btn-card-acceso">Ver fechas</a>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card-acceso">
                            <span class="icono-acceso"><i class="bi bi-question-circle-fill"></i></span>
                            <h5>Preguntas frecuentes</h5>
                            <p>Encuentra respuestas a las dudas más comunes del proceso de admisión.</p>
                            <a href="#avisos" class="btn-card-acceso">Ver FAQ</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- /BIENVENIDA -->


        <!-- ---- SECCIÓN DE AVISOS ---- -->
        <section class="seccion-avisos" id="avisos">
            <div class="container">
                <div class="row">

                    <!-- Columna de avisos principales -->
                    <div class="col-12 col-lg-8">
                        <div class="linea-seccion"></div>
                        <h2 class="titulo-seccion">Avisos y Convocatorias</h2>
                        <p class="subtitulo-seccion">
                            Información relevante para los alumnos de nuevo ingreso al ciclo escolar 2026.
                        </p>

                        <div class="aviso-card">
                            <div class="aviso-fecha">
                                <i class="bi bi-megaphone-fill me-1"></i>Mayo 2026
                            </div>
                            <h3 class="aviso-titulo">
                                Apertura del sistema de registro de datos generales
                            </h3>
                            <p class="aviso-desc">
                                El sistema de captura de datos generales para alumnos de nuevo ingreso
                                estará disponible a partir del 20 de mayo de 2026. Es indispensable
                                contar con tu número de boleta asignado por el Departamento Escolar.
                            </p>
                        </div>

                        <div class="aviso-card">
                            <div class="aviso-fecha">
                                <i class="bi bi-calendar-check me-1"></i>Junio 2026
                            </div>
                            <h3 class="aviso-titulo">
                                Entrega de documentos
                            </h3>
                            <p class="aviso-desc">
                                La entrega de documentos originales y copias se llevará a cabo del
                                2 al 6 de junio de 2026 en las instalaciones del Departamento Escolar
                                de la ESCOM, en horario de 9:00 a 15:00 horas.
                            </p>
                        </div>

                        
                        <div class="aviso-card">
                            <div class="aviso-fecha">
                                <i class="bi bi-calendar-check me-1"></i>Julio 2026
                            </div>
                            <h3 class="aviso-titulo">
                                Semana de Inducción 
                            </h3>
                            <p class="aviso-desc">
                                La comunidad de la ESCOM te dara un recorrido por las instalaciones
                                del plantel, tu nuevo hogar, con el fin, de que conozcas todo lo que
                                la ESCOM tiene preparado para ti.
                                Asimismo se darán conferencias a padres, madres y tutores con el fin 
                                de aclarar dudas con respecto a temas de seguridad, infraestructura,
                                y medios de comunicación oficiales. 
                            </p>
                        </div>

                        <div class="aviso-card">
                            <div class="aviso-fecha">
                                <i class="bi bi-book me-1"></i>Agosto 2026
                            </div>
                            <h3 class="aviso-titulo">
                                Inicio de clases del ciclo escolar 2026-2027
                            </h3>
                            <p class="aviso-desc">
                                Las actividades académicas del primer semestre iniciarán el 17 de agosto
                                de 2026. Los horarios y grupos asignados podrán consultarse en el portal
                                institucional y medios digitales a partir del 1 de agosto.
                            </p>
                        </div>

                    </div>

                    <!-- Columna lateral: requisitos -->
                    <div class="col-12 col-lg-4 mt-4 mt-lg-0">
                        <div class="linea-seccion"></div>
                        <h2 class="titulo-seccion">Documentos requeridos</h2>
                        <p class="subtitulo-seccion">
                            Prepara con anticipación los siguientes documentos.
                        </p>

                        <div class="aviso-card" style="border-left-color: var(--escom-blue);">
                            <ul class="list-unstyled mb-0"
                                style="font-size: 0.875rem; color: var(--text-mid); line-height: 2;">
                                <li><i class="bi bi-check-circle-fill text-guinda me-2"></i>Acta de nacimiento (original
                                    y copia)</li>
                                <li><i class="bi bi-check-circle-fill text-guinda me-2"></i>CURP (impresión oficial)
                                </li>
                                <li><i class="bi bi-check-circle-fill text-guinda me-2"></i>Certificado de bachillerato
                                    (original y copia)</li>
                                <li><i class="bi bi-check-circle-fill text-guinda me-2"></i>Comprobante de domicilio (no
                                    mayor a 3 meses)</li>
                                <li><i class="bi bi-check-circle-fill text-guinda me-2"></i>6 fotografías tamaño
                                    infantil (blanco y negro)</li>
                                <li><i class="bi bi-check-circle-fill text-guinda me-2"></i>Identificación oficial con
                                    fotografía</li>
                                <li><i class="bi bi-check-circle-fill text-guinda me-2"></i>Carta de aceptación
                                    (impresión)</li>
                            </ul>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="registro.php" class="btn-institucional d-inline-block w-100">
                                <i class="bi bi-person-plus me-2"></i>Iniciar mi registro
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- /AVISOS -->

    </main>
    <!-- /MAIN -->


    <!-- ======================================================
       FOOTER
       ====================================================== -->
    <footer class="footer-institucional" aria-label="Pie de página institucional">
        <div class="container">
            <div class="row g-4">

                <!-- Columna: logos e información general -->
                <div class="col-12 col-md-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <a href="https://www.ipn.mx/" target="_blank" aria-label="Inicio IPN">
                            <img src="docs/img/logo-ipn-blanco.png" alt="IPN" class="footer-logo-img" />
                        </a>
                        <a href="https://www.escom.ipn.mx/" target="_blank" aria-label="Inicio ESCOM">
                            <img src="docs/img/logoEscom.png" alt="ESCOM" class="footer-logo-img" />
                        </a>
                    </div>
                    <p class="footer-texto">
                        Escuela Superior de Cómputo<br />
                        Instituto Politécnico Nacional<br />
                        Av. Juan de Dios Bátiz s/n, GAM, CDMX
                    </p>
                    <p class="footer-texto mt-2">
                        <i class="bi bi-telephone me-1"></i> (55) 5729-6000<br />
                        <i class="bi bi-envelope me-1"></i> info@escom.ipn.mx
                    </p>
                </div>

                <!-- Columna: navegación -->
                <div class="col-6 col-md-2">
                    <h3 class="footer-titulo-col">Navegación</h3>
                    <ul class="footer-link-list">
                        <li><a href="index.php"><i class="bi bi-chevron-right me-1"></i>Inicio</a></li>
                        <li><a href="registro.php"><i class="bi bi-chevron-right me-1"></i>Registro</a></li>
                        <li><a href="login.php"><i class="bi bi-chevron-right me-1"></i>Iniciar Sesión</a></li>
                    </ul>
                </div>

                <!-- Columna: información del proceso -->
                <div class="col-6 col-md-3">
                    <h3 class="footer-titulo-col">Proceso de admisión</h3>
                    <ul class="footer-link-list">
                        <li><a href="#avisos"><i class="bi bi-chevron-right me-1"></i>Documentos requeridos</a></li>
                        <li><a href="#avisos"><i class="bi bi-chevron-right me-1"></i>Fechas importantes</a></li>
                        <li><a href="#avisos"><i class="bi bi-chevron-right me-1"></i>Preguntas frecuentes</a></li>
                    </ul>
                </div>

                <!-- Columna: aviso legal / logo equipo -->
                <div class="col-12 col-md-3">
                    <h3 class="footer-titulo-col">Información</h3>
                    <p class="footer-texto">
                        U.A. Tecnologías para el Desarrollo de Aplicaciones Web.<br />
                        Proyecto desarrollado por estudiantes de la ESCOM para el
                        2do. departamental, ciclo 2026.
                    </p>
                    <div class="mt-3">
                        <img src="docs/img/logoEquipo.png" alt="Logo del equipo de desarrollo"
                            style="height: 38px; object-fit: contain; filter: brightness(1.1);"/>
                    </div>
                </div>

            </div>

            <hr class="footer-divider" />
        </div>

        <!-- Franja de derechos -->
        <div class="footer-copy">
            &copy; 2026 <span>ESCOM &mdash; Instituto Politécnico Nacional</span>.
            Todos los derechos reservados. &nbsp;|&nbsp;
            Sistema de Registro de Alumnos de Nuevo Ingreso.
        </div>
    </footer>
    <!-- /FOOTER -->


    <!-- Bootstrap 5 JS Bundle (Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmAqZF7SbGrAlYS9d4KFoSXHXMR"
        crossorigin="anonymous"></script>

    <!-- Script mínimo de Persona 1: activar nav-link correcto según página -->
    <script>
    (function () {
        const currentPage = window.location.pathname.split('/').pop() || 'index.php';
        document.querySelectorAll('.navbar-nav-bar .nav-link').forEach(function (link) {
            const href = link.getAttribute('href');
            if (href === currentPage) {
                link.classList.add('active');
                link.setAttribute('aria-current', 'page');
            } else {
                link.classList.remove('active');
                link.removeAttribute('aria-current');
            }
        });
    })();
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>