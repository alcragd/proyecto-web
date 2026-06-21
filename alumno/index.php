<?php 
    session_start();

    // Validación de sesión activa y rol de alumno (0)
    /*if(!isset($_SESSION["usuario"]) || $_SESSION["rol"] != "0"){
        header("Location: ../login.html");
        exit;
    }*/
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alumno | ESCOM IPN</title>
    <link rel="shortcut icon" href="../docs/img/logoEquipo.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Source+Serif+4:wght@400;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="../docs/css/style.css" />
</head>

<body class="bg-light">

    <header>
        <nav class="navbar-institucional" aria-label="Navegación principal">
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

            <div class="navbar-logos-block">
                <div class="container d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <a href="https://www.ipn.mx" target="_blank" aria-label="Inicio IPN">
                            <img src="../docs/img/logo-ipn-blanco.png" alt="Logotipo del Instituto Politécnico Nacional" class="navbar-logo-img" />
                        </a>
                        <div class="navbar-logo-divider d-none d-sm-block"></div>
                        <a href="https://www.escom.ipn.mx" target="_blank" aria-label="Inicio ESCOM">
                            <img src="../docs/img/logoEscom.png" alt="Logotipo de la Escuela Superior de Cómputo" class="navbar-logo-img" />
                        </a>
                    </div>

                    <div class="d-none d-lg-block text-center">
                        <div class="navbar-titulo">Panel de Alumno</div>
                        <div class="navbar-subtitulo">Bienvenido <?= $_SESSION["usuario"] ?></div>
                    </div>

                    <div class="d-none d-md-flex align-items-center ms-3">
                        <img src="../docs/img/logoEquipo.png" alt="Logotipo del equipo de desarrollo" class="navbar-logo-img" style="height: 42px;" />
                    </div>
                </div>
            </div>

            <div class="navbar-nav-bar">
                <div class="container">
                    <nav class="navbar navbar-expand-md p-0" aria-label="Menú principal">
                        <button class="navbar-toggler ms-auto my-1" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menú">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="menuPrincipal">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="../index.html"><i class="bi bi-house-door me-1"></i>Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../docs/php/logout.php"><i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </nav>
    </header>


    <main>
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-xl-10">
                    
                    <div class="card shadow-lg border-0" style="border-top: 4px solid var(--ipn-guinda) !important;">
                        <div class="card-header bg-white py-4 text-center border-bottom-0">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 text-guinda fw-bold">¡Registro Completado!</h3>
                            <p class="text-muted mb-0">A continuación se muestra la información asignada para tu examen diagnóstico.</p>
                        </div>
                        
                        <div class="card-body px-4 px-md-5 pb-5">
                            
                            <div class="ticket-examen p-4 mb-4 shadow-sm">
                                <div class="row text-center text-md-start">
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="ticket-label">Cuenta de Usuario</div>
                                        <div class="ticket-data"><?= $_SESSION["usuario"] ?></div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="ticket-label">Estatus</div>
                                        <div class="ticket-data text-success">Registrado</div>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <div class="ticket-label"><i class="bi bi-geo-alt-fill me-1"></i> Laboratorio Asignado</div>
                                        <div class="ticket-data text-escom">Laboratorio 1</div>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <div class="ticket-label"><i class="bi bi-clock-fill me-1"></i> Horario de Examen</div>
                                        <div class="ticket-data text-escom">08:00 - 09:30 hrs</div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-light p-4 rounded text-center border mt-4">
                                <h5 class="fw-bold mb-3">Descargar Acuse de Registro</h5>
                                <p class="small text-muted mb-4">Es obligatorio presentar este acuse impreso el día de tu examen diagnóstico junto con una identificación oficial.</p>
                                
                                <form action="generar_pdf.php" method="POST" target="_blank" id="frmImprimirAcuse">
                                    <div class="d-flex justify-content-center mb-4">
                                        <div class="g-recaptcha" data-sitekey="6LeeNyktAAAAAExUm6WtHBTq70bQUfh_Jv-2u9sn"></div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-institucional btn-lg w-100" style="max-width: 300px;">
                                        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Imprimir Acuse
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>


    <footer class="footer-institucional" aria-label="Pie de página institucional">
        <div class="container">
            <div class="row g-4">

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

                <div class="col-12 col-md-4 ms-auto">
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

        <div class="footer-copy">
            &copy; 2026 <span>ESCOM &mdash; Instituto Politécnico Nacional</span>.
            Todos los derechos reservados. &nbsp;|&nbsp;
            Sistema de Registro de Alumnos de Nuevo Ingreso.
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
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

    <script>
        document.getElementById('frmImprimirAcuse').addEventListener('submit', function(e) {
            if(grecaptcha.getResponse().length === 0) {
                e.preventDefault();
                alert("Por favor, completa el CAPTCHA para descargar tu acuse.");
            }
        });
    </script>
</body>

</html>