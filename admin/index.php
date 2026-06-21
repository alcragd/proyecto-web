<?php 
    session_start();

    // Validación de sesión activa y rol de administrador (1)
    if(!isset($_SESSION["usuario"]) || $_SESSION["rol"] != "1"){
        header("Location: ../login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | ESCOM IPN</title>
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

                    <div class="d-none d-lg-block text-end">
                        <div class="navbar-titulo">Panel de Administración</div>
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
                                    <a class="nav-link" href="../index.php"><i class="bi bi-house-door me-1"></i>Inicio</a>
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

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-12">
                
                <div class="card mb-4 shadow-sm border-0" style="border-top: 4px solid var(--ipn-guinda) !important;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="mb-0 text-guinda fw-bold"><i class="bi bi-sliders me-2"></i>Consola Administrativa (Operaciones CRUD)</h4>
                        <button class="btn btn-institucional btn-sm shadow-sm text-uppercase fw-bold" data-bs-toggle="modal" data-bs-target="#modalCrudAlumno" style="background-color: var(--ipn-guinda); color: white;">
                            <i class="bi bi-plus-circle me-1"></i> Registrar Alumno
                        </button>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered align-middle text-center">
                                <thead style="background-color: var(--ipn-guinda); color: white;">
                                    <tr>
                                        <th>Boleta</th>
                                        <th>Nombre Completo</th>
                                        <th>Escuela de Procedencia</th>
                                        <th>Promedio</th>
                                        <th>Laboratorio</th>
                                        <th>Horario Asignado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyAlumnos">
                                    <tr>
                                        <td class="fw-bold">2026630015</td>
                                        <td>Isaac Christian</td>
                                        <td>CECyT 9 "Juan de Dios Bátiz"</td>
                                        <td>9.45</td>
                                        <td>Laboratorio 3</td>
                                        <td>09:45 - 11:15</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" data-bs-target="#modalCrudAlumno" title="Editar"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-trash3"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <div class="modal fade" id="modalCrudAlumno" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header" style="background-color: var(--ipn-guinda); color: white;">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-gear me-2"></i>Actualizar / Crear Registro de Alumno</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="frmCrudAlumno">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">No. de Boleta</label>
                                <input type="text" class="form-control" name="boleta" required placeholder="Ej: 2026630000">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nombre(s)</label>
                                <input type="text" class="form-control" name="nombre" required placeholder="Nombre completo o descriptivo">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Laboratorio Asignado</label>
                                <select class="form-select" name="laboratorio" required>
                                    <option value="" disabled selected>Selecciona una opción...</option>
                                    <option value="1">Laboratorio 1</option>
                                    <option value="2">Laboratorio 2</option>
                                    <option value="3">Laboratorio 3</option>
                                    <option value="4">Laboratorio 4</option>
                                    <option value="5">Laboratorio 5</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Horario Reasignado</label>
                                <select class="form-select" name="horario" required>
                                    <option value="" disabled selected>Selecciona una opción...</option>
                                    <option value="1">08:00 - 09:30</option>
                                    <option value="2">09:45 - 11:15</option>
                                    <option value="3">11:30 - 13:00</option>
                                    <option value="4">13:15 - 14:45</option>
                                </select>
                            </div>
                        </div>

        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-institucional-outline text-uppercase fw-bold" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-institucional text-uppercase fw-bold" style="background-color: var(--ipn-guinda); color: white;">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

                <div class="col-6 col-md-2">
                    <h3 class="footer-titulo-col">Navegación</h3>
                    <ul class="footer-link-list">
                        <li><a href="../index.php"><i class="bi bi-chevron-right me-1"></i>Inicio</a></li>
                        <li><a href="../registro.php"><i class="bi bi-chevron-right me-1"></i>Registro</a></li>
                        <li><a href="../login.php"><i class="bi bi-chevron-right me-1"></i>Iniciar Sesión</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-3">
                    <h3 class="footer-titulo-col">Proceso de admisión</h3>
                    <ul class="footer-link-list">
                        <li><a href="../index.php#avisos"><i class="bi bi-chevron-right me-1"></i>Documentos requeridos</a></li>
                        <li><a href="../index.php#avisos"><i class="bi bi-chevron-right me-1"></i>Fechas importantes</a></li>
                        <li><a href="../index.php#avisos"><i class="bi bi-chevron-right me-1"></i>Preguntas frecuentes</a></li>
                    </ul>
                </div>

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
</body>

</html>