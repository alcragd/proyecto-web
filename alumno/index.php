<?php 
    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alumno</title>
    <link rel="shortcut icon" href="../docs/img/logoEquipo.png" type="image/x-icon">


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
    <link rel="stylesheet" href="../docs/css/style.css" />
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
                        <a href="https://www.ipn.mx" target="_blank" aria-label="Inicio IPN">
                            <img src="../docs/img/logo-ipn-blanco.png" alt="Logotipo del Instituto Politécnico Nacional"
                                class="navbar-logo-img" />
                        </a>
                        <div class="navbar-logo-divider d-none d-sm-block"></div>
                        <a href="https://www.escom.ipn.mx" target="_blank" aria-label="Inicio ESCOM">
                            <img src="../docs/img/logoEscom.png" alt="Logotipo de la Escuela Superior de Cómputo"
                                class="navbar-logo-img" />
                        </a>
                    </div>

                    <!-- Título del sistema (centro/derecha) -->
                    <div class="d-none d-lg-block text-center">
                        <div class="navbar-titulo">Panel de Administración</div>
                        <div class="navbar-subtitulo">Bienvenido -USER-</div>
                    </div>

                    <!-- Logo del equipo (extremo derecho) -->
                    <div class="d-none d-md-flex align-items-center ms-3">
                        <img src="../docs/img/logoEquipo.png" alt="Logotipo del equipo de desarrollo"
                            class="navbar-logo-img" style="height: 42px;" />
                    </div>
                </div>
            </div>

            

        </nav>
    </header>
    <!-- /NAVBAR -->


    <!-- ======================================================
       CONTENIDO PRINCIPAL
       ====================================================== -->
    <main>
        <div class="container-sm my-5">
            
        </div>
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
                            <img src="../docs/img/logo-ipn-blanco.png" alt="IPN" class="footer-logo-img" />
                        </a>
                        <a href="https://www.escom.ipn.mx/" target="_blank" aria-label="Inicio ESCOM">
                            <img src="../docs/img/logoEscom.png" alt="ESCOM" class="footer-logo-img" />
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

                

                <!-- Columna: aviso legal / logo equipo -->
                <div class="col-12 col-md-3">
                    <h3 class="footer-titulo-col">Información</h3>
                    <p class="footer-texto">
                        U.A. Tecnologías para el Desarrollo de Aplicaciones Web.<br />
                        Proyecto desarrollado por estudiantes de la ESCOM para el
                        2do. departamental, ciclo 2026.
                    </p>
                    <div class="mt-3">
                        <img src="../docs/img/logoEquipo.png" alt="Logo del equipo de desarrollo"
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
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
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